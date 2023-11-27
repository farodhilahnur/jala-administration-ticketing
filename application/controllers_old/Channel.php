<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Channel extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('LeadModels');
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

        $this->template->load('template', 'channel/index', $data);
    }

}
