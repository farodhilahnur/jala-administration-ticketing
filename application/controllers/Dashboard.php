<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
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

    public function index() {

        $get = $this->input->get();
        $role = $this->MainModels->UserSession('role_id');

        //assets
        $counterup_assets = $this->MainModels->getAssets('counterup');
        $daterangepicker_assets = $this->MainModels->getAssets('daterangepicker');
        $highcharts_assets = $this->MainModels->getAssets('highcharts');
        $dashboard_assets = $this->MainModels->getAssets('dashboard');

        $js = array_merge($counterup_assets['js'], $daterangepicker_assets['js'], $highcharts_assets['js'], $dashboard_assets['js']);
        $css = array_merge($counterup_assets['css'], $daterangepicker_assets['css'], $highcharts_assets['css'], $dashboard_assets['css']);

        //dashboard session
        $session_dashboard = $this->session->userdata('dashboard');
        
        if (isset($get['project_id'])) {
            $session_dashboard = $this->session->userdata('dashboard');

            if($get['project_id'] == 0){
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
                $data_project = $this->ProjectModels->getDataProjectbyClientId($this->session->userdata('dashboard'));
                $data_campaign = $this->CampaignModels->getDataCampaignbyClientId();
                $data_channel = $this->ChannelModels->getDataChannelbyClientId();
                $data_sales_team = $this->TeamModels->getDataSalesTeambyClientId($this->MainModels->getClientId());
                $data_sales_officer = $this->SalesOfficerModels->getDataSalesOfficerbyClientId();
                $data_lead = $this->LeadModels->getCountLeadbyClientId();

                //get data graphic
                //get data lead offline online
                
                $data_chart_campaign = $this->CampaignModels->getDataLeadByCampaignDashboard($this->session->userdata('dashboard'));
                $data_chart_channel = $this->ChannelModels->getDataLeadByChannelDashboard($this->session->userdata('dashboard'));
                $data_lead_offline_online = $this->LeadModels->getDataOnlineOfflineNew($this->session->userdata('dashboard'));
                $data_chart_category = $this->LeadModels->getDataLeadByCategoryDashboard($this->session->userdata('dashboard'));
                $data_chart_status = $this->ProjectModels->getStatusbyClientId($this->session->userdata('dashboard'));
                $data_top_sales_team = $this->SalesTeamModels->getDataTopSalesTeam();
                
                break;
            case 3:
                //get data filter
                $data_project_filter = $this->ProjectModels->getProjectbySalesTeamId($this->MainModels->getSalesTeamId());
                $data_category = $this->db->get('tbl_lead_category')->result();

                //get data dashboard statistics
                $data_project = $this->ProjectModels->getDataProjectStatisticsbySalesTeamId($this->MainModels->getSalesTeamId());
                $data_campaign = $this->CampaignModels->getDataCampaignStatisticsbySalesTeamId($this->MainModels->getSalesTeamId());

                $data_channel = $this->ChannelModels->getDataChannelStatisticsbySalesTeamId($this->MainModels->getSalesTeamId());

                $data_sales_team = array();
                $data_sales_officer = $this->SalesOfficerModels->getDataSalesOfficerStatisticsbySalesTeamId($this->MainModels->getSalesTeamId());

                $data_lead = $this->LeadModels->getCountLeadbySalesTeamId($this->MainModels->getSalesTeamId());

                //get data graphic
                $data_chart_campaign = $this->CampaignModels->getDataLeadByCampaignDashboard($this->session->userdata('dashboard'));
                $data_chart_channel = $this->ChannelModels->getDataLeadByChannelDashboard($this->session->userdata('dashboard'));
                $data_chart_category = $this->LeadModels->getDataLeadByCategoryDashboard($this->session->userdata('dashboard'));
                $data_chart_status = $this->ProjectModels->getStatusbyClientId($this->session->userdata('dashboard'));
                $data_top_sales_team = $this->SalesTeamModels->getDataTopSalesTeam();
                $data_lead_offline_online = $this->LeadModels->getDataOnlineOfflineNewSalesTeam($this->session->userdata('dashboard'));
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
                $data_lead = $this->LeadModels->getCountLeadbyProjectAdmin();

                //get data graphic
                $data_chart_campaign = $this->CampaignModels->getDataLeadByCampaignAdminDashboard($this->session->userdata('dashboard'));
                $data_chart_channel = $this->ChannelModels->getDataLeadByChannelDashboard($this->session->userdata('dashboard'));
                $data_chart_category = $this->LeadModels->getDataLeadByCategoryDashboard($this->session->userdata('dashboard'));
                $data_chart_status = $this->ProjectModels->getStatusbyClientId($this->session->userdata('dashboard'));
                $data_top_sales_team = $this->SalesTeamModels->getDataTopSalesTeam();
                $data_lead_offline_online = '' ;
                break;
            default:
                break;
        }



        $data = array(
            'js' => $js,
            'css' => $css,
            'data_category' => $data_category,
            'data_project_filter' => $data_project_filter,
            'data_project' => $data_project,
            'data_campaign' => $data_campaign,
            'data_channel' => $data_channel,
            'data_sales_team' => $data_sales_team,
            'data_sales_officer' => $data_sales_officer,
            'data_lead' => $data_lead,
            'data_chart_campaign' => $data_chart_campaign,
            'data_chart_lead_offline_online' => $data_lead_offline_online,
            'data_chart_channel' => $data_chart_channel,
            'data_chart_category' => $data_chart_category,
            'data_chart_status' => $data_chart_status,
            'data_top_sales_team' => $data_top_sales_team,
        );

        $this->template->load('template', 'dashboard/dashboard', $data);
    }

    public function resetFilter() {

        $session_dashboard = $this->session->userdata('dashboard');

        $user_id = $this->MainModels->UserSession('user_id');
        $data_user = $this->db->get_where('tbl_user', array('user_id' => $user_id))->row();

        $client_date = substr($data_user->create_at, 0, 10);
        $substract_month = date("Y-m-d", strtotime("-2 months"));
        $now = date('Y-m-d');
        $newDate = date("Y-m-d", strtotime($client_date));

        $from = $substract_month;
        $to = $now;

        $data_session_dashboard = array(
            'project_id' => 0,
            'from' => $from,
            'to' => $to,
            'category_id_1' => 0,
            'category_id_2' => 0
        );

        $this->session->set_userdata('dashboard', $data_session_dashboard);
        redirect(base_url());
    }
    
    public function get_md5(){
        $string = '12345678' ; 
        
        $gen_md5 = md5($string);
        
        echo $gen_md5 ; 
    }

}
