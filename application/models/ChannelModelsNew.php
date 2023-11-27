<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ChannelModelsNew extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('ProjectModels');
        $this->load->model('CampaignModels');
        $this->load->model('SalesTeamModels');
    }

    public function getChannelbyProjectId($role_id, $project_id)
    {

        //if sales team
        if($role_id == 3){
            //get sales team id
            $sales_team_id = $this->MainModels->UserSession('user_id');

            //get sales team channel
            $channel_id = $this->SalesTeamModels->getSalesTeamChannel($sales_team_id);
        } else {

            //get campaign
            $data_campaign = $this->CampaignModels->getCampaignbyProjectId($project_id);

            print_r($data_campaign);

        }

        exit ;

    }

}
