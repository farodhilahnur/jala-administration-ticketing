<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ChannelModels extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->model('ProjectModels');
        $this->load->model('CampaignModels');
    }

    public function addChannel($post, $file_name) {

        $unique_code = $this->MainModels->generateRandomString();

        $data_insert = array(
            'channel_name' => $post['channel_name'],
            'campaign_id' => $post['campaign_id'],
            'channel_media' => $post['media_id'],
            'channel_url' => $post['channel_url'],
            'channel_redirect_url' => $post['channel_redirect_url'],
            'unique_code' => $unique_code,
            'channel_detail' => $post['channel_detail'],
            'channel_picture' => $file_name,
            'create_by' => $this->MainModels->UserSession('user_id')
        );

        $insert_channel = $this->db->insert('tbl_channel', $data_insert);

        if ($insert_channel) {

            $channel_id = $this->db->insert_id();

            foreach ($post['sales_team'] as $sales_team_id) {
                $data_insert_sales_team_channel = array('sales_team_id' => $sales_team_id, 'channel_id' => $channel_id);

                $insert_sales_team_channel = $this->db->insert('tbl_sales_team_channel', $data_insert_sales_team_channel);

                if ($insert_sales_team_channel) {
                    $response = 'success';
                    $message = '<p class="alert alert-success"> Success Add Channel </p>';
                } else {
                    $response = 'error';
                    $message = '<p class="alert alert-danger"> Error Add Channel </p>';
                }
            }
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Add Channel </p>';
        }

        $data_channel = array('message' => $message, 'res' => $response);
        return $data_channel;
    }

    public function editChannel($post, $file_name) {

        if ($file_name == "") {
            $data_update = array(
                'channel_name' => $post['channel_name'],
                'channel_url' => $post['channel_url'],
                'channel_redirect_url' => $post['channel_redirect_url'],
                'channel_detail' => $post['channel_detail'],
                'update_by' => $this->MainModels->UserSession('user_id')
            );
        } else {
            $data_update = array(
                'channel_name' => $post['channel_name'],
                'channel_url' => $post['channel_url'],
                'channel_redirect_url' => $post['channel_redirect_url'],
                'channel_detail' => $post['channel_detail'],
                'update_by' => $this->MainModels->UserSession('user_id'),
                'channel_picture' => $file_name
            );
        }


        $this->db->where('id', $post['channel_id']);
        $update_campaign = $this->db->update('tbl_channel', $data_update);

        if ($update_campaign) {
            $response = 'success';
            $message = '<p class="alert alert-success"> Success Update Channel </p>';
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Update Channel </p>';
        }

        $data_channel = array('message' => $message, 'res' => $response);
        return $data_channel;
    }

    public function getParticipateDealerbyChannelId($channel_id) {

        $this->db->select('a.sales_team_name');
        $this->db->join('tbl_sales_team a', 'a.sales_team_id = b.sales_team_id');
        $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel b', array('b.channel_id' => $channel_id))->result();

        return $data_sales_team_channel;
    }

    public function getDataChannelUploadbyProjectId($project_id) {
        $this->db->select('a.id as channel_id, a.channel_name');
        $this->db->where('a.channel_media', 3);
        $this->db->where('b.project_id', $project_id);
        $this->db->join('tbl_campaign b', 'a.campaign_id = b.id');
        $data_channel = $this->db->get('tbl_channel a')->result();

        return $data_channel;
    }

    public function getDataChannelbyProjectId($project_id) {
        $this->db->select('a.id as channel_id, a.channel_name');
        $this->db->where('b.project_id', $project_id);
        $this->db->join('tbl_campaign b', 'a.campaign_id = b.id');
        $data_channel = $this->db->get('tbl_channel a')->result();

        return $data_channel;
    }

    public function getDataChannelbyProjectId2($project_id) {
        $this->db->select('a.id, a.channel_name');
        $this->db->where('b.project_id', $project_id);
        $this->db->join('tbl_campaign b', 'a.campaign_id = b.id');
        $data_channel = $this->db->get('tbl_channel a')->result();

        return $data_channel;
    }

    public function getDataChannelbyCampagnId($campaign_id) {
        $this->db->select('a.id as channel_id, a.channel_name');
        $this->db->where('a.campaign_id', $campaign_id);
        $data_channel = $this->db->get('tbl_channel a')->result();

        return $data_channel;
    }

    public function getDataChannelbyCampagnId2($campaign_id) {
        $this->db->where('a.campaign_id', $campaign_id);
        $data_channel = $this->db->get('tbl_channel a')->result();

        return $data_channel;
    }

    public function getDataChannelLeadbyCampaignIdDash($id) {

        $data = array();

        $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $id))->result();
        foreach ($data_channel as $dch) {
            $this->db->where('channel_id', $dch->id);
            $this->db->select('count(lead_id) as leads');
            //$this->db->group_by('channel_id');
            $data_count_lead = $this->db->get('tbl_lead')->row();

            if ($data_count_lead->leads == 0) {
                $total = 0;
            } else {
                $total = $data_count_lead->leads;
            }

            $data_push = array(
                'channel_name' => $dch->channel_name,
                'total' => $total
            );

            array_push($data, $data_push);
        }

        return $data;
    }

    public function getDataChannelLeadbyCampaignId($id, $sales_officer_id) {

        $data = array();

        $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $id))->result();
        foreach ($data_channel as $dch) {
            $this->db->where('channel_id', $dch->id);
            $this->db->select('count(lead_id) as leads');
            $this->db->where('sales_officer_id', $sales_officer_id);
            //$this->db->group_by('channel_id');
            $data_count_lead = $this->db->get('tbl_lead')->row();

            if ($data_count_lead->leads == 0) {
                $total = 0;
            } else {
                $total = $data_count_lead->leads;
            }

            $data_push = array(
                'channel_name' => $dch->channel_name,
                'channel_id' => $dch->id,
                'total' => $total
            );

            array_push($data, $data_push);
        }

        return $data;
    }

    public function getDataChannelOfflineLeadbyCampaignId($id, $sales_officer_id) {

        $list_sales_team = array();
        $data_sales_officer_group = $this->db->get_where('tbl_sales_officer_group', array('sales_officer_id' => $sales_officer_id))->result();
        
        if (!empty($data_sales_officer_group)) {
            foreach ($data_sales_officer_group as $dsog) {
                array_push($list_sales_team, $dsog->sales_team_id);
            }

            $this->db->where('c.campaign_id', $id);
            $this->db->where_in('a.sales_team_id', $list_sales_team);
            $this->db->where('b.media_category', 3);   
            $this->db->join('tbl_channel c', 'a.channel_id = c.id');
            $this->db->join('tbl_media b', 'b.id = c.channel_media');
            $data_channel = $this->db->get('tbl_sales_team_channel a')->result();
        } else {
            $data_channel = [];   
        }
        
        return $data_channel;
    }

    public function getDataChannelbyCampaignId($id) {
        $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $id))->result();

        return $data_channel;
    }

    public function getDataChannelbyClientId() {

        $data_campaign = $this->CampaignModels->getDataCampaignbyClientId();

        $list_campaign_id = array();

        foreach ($data_campaign as $dcg) {
            array_push($list_campaign_id, $dcg->id);
        }

        if (!empty($list_campaign_id)) {
            $this->db->where_in('campaign_id', $list_campaign_id);
            $data_channel = $this->db->get('tbl_channel')->result();
        } else {
            $data_channel = array();
        }

        return $data_channel;
    }

    public function getDataChannelbyClientIdNonSession() {

        $data_campaign = $this->CampaignModels->getDataCampaignbyClientIdNonSession();

        $list_campaign_id = array();

        foreach ($data_campaign as $dcg) {
            array_push($list_campaign_id, $dcg->id);
        }

        if (!empty($list_campaign_id)) {
            $this->db->where_in('campaign_id', $list_campaign_id);
            $data_channel = $this->db->get('tbl_channel')->result();
        } else {
            $data_channel = array();
        }

        return $data_channel;
    }

    public function getDataChannelbySalesTeamId($sales_team_id) {

        $list_channel_id = array();

        $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel', array('sales_team_id' => $sales_team_id))->result();

        if (!empty($data_sales_team_channel)) {
            foreach ($data_sales_team_channel as $dstc) {
                array_push($list_channel_id, $dstc->channel_id);
            }

            $this->db->where_in('id', $list_channel_id);
            $this->db->select('*, id as channel_id');
            $data_channel = $this->db->get('tbl_channel')->result();
        } else {
            $data_channel = array();
        }

        return $data_channel;
    }

    public function getDataLeadByChannelDashboard($session_dashboard) {

        $project_id = $session_dashboard['project_id'];
        $date = explode(' to ', $session_dashboard['date_range']);
        $from_date = $date[0];
        $to_date = $date[1];

        $jum = count($this->LeadModels->getLeadDashboard($project_id, $from_date, $to_date));

        $data_chart = array();

        if ($project_id == 0) {
            $data_channel = $this->ChannelModels->getDataChannelbyClientId();
        } else {
            $data_channel = $this->ChannelModels->getDataChannelbyProjectId2($project_id);
        }

        foreach ($data_channel as $dch) {
            $this->db->where_in('a.channel_id', $dch->id);
            $this->db->where('a.create_date >=', $from_date . ' 00:00:00');
            $this->db->where('a.create_date <=', $to_date . ' 23:59:59');
            $this->db->select('count(a.lead_id) as total');
            $data_lead_by_channel = $this->db->get('tbl_lead a')->row();

            if ($jum != 0) {
                $percent = round(intval($data_lead_by_channel->total / intval($jum) * 100), 2);
            } else {
                $percent = 0;
            }

            $data = array(
                'channel_name' => $dch->channel_name,
                'total' => $data_lead_by_channel->total,
                'percent' => $percent
            );

            array_push($data_chart, $data);
        }

        return $data_chart;
    }

}
