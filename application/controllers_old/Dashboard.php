<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

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
            $this->load->model('TeamModels');
            $this->load->model('SalesOfficerModels');
            $this->load->model('SalesTeamModels');
        }
    }

    public function index()
    {
        // echo '<pre>';
        // print_r($this->session->userdata());
        // echo '</pre>';

        $get = $this->input->get();
        $role = $this->MainModels->UserSession('role_id');
        $counterup_assets = $this->MainModels->getAssets('counterup');
        $daterangepicker_assets = $this->MainModels->getAssets('daterangepicker');
        $highcharts_assets = $this->MainModels->getAssets('highcharts');
        $dashboard_assets = $this->MainModels->getAssets('dashboard');

        $js = array_merge($counterup_assets['js'], $daterangepicker_assets['js'], $highcharts_assets['js'], $dashboard_assets['js']);
        $css = array_merge($counterup_assets['css'], $daterangepicker_assets['css'], $highcharts_assets['css'], $dashboard_assets['css']);

        if ($role == 1) {
            $data_project = array();
            $data_campaign = array();
            $data_channel = array();
            $data_lead = array();
            $data_sales_team = array();
            $data_sales_officer = array();
            $data_chart_campaign = array();
            $data_chart_category = array();
            $data_top_sales_team = array();
            $data_chart_status = array();
            $data_chart_channel = array();
        } elseif ($role == 2 || $role == 5) {
            if (isset($get['project_id'])) {
                $session_dashboard = $this->session->userdata('dashboard');

                $data_session_dashboard = array('project_id' => $get['project_id'], 'date_range' => $get['date_range'], 'category_id_1' => $session_dashboard['category_id_1'], 'category_id_2' => $session_dashboard['category_id_2']);
                $this->session->set_userdata('dashboard', $data_session_dashboard);
            }

            if (isset($get['versus'])) {
                $session_dashboard = $this->session->userdata('dashboard');

                $data_session_dashboard = array('project_id' => $session_dashboard['project_id'], 'date_range' => $session_dashboard['date_range'], 'category_id_1' => $get['category_id_1'], 'category_id_2' => $get['category_id_2']);
                $this->session->set_userdata('dashboard', $data_session_dashboard);
            }

            $session_dashboard = $this->session->userdata('dashboard');

            $data_chart_campaign = $this->CampaignModels->getDataLeadByCampaignDashboard($session_dashboard);
            $data_chart_category = $this->LeadModels->getDataLeadByCategoryDashboard($session_dashboard);
            $data_project = $this->ProjectModels->getDataProjectbyClientId($session_dashboard);
            $data_chart_status = $this->ProjectModels->getStatusbyClientId($session_dashboard);
            $data_campaign = $this->CampaignModels->getDataCampaignbyClientId();
            $data_channel = $this->ChannelModels->getDataChannelbyClientId();
            $data_lead = $this->LeadModels->getCountLeadbyClientId();
            $data_sales_team = $this->TeamModels->getDataSalesTeambyClientId($this->MainModels->getClientId());
            $data_sales_officer = $this->SalesOfficerModels->getDataSalesOfficerbyClientId();
            $data_top_sales_team = $this->SalesTeamModels->getDataTopSalesTeam();
            $data_chart_channel = $this->ChannelModels->getDataLeadByChannelDashboard($session_dashboard);
        } elseif ($role == 3) {
            $role_id = $this->MainModels->UserSession('role_id');
            $user_id = $this->MainModels->UserSession('user_id');

            $sales_team = $this->MainModels->getIdbyUserIdRoleId($user_id, $role_id);
            $sales_team_id = $sales_team['id'];

            if (isset($get['project_id'])) {
                $session_dashboard = $this->session->userdata('dashboard');

                $data_session_dashboard = array('project_id' => $get['project_id'], 'date_range' => $get['date_range'], 'category_id_1' => $session_dashboard['category_id_1'], 'category_id_2' => $session_dashboard['category_id_2']);
                $this->session->set_userdata('dashboard', $data_session_dashboard);
            }

            if (isset($get['versus'])) {
                $session_dashboard = $this->session->userdata('dashboard');

                $data_session_dashboard = array('project_id' => $session_dashboard['project_id'], 'date_range' => $session_dashboard['date_range'], 'category_id_1' => $get['category_id_1'], 'category_id_2' => $get['category_id_2']);
                $this->session->set_userdata('dashboard', $data_session_dashboard);
            }

            $session_dashboard = $this->session->userdata('dashboard');

            $data_project = $this->ProjectModels->getDataProjectbyClientId($session_dashboard);
            $data_campaign = $this->CampaignModels->getDataCampaignbyClientId();
            $data_channel = $this->ChannelModels->getDataChannelbySalesTeamId($sales_team_id);
            $data_leads = $this->LeadModels->getDataLeadBySalesTeamId($sales_team_id);

            $data_lead = $data_leads[0]['total'];

            $data_sales_team = array();
            $data_sales_officer = $this->SalesOfficerModels->getDataSalesOfficerbySalesTeamId($sales_team_id);
            $data_chart_campaign = array();
            $data_chart_category = array();
            $data_top_sales_team = $this->SalesTeamModels->getDataTopSalesTeam();
            $data_chart_status = array();
            $data_chart_channel = array();
        }

        $data_project_filter = $this->db->get_where('tbl_project', array('client_id' => $this->MainModels->getClientId()))->result();
        $data_category = $this->db->get('tbl_lead_category')->result();

        $data = array(
            'js' => $js,
            'css' => $css,
            'data_category' => $data_category,
            'data_project' => $data_project,
            'data_campaign' => $data_campaign,
            'data_lead' => $data_lead,
            'data_channel' => $data_channel,
            'data_sales_team' => $data_sales_team,
            'data_sales_officer' => $data_sales_officer,
            'data_chart_campaign' => $data_chart_campaign,
            'data_chart_category' => $data_chart_category,
            'data_chart_status' => $data_chart_status,
            'data_top_sales_team' => $data_top_sales_team,
            'data_project_filter' => $data_project_filter,
            'data_chart_channel' => $data_chart_channel,
        );

        $this->template->load('template', 'dashboard/dashboard', $data);
    }

    public function createSessionTime()
    {
    }
}
