<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Team extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (empty($this->MainModels->UserSession('user_id'))) {
            $this->session->set_flashdata('message', '<p style="color:black;" class="alert alert-warning">Login First to Create Session !!!</p>');
            redirect(base_url('login'));
        } else {
            $this->load->model('TeamModels');
            $this->load->model('LeadModels');
            $this->load->model('SalesOfficerModels');
            $this->load->model('StatusModels');
            $this->load->model('ComponentModels');

            $user_id = $this->MainModels->UserSession('user_id');
            $data_user = $this->db->get_where('tbl_user', array('user_id' => $user_id))->row();

            $client_date = substr($data_user->create_at, 0, 10);
            $now = date('Y-m-d');
            $newDate = date("Y-m-d", strtotime($client_date));

            $from = $newDate;
            $to = $now;

            $data_session_dashboard = array(
                'project_id' => 0,
                'from' => $from,
                'to' => $to,
                'category_id_1' => 0,
                'category_id_2' => 0
            );

            $this->session->set_userdata('dashboard', $data_session_dashboard);
        }
    }

    public function index()
    {

        $data = array(
            'title' => 'Team',
        );

        $this->template->load('template__', 'team/index', $data);

    }

    public function client()
    {
        $datatable_assets = $this->MainModels->getAssets('datatable');
        $team_assets = $this->MainModels->getAssets('team');
        $modal_asstes = $this->MainModels->getAssets('modal');

        $js = array_merge($datatable_assets['js'], $team_assets['js'], $modal_asstes['js']);
        $css = array_merge($datatable_assets['css'], $modal_asstes['css']);

        if ($this->MainModels->UserSession('role_id') == 1) {
            $data_client = $this->TeamModels->getDataClientAll();
        } else {
            $data_client = $this->TeamModels->getDataSalesTeamByClientId($data_client->client_id);
        }

        $data = array(
            'title' => 'Client',
            'action_add' => base_url('team/add_client'),
            'action_edit' => base_url('team/edit_client'),
            'data_client' => $data_client,
            'js' => $js,
            'css' => $css
        );

        $this->template->load('template', 'team/client', $data);
    }

    public function add_client()
    {
        $post = $this->input->post();
        $select2_assets = $this->MainModels->getAssets('select2');

        $js = array_merge($select2_assets['js']);
        $css = array_merge($select2_assets['css']);

        if ($post) {

            $insert_client = $this->TeamModels->addClient($post);
            $this->session->set_flashdata('message', $insert_client['message']);

            redirect(base_url('team/client'));
        }

        $data = array(
            'function' => 'add',
            'js' => $js,
            'css' => $css
        );

        $this->template->load('template', 'team/form-client', $data);
    }

    public function sales_team()
    {

        $datatable_assets = $this->MainModels->getAssets('datatable');
        $team_assets = $this->MainModels->getAssets('team');

        $js = array_merge($datatable_assets['js'], $team_assets['js']);
        $css = array_merge($datatable_assets['css'], $team_assets['css']);
        $role = $this->MainModels->UserSession('role_id');

        if ($role == 1) {
            $data_team = $this->TeamModels->getDataSalesTeamAll();
            $data_client = $this->db->get('tbl_client')->result();
            $data_chart_team = array();
        } else if ($role == 2) {
            $client_id = $this->MainModels->getClientId();
            $data_client = '';
            $data_team = $this->TeamModels->getDataSalesTeamByClientId($client_id);

            $list_sales_team = array();

            foreach ($data_team as $dt) {
                array_push($list_sales_team, $dt->sales_team_id);
            }

            if (!empty($list_sales_team)) {
                $data_chart_team = $this->LeadModels->getDataLeadBySalesTeam($list_sales_team);
            } else {
                $data_chart_team = array();
            }
        } else if ($role == 5) {
            $client_id = $this->MainModels->getClientId();
            $data_client = '';
            $data_team = $this->TeamModels->getDataSalesTeambyClientAdminId();

            $list_sales_team = array();

            foreach ($data_team as $dt) {
                array_push($list_sales_team, $dt->sales_team_id);
            }

            if (!empty($list_sales_team)) {
                $data_chart_team = $this->LeadModels->getDataLeadBySalesTeam($list_sales_team);
            } else {
                $data_chart_team = array();
            }
        }

        $data = array(
            'title' => 'Sales Team',
            'action_add' => base_url('team/add_sales_team'),
            'action_edit' => base_url('team/edit_sales_team'),
            'data_client' => $data_client,
            'data_chart_team' => $data_chart_team,
            'data_team' => $data_team,
            'js' => $js,
            'total' => count($data_team),
            'css' => $css
        );

        $this->template->load('template__', 'team/sales_team', $data);
    }

    public function add_sales_team()
    {

        $post = $this->input->post();
        $select2_assets = $this->MainModels->getAssets('select2');
        $user_assets = $this->MainModels->getAssets('user');

        $js = array_merge($select2_assets['js'], $user_assets['js']);
        $css = array_merge($select2_assets['css'], $user_assets['css']);

        if ($post) {

            $insert_sales_team = $this->TeamModels->addSalesTeam($post);
            $this->session->set_flashdata('message', $insert_sales_team['message']);

            redirect(base_url('team/sales_team'));
        }

        $data_client = $this->db->get_where('tbl_client', array('status' => 1))->result();
        $data_kota = $this->db->get('tbl_kota')->result();

        $data = array(
            'action_add' => base_url('user/add'),
            'data_client' => $data_client,
            'function' => 'add',
            'data_kota' => $data_kota,
            'js' => $js,
            'css' => $css
        );

        $this->template->load('template__', 'team/form-salesteam', $data);
    }

    public function edit_sales_team()
    {

        $sales_team_id = $this->input->get('id');
        $post = $this->input->post();
        $select2_assets = $this->MainModels->getAssets('select2');

        $js = array_merge($select2_assets['js']);
        $css = array_merge($select2_assets['css']);

        if ($post) {

            $update_sales_team = $this->TeamModels->EditSalesTeam($post);
            $this->session->set_flashdata('message', $update_sales_team['message']);

            redirect(base_url('team/sales_team'));
        }

        $data_client = $this->db->get_where('tbl_client', array('status' => 1))->result();
        $data_kota = $this->db->get('tbl_kota')->result();

        $data_sales_team = $this->db->get_where('tbl_sales_team', array('sales_team_id' => $sales_team_id))->row();

        $coverage_area = array();

        if ($data_sales_team->is_all_city != 1) {

            $data_coverage_area = $this->db->get_where('tbl_sales_team_city', array('sales_team_id' => $sales_team_id))->result();
            foreach ($data_coverage_area as $ca) {
                array_push($coverage_area, $ca->city_id);
            }
        }

        $data = array(
            'action_add' => base_url('user/add'),
            'data_client' => $data_client,
            'data_sales_team' => $data_sales_team,
            'function' => 'edit',
            'coverage_area' => $coverage_area,
            'data_kota' => $data_kota,
            'js' => $js,
            'css' => $css
        );

        $this->template->load('template__', 'team/form-salesteam', $data);
    }

    public function sales_officer()
    {

        $session_user = $this->session->userdata('user');

        $datatable_assets = $this->MainModels->getAssets('datatable');
        $team_assets = $this->MainModels->getAssets('team');

        $js = array_merge($datatable_assets['js'], $team_assets['js']);
        $css = array_merge($datatable_assets['css'], $team_assets['css']);

        if ($this->MainModels->UserSession('role_id') == 1) {
            $data_sales_officer = $this->TeamModels->getDataSalesOfficerAll();
            $data_chart_sales_officer = array();
        } else if ($this->MainModels->UserSession('role_id') == 2) {
            if ($this->input->get('sales_team_id') != NULL) {
                $data_sales_officer = $this->TeamModels->getDataSalesOfficerBySalesTeamId($this->input->get('sales_team_id'));

                $list_sales_officer_id = array();

                foreach ($data_sales_officer as $dso) {
                    array_push($list_sales_officer_id, $dso->sales_officer_id);
                }

                if (!empty($list_sales_officer_id)) {
                    $data_chart_sales_officer = $this->LeadModels->getDataLeadBySalesOfficer($list_sales_officer_id);
                } else {
                    $data_chart_sales_officer = array();
                }
            } else {
                $client_id = $this->MainModels->getClientId();
                $data_sales_officer = $this->TeamModels->getDataSalesOfficerByClientId($client_id);

                $list_sales_officer_id = array();

                foreach ($data_sales_officer as $dso) {
                    array_push($list_sales_officer_id, $dso->sales_officer_id);
                }

                if (!empty($list_sales_officer_id)) {
                    $data_chart_sales_officer = $this->LeadModels->getDataLeadBySalesOfficer($list_sales_officer_id);
                } else {
                    $data_chart_sales_officer = array();
                }
            }
        } else if ($this->MainModels->UserSession('role_id') == 5) {
            if ($this->input->get('sales_team_id') != NULL) {
                $data_sales_officer = $this->TeamModels->getDataSalesOfficerBySalesTeamId($this->input->get('sales_team_id'));

                $list_sales_officer_id = array();

                foreach ($data_sales_officer as $dso) {
                    array_push($list_sales_officer_id, $dso->sales_officer_id);
                }

                if (!empty($list_sales_officer_id)) {
                    $data_chart_sales_officer = $this->LeadModels->getDataLeadBySalesOfficer($list_sales_officer_id);
                } else {
                    $data_chart_sales_officer = array();
                }
            } else {
                $data_sales_officer = $this->SalesOfficerModels->getDataSalesOfficerbyClientAdminId();

                $list_sales_officer_id = array();

                foreach ($data_sales_officer as $dso) {
                    array_push($list_sales_officer_id, $dso->sales_officer_id);
                }

                if (!empty($list_sales_officer_id)) {
                    $data_chart_sales_officer = $this->LeadModels->getDataLeadBySalesOfficer($list_sales_officer_id);
                } else {
                    $data_chart_sales_officer = array();
                }
            }
        } else {

            $user_id = $session_user['user_id'];
            $role_id = $session_user['role_id'];

            $sales_team_id = $this->MainModels->getIdbyUserIdRoleId($user_id, $role_id);

            $data_sales_officer = $this->TeamModels->getDataSalesOfficerBySalesTeamId($sales_team_id['id']);

            $list_sales_officer_id = array();

            foreach ($data_sales_officer as $dso) {
                array_push($list_sales_officer_id, $dso->sales_officer_id);
            }

            if (!empty($list_sales_officer_id)) {
                $data_chart_sales_officer = $this->LeadModels->getDataLeadBySalesOfficer($list_sales_officer_id);
            } else {
                $data_chart_sales_officer = array();
            }


        }

        $data_status = $this->StatusModels->getStatusAll();
        $data_category = $this->db->get('tbl_lead_category')->result();

        $data = array(
            'action_add' => base_url('team/add_sales_officer'),
            'action_edit' => base_url('team/edit_sales_officer'),
            'data_sales_officer' => $data_sales_officer,
            'data_chart_sales_officer' => $data_chart_sales_officer,
            'js' => $js,
            'total' => count($data_sales_officer),
            'data_category' => $data_category,
            'data_status' => $data_status,
            'css' => $css
        );

        $this->template->load('template__', 'team/sales_officer', $data);
    }

    public function add_sales_officer()
    {

        $post = $this->input->post();
        $role = $this->MainModels->UserSession('role_id');

        if ($post) {

            $add_sales_officer = $this->TeamModels->AddSalesOfficer($post);
            $this->session->set_flashdata('message', $add_sales_officer['message']);

            redirect(base_url('team/sales_officer'));
        }

        $select2_assets = $this->MainModels->getAssets('select2');
        $user_assets = $this->MainModels->getAssets('user');

        $js = array_merge($select2_assets['js'], $user_assets['js']);
        $css = array_merge($select2_assets['css'], $user_assets['css']);

        $data_client = $this->db->get('tbl_client')->result();
        if ($role == 2) {
            $client_id = $this->db->get_where('tbl_client', array('user_id' => $this->MainModels->UserSession('user_id')))->row('client_id');
        } else {
            $client_id = $this->db->get_where('tbl_client_admin', array('user_id' => $this->MainModels->UserSession('user_id')))->row('client_id');
        }

        $data_sales_team = $this->db->get_where('tbl_sales_team', array('status' => 1, 'client_id' => $client_id))->result();

        $data = array(
            'action_add' => base_url('user/add'),
            'function' => 'add',
            'data_client' => $data_client,
            'data_sales_team' => $data_sales_team,
            'js' => $js,
            'css' => $css
        );

        $this->template->load('template__', 'team/form-salesofficer', $data);
    }

    public function edit_sales_officer()
    {

        $post = $this->input->post();

        $role = $this->MainModels->UserSession('role_id');

        if ($post) {

            $edit_sales_officer = $this->TeamModels->EditSalesOfficer($post);
            $this->session->set_flashdata('message', $edit_sales_officer['message']);

            redirect(base_url('team/sales_officer'));
        }

        $select2_assets = $this->MainModels->getAssets('select2');
        $js = array_merge($select2_assets['js']);
        $css = array_merge($select2_assets['css']);

        if ($role == 2) {
            $client_id = $this->db->get_where('tbl_client', array('user_id' => $this->MainModels->UserSession('user_id')))->row('client_id');
        } else {
            $client_id = $this->db->get_where('tbl_client_admin', array('user_id' => $this->MainModels->UserSession('user_id')))->row('client_id');
        }

        $data_sales_team = $this->db->get_where('tbl_sales_team', array('status' => 1, 'client_id' => $client_id))->result();


        $list_sales_team = array();

        $data_sales_officer_group = $this->db->get_where('tbl_sales_officer_group', array('sales_officer_id' => $this->input->get('id')))->result();

        foreach ($data_sales_officer_group as $dsog) {
            array_push($list_sales_team, $dsog->sales_team_id);
        }

        $data_sales_officer = $this->db->get_where('tbl_sales_officer', array('sales_officer_id' => $this->input->get('id')))->row();

        $data = array(
            'function' => 'edit',
            'data_sales_team' => $data_sales_team,
            'data_sales_officer' => $data_sales_officer,
            'list_sales_team' => $list_sales_team,
            'js' => $js,
            'css' => $css
        );

        $this->template->load('template__', 'team/form-salesofficer', $data);
    }

    public function lead_migration()
    {

        $datatable_assets = $this->MainModels->getAssets('datatable');
        $team_assets = $this->MainModels->getAssets('team');
        $lead_migration_assets = $this->MainModels->getAssets('lead_migration');
        $select2_assets = $this->MainModels->getAssets('select2');

        $js = array_merge($datatable_assets['js'], $team_assets['js'], $lead_migration_assets['js'], $select2_assets['js']);
        $css = array_merge($datatable_assets['css'], $lead_migration_assets['css'], $select2_assets['css']);


        $data = array(
            'js' => $js,
            'css' => $css
        );

        $this->template->load('template__', 'team/lead_migration', $data);
    }

    public function migrate()
    {

        $post = $this->input->post();

        $sales_officer_id = $post['sales_officer_id'];
        $migrateWho = $post['migrateWho'];
        $migrateHow = $post['migrateHow'];


        if ($migrateWho == 'all-sales-officer') {
            $data_sales_officer = $this->SalesOfficerModels->getSalesOfficerAll($sales_officer_id);

            $list_sales_officer_id = array();

            foreach ($data_sales_officer as $dso) {
                array_push($list_sales_officer_id, $dso->sales_officer_id);
            }
        } else {
            $list_sales_officer_id = $post['list_sales_officer_id'];
        }

        if ($migrateHow == 'by-category') {

            if (in_array(0, $post['category'])) {

                $data_category = $this->db->get('tbl_lead_category')->result();

                $list_category = array();

                foreach ($data_category as $dc) {
                    array_push($list_category, $dc->lead_category_id);
                }
            } else {
                $list_category = $post['category'];
            }

            //get data lead 
            $this->db->where_in('lead_category_id', $list_category);
            $data_lead = $this->db->get_where('tbl_lead', array('sales_officer_id' => $sales_officer_id))->result();

            $list_lead_id = array();

            if (!empty($data_lead)) {
                foreach ($data_lead as $lead) {
                    array_push($list_lead_id, $lead->lead_id);
                }

                foreach ($list_lead_id as $lead_id) {

                    foreach ($list_sales_officer_id as $id) {
                        $data_update = array(
                            'sales_officer_id' => $id
                        );

                        $this->db->where_in('lead_category_id', $list_category);
                        $this->db->where('lead_id', $lead_id);
                        $update_lead = $this->db->update('tbl_lead', $data_update);
                    }
                }
            }
        }

        redirect(base_url('team/sales_officer'));
    }

    public function getSalesOfficerAll()
    {

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $sales_officer_id = $this->input->get('id');

        $data_sales_officer = $this->SalesOfficerModels->getSalesOfficerAll($sales_officer_id);

        $html = "";


        foreach ($data_sales_officer as $value) {

            //$option = "<div class='col-md-3'><div class='checkbox'><label><input name='list_sales_officer_id[]' type='checkbox' value=$value->sales_officer_id>$value->sales_officer_name</label></div></div>";

            $option = "<option value='$value->sales_officer_id'>$value->sales_officer_name</option>";
            $html .= $option;
        }

        echo json_encode($html);
    }

    public function delete_sales_officer()
    {
        $id = $this->input->get('id');

        //get user id 
        $user_id = $this->db->get_where('tbl_sales_officer', array('sales_officer_id' => $id))->row('user_id');

        //delete user
        $this->db->where('user_id', $user_id);
        $delete_user = $this->db->delete('tbl_user');

        if ($delete_user) {
            //delete sales officer 
            $this->db->where('sales_officer_id', $id);
            $delete_sales_officer = $this->db->delete('tbl_sales_officer');

            if ($delete_sales_officer) {
                $this->db->where('sales_officer_id', $id);
                $delete_sales_officer_group = $this->db->delete('tbl_sales_officer_group', array('sales_officer_id' => $id));

                if ($delete_sales_officer_group) {
                    $this->session->set_flashdata('message', '<p class="alert alert-success"> Success delete sales officer !!!  </p>');
                    redirect(base_url('team/sales_officer'));
                } else {
                    $this->session->set_flashdata('message', '<p class="alert alert-da"nger> Error delete sales officer group !!!  </p>');
                    redirect(base_url('team/sales_officer'));
                }
            } else {
                $this->session->set_flashdata('message', '<p class="alert alert-da"nger> Error delete sales officer !!!  </p>');
                redirect(base_url('team/sales_officer'));
            }
        } else {
            $this->session->set_flashdata('message', '<p class="alert alert-danger"> Error delete user !!!  </p>');
            redirect(base_url('team/sales_officer'));
        }
    }

    public function delete_sales_team()
    {
        $id = $this->input->get('id');

        $delete = $this->TeamModels->deleteSalesTeam($id);
        $this->session->set_flashdata('message', $delete['message']);
        redirect(base_url('team/sales_team'));
    }

}
