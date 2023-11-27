<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Project_new extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        ini_set('max_execution_time', 0);

        $session = $this->session->userdata('user');

        if (empty($session['user_id'])) {
            $this->session->set_flashdata('message', '<p style="color:black;" class="alert alert-warning">Login First to Create Session !!!</p>');
            redirect(base_url('login'));
        } else {
            $this->load->model('UserModels');
            $this->load->model('CampaignModels');
            $this->load->model('ChannelModels');
            $this->load->model('LeadModels');
            $this->load->model('LeadModelsNew');
            $this->load->model('ProductModels');
            $this->load->model('StatusModels');
            $this->load->model('ProjectModels');
            $this->load->model('SalesOfficerModels');
            $this->load->model('SalesTeamModels');
            $this->load->model('ComponentModels');
        }
    }

    public function get_first_char($str)
    {
        if ($str) {
            return strtolower(substr($str, 0, 1));
        } else {
            return;
        }
    }

    public function index()
    {
        $role = $this->MainModels->UserSession('role_id');
        $datatable_assets = $this->MainModels->getAssets('datatable');
        $lead_assets = $this->MainModels->getAssets('leads');
        $project_assets = $this->MainModels->getAssets('project');
        $get = $this->input->get();

        $js = array_merge($datatable_assets['js'], $lead_assets['js'], $project_assets['js']);
        $css = array_merge($datatable_assets['css']);

        if ($role == 1) {

            $this->db->select('id, project_name, project_detail, status, DATE_FORMAT(create_at, \'%b %d, %Y\') as date');
            $data_project = $this->db->get('tbl_project')->result();
        } else if($role == 3){

            $sales_team_id = $this->MainModels->getSalesTeamId();

            $data_project = $this->ProjectModels->getProjectbySalesTeamId($sales_team_id);
        } else if($role == 2){
            $data_project = $this->ProjectModels->getDataProjectbyClientIdNonSession();
        }else if($role == 5){
            $data_project = $this->ProjectModels->produklocaliniyessii();
        }

        $data = array(
            'data_project' => $data_project,
            'js' => $js,
            'css' => $css,
        );

        $this->template->load('template__', 'projects/index', $data);
    }

    public function add_project()
    {
        $form_wizard_assets = $this->MainModels->getAssets('form-wizard');
        $select2_assets = $this->MainModels->getAssets('select2');
        $project_assets = $this->MainModels->getAssets('project');
        $input_mask = $this->MainModels->getAssets('input-mask');

        $js = array_merge($form_wizard_assets['js'], $select2_assets['js'], $project_assets['js'], $input_mask['js']);
        $css = array_merge($form_wizard_assets['css'], $select2_assets['css'], $input_mask['css']);

        $post = $this->input->post();
        $user_id = $this->MainModels->UserSession('user_id');

        $data_master_status = $this->db->get_where('tbl_master_status', array('status' => 1))->result();

        $data = array(
            'js' => $js,
            'css' => $css,
            'user_id' => $user_id,
            'data_master_status' => $data_master_status,
        );

        $this->template->load('template__', 'project/add_project', $data);
    }

    public function add_project_action()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $post = $this->input->post();
        $role = $this->MainModels->UserSession('role_id');

        if ($role == 2) {
            $client_id = $this->db->get_where('tbl_client', array('user_id' => $post['user_id']))->row('client_id');
        }

        $data_insert_project = array(
            'project_name' => $post['project_name'],
            'project_detail' => $post['project_detail'],
            'client_id' => $client_id,
            'create_by' => 1,
        );

        $insert_project = $this->db->insert('tbl_project', $data_insert_project);

        if ($insert_project) {
            $project_id = $this->db->insert_id();
            $product_name = $post['product']['product_name'];
            foreach ($product_name as $key => $pn) {
                $data_insert_product = array(
                    'product_name' => $pn,
                    'product_price' => $post['product']['product_price'][$key],
                    'product_detail' => $post['product']['product_detail'][$key],
                    'create_by' => 1,
                    'project_id' => $project_id,
                );

                $insert = $this->db->insert('tbl_product', $data_insert_product);

                if ($insert) {
                    $res = 200;
                    $message = 'success';
                } else {
                    $res = 400;
                    $message = 'error';
                }
            }

            $status_name = $post['status']['status_name'];
            foreach ($status_name as $key => $s) {
                $data_insert_status = array(
                    'status_name' => $s,
                    'point' => $post['status']['point'][$key],
                    'project_id' => $project_id,
                    'create_by' => 1,
                );

                $insert_status = $this->db->insert('tbl_status', $data_insert_status);

                if ($insert_status) {
                    $res = 200;
                    $message = 'success';
//                    $redirect = base_url('project/setting/?id=' . $project_id);
                } else {
                    $res = 400;
                    $message = 'error';
//                    $redirect = base_url('project/setting/?id=' . $project_id);
                }
            }

            //insert log

            $insert_log = $this->MainModels->insert_log('Project Created By ', 1, $project_id);

            if ($insert_log['status'] == 200) {
                $res = 200;
                $message = 'success';
                $redirect = base_url('project/setting/?id=' . $project_id);
            }
        } else {
            $res = 400;
            $message = 'error';
            $redirect = base_url('project/setting/?id=' . $project_id);
        }

        $data = array('res' => $res, 'message' => $message, 'redirect' => $redirect);

        echo json_encode($data);
    }

    public function campaign()
    {
        $role = $this->MainModels->UserSession('role_id');
        $datatable_assets = $this->MainModels->getAssets('datatable');
        $team_assets = $this->MainModels->getAssets('team');
        $daterangepicker_assets = $this->MainModels->getAssets('daterangepicker');
//        $modals_assets = $this->MainModels->getAssets('modals');
        $file_input_assets = $this->MainModels->getAssets('file-input');
        $campaign_assets = $this->MainModels->getAssets('campaign');
        $select2_assets = $this->MainModels->getAssets('select2');
        $project_assets = $this->MainModels->getAssets('project');

        $js = array_merge($datatable_assets['js'], $team_assets['js'], $daterangepicker_assets['js'], $file_input_assets['js'], $campaign_assets['js'], $select2_assets['js']);
        $css = array_merge($datatable_assets['css'], $daterangepicker_assets['css'], $file_input_assets['css'], $select2_assets['css'], $project_assets['css']);

        if ($role == 1) {
            $project_id = 0;
            $data_campaign = $this->db->get('tbl_campaign')->result();
        } elseif ($role == 2 || $role == 5) {
            $get = $this->input->get();
            $project_id = $get['id'];
            $data_project = $this->db->get_where('tbl_project', array('id' => $project_id))->row();

            $project_date = substr($data_project->create_at, 0, 10);
            $now = date('Y-m-d');
            $newDate = date('Y-m-d', strtotime($project_date));

            $client_id = $this->MainModels->getClientId();

            $data_campaign = $this->db->get_where('tbl_campaign', array('client_id' => $client_id, 'project_id' => $project_id))->result();
            $data_campaign_filter = $this->db->get_where('tbl_campaign', array('project_id' => $project_id))->result();

            $data_lead_by_campaign = $this->LeadModels->getDataLeadByCampaignbyProjectIdNonSession($project_id);
        } else {
            $get = $this->input->get();
            $project_id = $get['id'];

            $role = $this->MainModels->UserSession('role_id');
            $sales_team_id = $this->MainModels->getSalesTeamId();

            $data_project = $this->db->get_where('tbl_project', array('id' => $project_id))->row();

            $project_date = substr($data_project->create_at, 0, 10);
            $now = date('Y-m-d');
            $newDate = date('Y-m-d', strtotime($project_date));

            if (isset($get['campaign_id'])) {
                $data_session_filter = array('campaign_id' => $get['campaign_id'], 'date_range' => $get['date_range']);
                $this->session->set_userdata('filter', $data_session_filter);
            } else {
                $data_session_filter = array('campaign_id' => 0, 'date_range' => $newDate . ' to ' . $now);
                $this->session->set_userdata('filter', $data_session_filter);
            }

            $client_id = $this->MainModels->getClientId();
            $data_campaign_filter = $this->db->get_where('tbl_campaign', array('project_id' => $project_id))->result();

            //data sales team channel
            $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel', array('sales_team_id' => $sales_team_id))->result();
            $list_channel_id = array();

            if (!empty($data_sales_team_channel)) {
                foreach ($data_sales_team_channel as $dstc) {
                    array_push($list_channel_id, $dstc->channel_id);
                }
            }

            $this->db->where_in('b.id', $list_channel_id);
            $this->db->join('tbl_channel b', 'a.id = b.campaign_id');
            $this->db->group_by('a.id');
            $data_campaign = $this->db->get_where('tbl_campaign a', array('a.client_id' => $client_id, 'a.project_id' => $project_id))->result();

            $data_lead_by_campaign = $this->LeadModels->getDataLeadByCampaignbyProjectIdNonSession($project_id);

        }

        $data = array(
            'data_campaign' => $data_campaign,
            'data_campaign_filter' => $data_campaign_filter,
            'project_id' => $project_id,
            'js' => $js,
            'from' => $newDate,
            'to' => $now,
            'data_chart_campaign' => $data_lead_by_campaign,
            'css' => $css,
        );

        $this->template->load('template__', 'project/campaign/index', $data);
    }

    public function channel()
    {
        $role = $this->MainModels->UserSession('role_id');
        $datatable_assets = $this->MainModels->getAssets('datatable');
        $team_assets = $this->MainModels->getAssets('team');
        $daterangepicker_assets = $this->MainModels->getAssets('daterangepicker');
        $file_input_assets = $this->MainModels->getAssets('file-input');
        $channel_assets = $this->MainModels->getAssets('channel');
        $input_mask = $this->MainModels->getAssets('input-mask');
        $select2_assets = $this->MainModels->getAssets('select2');
        $project_assets = $this->MainModels->getAssets('project');

        $js = array_merge($datatable_assets['js'], $select2_assets['js'], $team_assets['js'], $daterangepicker_assets['js'], $file_input_assets['js'], $input_mask['js'], $channel_assets['js']);
        $css = array_merge($datatable_assets['css'], $select2_assets['css'], $daterangepicker_assets['css'], $file_input_assets['css'], $input_mask['css'], $project_assets['css']);

        if ($role == 1) {
            $project_id = 0;
            $data_channel = $this->db->get('tbl_channel')->result();
            $data_campaign = $this->db->get('tbl_campaign')->result();
            $data_sales_team = $this->db->get('tbl_sales_team')->result();
        } elseif ($role == 2 || $role == 5) {
            $get = $this->input->get();
            $project_id = $get['id'];
            $data_project = $this->db->get_where('tbl_project', array('id' => $project_id))->row();

            $project_date = substr($data_project->create_at, 0, 10);
            $now = date('Y-m-d');
            $newDate = date('Y-m-d', strtotime($project_date));

            $data_campaign = $this->db->get_where('tbl_campaign', array('project_id' => $project_id))->result();

            $data_lead_by_channel = $this->LeadModels->getDataLeadByChannelbyProjectIdNonSession($project_id);

            $filter = $this->session->userdata('filter');
            $campaign_id = $filter['campaign_id'];

            if ($campaign_id != 0) {
                $data_campaign_filter = $this->db->get_where('tbl_campaign', array('id' => $campaign_id))->result();
            } else {
                $data_campaign_filter = $this->db->get_where('tbl_campaign', array('project_id' => $project_id))->result();
            }

            $list_campaign_id = array();

            foreach ($data_campaign_filter as $dc) {
                array_push($list_campaign_id, $dc->id);
            }

            if (!empty($list_campaign_id)) {
                $this->db->where_in('campaign_id', $list_campaign_id);
                $data_channel = $this->db->get('tbl_channel')->result();
            } else {
                $data_channel = array();
            }

            $data_sales_team = $this->db->get_where('tbl_sales_team', array('client_id' => $this->MainModels->getClientId()))->result();
        } else {
            $get = $this->input->get();
            $project_id = $get['id'];
            $data_project = $this->db->get_where('tbl_project', array('id' => $project_id))->row();

            $role_id = $this->MainModels->UserSession('role_id');
            $user_id = $this->MainModels->UserSession('user_id');

            $sales_team_id = $this->MainModels->getIdbyUserIdRoleId($user_id, $role_id);

            $project_date = substr($data_project->create_at, 0, 10);
            $now = date('Y-m-d');
            $newDate = date('Y-m-d', strtotime($project_date));

            if (isset($get['campaign_id'])) {
                $data_session_filter = array('campaign_id' => $get['campaign_id'], 'date_range' => $get['date_range']);
                $this->session->set_userdata('filter', $data_session_filter);
            } else {
                $data_session_filter = array('campaign_id' => 0, 'date_range' => $newDate . ' to ' . $now);
                $this->session->set_userdata('filter', $data_session_filter);
            }

            $data_campaign = $this->db->get_where('tbl_campaign', array('project_id' => $project_id))->result();

            $data_lead_by_channel = $this->LeadModels->getDataLeadByChannelbyProjectIdSalesTeamId($project_id, $sales_team_id['id']);

            $filter = $this->session->userdata('filter');
            $campaign_id = $filter['campaign_id'];

            if ($campaign_id != 0) {
                $data_campaign_filter = $this->db->get_where('tbl_campaign', array('id' => $campaign_id))->result();
            } else {
                $data_campaign_filter = $this->db->get_where('tbl_campaign', array('project_id' => $project_id))->result();
            }

            $list_campaign_id = array();

            foreach ($data_campaign_filter as $dc) {
                array_push($list_campaign_id, $dc->id);
            }

            //get data sales team channel

            $list_channel_id = array();

            $sales_team_channel = $this->ChannelModels->getDataChannelbySalesTeamId($sales_team_id['id']);

            foreach ($sales_team_channel as $stc) {
                array_push($list_channel_id, $stc->id);
            }

            if (!empty($list_channel_id)) {
                if (!empty($list_campaign_id)) {
                    $this->db->where_in('id', $list_channel_id);
                    $this->db->where_in('campaign_id', $list_campaign_id);
                    $data_channel = $this->db->get('tbl_channel')->result();
                } else {
                    $data_channel = array();
                }
            } else {
                $data_channel = array();
            }

            $data_sales_team = $this->db->get_where('tbl_sales_team', array('client_id' => $this->MainModels->getClientId()))->result();
        }

        $data_media = $this->db->get_where('tbl_media', array('status' => 1))->result();

        $data = array(
            'data_channel' => $data_channel,
            'data_media' => $data_media,
            'data_sales_team' => $data_sales_team,
            'data_campaign' => $data_campaign,
            'data_chart_channel' => $data_lead_by_channel,
            'data_media' => $this->db->get_where('tbl_media')->result(),
            'from' => $newDate,
            'to' => $now,
            'project_id' => $project_id,
            'data_sales_team' => $data_sales_team,
            'js' => $js,
            'css' => $css,
        );

        $this->template->load('template__', 'project/channel/index', $data);
    }

    public function form_add_channel()
    {
        $select2_assets = $this->MainModels->getAssets('select2');
        $code_edit_assets = $this->MainModels->getAssets('code_editor');

        $add_channel = $this->MainModels->getAssets('add_channel');

        $post = $this->input->post();
        $get = $this->input->get();

        $client_id = $this->MainModels->getClientId();
        $js = array_merge($add_channel['js'], $select2_assets['js'], $code_edit_assets['js']);
        $css = array_merge($add_channel['css'], $select2_assets['css'], $code_edit_assets['css']);
        $step = $get['step'];
        $project_id = $get['id'];

        //get all media for step 1
        $data_online = $this->db->get_where('tbl_media', array('media_category' => 1))->result();


        $this->db->where_not_in('media_category', 1);
        $data_offline = $this->db->get('tbl_media')->result();

        //get data campaign for step 2
        $data_campaign = $this->db->get_where('tbl_campaign', array('project_id' => $project_id))->result();

        //get data field for step 3
        $field = array('Name', 'Phone', 'Email', 'No KTP', 'Address', 'City', 'Gender', 'Note');

        //get data sales team for step 4
        $sales_team = $this->db->get_where('tbl_sales_team', array('client_id' => $client_id))->result();

        if ($post) {

            $step_1 = $this->session->userdata('step_1');
            $category = $step_1['category'];

            switch ($post['step']) {
                case 1 :

                    //get media category
                    $media_category = $this->db->get_where('tbl_media', array('id' => $post['media_id']))->row('media_category');

                    if ($media_category == 1) {
                        $category = 'Online';
                    } else {
                        $category = 'Offline';
                    }

                    $data = array(
                        'media_id' => $post['media_id'],
                        'category' => $category
                    );

                    $this->session->set_userdata('step_1', $data);
                    break;
                case 2 :

                    if ($category == 'Online') {
                        $data = array(
                            'channel_name' => $post['channel_name'],
                            'campaign_channel' => $post['campaign_channel'],
                            'channel_detail' => $post['channel_detail'],
                            'lp_url' => $post['lp_url'],
                            'redirect_url' => $post['redirect_url']
                        );
                    }
                    if ($category == 'Offline') {
                        $data = array(
                            'channel_name' => $post['channel_name'],
                            'campaign_channel' => $post['campaign_channel'],
                            'channel_detail' => $post['channel_detail'],
                        );
                    }


                    $this->session->set_userdata('step_2', $data);

                    break;
                case 3 :


                    $field = array();

                    foreach ($post['field'] as $f) {
                        array_push($field, $f);
                    }

                    $data = array(
                        'field' => $field
                    );


                    $this->session->set_userdata('step_3', $data);

                    break;
                case 4 :

                    $sales_team = array();

                    foreach ($post['sales_team'] as $st) {
                        array_push($sales_team, $st);
                    }

                    $data = array(
                        'sales_team' => $sales_team
                    );


                    $this->session->set_userdata('step_4', $data);

                    break;
                case 5 :

                    $session = $this->session->userdata();
                    $step_1 = $session['step_1'];
                    $step_2 = $session['step_2'];
                    $step_3 = $session['step_3'];
                    $step_4 = $session['step_4'];

                    $media_id = $step_1['media_id'];
                    $picture_media = $this->db->get_where('tbl_media', array('id' => $media_id))->row('media_pic');
                    $file_name = 'https://jala.ai/dashboard/assets/picture/media/' . $picture_media;

                    $insert_channel = $this->ChannelModels->addChannelNew($step_1, $step_2, $step_3, $step_4, $file_name);

                    $this->session->set_flashdata('message', $insert_channel['message']);

                    // redirect(base_url('project/channel/?id=' . $post['project_id']));

                    break;
            }

            $next_step = $post['step'] + 1;
            redirect(base_url('project_new/form_add_channel/?id=' . $project_id . '&step=' . $next_step));

        }

        $data = array(
            'js' => $js,
            'css' => $css,
            'step' => $step,
            'online' => $data_online,
            'offline' => $data_offline,
            'project_id' => $project_id,
            'campaign' => $data_campaign,
            'field' => $field,
            'sales_team' => $sales_team
        );

        $this->template->load('template__', 'project/form_add_channel', $data);
    }

    public function leads()
    {
        $role = $this->MainModels->UserSession('role_id');
        $get = $this->input->get();
        $project_id = $get['id'];

        //get assets
        $datatable_assets = $this->MainModels->getAssets('datatable');
        $daterangepicker_assets = $this->MainModels->getAssets('daterangepicker');
        $counterup_assets = $this->MainModels->getAssets('counterup');
        $lead_assets = $this->MainModels->getAssets('leads');

        $js = array_merge($datatable_assets['js'], $daterangepicker_assets['js'], $counterup_assets['js'], $lead_assets['js']);
        $css = array_merge($datatable_assets['css'], $daterangepicker_assets['css'], $counterup_assets['css']);

        if ($role == 2 || $role == 5) {
            $channel_id = 0;
            $sales_team_id = 0;
            $sales_officer_id = 0;

            //get data filter
            $create_at = $this->db->get_where('tbl_project', array('id' => $project_id))->row('create_at');
            $project_date = substr($create_at, 0, 10);
            $now = date('Y-m-d');
            $newDate = date('Y-m-d', strtotime($project_date));


            //set session filter & session search
            if (isset($get['search'])) {

                $campaign_id = $get['campaign_id'];
                $data_session_filter = array(
                    'campaign_id' => $get['campaign_id'],
                    'from' => $get['from'],
                    'to' => $get['to']
                );
                $this->session->set_userdata('filter', $data_session_filter);


                if ($get['sales_team_id'] != null) {
                    $sales_team_id = $get['sales_team_id'];
                } else {
                    $sales_team_id = 0;
                }

                if ($get['lead_category_id'] != null) {
                    $lead_category_id = $get['lead_category_id'];
                } else {
                    $lead_category_id = 0;
                }

                if ($get['type_id'] != null) {
                    $type_id = $get['type_id'];
                } else {
                    $type_id = 0;
                }

                if ($get['status_id'] != null) {
                    $status_id = $get['status_id'];
                } else {
                    $status_id = 0;
                }

                if ($get['channel_id'] != null) {
                    $channel_id = $get['channel_id'];
                } else {
                    $channel_id = 0;
                }

                if ($get['sales_officer_id'] != null) {
                    $sales_officer_id = $get['sales_officer_id'];
                } else {
                    $sales_officer_id = 0;
                }

                $data_session_search = array(
                    'sales_team_id' => $sales_team_id,
                    'lead_category_id' => $lead_category_id,
                    'status_id' => $status_id,
                    'channel_id' => $channel_id,
                    'sales_officer_id' => $sales_officer_id,
                    'type_id' => $type_id
                );
                $this->session->set_userdata('search', $data_session_search);
            } else {

                $campaign_id = 0;
                $data_session_filter = array(
                    'campaign_id' => 0,
                    'from' => $newDate,
                    'to' => $now
                );
                $this->session->set_userdata('filter', $data_session_filter);

                $data_session_search = array(
                    'sales_team_id' => 0,
                    'lead_category_id' => 0,
                    'status_id' => 0,
                    'channel_id' => 0,
                    'sales_officer_id' => 0,
                    'type_id' => 0
                );
                $this->session->set_userdata('search', $data_session_search);
            }

            //set session filter and search
            $session_filter = $this->session->userdata('filter');
            $session_search = $this->session->userdata('search');

            //get data lead
            $data_lead = $this->LeadModels->getDataLeadByProjectTable($project_id, $session_filter, $session_search);

            //validation when channel and campaign is null
            $data_campaign = $this->CampaignModels->getCampaignbyProjectId($project_id);
            if (!empty($data_campaign)) {
                $data_channel = $this->ChannelModels->getDataChannelbyProjectId($project_id);

                if (empty($data_channel)) {
                    $this->session->set_flashdata('message', '<p class="alert alert-warning">Create Channel First !!!</p>');
                    redirect(base_url('project_new/channel/?id=' . $project_id));
                }
            } else {
                $this->session->set_flashdata('message', '<p class="alert alert-warning">Create Campaign First !!!</p>');
                redirect(base_url('project_new/campaign/?id=' . $project_id));
            }

            //get data search
            $data_sales_officer = $this->SalesOfficerModels->getSalesOfficerbyProjectId($project_id);
            $data_status = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status' => 1))->result();
            $data_product = $this->db->get_where('tbl_product', array('project_id' => $project_id, 'status' => 1))->result();
            $data_sales_team = $this->SalesTeamModels->getSalesTeamByProjectId($project_id);

            $data_lead_by_category = $this->LeadModels->getDataLeadByCategorybyProjectId($project_id);
            $data_lead_by_channel = $this->LeadModels->getDataLeadByChannelbyProjectId($project_id);
            $data_lead_by_campaign = $this->LeadModels->getDataLeadByCampaignbyProjectId($project_id);
        } elseif ($role == 3) {
            $get = $this->input->get();
            $project_id = $get['id'];
            $data_project = $this->db->get_where('tbl_project', array('id' => $project_id))->row();

            $sales_team_id = $this->MainModels->getSalesTeamId();

            $campaign_id = '';
            $channel_id = '';
            $sales_officer_id = '';

            $project_date = substr($data_project->create_at, 0, 10);
            $now = date('Y-m-d');
            $newDate = date('Y-m-d', strtotime($project_date));

            if (isset($get['search'])) {

                $campaign_id = $get['campaign_id'];
                $data_session_filter = array(
                    'campaign_id' => $get['campaign_id'],
                    'from' => $get['from'],
                    'to' => $get['to']
                );
                $this->session->set_userdata('filter', $data_session_filter);


                if ($get['lead_category_id'] != null) {
                    $lead_category_id = $get['lead_category_id'];
                } else {
                    $lead_category_id = 0;
                }

                if ($get['type_id'] != null) {
                    $type_id = $get['type_id'];
                } else {
                    $type_id = 0;
                }

                if ($get['status_id'] != null) {
                    $status_id = $get['status_id'];
                } else {
                    $status_id = 0;
                }

                if ($get['channel_id'] != null) {
                    $channel_id = $get['channel_id'];
                } else {
                    $channel_id = 0;
                }

                if ($get['sales_officer_id'] != null) {
                    $sales_officer_id = $get['sales_officer_id'];
                } else {
                    $sales_officer_id = 0;
                }

                $data_session_search = array(
                    'sales_team_id' => $sales_team_id,
                    'lead_category_id' => $lead_category_id,
                    'status_id' => $status_id,
                    'channel_id' => $channel_id,
                    'sales_officer_id' => $sales_officer_id,
                    'type_id' => $type_id
                );
                $this->session->set_userdata('search', $data_session_search);
            } else {

                $campaign_id = 0;
                $data_session_filter = array(
                    'campaign_id' => 0,
                    'from' => $newDate,
                    'to' => $now
                );
                $this->session->set_userdata('filter', $data_session_filter);

                $data_session_search = array(
                    'sales_team_id' => $sales_team_id,
                    'lead_category_id' => 0,
                    'status_id' => 0,
                    'channel_id' => 0,
                    'sales_officer_id' => 0,
                    'type_id' => 0
                );
                $this->session->set_userdata('search', $data_session_search);
            }

            //set session filter and search
            $session_filter = $this->session->userdata('filter');
            $session_search = $this->session->userdata('search');

            //get data lead
            $data_lead = $this->LeadModels->getDataLeadByProjectTable($project_id, $session_filter, $session_search);

            //validation when channel and campaign is null
            $data_campaign = $this->CampaignModels->getCampaignbyProjectId($project_id);
            if (!empty($data_campaign)) {
                $data_channel = $this->ChannelModels->getDataChannelbyProjectId($project_id);

                if (empty($data_channel)) {
                    $this->session->set_flashdata('message', '<p class="alert alert-warning">Create Channel First !!!</p>');
                    redirect(base_url('project_new/channel/?id=' . $project_id));
                }
            } else {
                $this->session->set_flashdata('message', '<p class="alert alert-warning">Create Campaign First !!!</p>');
                redirect(base_url('project_new/campaign/?id=' . $project_id));
            }

            //get data search
            $data_sales_officer = $this->SalesOfficerModels->getDataSalesOfficerbySalesTeamId($sales_team_id);
            $data_status = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status' => 1))->result();
            $data_product = $this->db->get_where('tbl_product', array('project_id' => $project_id, 'status' => 1))->result();
            $data_sales_team = $this->SalesTeamModels->getSalesTeamByProjectId($project_id);


            $data_lead_by_category = $this->LeadModels->getDataLeadByCategorybyProjectId($project_id);
            $data_lead_by_channel = $this->LeadModels->getDataLeadByChannelbyProjectId($project_id);
            $data_lead_by_campaign = $this->LeadModels->getDataLeadByCampaignbyProjectId($project_id);
        }

        $data_lead_category = $this->db->get_where('tbl_lead_category')->result();

        $data = array(
            'project_id' => $project_id,
            'now' => $now,
            'from' => $newDate,
            'to' => $now,
            'project_date' => $newDate,
            'data_lead' => $data_lead,
            'data_campaign' => $data_campaign,
            'data_lead_category' => $data_lead_category,
            'data_channel' => $data_channel,
            'data_status' => $data_status,
            'data_lead_status' => $data_status,
            'data_product' => $data_product,
            'data_chart_category' => $data_lead_by_category,
            'data_chart_channel' => $data_lead_by_channel,
            'data_chart_campaign' => $data_lead_by_campaign,
            'data_sales_officer' => $data_sales_officer,
            'data_sales_team' => $data_sales_team,
            'js' => $js,
            'css' => $css,
            'total' => count($data_lead),
            'campaign_id' => $campaign_id,
            'channel_id' => $channel_id,
            'sales_team_id' => $sales_team_id,
            'sales_officer_id' => $sales_officer_id,
        );

        $this->template->load('template__', 'project/leads/index', $data);
    }

    public function setting()
    {
        $role = $this->MainModels->UserSession('role_id');
        $datatable_assets = $this->MainModels->getAssets('datatable');
        $modals_assets = $this->MainModels->getAssets('modals');
        $daterangepicker_assets = $this->MainModels->getAssets('daterangepicker');
        $switch_assets = $this->MainModels->getAssets('switch');
        $project_setting_assets = $this->MainModels->getAssets('project_setting');

        $js = array_merge($datatable_assets['js'], $daterangepicker_assets['js'], $modals_assets['js'], $switch_assets['js'], $project_setting_assets['js']);
        $css = array_merge($datatable_assets['css'], $daterangepicker_assets['css'], $modals_assets['css'], $switch_assets['css'], $project_setting_assets['css']);

        if ($role == 1) {
            $project_id = 0;
            $data_lead = '';
            $data_status = '';
            $data_project = '';
        } else {
            $project_id = $this->input->get('id');
            $data_product = $this->ProductModels->getDataProductByProjectId($project_id);
            $data_status = $this->StatusModels->getDataStatusByProjectId($project_id);
            $data_project = $this->db->get_where('tbl_project', array('id' => $project_id))->row();
        }

        $data = array(
            'project_id' => $project_id,
            'data_status' => $data_status,
            'data_product' => $data_product,
            'data_project' => $data_project,
            'js' => $js,
            'css' => $css,
        );

        $this->template->load('template__', 'project/setting/index', $data);
    }

    public function add_channel()
    {
        $channel_form_wizard_assets = $this->MainModels->getAssets('channel-form-wizard');
        $select2_assets = $this->MainModels->getAssets('select2');
        $input_mask = $this->MainModels->getAssets('input-mask');

        $js = array_merge($channel_form_wizard_assets['js'], $select2_assets['js'], $input_mask['js']);
        $css = array_merge($channel_form_wizard_assets['css'], $select2_assets['css'], $input_mask['css']);

        $data = array(
            'js' => $js,
            'css' => $css,
        );

        $post = $this->input->post();
        $media_id = $post['media_id'];
        $picture_media = $this->db->get_where('tbl_media', array('id' => $media_id))->row('media_pic');

        $file_name = 'https://jala.ai/dashboard/assets/picture/media/' . $picture_media;

        $insert_channel = $this->ChannelModels->addChannel($post, $file_name);
        $this->session->set_flashdata('message', $insert_channel['message']);

        redirect(base_url('project/channel/?id=' . $post['project_id']));
        //}
    }

    public function add_channel_action()
    {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');

        $post = $this->input->post();

        $media_id = $post['media_id'];
        $project_id = $post['project_id'];

        $picture_media = $this->db->get_where('tbl_media', array('id' => $media_id))->row('media_pic');

        $file_name = 'https://jala.ai/dashboard/assets/picture/media/' . $picture_media;

        $data_insert = array(
            'channel_name' => $post['channel_name'],
            'campaign_id' => $post['campaign_id'],
            'channel_media' => $post['media_id'],
            'channel_url' => $post['landingPageUrl'],
            'channel_redirect_url' => $post['redirectPageUrl'],
            'unique_code' => $post['uniqueCode'],
            'channel_detail' => $post['channel_detail'],
            'channel_picture' => $file_name,
            'create_by' => 1
        );

        $sales_team = $post['sales_team'];

        // foreach ($sales_team as $key => $value) {
        //     echo $key."<br>";
        // }
        // exit;

        $insert_channel = $this->db->insert('tbl_channel', $data_insert);

        if ($insert_channel) {

            $channel_id = $this->db->insert_id();

            foreach ($sales_team as $sales_team_id) {
                $data_insert_sales_team_channel = array('sales_team_id' => $sales_team_id, 'channel_id' => $channel_id);

                $insert_sales_team_channel = $this->db->insert('tbl_sales_team_channel', $data_insert_sales_team_channel);

                if ($insert_sales_team_channel) {
                    $response = 'success';
                    $status = 200;
                    $message = '<p class="alert alert-success"> Success Add Channel </p>';
                    $redirect = base_url("project/channel/?id=" . $project_id);
                } else {
                    $response = 'error';
                    $status = 400;
                    $message = '<p class="alert alert-danger"> Error Add Channel </p>';
                    $redirect = base_url("channel/wizard/?id=" . $project_id);
                }
            }
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Add Channel </p>';
            $redirect = base_url("channel/wizard/?id=" . $project_id);
        }

        $data = array('res' => $response, 'status' => $status, 'redirect' => $redirect);

        echo json_encode($data);
    }

    public function add_campaign()
    {
        $post = $this->input->post();
        $config['upload_path'] = 'assets/picture/campaign';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = true;
        $config['overwrite'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('campaign_picture')) {
            $error = array('error' => $this->upload->display_errors());
            $message = '<p class="alert alert-danger"> ' . $error['error'] . ' </p>';
            $this->session->set_flashdata('message', $message);

            $default_pic = array('https://jala.ai/dashboard/assets/picture/campaign/default-campaign-1.png', 'https://jala.ai/dashboard/assets/picture/campaign/default-campaign-2.png');

            $random = array_rand($default_pic);

            $file_name = $default_pic[$random];

            $insert_campaign = $this->CampaignModels->addCampaign($post, $file_name);
            $this->session->set_flashdata('message', $insert_campaign['message']);

            redirect(base_url('project_new/campaign/?id=' . $post['project_id']));
            redirect(base_url('project_new/campaign/?id=' . $post['project_id']));
        } else {
            $data = array('upload_data' => $this->upload->data());

            $config['image_library'] = 'gd2';
            $config['source_image'] = 'assets/picture/' . $data['upload_data']['file_name'];
            $config['create_thumb'] = false;
            $config['maintain_ratio'] = false;
            $config['quality'] = '100%';
            $config['width'] = 600;
            $config['height'] = 250;
            $config['new_image'] = 'assets/picture/' . $data['upload_data']['file_name'];
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();

            $file_name = base_url('assets/picture/campaign/') . $data['upload_data']['file_name'];

            $insert_campaign = $this->CampaignModels->addCampaign($post, $file_name);
            $this->session->set_flashdata('message', $insert_campaign['message']);

            redirect(base_url('project_new/campaign/?id=' . $post['project_id']));
        }
    }

    public function add_product()
    {
        $post = $this->input->post();
        $insert_product = $this->ProductModels->addProduct($post);
        $this->session->set_flashdata('message', $insert_product['message']);

        redirect(base_url('project_new/setting/?id=' . $post['project_id']));
    }

    public function edit_project()
    {
        $post = $this->input->post();

        $edit_project = $this->ProjectModels->editProject($post);
        $this->session->set_flashdata('message', $edit_project['message']);

        redirect(base_url('project_new/setting/?id=' . $post['project_id']));
    }

    public function edit_channel_new()
    {

        $id = $this->input->get('id');
        $channel_assets = $this->MainModels->getAssets('channel');
        $select2_assets = $this->MainModels->getAssets('select2');

        $data_channel = $this->db->get_where('tbl_channel', array('id' => $id))->row();
        $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel', array('channel_id' => $id))->result();
        $list_sales_team_id = array();

        $campaign_id = $data_channel->campaign_id;

        if (!empty($data_sales_team_channel)) {
            foreach ($data_sales_team_channel as $value) {
                array_push($list_sales_team_id, $value->sales_team_id);
            }
        }

        $js = array_merge($select2_assets['js'], $channel_assets['js']);
        $css = array_merge($select2_assets['css'], $channel_assets['css']);

        //get project id
        $project_id = $this->db->get_where('tbl_campaign', array('id' => $campaign_id))->row('project_id');
        $data_sales_team = $this->db->get_where('tbl_sales_team', array('client_id' => $this->MainModels->getClientId()))->result();

        $data = array(
            'js' => $js,
            'project_id' => $project_id,
            'data_sales_team' => $data_sales_team,
            'css' => $css,
            'data_channel' => $data_channel,
            'list_sales_team' => $list_sales_team_id
        );

        $this->template->load('template__', 'project/channel/edit_channel', $data);
    }

    public function edit_channel()
    {
        $post = $this->input->post();

//        $config['upload_path'] = 'assets/picture/channel';
        //        $config['allowed_types'] = 'gif|jpg|png';
        //        $config['encrypt_name'] = TRUE;
        //        $config['overwrite'] = TRUE;
        //
        //        $this->load->library('upload', $config);
        //
        //        if (!$this->upload->do_upload('channel_picture')) {
        //            $error = array('error' => $this->upload->display_errors());
        //            $message = '<p class="alert alert-danger"> ' . $error['error'] . ' </p>';
        //
        //            $file_name = 'https://source.unsplash.com/random';
        //
        //            $update_channel = $this->ChannelModels->editChannel($post, $file_name);
        //            $this->session->set_flashdata('message', $update_channel['message']);
        //
        //            redirect(base_url('project/channel/?id=' . $post['project_id']));
        //        } else {
        //            $data = array('upload_data' => $this->upload->data());
        //
        //            $media_id = $post['media_id'];
        //            $picture_media = $this->db->get_where('tbl_media', array('id' => $media_id))->row('media_pic');

        $media_id = $post['media_id'];
        $picture_media = $this->db->get_where('tbl_media', array('id' => $media_id))->row('media_pic');
        $file_name = 'https://jala.ai/dashboard/assets/picture/media/' . $picture_media;

        $update_channel = $this->ChannelModels->editChannel($post, $file_name);
        $this->session->set_flashdata('message', $update_channel['message']);

        redirect(base_url('project_new/channel/?id=' . $post['project_id']));
        //}
    }

    public function edit_campaign()
    {
        $post = $this->input->post();
        $config['upload_path'] = 'assets/picture/campaign';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['encrypt_name'] = true;
        $config['overwrite'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('campaign_picture')) {

            $error = array('error' => $this->upload->display_errors());

            $message = '<p class="alert alert-danger"> ' . $error['error'] . ' </p>';

            $default_pic = array('https://jala.ai/dashboard/assets/picture/campaign/default-campaign-1.png', 'https://jala.ai/dashboard/assets/picture/campaign/default-campaign-2.png');

            $random = array_rand($default_pic);

//            $file_name = $default_pic[$random];
            $file_name = '' ;

            $update_campaign = $this->CampaignModels->editCampaign($post, $file_name);
            $this->session->set_flashdata('message', $update_campaign['message']);

            redirect(base_url('project_new/campaign/?id=' . $post['project_id']));
        } else {

            $data = array('upload_data' => $this->upload->data());

            $file_name = base_url('assets/picture/campaign/') . $data['upload_data']['file_name'];

            $update_campaign = $this->CampaignModels->editCampaign($post, $file_name);
            $this->session->set_flashdata('message', $update_campaign['message']);

            redirect(base_url('project_new/campaign/?id=' . $post['project_id']));
        }
    }

    public function edit_product()
    {
        $post = $this->input->post();
        $update_product = $this->ProductModels->editProduct($post);
        $this->session->set_flashdata('message', $update_product['message']);

        redirect(base_url('project/setting/?id=' . $post['project_id']));
    }

    public function edit_status()
    {
        $post = $this->input->post();
        $update_status = $this->StatusModels->editStatus($post);
        $this->session->set_flashdata('message', $update_status['message']);

        redirect(base_url('project/setting/?id=' . $post['project_id']));
    }

    public function getDataCampaignEdit()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $id = $this->input->get('id');

        $data_campaign = $this->db->get_where('tbl_campaign', array('id' => $id))->row();

        $data = array(
            'res' => 200,
            'data' => $data_campaign,
        );

        echo json_encode($data);
    }

    public function getDataChannelEdit()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $id = $this->input->get('id');

        $data_channel = $this->db->get_where('tbl_channel', array('id' => $id))->row();
        $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel', array('channel_id' => $id))->result();

        $list_sales_team = array();

        if (!empty($data_sales_team_channel)) {
            foreach ($data_sales_team_channel as $value) {
                array_push($list_sales_team, $value->sales_team_id);
            }
        }

        $data = array(
            'res' => 200,
            'data' => $data_channel,
            'participate_sales_team' => $list_sales_team
        );

        echo json_encode($data);
    }

    public function getDataProductEdit()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $id = $this->input->get('id');

        $data_product = $this->db->get_where('tbl_product', array('id' => $id))->row();

        $data = array(
            'res' => 200,
            'data' => $data_product,
        );

        echo json_encode($data);
    }

    public function getDataStatusEdit()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $id = $this->input->get('id');

        $data_status = $this->db->get_where('tbl_status', array('id' => $id))->row();

        $data = array(
            'res' => 200,
            'data' => $data_status,
        );

        echo json_encode($data);
    }

    public function reset_filter()
    {
        $data_session_search = array('sales_team_id' => 0, 'lead_category_id' => 0, 'status_id' => 0, 'channel_id' => 0, 'sales_officer_id' => 0);
        $this->session->set_userdata('search', $data_session_search);

        $this->session->set_flashdata('message', '<p class="alert alert-success">Filter has been reset  !!!</p>');

        redirect(base_url('project_new/leads/?id=' . $this->input->get('id')));
    }

    public function import_excel_migrate()
    {
        $project_id = $this->input->get('id');

        $file_input_assets = $this->MainModels->getAssets('file-input');

        $js = array_merge($file_input_assets['js']);
        $css = array_merge($file_input_assets['css']);

        $data_channel = $this->ChannelModels->getDataChannelUploadbyProjectId($project_id);

        if (empty($data_channel)) {
            $this->session->set_flashdata('message', '<p class="alert alert-warning">Create channel upload lead first  !!!</p>');

            redirect(base_url('project/channel/?id=' . $this->input->get('id')));
        }

        $data = array(
            'project_id' => $project_id,
            'js' => $js,
            'data_channel' => $data_channel,
            'css' => $css,
        );

        $this->template->load('template', 'project/import-excel-migrate', $data);
    }

    public function import_excel()
    {
        $project_id = $this->input->get('id');

        $file_input_assets = $this->MainModels->getAssets('file-input');

        $js = array_merge($file_input_assets['js']);
        $css = array_merge($file_input_assets['css']);

        $data_channel = $this->ChannelModels->getDataChannelUploadbyProjectId($project_id);

        if (empty($data_channel)) {
            $this->session->set_flashdata('message', '<p class="alert alert-warning">Create channel upload lead first  !!!</p>');

            redirect(base_url('project_new/channel/?id=' . $this->input->get('id')));
        }

        $data = array(
            'project_id' => $project_id,
            'js' => $js,
            'data_channel' => $data_channel,
            'css' => $css,
        );

        $this->template->load('template__', 'project/import-excel', $data);
    }

    private $filename = 'import_data'; // Kita tentukan nama filenya

    public function import_action()
    {
        // Load plugin PHPExcel nya

        $this->load->model('SiswaModel');

        $upload = $this->SiswaModel->upload_file($this->filename);

        $channel_id = $this->input->post('channel_id');
        $project_id = $this->input->post('project_id');

        //get status_id new leads
        $status_id = $this->db->get_where('tbl_status', array('status_name' => 'New Leads', 'project_id' => $project_id))->row('id');

        if ($upload['result'] == 'success') { // Jika proses upload sukses
            // Load plugin PHPExcel nya
            include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

            $excelreader = new PHPExcel_Reader_Excel2007();
            $loadexcel = $excelreader->load('assets/excel/' . $this->filename . '.xlsx'); // Load file yang telah diupload ke folder excel
            $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

            // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
            $data = array();

            $numrow = 1;
            foreach ($sheet as $row) {
                // Cek $numrow apakah lebih dari 1
                // Artinya karena baris pertama adalah nama-nama kolom
                // Jadi dilewat saja, tidak usah diimport
                if ($numrow > 1) {
//                    if ($row['E'] == 'Pria' || $row['E'] == 'Laki-laki') {
//                        $gender = 1;
//                    } else {
//                        $gender = 2;
//                    }
                    // Kita push (add) array data ke variabel data

                    $test = $this->get_first_char($row['C']);

//                    if ($test == '0') {
//                        $ptn = '/^0/'; // Regex
//                        $str = $row['C']; //Your input, perhaps $_POST['textbox'] or whatever
//                        $rpltxt = '+62'; // Replacement string
//                        $phone_new = preg_replace($ptn, $rpltxt, $str);
//                    } else {
//                        $phone_new = '+62' . $row['C'];
//                    }

                    array_push($data, array(
                        'lead_name' => $row['A'], // Ambil data nama
                        'lead_address' => $row['B'], // Ambil data alamat
                        'lead_phone' => $row['C'],
                        'lead_email' => $row['D'], // Ambil data jenis kelamin
                        'note' => $row['E'], // Ambil data alamat
                        'channel_id' => $channel_id,
                        'status_id' => $status_id,
                    ));
                }

                ++$numrow; // Tambah 1 setiap kali looping
            }

            // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
            $this->load->model('SiswaModel');

            $this->SiswaModel->insert_multiple($data);
            $this->session->set_flashdata('message', '<p class="alert alert-success"> Data berhasil di import !!!  </p>');
            redirect(base_url('project_new/leads/?id=' . $project_id));
        } else { // Jika proses upload gagal
            $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
            $this->session->set_flashdata('message', '<p class="alert alert-success"> ' . $data['upload_error'] . '  </p>');
            redirect(base_url('project_new/leads/?id=' . $project_id));
        }
    }

    public function import_action_migrate()
    {
        // Load plugin PHPExcel nya

        $this->load->model('SiswaModel');
        $upload = $this->SiswaModel->upload_file($this->filename);

        $channel_id = $this->input->post('channel_id');
        $project_id = $this->input->post('project_id');

        //get status_id new leads
        //        $status_id = $this->db->get_where('tbl_status', array('status_name' => 'New Lead', 'project_id' => $project_id))->row('id');

        if ($upload['result'] == 'success') { // Jika proses upload sukses
            // Load plugin PHPExcel nya
            include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

            $excelreader = new PHPExcel_Reader_Excel2007();
            $loadexcel = $excelreader->load('assets/excel/' . $this->filename . '.xlsx'); // Load file yang telah diupload ke folder excel
            $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

            // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
            $data = array();

            $numrow = 1;
            foreach ($sheet as $row) {
                // Cek $numrow apakah lebih dari 1
                // Artinya karena baris pertama adalah nama-nama kolom
                // Jadi dilewat saja, tidak usah diimport
                if ($numrow > 1) {
                    // Kita push (add) array data ke variabel data
//                    $test = $this->get_first_char($row['E']);
//
//                    if ($test == '8') {
//                        //$ptn = '/^0/'; // Regex
//                        //$str = $row['E']; //Your input, perhaps $_POST['textbox'] or whatever
//                        //$rpltxt = '+62'; // Replacement string
//                        //$phone_new = preg_replace($ptn, $rpltxt, $str);
//                        $phone_new = '62' . $row['E'];
//                    } else {
//                        $phone_new = $row['E'];
//                    }
//
//                    switch ($row['I']) {
//                        case 1:
//                            $st = 103;
//                            $lc = 1;
//                            break;
//                        case 2:
//                            $st = 111;
//                            $lc = 7;
//                            break;
//                        case 3:
//                            $st = 104;
//                            $lc = 2;
//                            break;
//                        case 4:
//                            $st = 109;
//                            $lc = 3;
//                            break;
//                        case 5:
//                            $st = 113;
//                            $lc = 4;
//                            break;
//                        case 6:
//                            $st = 112;
//                            $lc = 3;
//                            break;
//                        case 7:
//                            $st = 114;
//                            $lc = 7;
//                            break;
//                        case 8:
//                            $st = 108;
//                            $lc = 5;
//                            break;
//                        case 9:
//                            $st = 110;
//                            $lc = 4;
//                            break;
//                        default:
//                            $st = 103;
//                            $lc = 1;
//                            break;
//                    }

                    array_push($data, array(
                        'create_date' => $row['A'],
                        'update_date' => $row['A'],
                        'lead_name' => $row['B'], // Ambil data nama
                        'lead_phone' => $row['E'],
                        'lead_email' => $row['F'], // Ambil data jenis kelamin
                        'lead_category_id' => $row['G'],
                        'status_id' => $row['H'],
                        'channel_id' => $row['I'],
                        'product_id' => $row['J'],
                        'lead_city' => $row['D']
                    ));
                }

                ++$numrow; // Tambah 1 setiap kali looping
            }

            // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
            $this->load->model('SiswaModel');


            $insert = $this->SiswaModel->insert_multiple($data);

            if ($insert) {
                $this->session->set_flashdata('message', '<p class="alert alert-success"> Data berhasil di import !!!  </p>');
                redirect(base_url('project_new/leads/?id=' . $project_id));
            } else {
                $this->session->set_flashdata('message', '<p class="alert alert-danger"> Data gagal di import !!!  </p>');
                redirect(base_url('project_new/leads/?id=' . $project_id));
            }
        } else { // Jika proses upload gagal
            $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
            $this->session->set_flashdata('message', '<p class="alert alert-success"> ' . $data['upload_error'] . '  </p>');
            redirect(base_url('project_new/leads/?id=' . $project_id));
        }
    }

    public function import_action_migrate_history()
    {
        // Load plugin PHPExcel nya

        $this->load->model('SiswaModel');
        $upload = $this->SiswaModel->upload_file($this->filename);

        $channel_id = $this->input->post('channel_id');
        $project_id = $this->input->post('project_id');

        //get status_id new leads
        //        $status_id = $this->db->get_where('tbl_status', array('status_name' => 'New Lead', 'project_id' => $project_id))->row('id');

        if ($upload['result'] == 'success') { // Jika proses upload sukses
            // Load plugin PHPExcel nya
            include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

            $excelreader = new PHPExcel_Reader_Excel2007();
            $loadexcel = $excelreader->load('assets/excel/' . $this->filename . '.xlsx'); // Load file yang telah diupload ke folder excel
            $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

            // Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
            $data = array();

            $numrow = 1;
            foreach ($sheet as $row) {
                // Cek $numrow apakah lebih dari 1
                // Artinya karena baris pertama adalah nama-nama kolom
                // Jadi dilewat saja, tidak usah diimport
                if ($numrow > 1) {
                    // Kita push (add) array data ke variabel data
                    // $test = $this->get_first_char($row['D']);
                    // if ($test == '0') {
                    //     $ptn = '/^0/'; // Regex
                    //     $str = $row['D']; //Your input, perhaps $_POST['textbox'] or whatever
                    //     $rpltxt = '+62'; // Replacement string
                    //     $phone_new = preg_replace($ptn, $rpltxt, $str);
                    // } else {
                    //     $phone_new = '+62'.$row['D'];
                    // }

                    switch ($row['D']) {
                        case 1:
                            $st = 13;
                            $lc = 1;
                            break;
                        case 2:
                            $st = 18;
                            $lc = 7;
                            break;
                        case 3:
                            $st = 14;
                            $lc = 2;
                            break;
                        case 4:
                            $st = 16;
                            $lc = 3;
                            break;
                        case 5:
                            $st = 20;
                            $lc = 4;
                            break;
                        case 6:
                            $st = 19;
                            $lc = 3;
                            break;
                        case 7:
                            $st = 21;
                            $lc = 7;
                            break;
                        case 8:
                            $st = 15;
                            $lc = 5;
                            break;
                        case 9:
                            $st = 17;
                            $lc = 4;
                            break;
                        default:
                            $st = 1;
                            $lc = 1;
                            break;
                    }

                    array_push($data, array(
                        'create_date' => $row['E'],
                        'lead_id' => $row['B'], // Ambil data nama
                        'category_id' => $lc,
                        'status_id' => $st,
                        'notes' => $row['F'],
                        'sales_officer_id' => $row['C'],
                        'point' => $row['G'],
                    ));
                }

                ++$numrow; // Tambah 1 setiap kali looping
            }

            // Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
            $this->load->model('SiswaModel');

            $this->SiswaModel->insert_multiple_history($data);
            $this->session->set_flashdata('message', '<p class="alert alert-success"> Data berhasil di import !!!  </p>');
            redirect(base_url('project_new/leads/?id=' . $project_id));
        } else { // Jika proses upload gagal
            $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
            $this->session->set_flashdata('message', '<p class="alert alert-success"> ' . $data['upload_error'] . '  </p>');
            redirect(base_url('project_new/leads/?id=' . $project_id));
        }
    }

    public function getCheckMedia()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $id = $this->input->get('id');

        $data_media = $this->db->get_where('tbl_media', array('id' => $id))->row();

        $data = array(
            'res' => 200,
            'data' => $data_media,
        );

        echo json_encode($data);
    }

    public function add_product_()
    {
        $post = $this->input->post();
        $config['upload_path'] = 'assets/picture/product';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = true;
        $config['overwrite'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('campaign_picture')) {
            $error = array('error' => $this->upload->display_errors());
            $message = '<p class="alert alert-danger"> ' . $error['error'] . ' </p>';
            $this->session->set_flashdata('message', $message);

            $default_pic = array('https://jala.ai/dashboard/assets/picture/campaign/default-campaign-1.png', 'https://jala.ai/dashboard/assets/picture/campaign/default-campaign-2.png');

            $random = array_rand($default_pic);

            $file_name = $default_pic[$random];

            $insert_campaign = $this->CampaignModels->addCampaign($post, $file_name);
            $this->session->set_flashdata('message', $insert_campaign['message']);

            redirect(base_url('project/campaign/?id=' . $post['project_id']));
        } else {
            $data = array('upload_data' => $this->upload->data());

            $config['image_library'] = 'gd2';
            $config['source_image'] = 'assets/picture/' . $data['upload_data']['file_name'];
            $config['create_thumb'] = false;
            $config['maintain_ratio'] = false;
            $config['quality'] = '100%';
            $config['width'] = 600;
            $config['height'] = 250;
            $config['new_image'] = 'assets/picture/' . $data['upload_data']['file_name'];
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();

            $file_name = 'https://jala.ai/dashboard/assets/picture/campaign/' . $data['upload_data']['file_name'];

            $insert_campaign = $this->CampaignModels->addCampaign($post, $file_name);
            $this->session->set_flashdata('message', $insert_campaign['message']);

            redirect(base_url('project/campaign/?id=' . $post['project_id']));
        }
    }

    public function getCategories()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $get = $this->input->get();
        $project_id = $get['project_id'];

        //get data filter
        $create_at = $this->db->get_where('tbl_project', array('id' => $project_id))->row('create_at');
        $project_date = substr($create_at, 0, 10);
        $now = date('Y-m-d');
        $newDate = date('Y-m-d', strtotime($project_date));


        //set session filter & session search
        if (isset($get['search'])) {

            $campaign_id = $get['campaign_id'];
            $data_session_filter = array(
                'campaign_id' => $get['campaign_id'],
                'from' => $get['from'],
                'to' => $get['to']
            );
            $this->session->set_userdata('filter', $data_session_filter);


            if ($get['sales_team_id'] != null) {
                $sales_team_id = $get['sales_team_id'];
            } else {
                $sales_team_id = 0;
            }

            if ($get['lead_category_id'] != null) {
                $lead_category_id = $get['lead_category_id'];
            } else {
                $lead_category_id = 0;
            }

            if ($get['type_id'] != null) {
                $type_id = $get['type_id'];
            } else {
                $type_id = 0;
            }

            if ($get['status_id'] != null) {
                $status_id = $get['status_id'];
            } else {
                $status_id = 0;
            }

            if ($get['channel_id'] != null) {
                $channel_id = $get['channel_id'];
            } else {
                $channel_id = 0;
            }

            if ($get['sales_officer_id'] != null) {
                $sales_officer_id = $get['sales_officer_id'];
            } else {
                $sales_officer_id = 0;
            }

            $data_session_search = array(
                'sales_team_id' => $sales_team_id,
                'lead_category_id' => $lead_category_id,
                'status_id' => $status_id,
                'channel_id' => $channel_id,
                'sales_officer_id' => $sales_officer_id,
                'type_id' => $type_id
            );
            $this->session->set_userdata('search', $data_session_search);
        } else {

            $campaign_id = 0;
            $data_session_filter = array(
                'campaign_id' => 0,
                'from' => $newDate,
                'to' => $now
            );
            $this->session->set_userdata('filter', $data_session_filter);

            $data_session_search = array(
                'sales_team_id' => 0,
                'lead_category_id' => 0,
                'status_id' => 0,
                'channel_id' => 0,
                'sales_officer_id' => 0,
                'type_id' => 0
            );
            $this->session->set_userdata('search', $data_session_search);
        }

        $data_lead_by_category = $this->LeadModelsNew->getDataLeadByCategorybyProjectId($project_id);

        $label = array();
        $total = array();
        $bg = array();

        if (!empty($data_lead_by_category)) {
            foreach ($data_lead_by_category as $dl) {
                array_push($label, $dl['category_name']);
                array_push($total, $dl['total']);
                array_push($bg, $dl['bg']);
            }
        }

        $data = array('label' => $label, 'total' => $total, 'background' => $bg);

        echo json_encode($data);
    }

    public function getChannels()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $get = $this->input->get();
        $project_id = $get['project_id'];

        //get data filter
        $create_at = $this->db->get_where('tbl_project', array('id' => $project_id))->row('create_at');
        $project_date = substr($create_at, 0, 10);
        $now = date('Y-m-d');
        $newDate = date('Y-m-d', strtotime($project_date));
        $page = $this->input->get('page') * 5;

        //set session filter & session search
        if (isset($get['search'])) {

            $campaign_id = $get['campaign_id'];
            $data_session_filter = array(
                'campaign_id' => $get['campaign_id'],
                'from' => $get['from'],
                'to' => $get['to']
            );
            $this->session->set_userdata('filter', $data_session_filter);


            if ($get['sales_team_id'] != null) {
                $sales_team_id = $get['sales_team_id'];
            } else {
                $sales_team_id = 0;
            }

            if ($get['lead_category_id'] != null) {
                $lead_category_id = $get['lead_category_id'];
            } else {
                $lead_category_id = 0;
            }

            if ($get['type_id'] != null) {
                $type_id = $get['type_id'];
            } else {
                $type_id = 0;
            }

            if ($get['status_id'] != null) {
                $status_id = $get['status_id'];
            } else {
                $status_id = 0;
            }

            if ($get['channel_id'] != null) {
                $channel_id = $get['channel_id'];
            } else {
                $channel_id = 0;
            }

            if ($get['sales_officer_id'] != null) {
                $sales_officer_id = $get['sales_officer_id'];
            } else {
                $sales_officer_id = 0;
            }

            $data_session_search = array(
                'sales_team_id' => $sales_team_id,
                'lead_category_id' => $lead_category_id,
                'status_id' => $status_id,
                'channel_id' => $channel_id,
                'sales_officer_id' => $sales_officer_id,
                'type_id' => $type_id
            );
            $this->session->set_userdata('search', $data_session_search);
        } else {

            $campaign_id = 0;
            $data_session_filter = array(
                'campaign_id' => 0,
                'from' => $newDate,
                'to' => $now
            );
            $this->session->set_userdata('filter', $data_session_filter);

            $data_session_search = array(
                'sales_team_id' => 0,
                'lead_category_id' => 0,
                'status_id' => 0,
                'channel_id' => 0,
                'sales_officer_id' => 0,
                'type_id' => 0
            );
            $this->session->set_userdata('search', $data_session_search);
        }
        //$data_lead = $this->LeadModels->getDataLeadByProjectTable($project_id, $session_filter, $session_search);
        $data_lead_by_channel = $this->LeadModels->getDataLeadByChannelbyProjectIdChart($project_id, $page);

        usort($data_lead_by_channel, function ($a, $b) {
            return $b['total'] <=> $a['total'];
        });
        //var_dump($data_lead_by_channel);

        $label = array();
        $total = array();
        $bg = array();

        if (!empty($data_lead_by_channel)) {
            foreach ($data_lead_by_channel as $dl) {
                array_push($label, $dl['channel_name']);
                array_push($total, $dl['total']);
                array_push($bg, '#FFB7B3');
            }
        }

        $data = array('label' => $label, 'total' => $total, 'background' => $bg);

        echo json_encode($data);
    }

    public function product()
    {
        $role = $this->MainModels->UserSession('role_id');
        $datatable_assets = $this->MainModels->getAssets('datatable');
        $modals_assets = $this->MainModels->getAssets('modals');
        $daterangepicker_assets = $this->MainModels->getAssets('daterangepicker');
        $switch_assets = $this->MainModels->getAssets('switch');
        $project_setting_assets = $this->MainModels->getAssets('project_setting');

        $js = array_merge($datatable_assets['js'], $daterangepicker_assets['js'], $modals_assets['js'], $switch_assets['js'], $project_setting_assets['js']);
        $css = array_merge($datatable_assets['css'], $daterangepicker_assets['css'], $modals_assets['css'], $switch_assets['css'], $project_setting_assets['css']);

        if ($role == 1) {
            $project_id = 0;
            $data_lead = '';
            $data_status = '';
            $data_project = '';
        } else {
            $project_id = $this->input->get('id');
            $data_product = $this->ProductModels->getDataProductByProjectId($project_id);
        }

        $data = array(
            'project_id' => $project_id,
            'data_product' => $data_product,
            'js' => $js,
            'css' => $css,
        );

        $this->template->load('template__', 'project/product/index', $data);
    }

}
