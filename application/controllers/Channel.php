<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Channel extends CI_Controller {

    function __construct() {
        parent::__construct();
        
        $this->load->model('LeadModels');
    }

    public function wizard(){

        $role = $this->MainModels->UserSession('role_id');
        $datatable_assets = $this->MainModels->getAssets('datatable');
        $team_assets = $this->MainModels->getAssets('team');
        $daterangepicker_assets = $this->MainModels->getAssets('daterangepicker');
//      $modals_assets = $this->MainModels->getAssets('modals');
        $channel_form_wizard_assets = $this->MainModels->getAssets('channel-form-wizard');
        $file_input_assets = $this->MainModels->getAssets('file-input');
        $input_mask = $this->MainModels->getAssets('input-mask');
        $channel_assets = $this->MainModels->getAssets('channel');
        $select2_assets = $this->MainModels->getAssets('select2');

        $js = array_merge($datatable_assets['js'], $select2_assets['js'], $team_assets['js'], $daterangepicker_assets['js'], $channel_form_wizard_assets['js'], $file_input_assets['js'], $input_mask['js'], $channel_assets['js']);
        $css = array_merge($datatable_assets['css'], $select2_assets['css'], $daterangepicker_assets['css'], $channel_form_wizard_assets['js'], $file_input_assets['css'], $input_mask['css']);

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

        $this->template->load('template', 'project/channel/form-add-channel', $data);
    }

    public function index() {

        $role = $this->MainModels->UserSession('role_id');
        $datatable_assets = $this->MainModels->getAssets('datatable');
        $lead_assets = $this->MainModels->getAssets('leads');
        $get = $this->input->get();

        $js = array_merge($datatable_assets['js'], $lead_assets['js']);
        $css = array_merge($datatable_assets['css']);

        if ($role == 1) {
            $data_lead = '';
            $data_campaign = $this->db->get('tbl_campaign')->result();
            $data_channel = '';

            $data_project = '';
        } else {

            $data_project = $this->ProjectModels->getDataProjectbyClientIdNonSession();
            $data_campaign = $this->CampaignModels->getDataCampaignbyClientIdNonSession();
            $data_channel = $this->ChannelModels->getDataChannelbyClientId();

            if (isset($get['sales_team_id'])) {
                $sales_team_id = $get['sales_team_id'];
                $data_channel = $this->ChannelModels->getDataChannelbySalesTeamId($sales_team_id);
            } else {
                $sales_team_id = 0;
                $data_channel = $this->ChannelModels->getDataChannelbyClientId();
            }
            
            if (isset($get['campaign_id'])) {
                $campaign_id = $get['campaign_id'];
                $data_channel = $this->ChannelModels->getDataChannelbyCampagnId2($campaign_id);
            } else {
                $campaign_id = 0;
                $data_channel = $this->ChannelModels->getDataChannelbyClientId();
            }
            
            if (isset($get['sales_officer_id'])) {
                $sales_officer_id = $get['sales_officer_id'];
            } else {
                $sales_officer_id = 0;
            }
            
        }

        $data = array(
            'data_campaign' => $data_campaign,
            'data_channel' => $data_channel,
            'js' => $js,
            'get' => $get, 
            'css' => $css
        );

        $this->template->load('template__', 'channel/index', $data);
    }

}
