<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_new extends CI_Controller
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
            $this->load->model('ProjectModels');
            $this->load->model('CampaignModels');
            $this->load->model('ChannelModels');
            $this->load->model('LeadModels');
            $this->load->model('LeadModelsNew');
            $this->load->model('TeamModels');
            $this->load->model('SalesOfficerModels');
            $this->load->model('SalesTeamModels');
            $this->load->model('ComponentModels');
        }
    }

    public function index()
    {
        $get = $this->input->get();
        $role = $this->MainModels->UserSession('role_id');

        $counterup_assets = $this->MainModels->getAssets('counterup');
        $daterangepicker_assets = $this->MainModels->getAssets('daterangepicker');
        $dashboard_assets = $this->MainModels->getAssets('dashboard');
        $js = array_merge($counterup_assets['js'], $daterangepicker_assets['js'], $dashboard_assets['js']);
        $css = array_merge($counterup_assets['css'], $daterangepicker_assets['css'], $dashboard_assets['css']);

        //dashboard session
        $session_dashboard = $this->session->userdata('dashboard');

        if (isset($get['project_id'])) {
            $session_dashboard = $this->session->userdata('dashboard');

            if ($get['project_id'] == 0) {
                $default_project_id = $session_dashboard['default_project_id'];
            } else {
                $default_project_id = $get['project_id'];
            }

            $data_session_dashboard = array(
                'project_id' => $get['project_id'],
                'default_project_id' => $default_project_id,
                'from' => $get['from'],
                'to' => $get['to'],
                'category_id_1' => $session_dashboard['category_id_1'],
                'category_id_2' => $session_dashboard['category_id_2']
            );
            $this->session->set_userdata('dashboard', $data_session_dashboard);
        }

        if (isset($get['versus'])) {
            $session_dashboard = $this->session->userdata('dashboard');

            $data_session_dashboard = array(
                'project_id' => $session_dashboard['project_id'],
                'default_project_id' => $session_dashboard['default_project_id'],
                'from' => $session_dashboard['from'],
                'to' => $session_dashboard['to'],
                'category_id_1' => $get['category_id_1'],
                'category_id_2' => $get['category_id_2']);
            $this->session->set_userdata('dashboard', $data_session_dashboard);
        }


        switch ($role) {
            case 2:
                //get data filter
                $data_project_filter = $this->db->get_where('tbl_project', array('client_id' => $this->MainModels->getClientId()))->result();
                $data_category = $this->db->get('tbl_lead_category')->result();

                //get data dashboard statistics
                $data_lead = $this->LeadModelsNew->getCountLeadbyClientId();
                $data_sales_officer = $this->SalesOfficerModels->getDataSalesOfficerbyClientId();
                $data_new_leads = $this->LeadModelsNew->getLeadsbyCategory(1);
                $data_onprogress = $this->LeadModelsNew->getLeadsbyCategory(0);

                $data_online_offline = $this->LeadModelsNew->OnlineOfflineLead();

                break;
            case 3:
                //get data filter
                $data_project_filter = $this->ProjectModels->getProjectbySalesTeamId($this->MainModels->getSalesTeamId());
                $data_category = $this->db->get('tbl_lead_category')->result();

                //get data dashboard statistics
                $data_sales_officer = $this->SalesOfficerModels->getDataSalesOfficerStatisticsbySalesTeamId($this->MainModels->getSalesTeamId());
                $data_lead = $this->LeadModelsNew->getCountLeadbySalesTeamId($this->MainModels->getSalesTeamId());
                $data_new_leads = $this->LeadModelsNew->getLeadsbyCategorySalesTeamId(1, $this->MainModels->getSalesTeamId());
                $data_onprogress = $this->LeadModelsNew->getLeadsbyCategorySalesTeamId(0, $this->MainModels->getSalesTeamId());
                $data_online_offline = $this->LeadModelsNew->OnlineOfflineLead();

                break;
            case 5:
                //get data filter

                $user_id = $this->MainModels->UserSession('user_id');

                $project_id = $this->db->get_where('tbl_client_admin', array('user_id' => $user_id))->row('project_id');

                if ($project_id != 0) {
                    $data_project_filter = $this->db->get_where('tbl_project', array('id' => $project_id))->result();
                    $data_project = $this->ProjectModels->getDataProjectbyClientAdminId($this->session->userdata('dashboard'));
                    $data_campaign = $this->CampaignModels->getDataCampaignbyClientAdminId();
                    $data_channel = $this->ChannelModels->getDataChannelbyClientAdminId();
                    $data_sales_team = $this->TeamModels->getDataSalesTeambyClientAdminId();
                    $data_sales_officer = $this->SalesOfficerModels->getDataSalesOfficerbyClientAdminId();

                } else {
                    $data_project = $this->ProjectModels->getDataProjectbyClientId($this->session->userdata('dashboard'));
                    $data_campaign = $this->CampaignModels->getDataCampaignbyClientId();
                    $data_channel = $this->ChannelModels->getDataChannelbyClientId();
                    $data_sales_team = $this->TeamModels->getDataSalesTeambyClientId($this->MainModels->getClientId());
                    $data_sales_officer = $this->SalesOfficerModels->getDataSalesOfficerbyClientId();
                    $data_project_filter = $this->db->get_where('tbl_project', array('client_id' => $this->MainModels->getClientId()))->result();
                }

                $data_category = $this->db->get('tbl_lead_category')->result();

                //get data dashboard statistics
                $data_lead = $this->LeadModelsNew->getCountLeadbyProjectAdmin();
                $data_new_leads = $this->LeadModelsNew->getLeadsbyCategory(1);
                $data_onprogress = $this->LeadModelsNew->getLeadsbyCategory(0);

                //get data graphic
                $data_chart_campaign = $this->CampaignModels->getDataLeadByCampaignAdminDashboard($this->session->userdata('dashboard'));
                $data_chart_channel = $this->ChannelModels->getDataLeadByChannelDashboard($this->session->userdata('dashboard'));
                $data_chart_category = $this->LeadModels->getDataLeadByCategoryDashboard($this->session->userdata('dashboard'));
                $data_chart_status = $this->ProjectModels->getStatusbyClientId($this->session->userdata('dashboard'));
                $data_top_sales_team = $this->SalesTeamModels->getDataTopSalesTeam();
                $data_online_offline = $this->LeadModelsNew->OnlineOfflineLead();
                break;
            default:
                break;
        }

        $data = array(
            'js' => $js,
            'css' => $css,
            'data_project_filter' => $data_project_filter,
            'data_lead' => $data_lead,
            'data_sales_officer' => $data_sales_officer,
            'data_new_leads' => $data_new_leads,
            'data_onprogress' => $data_onprogress,
            'data_online_offline' => $data_online_offline
        );

        $this->template->load('template__', 'dashboard/dashboard_new', $data);
    }

    public function resetFilter()
    {

        $session_dashboard = $this->session->userdata('dashboard');

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
        redirect(base_url('dashboard_new'));
    }

    public function get_md5()
    {
        $string = '12345678';

        $gen_md5 = md5($string);

        echo $gen_md5;
    }

}
