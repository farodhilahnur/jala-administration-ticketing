<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ChannelModels extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('ProjectModels');
        $this->load->model('CampaignModels');
    }

    public function getChannelbyCampaignId($campaign_id)
    {
        $this->db->where_in('campaign_id', $campaign_id);
        $this->db->select('id');
        $data_channel = $this->db->get('tbl_channel')->result();

        $channel_id = array();
        if (!empty($data_channel)) {
            foreach ($data_channel as $dc) {
                array_push($channel_id, $dc->id);
            }
        }

        return $channel_id;

    }

    public function addChannel($post, $file_name)
    {

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

    public function generate_script()
    {


    }

    public function addChannelNew($step_1, $step_2, $step_3, $step_4, $file_name)
    {

        $unique_code = $this->MainModels->generateRandomString();
        $category = $step_1['category'];

        $data_insert_on = array(
            'channel_name' => $step_2['channel_name'],
            'campaign_id' => $step_2['campaign_channel'],
            'channel_media' => $step_1['media_id'],
            'channel_url' => $step_2['lp_url'],
            'channel_redirect_url' => $step_2['redirect_url'],
            'unique_code' => $unique_code,
            'channel_detail' => $step_2['channel_detail'],
            'channel_picture' => $file_name,
            'create_by' => $this->MainModels->UserSession('user_id')
        );

        $data_insert_off = array(
            'channel_name' => $step_2['channel_name'],
            'campaign_id' => $step_2['campaign_channel'],
            'channel_media' => $step_1['media_id'],
            'channel_detail' => $step_2['channel_detail'],
            'channel_picture' => $file_name,
            'create_by' => $this->MainModels->UserSession('user_id')
        );

        if ($category == 'Online') {
            $insert_channel = $this->db->insert('tbl_channel', $data_insert_on);
        }
        if ($category == 'Offline') {
            $insert_channel = $this->db->insert('tbl_channel', $data_insert_off);
        }

        if ($insert_channel) {

            $channel_id = $this->db->insert_id();

            foreach ($step_4['sales_team'] as $sales_team_id) {
                $data_insert_sales_team_channel = array('sales_team_id' => $sales_team_id, 'channel_id' => $channel_id);

                $insert_sales_team_channel = $this->db->insert('tbl_sales_team_channel', $data_insert_sales_team_channel);

                if ($insert_sales_team_channel) {
                    $response = 'success';
                    $message = '<p class="alert alert-success"> Success Add Channel </p>';
                    $this->session->set_userdata('unique_code', $unique_code);
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

    public function editChannel($post, $file_name)
    {
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

            //delete sales team channel
            $this->db->where('channel_id', $post['channel_id']);
            $this->db->delete('tbl_sales_team_channel');

            //insert sales team channel
            foreach ($post['salesTeam'] as $value) {
                $data_insert_sales_team_channel = array(
                    'sales_team_id' => $value,
                    'channel_id' => $post['channel_id']
                );

                $this->db->insert('tbl_sales_team_channel', $data_insert_sales_team_channel);
            }

            $response = 'success';
            $message = '<p class="alert alert-success"> Success Update Channel </p>';
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Update Channel </p>';
        }

        $data_channel = array('message' => $message, 'res' => $response);
        return $data_channel;
    }

    public function getParticipateDealerbyChannelId($channel_id)
    {

        $this->db->select('a.sales_team_name');
        $this->db->join('tbl_sales_team a', 'a.sales_team_id = b.sales_team_id');
        $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel b', array('b.channel_id' => $channel_id))->result();

        return $data_sales_team_channel;
    }

    public function getDataChannelUploadbyProjectId($project_id)
    {
        $this->db->select('a.id as channel_id, a.channel_name');
        $this->db->where('a.channel_media', 3);
        $this->db->where('b.project_id', $project_id);
        $this->db->join('tbl_campaign b', 'a.campaign_id = b.id');
        $data_channel = $this->db->get('tbl_channel a')->result();

        return $data_channel;
    }

    public function getDataChannelbyProjectId($project_id)
    {
        $this->db->select('a.id as channel_id, a.channel_name');
        $this->db->where('b.project_id', $project_id);
        $this->db->join('tbl_campaign b', 'a.campaign_id = b.id');
        $data_channel = $this->db->get('tbl_channel a')->result();

        return $data_channel;
    }

    public function getDataChannelbyProjectIdChart($project_id, $page)
    {
        $this->db->limit($page);
        $this->db->order_by('count(c.lead_id)', 'desc');
        $this->db->select('a.id as channel_id, a.channel_name');
        $this->db->group_by('c.channel_id');
        $this->db->where('b.project_id', $project_id);
        $this->db->join('tbl_campaign b', 'a.campaign_id = b.id');
        $this->db->join('tbl_lead c', 'a.id = c.channel_id');
        $data_channel = $this->db->get('tbl_channel a')->result();

        return $data_channel;
    }

    public function getDataChannelbyProjectId2($project_id)
    {
        $this->db->select('a.id, a.channel_name');
        $this->db->where('b.project_id', $project_id);
        $this->db->join('tbl_campaign b', 'a.campaign_id = b.id');
        $data_channel = $this->db->get('tbl_channel a')->result();

        return $data_channel;
    }

    public function getDataChannelbyCampagnId($campaign_id)
    {
        $this->db->select('a.id as channel_id, a.channel_name');
        $this->db->where('a.campaign_id', $campaign_id);
        $data_channel = $this->db->get('tbl_channel a')->result();

        return $data_channel;
    }

    public function getDataChannelbyCampagnIdChart($campaign_id, $page)
    {
        $this->db->limit($page);
        $this->db->order_by('count(c.lead_id)', 'desc');
        $this->db->select('a.id as channel_id, a.channel_name');
        $this->db->group_by('c.channel_id');
        $this->db->where('a.campaign_id', $campaign_id);
        $this->db->join('tbl_lead c', 'a.id = c.channel_id');
        $data_channel = $this->db->get('tbl_channel a')->result();

        return $data_channel;
    }

    public function getDataChannelbyCampagnId2($campaign_id)
    {
        $this->db->where('a.campaign_id', $campaign_id);
        $data_channel = $this->db->get('tbl_channel a')->result();

        return $data_channel;
    }

    public function getDataChannelLeadbyCampaignIdDash($id)
    {

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

    public function getDataChannelLeadbyCampaignId($id, $sales_officer_id)
    {

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

    public function getDataChannelOfflineLeadbyCampaignId($id, $sales_officer_id)
    {

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
            $data_channel = array();
        }

        return $data_channel;
    }

    public function getDataChannelbyCampaignId($id)
    {
        $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $id))->result();

        return $data_channel;
    }

    public function getCountChannelbyCampaignId($id)
    {

        $role_id = $this->MainModels->UserSession('role_id');

        switch ($role_id) {
            case 2:
                $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $id))->result();
                $count = count($data_channel);
                break;
            case 5:
                $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $id))->result();
                $count = count($data_channel);
                break;
            case 3:
                $sales_team_id = $this->MainModels->getSalesTeamId();
                $this->db->join('tbl_sales_team_channel b', 'a.id = b.channel_id');
                $data_channel = $this->db->get_where('tbl_channel a', array('a.campaign_id' => $id, 'b.sales_team_id' => $sales_team_id))->result();

                $count = count($data_channel);
                break;
            default:
                break;
        }

        return $count;
    }


    public function getDataChannelbyClientId()
    {

        $session_dashboard = $this->session->userdata('dashboard');

        $data_campaign = $this->CampaignModels->getDataCampaignbyClientId();

        $from = $session_dashboard['from'];
        $to = $session_dashboard['to'];
        $list_campaign_id = array();

        foreach ($data_campaign as $dcg) {
            array_push($list_campaign_id, $dcg->id);
        }

        if (!empty($list_campaign_id)) {
//            $this->db->where('create_at >=', $from . ' 00:00:00');
//            $this->db->where('create_at <=', $to . ' 23:59:59');
            $this->db->select('id, channel_name');
            $this->db->where_in('campaign_id', $list_campaign_id);
            $data_channel = $this->db->get('tbl_channel')->result();
        } else {
            $data_channel = array();
        }

        return $data_channel;
    }

    public function getDataChannelbyClientAdminId()
    {

        $session_dashboard = $this->session->userdata('dashboard');

        $data_campaign = $this->CampaignModels->getDataCampaignbyClientAdminId();

        $from = $session_dashboard['from'];
        $to = $session_dashboard['to'];
        $list_campaign_id = array();

        foreach ($data_campaign as $dcg) {
            array_push($list_campaign_id, $dcg->id);
        }

        if (!empty($list_campaign_id)) {
//            $this->db->where('create_at >=', $from . ' 00:00:00');
//            $this->db->where('create_at <=', $to . ' 23:59:59');
            $this->db->select('id, channel_name');
            $this->db->where_in('campaign_id', $list_campaign_id);
            $data_channel = $this->db->get('tbl_channel')->result();
        } else {
            $data_channel = array();
        }

        return $data_channel;
    }

    public function getDataChannelbyClientIdNonSession()
    {

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

    public function getDataChannelbySalesTeamId($sales_team_id)
    {

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

    public function getDataLeadByChannelDashboard($session_dashboard)
    {

        $project_id = $session_dashboard['project_id'];
        $from_date = $session_dashboard['from'];
        $to_date = $session_dashboard['to'];

        $jum = count($this->LeadModels->getLeadDashboard($project_id, $from_date, $to_date));

        $data_chart = array();

        $data_channel = $this->ChannelModels->getDataChannelbyClientAdminId();

        foreach ($data_channel as $dch) {
            $this->db->where_in('a.channel_id', $dch->id);
            $this->db->where('a.update_date >=', $from_date . ' 00:00:00');
            $this->db->where('a.update_date <=', $to_date . ' 23:59:59');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
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

    public function getDataChannelStatisticsbySalesTeamId($sales_team_id)
    {
        $session_filter = $this->session->userdata('dashboard');
//        $project_id = $session_filter['project_id'];
//        $from = $session_filter['from'];
//        $to = $session_filter['to'];

        $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel', array('sales_team_id' => $sales_team_id))->result();

        $list_channel = array();

        if (!empty($data_sales_team_channel)) {
            foreach ($data_sales_team_channel as $dstc) {
                array_push($list_channel, $dstc->channel_id);
            }

            //get data campaign by channel id
//            $this->db->where('create_at >=', $from . ' 00:00:00');
//            $this->db->where('create_at <=', $to . ' 23:59:59');
            $this->db->where_in('id', $list_channel);
            $data = $this->db->get('tbl_channel')->result();
        } else {
            $data = array();
        }

        return $data;
    }

    public function getDataChannelReportbyClientId($client_id)
    {

        $data_campaign = $this->CampaignModels->getDataCampaignReportbyClientId($client_id);

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

    public function getDataChannelOfflinebyClientId()
    {

        $session_dashboard = $this->session->userdata('dashboard');

        $data_campaign = $this->CampaignModels->getDataCampaignbyClientId();

        $list_campaign_id = array();

        foreach ($data_campaign as $dcg) {
            array_push($list_campaign_id, $dcg->id);
        }

        if (!empty($list_campaign_id)) {
            $this->db->where('c.media_category', 3);
            $this->db->where_in('a.campaign_id', $list_campaign_id);
            $this->db->join('tbl_media c', 'a.channel_media = c.id');
            $this->db->select('a.*');
            $data_channel = $this->db->get('tbl_channel a')->result();
        } else {
            $data_channel = array();
        }

        return $data_channel;
    }

    public function getDataChannelOnlinebyClientId()
    {

        $session_dashboard = $this->session->userdata('dashboard');

        $data_campaign = $this->CampaignModels->getDataCampaignbyClientId();

        $list_campaign_id = array();

        foreach ($data_campaign as $dcg) {
            array_push($list_campaign_id, $dcg->id);
        }

        if (!empty($list_campaign_id)) {
            $this->db->where('c.media_category', 1);
            $this->db->where_in('a.campaign_id', $list_campaign_id);
            $this->db->join('tbl_media c', 'a.channel_media = c.id');
            $this->db->select('a.*');
            $data_channel = $this->db->get('tbl_channel a')->result();
        } else {
            $data_channel = array();
        }

        return $data_channel;
    }

    public function getDataChannelOfflinebySalesTeamId($sales_team_id)
    {

        $list_channel_id = array();

        $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel', array('sales_team_id' => $sales_team_id))->result();

        if (!empty($data_sales_team_channel)) {
            foreach ($data_sales_team_channel as $dstc) {
                array_push($list_channel_id, $dstc->channel_id);
            }

            $this->db->where('c.media_category', 3);
            $this->db->where_in('a.id', $list_channel_id);
            $this->db->join('tbl_media c', 'a.channel_media = c.id');
            $this->db->select('a.*');
            $data_channel = $this->db->get('tbl_channel a')->result();
        } else {
            $data_channel = array();
        }

        return $data_channel;
    }

    public function getDataChannelOnlinebySalesTeamId($sales_team_id)
    {
        $list_channel_id = array();

        $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel', array('sales_team_id' => $sales_team_id))->result();

        if (!empty($data_sales_team_channel)) {
            foreach ($data_sales_team_channel as $dstc) {
                array_push($list_channel_id, $dstc->channel_id);
            }

            $this->db->where('c.media_category', 1);
            $this->db->where_in('a.id', $list_channel_id);
            $this->db->join('tbl_media c', 'a.channel_media = c.id');
            $this->db->select('a.*');
            $data_channel = $this->db->get('tbl_channel a')->result();
        } else {
            $data_channel = array();
        }

        return $data_channel;
    }

    public function getChannelTypeProjectId($project_id, $type)
    {

        if ($project_id != 0) {
            //get campaign
            $this->db->select('id');
            $data_campaign = $this->db->get_where('tbl_campaign', array('project_id' => $project_id))->result();

            $campaign_id = array();
            if (!empty($data_campaign)) {
                foreach ($data_campaign as $dc) {
                    array_push($campaign_id, $dc->id);
                }
            }

            $this->db->select('a.id');
            $this->db->where_in('a.campaign_id', $campaign_id);
            $this->db->where('b.media_category', $type);
            $this->db->join('tbl_media b', 'a.channel_media = b.id');
            $data_channel = $this->db->get('tbl_channel a')->result();


        } else {
            $client_id = $this->MainModels->getClientId();

            $this->db->where('client_id', $client_id);
            $this->db->select('id');
            $data_project = $this->db->get('tbl_project')->result();

            $project_id = array();
            if (!empty($data_project)) {
                foreach ($data_project as $dp) {
                    array_push($project_id, $dp->id);
                }
            }

            if (!empty($project_id)) {
                //get campaign
                $this->db->where_in('project_id', $project_id);
                $this->db->select('id');
                $data_campaign = $this->db->get('tbl_campaign')->result();

                $campaign_id = array();
                if (!empty($data_campaign)) {
                    foreach ($data_campaign as $dc) {
                        array_push($campaign_id, $dc->id);
                    }

                    $this->db->select('a.id');
                    $this->db->where_in('a.campaign_id', $campaign_id);
                    $this->db->where('b.media_category', $type);
                    $this->db->join('tbl_media b', 'a.channel_media = b.id');
                    $data_channel = $this->db->get('tbl_channel a')->result();

                } else {
                    $data_channel = array();
                }


            } else {
                $data_channel = array();
            }


        }

        return $data_channel;

    }

    public function getChannelbyProjectId($project_id)
    {

        if ($project_id != 0) {
            //get campaign
            $this->db->select('id');
            $data_campaign = $this->db->get_where('tbl_campaign', array('project_id' => $project_id))->result();

            $campaign_id = array();
            if (!empty($data_campaign)) {
                foreach ($data_campaign as $dc) {
                    array_push($campaign_id, $dc->id);
                }

                $this->db->select('id');
                $this->db->where_in('campaign_id', $campaign_id);
                $data_channel = $this->db->get('tbl_channel')->result();

            } else {
                $data_channel = array();
            }


        } else {
            $client_id = $this->MainModels->getClientId();

            $this->db->where('client_id', $client_id);
            $this->db->select('id');
            $data_project = $this->db->get('tbl_project')->result();


            $project_id = array();
            if (!empty($data_project)) {
                foreach ($data_project as $dp) {
                    array_push($project_id, $dp->id);
                }
            }

            if (!empty($project_id)) {

                //get campaign
                $this->db->where_in('project_id', $project_id);
                $this->db->select('id');
                $data_campaign = $this->db->get('tbl_campaign')->result();


                $campaign_id = array();
                if (!empty($data_campaign)) {
                    foreach ($data_campaign as $dc) {
                        array_push($campaign_id, $dc->id);
                    }

                    $this->db->select('id');
                    $this->db->where_in('campaign_id', $campaign_id);
                    $data_channel = $this->db->get('tbl_channel')->result();

                } else {
                    $data_channel = array();
                }


            } else {
                $data_channel = array();
            }


        }

        return $data_channel;

    }

}
