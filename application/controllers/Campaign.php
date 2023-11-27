<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign extends CI_Controller {

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
            $data_campaign = $this->db->get('tbl_campaign')->result();
        } else {
            $data_campaign = $this->CampaignModels->getDataCampaignbyClientId();
        }
       
        $data = array(
            'data_campaign' => $data_campaign,
            'js' => $js,
            'css' => $css
        );

        $this->template->load('template', 'campaign/index', $data);
    }

}
