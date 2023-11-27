<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CampaignModels extends CI_Model {

    function __construct() {
        parent::__construct();


        $this->load->model('ChannelModels');
        $this->load->model('ProjectModels');
        $this->load->model('CampaignModels');
        $this->load->model('LeadModels');
    }

    public function addCampaign($post, $file_name) {

        $data_insert = array(
            'campaign_name' => $post['campaign_name'],
            'client_id' => $this->MainModels->getClientId(),
            'campaign_detail' => $post['campaign_detail'],
            'campaign_picture' => $file_name,
            'create_by' => $this->MainModels->UserSession('user_id'),
            'project_id' => $post['project_id']
        );

        $insert_campaign = $this->db->insert('tbl_campaign', $data_insert);

        if ($insert_campaign) {
            $response = 'success';
            $message = '<p class="alert alert-success"> Success Add Campaign </p>';
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Add Campaign </p>';
        }

        $data_campaign = array('message' => $message, 'res' => $response);  
        return $data_campaign;
    }

    public function editCampaign($post, $file_name) {

        if ($file_name == "") {
            $data_update = array(
                'campaign_name' => $post['campaign_name'],
                'campaign_detail' => $post['campaign_detail'],
                'update_by' => $this->MainModels->UserSession('user_id')
            );
        } else {
            $data_update = array(
                'campaign_name' => $post['campaign_name'],
                'client_id' => $this->MainModels->getClientId(),
                'campaign_detail' => $post['campaign_detail'],
                'campaign_picture' => $file_name,
                'update_by' => $this->MainModels->UserSession('user_id')
            );
        }


        $this->db->where('id', $post['campaign_id']);
        $update_campaign = $this->db->update('tbl_campaign', $data_update);

        if ($update_campaign) {
            $response = 'success';
            $message = '<p class="alert alert-success"> Success Update Campaign </p>';
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Update Campaign </p>';
        }

        $data_campaign = array('message' => $message, 'res' => $response);
        return $data_campaign;
    }

    public function getCampaignbyProjectId($projectId) {
        $client_id = $this->MainModels->getClientId();
        $data_campaign = $this->db->get_where('tbl_campaign', array('client_id' => $client_id, 'project_id' => $projectId, 'status' => 1))->result();

        return $data_campaign;
    }

    public function getDataCampaignbyClientId() {

        $session_dashboard = $this->session->userdata('dashboard');

        $data_project = $this->ProjectModels->getDataProjectbyClientId($session_dashboard);

        $list_project_id = array();

        foreach ($data_project as $dpr) {
            array_push($list_project_id, $dpr->id);
        }

        if (!empty($list_project_id)) {
            $this->db->where_in('project_id', $list_project_id);
            $data_campaign = $this->db->get('tbl_campaign')->result();
        } else {
            $data_campaign = array();
        }

        return $data_campaign;
    }

    public function getDataCampaignbyClientIdNonSession() {

        //$session_dashboard = $this->session->userdata('dashboard');

        $data_project = $this->ProjectModels->getDataProjectbyClientIdNonSession();

        $list_project_id = array();

        foreach ($data_project as $dpr) {
            array_push($list_project_id, $dpr->id);
        }

        if (!empty($list_project_id)) {
            $this->db->where_in('project_id', $list_project_id);
            $data_campaign = $this->db->get('tbl_campaign')->result();
        } else {
            $data_campaign = array();
        }

        return $data_campaign;
    }

    public function getDataLeadByCampaignDashboard($session_dashboard) {

        $project_id = $session_dashboard['project_id'];
        $date = explode(' to ', $session_dashboard['date_range']);
        $from_date = $date[0];
        $to_date = $date[1];

        if ($project_id != 0) {
            $data_campaign = $this->getCampaignbyProjectId($project_id);
        } else {
            $data_campaign = $this->getDataCampaignbyClientId();
        }

        $jum = count($this->LeadModels->getLeadDashboard($project_id, $from_date, $to_date));

        $data_chart = array();

        foreach ($data_campaign as $dcc) {

            $list_channel_id = array();

            //get data channel
            $data_channel = $this->ChannelModels->getDataChannelbyCampagnId($dcc->id);

            foreach ($data_channel as $dch) {
                array_push($list_channel_id, $dch->channel_id);
            }

            if (!empty($list_channel_id)) {
                $this->db->where_in('a.channel_id', $list_channel_id);
                $this->db->where('a.create_date >=', $from_date . ' 00:00:00');
                $this->db->where('a.create_date <=', $to_date . ' 23:59:59');
                $this->db->select('count(a.lead_id) as total');
                $data_lead_by_channel = $this->db->get('tbl_lead a')->row();

                $list_channel_id = array();

                if ($jum != 0) {
                    $percent = round(intval($data_lead_by_channel->total / intval($jum) * 100), 2);
                } else {
                    $percent = 0;
                }

                $data = array(
                    'campaign_name' => $dcc->campaign_name,
                    'total' => $data_lead_by_channel->total,
                    'percent' => $percent
                );
            } else {

                $data = array(
                    'campaign_name' => $dcc->campaign_name,
                    'total' => 0,
                    'percent' => 0
                );
            }

            array_push($data_chart, $data);
        }

        return $data_chart;
    }

    public function getDetailCampaignbyId($campaign_id, $sales_officer_id) {
        $new_leads = count($this->LeadModels->getDataLeadByCampaignIdApi($campaign_id, 1, $sales_officer_id));
        $on_progress = count($this->LeadModels->getDataLeadByCampaignIdApi($campaign_id, 0, $sales_officer_id));
        $closing = count($this->LeadModels->getDataLeadByCampaignIdApi($campaign_id, 5, $sales_officer_id));
        
        $data = array(
            'new_leads' => $new_leads, 
            'on_progress' => $on_progress, 
            'closing' => $closing
        );
        
        return $data ;
    }

    public function getCampaignBySalesOfficerId($sales_officer_id) {

        //get data sales team id to tbl sales officer group
        $data_sales_officer_group = $this->db->get_where('tbl_sales_officer_group', array('sales_officer_id' => $sales_officer_id))->result();
        $list_sales_team_id = array();

        foreach ($data_sales_officer_group as $dsog) {
            array_push($list_sales_team_id, $dsog->sales_team_id);
        }

        if (!empty($list_sales_team_id)) {

            //get data sales team channel
            $list_channel_id = array();
            $this->db->where_in('sales_team_id', $list_sales_team_id);
            $data_sales_team_channel = $this->db->get('tbl_sales_team_channel')->result();

            foreach ($data_sales_team_channel as $dstc) {
                if (in_array($dstc->channel_id, $list_channel_id)) {
                    
                } else {
                    array_push($list_channel_id, $dstc->channel_id);
                }
            }

            if (!empty($list_channel_id)) {

                //get data channel 
                $list_campaign_id = array();
                $this->db->where_in('id', $list_channel_id);
                $data_channel = $this->db->get('tbl_channel')->result();

                foreach ($data_channel as $dch) {
                    if (in_array($dch->campaign_id, $list_campaign_id)) {
                        
                    } else {
                        array_push($list_campaign_id, $dch->campaign_id);
                    }
                }

                if (!empty($list_campaign_id)) {

                    $data_response = array();
                    //get data campaign 
                    $this->db->where_in('id', $list_campaign_id);
                    $data_campaign = $this->db->get('tbl_campaign')->result();

                    foreach ($data_campaign as $dcg) {

                        //get data lead     
                        $new_leads = count($this->LeadModels->getDataLeadByCampaignIdApi($dcg->id, 1, $sales_officer_id));
                        $on_progress = count($this->LeadModels->getDataLeadByCampaignIdApi($dcg->id, 0, $sales_officer_id));
                        $closing = count($this->LeadModels->getDataLeadByCampaignIdApi($dcg->id, 5, $sales_officer_id));

                        $activity = count($this->LeadModels->getHistorybyCampaignId($dcg->id, $sales_officer_id));
                        $channel_count = count($this->ChannelModels->getDataChannelbyCampagnId($dcg->id));

                        $campaign_name = $dcg->campaign_name;
                        $campaign_id = $dcg->id;
                        $campaign_picture = $dcg->campaign_picture;

                        $data_push = array(
                            'campaign_name' => $campaign_name,
                            'campaign_id' => $campaign_id,
                            'campaign_picture' => $campaign_picture,
                            'new_leads' => $new_leads,
                            'on_progress' => $on_progress,
                            'closing' => $closing,
                            'activity' => $activity,
                            'channel_count' => $channel_count
                        );
                        array_push($data_response, $data_push);
                    }

                    $data = $data_response;
                } else {
                    $data = array();
                }
            } else {
                $data = array();
            }
        } else {
            $data = array();
        }

        return $data;
    }

    public function getCampaignBySalesOfficerIdNew($sales_officer_id) {

        //get data sales team id to tbl sales officer group
        $data_sales_officer_group = $this->db->get_where('tbl_sales_officer_group', array('sales_officer_id' => $sales_officer_id))->result();
        $list_sales_team_id = array();

        foreach ($data_sales_officer_group as $dsog) {
            array_push($list_sales_team_id, $dsog->sales_team_id);
        }

        if (!empty($list_sales_team_id)) {

            //get data sales team channel
            $list_channel_id = array();
            $this->db->where_in('sales_team_id', $list_sales_team_id);
            $data_sales_team_channel = $this->db->get('tbl_sales_team_channel')->result();

            foreach ($data_sales_team_channel as $dstc) {
                if (in_array($dstc->channel_id, $list_channel_id)) {
                    
                } else {
                    array_push($list_channel_id, $dstc->channel_id);
                }
            }

            if (!empty($list_channel_id)) {

                //get data channel 
                $list_campaign_id = array();
                $this->db->where_in('id', $list_channel_id);
                $data_channel = $this->db->get('tbl_channel')->result();

                foreach ($data_channel as $dch) {
                    if (in_array($dch->campaign_id, $list_campaign_id)) {
                        
                    } else {
                        array_push($list_campaign_id, $dch->campaign_id);
                    }
                }

                if (!empty($list_campaign_id)) {

                    $data_response = array();
                    //get data campaign 
                    $this->db->where_in('id', $list_campaign_id);
                    $data_campaign = $this->db->get('tbl_campaign')->result();

                    foreach ($data_campaign as $dcg) {

                        //get data lead 
                        $new_leads = count($this->LeadModels->getDataLeadByCampaignIdApi($dcg->id, 1, $sales_officer_id));
                        $on_progress = count($this->LeadModels->getDataLeadByCampaignIdApi($dcg->id, 0, $sales_officer_id));
                        $channel_count = count($this->ChannelModels->getDataChannelbyCampagnId($dcg->id));

                        $campaign_name = $dcg->campaign_name;
                        $campaign_id = $dcg->id;
                        $campaign_picture = $dcg->campaign_picture;

                        $data_push = array(
                            'campaign_name' => $campaign_name,
                            'campaign_id' => $campaign_id,
                            'campaign_picture' => $campaign_picture,
                            'new_leads' => $new_leads,
                            'on_progress' => $on_progress,
                            'channel_count' => $channel_count
                        );
                        array_push($data_response, $data_push);
                    }

                    $data_campaign = array();
                    $data = array('status' => 200, 'count' => count($data_response), 'data' => $data_response);
                    $data = $data_response;
                } else {
                    $data_campaign = array();
                    $data = array('status' => 400, 'count' => 0, 'data' => $data_campaign);
                }
            } else {
                $data_campaign = array();
                $data = array('status' => 400, 'count' => 0, 'data' => $data_campaign);
            }
        } else {
            $data_campaign = array();
            $data = array('status' => 400, 'count' => 0, 'data' => $data_campaign);
        }

        return $data;
    }

    public function getLeadCategorybyCampaignId($campaign_id, $sales_officer_id) {

        //get data lead category
        $this->db->order_by('urutan', 'asc');
        $data_category = $this->db->get('tbl_lead_category')->result();

        //get data channel 
        $data_channel = $this->ChannelModels->getDataChannelbyCampagnId($campaign_id);

        $data_response = array();


        if (!empty($data_channel)) {

            $list_channel_id = array();
            foreach ($data_channel as $dch) {
                array_push($list_channel_id, $dch->channel_id);
            }

            foreach ($data_category as $dct) {

                $this->db->where_in('a.channel_id', $list_channel_id);
                $this->db->where('a.sales_officer_id', $sales_officer_id);
                $this->db->where('a.lead_category_id', $dct->lead_category_id);
                $this->db->select('count(a.lead_id) as total');
                $total = $this->db->get('tbl_lead a')->row('total');

                $data_push = array(
                    'lead_category_id' => $dct->lead_category_id,
                    'category_name' => $dct->category_name,
                    'mobile_icon' => $dct->mobile_icon,
                    'total' => $total
                );

                array_push($data_response, $data_push);
            }
        }

        return $data_response;
    }

    public function getStatusbyCampaignId($campaign_id) {

        $project_id = $this->db->get_where('tbl_campaign', array('id' => $campaign_id))->row('project_id');

        $data_status = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status' => 1))->result();

        return $data_status;
    }

    public function getProductbyCampaignId($campaign_id) {

        $project_id = $this->db->get_where('tbl_campaign', array('id' => $campaign_id))->row('project_id');

        $data_product = $this->db->get_where('tbl_product', array('project_id' => $project_id, 'status' => 1))->result();

        return $data_product;
    }

}
