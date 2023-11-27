<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LeadModels extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('ChannelModels');
        $this->load->model('ProjectModels');
        $this->load->model('CampaignModels');
        $this->load->model('TeamModels');
        $this->load->model('StatusModels');
    }

    public function getLeadPerformanceCampaign($from, $to, $project_id, $role, $list_sales_officer_id)
    {

        //GET CATEGORY
        $this->db->order_by('urutan', 'asc');
        $this->db->select('lead_category_id');
        $data_category = $this->db->get('tbl_lead_category')->result();

        $category_id = array();
        foreach ($data_category as $dct) {
            array_push($category_id, $dct->lead_category_id);
        }

        //GET CAMPAIGN
        $campaign_id = $this->CampaignModels->getDataCampaignbyProjectId($project_id);

        //GET CHANNEL
        $channel_id = $this->ChannelModels->getChannelbyCampaignId($campaign_id);

        //GET DETAIL CAMPAIGN
        $this->db->where_in('id', $campaign_id);
        $this->db->select('campaign_name, ');
        $data_label = $this->db->get('tbl_campaign')->result();

        //GET COUNT LEAD PER CAMPAIGN
        $this->db->order_by('count(a.lead_id)', 'desc');
        $this->db->where('a.update_date >=', $from . ' 00:00:00');
        $this->db->where('a.update_date <=', $to . ' 23:59:59');
        $this->db->where_in('b.id', $campaign_id);

        if ($role == 3) {
            $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
        }

        $this->db->group_by('b.id');
        $this->db->select('count(a.lead_id) as total, b.campaign_name, b.id');
        $this->db->join('tbl_channel c', 'c.id = a.channel_id');
        $this->db->join('tbl_campaign b', 'b.id = c.campaign_id');
        $this->db->join('tbl_lead_category e', 'a.lead_category_id = e.lead_category_id');
        $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
        $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
        $data_label = $this->db->get('tbl_lead a')->result();

        print_r($data_label);
        exit;

        $lbl = array();

        if (!empty($data_label)) {
            foreach ($data_label as $dlb) {
                array_push($lbl, $dlb->campaign_name);
            }
        }

        $dataset = array();
        $json = array();
        if (!empty($data_label)) {

            foreach ($category_id as $c) {

                $data_category = $this->db->get_where('tbl_lead_category', array('lead_category_id' => $c))->row();

                $bg_color = $data_category->background_color;
                $category_name = $data_category->category_name;

                $total = array();

                foreach ($data_label as $dl) {

                    $this->db->where('a.update_date >=', $from . ' 00:00:00');
                    $this->db->where('a.update_date <=', $to . ' 23:59:59');
                    $this->db->where('b.id', $dl->id);
                    if ($role == 3) {
                        $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                    }
                    $this->db->where('a.lead_category_id', $c);
                    $this->db->select('count(a.lead_id) as total, e.category_name, e.background_color');
                    $this->db->join('tbl_channel c', 'c.id = a.channel_id');
                    $this->db->join('tbl_campaign b', 'b.id = c.campaign_id');
                    $this->db->join('tbl_lead_category e', 'a.lead_category_id = e.lead_category_id');
                    $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
                    $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                    $data_lead = $this->db->get('tbl_lead a')->result();

                    if (!empty($data_lead)) {
                        foreach ($data_lead as $dle) {
                            array_push($total, $dle->total);
                        }
                    }

                }
                $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color);
                array_push($dataset, $data);
            }

            array_push($json, $dataset);

        }

        array_push($json, $lbl);
        print_r($json);
        exit;


        return $json;

    }

    public function OnlineOfflineLead()
    {
        $session_dashboard = $this->session->userdata('dashboard');
        $role = $this->MainModels->UserSession('role_id');

        if ($role == 3) {

            $sales_team_id = $this->MainModels->getSalesTeamId();

            //get data sales officer
            $data_sales_officer_group = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $sales_team_id))->result();

            $list_sales_officer_id = array();
            if (!empty($data_sales_officer_group)) {
                foreach ($data_sales_officer_group as $dsog) {
                    array_push($list_sales_officer_id, $dsog->sales_officer_id);
                }
            }
        }


        $from = $session_dashboard['from'];
        $to = $session_dashboard['to'];
        $project_id = $session_dashboard['project_id'];

        $data_channel_online = $this->ChannelModels->getChannelTypeProjectId($project_id, 1);
        $data_channel_offline = $this->ChannelModels->getChannelTypeProjectId($project_id, 3);

        $list_channel_online_id = array();

        foreach ($data_channel_online as $dco) {
            array_push($list_channel_online_id, $dco->id);
        }

        $list_channel_offline_id = array();

        foreach ($data_channel_offline as $dcof) {
            array_push($list_channel_offline_id, $dcof->id);
        }


        if (!empty($list_channel_online_id)) {
            $this->db->order_by('a.create_date', 'desc');
            $this->db->where('a.update_date >=', $from . ' 00:00:00');
            $this->db->where('a.update_date <=', $to . ' 23:59:59');

            if ($role == 3) {
                $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
            }

            $this->db->where_in('a.channel_id', $list_channel_online_id);
            $this->db->select('a.*, b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name');
            $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
            $this->db->join('tbl_channel f', 'a.channel_id = f.id');
            $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
            $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
            $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id', 'left');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
            $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
            $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
            $data_lead_online = $this->db->get('tbl_lead a')->result();
        } else {
            $data_lead_online = array();
        }

        if (!empty($list_channel_offline_id)) {
            $this->db->order_by('a.create_date', 'desc');
            $this->db->where('a.update_date >=', $from . ' 00:00:00');
            $this->db->where('a.update_date <=', $to . ' 23:59:59');

            if ($role == 3) {
                $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
            }

            $this->db->where_in('a.channel_id', $list_channel_offline_id);
            $this->db->select('a.*, b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name');
            $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
            $this->db->join('tbl_channel f', 'a.channel_id = f.id');
            $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
            $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
            $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id', 'left');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
            $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
            $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
            $data_lead_offline = $this->db->get('tbl_lead a')->result();
        } else {
            $data_lead_offline = array();
        }

        $data_all = $this->getCountLeadbyClientId();
        $jum_online = (count($data_lead_online) / count($data_all)) * 100;
        $jum_offline = (count($data_lead_offline) / count($data_all)) * 100;

        $data = array('online_total' => count($data_lead_online), 'online_percent' => $jum_online, 'offline_total' => count($data_lead_offline), 'offline_percent' => $jum_offline);

        return $data;
    }

    public function getCountLeadbySalesTeamId($sales_team_id)
    {
        $session_filter = $this->session->userdata('dashboard');
        $from = $session_filter['from'];
        $to = $session_filter['to'];

        //get data sales officer
        $data_sales_officer_group = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $sales_team_id))->result();

        $list_sales_officer_id = array();
        if (!empty($data_sales_officer_group)) {
            foreach ($data_sales_officer_group as $dsog) {
                array_push($list_sales_officer_id, $dsog->sales_officer_id);
            }

            $data_channel = $this->ChannelModels->getDataChannelStatisticsbySalesTeamId($sales_team_id);

            $list_channel = array();
            if (!empty($data_channel)) {
                foreach ($data_channel as $dch) {
                    array_push($list_channel, $dch->id);
                }

                //get data lead
                $this->db->order_by('a.create_date', 'desc');
                $this->db->where('a.update_date >=', $from . ' 00:00:00');
                $this->db->where('a.update_date <=', $to . ' 23:59:59');
                $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                $this->db->where_in('a.channel_id', $list_channel);
                $this->db->select('a.*, b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name');
                $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
                $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                $this->db->join('tbl_channel f', 'a.channel_id = f.id');
                $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
                $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
                $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id', 'left');
                $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
                $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
                $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
                $data_lead = $this->db->get('tbl_lead a')->result();
            } else {
                $data_lead = array();
            }
        } else {
            $data_lead = array();
        }

        return $data_lead;
    }

    public function getCountLeadbyClientId()
    {

        $session_dashboard = $this->session->userdata('dashboard');

        $from = $session_dashboard['from'];
        $to = $session_dashboard['to'];
        $project_id = $session_dashboard['project_id'];

        $data_channel = $this->ChannelModels->getChannelbyProjectId($project_id);

        $list_channel_id = array();

        foreach ($data_channel as $dch) {
            array_push($list_channel_id, $dch->id);
        }


        if (!empty($list_channel_id)) {
            $this->db->order_by('a.create_date', 'desc');
            $this->db->where('a.update_date >=', $from . ' 00:00:00');
            $this->db->where('a.update_date <=', $to . ' 23:59:59');
            $this->db->where_in('a.channel_id', $list_channel_id);
            $this->db->select('a.*, b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name');
            $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
            $this->db->join('tbl_channel f', 'a.channel_id = f.id');
            $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
            $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
            $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id', 'left');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
            $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
            $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
            $data_lead = $this->db->get('tbl_lead a')->result();
        } else {
            $data_lead = array();
        }

        return $data_lead;
    }

    public function getLeadsbyCategory($category)
    {

        $session_dashboard = $this->session->userdata('dashboard');

        $from = $session_dashboard['from'];
        $to = $session_dashboard['to'];
        $project_id = $session_dashboard['project_id'];
        $data_channel = $this->ChannelModels->getChannelbyProjectId($project_id);

        $list_channel_id = array();

        foreach ($data_channel as $dch) {
            array_push($list_channel_id, $dch->id);
        }

        if (!empty($list_channel_id)) {

            if ($category != 1) {
                $category = array(1, 5);
                $this->db->where_not_in('a.lead_category_id', $category);
            } else {
                $this->db->where('a.lead_category_id', 1);
            }

            $this->db->order_by('a.create_date', 'desc');
            $this->db->where('a.update_date >=', $from . ' 00:00:00');
            $this->db->where('a.update_date <=', $to . ' 23:59:59');
            $this->db->where_in('a.channel_id', $list_channel_id);
            $this->db->select('a.*, b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name');
            $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
            $this->db->join('tbl_channel f', 'a.channel_id = f.id');
            $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
            $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
            $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id', 'left');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
            $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
            $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
            $data_lead = $this->db->get('tbl_lead a')->result();
        } else {
            $data_lead = array();
        }

        return $data_lead;
    }

    public function getLeadsbyCategorySalesTeamId($category, $sales_team_id)
    {

        $session_dashboard = $this->session->userdata('dashboard');

        $from = $session_dashboard['from'];
        $to = $session_dashboard['to'];
        $project_id = $session_dashboard['project_id'];
        $data_channel = $this->ChannelModels->getChannelbyProjectId($project_id);

        $list_channel_id = array();

        foreach ($data_channel as $dch) {
            array_push($list_channel_id, $dch->id);
        }

        //get data sales officer
        $data_sales_officer_group = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $sales_team_id))->result();

        $list_sales_officer_id = array();
        if (!empty($data_sales_officer_group)) {
            foreach ($data_sales_officer_group as $dsog) {
                array_push($list_sales_officer_id, $dsog->sales_officer_id);
            }

            if (!empty($list_channel_id)) {

                if ($category != 1) {
                    $category = array(1, 5);
                    $this->db->where_not_in('a.lead_category_id', $category);
                } else {
                    $this->db->where('a.lead_category_id', 1);
                }

                $this->db->order_by('a.create_date', 'desc');
                $this->db->where('a.update_date >=', $from . ' 00:00:00');
                $this->db->where('a.update_date <=', $to . ' 23:59:59');
                $this->db->where_in('a.channel_id', $list_channel_id);
                $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                $this->db->select('a.*, b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name');
                $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
                $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                $this->db->join('tbl_channel f', 'a.channel_id = f.id');
                $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
                $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
                $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id', 'left');
                $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
                $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
                $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
                $data_lead = $this->db->get('tbl_lead a')->result();
            } else {
                $data_lead = array();
            }

        } else {
            $data_lead = array();
        }


        return $data_lead;
    }

    public function getCountLeadbyProjectAdmin()
    {
        $session_dashboard = $this->session->userdata('dashboard');

        $from = $session_dashboard['from'];
        $to = $session_dashboard['to'];

        $data_channel = $this->ChannelModels->getDataChannelbyClientAdminId();

        $list_channel_id = array();

        foreach ($data_channel as $dch) {
            array_push($list_channel_id, $dch->id);
        }


        if (!empty($list_channel_id)) {
            $this->db->order_by('a.create_date', 'desc');
            $this->db->where('a.update_date >=', $from . ' 00:00:00');
            $this->db->where('a.update_date <=', $to . ' 23:59:59');
            $this->db->where_in('a.channel_id', $list_channel_id);
            $this->db->select('a.*, b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name');
            $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
            $this->db->join('tbl_channel f', 'a.channel_id = f.id');
            $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
            $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
            $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id', 'left');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
            $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
            $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
            $data_lead = $this->db->get('tbl_lead a')->result();
        } else {
            $data_lead = array();
        }


        return $data_lead;
    }

    public function getCountLeadbyClientIdNonSession()
    {

        $data_channel = $this->ChannelModels->getDataChannelbyClientIdNonSession();
        $list_channel_id = array();

        foreach ($data_channel as $dch) {
            array_push($list_channel_id, $dch->id);
        }

        if (!empty($list_channel_id)) {
            $this->db->order_by('a.create_date', 'desc');
            $this->db->where_in('a.channel_id', $list_channel_id);
            $this->db->select('a.*, b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name');
            $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id', 'left');
            $this->db->join('tbl_channel f', 'a.channel_id = f.id');
            $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
            $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
            $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
            $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
            $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
            $data_lead = $this->db->get('tbl_lead a')->result();
        } else {
            $data_lead = array();
        }


        return $data_lead;
    }

    public function getCountLeadbyClientIdLeadIndex($from, $to, $sales_team_id, $sales_officer_id, $campaign_id, $channel_id, $category_id, $status_id)
    {

        if ($status_id != 0) {
            $status_name = $this->db->get_where('tbl_status', array('id' => $status_id))->row('status_name');

        }

        if ($campaign_id == 0) {
            $data_channel = $this->ChannelModels->getDataChannelbyClientId();
        } else {
            $data_channel = $this->ChannelModels->getDataChannelbyCampagnId($campaign_id);
        }

        $list_channel_id = array();

        if ($campaign_id == 0) {
            foreach ($data_channel as $dch) {
                array_push($list_channel_id, $dch->id);
            }
        } else {
            foreach ($data_channel as $dch) {
                array_push($list_channel_id, $dch->channel_id);
            }
        }

        if (!empty($list_channel_id)) {

            if ($sales_team_id != 0) {
                $this->db->where('j.sales_team_id', $sales_team_id);
            }

            if ($sales_officer_id != 0) {
                $this->db->where('a.sales_officer_id', $sales_officer_id);
            }

            $this->db->order_by('a.create_date', 'desc');

            if ($channel_id != 0) {
                $this->db->where('a.channel_id', $channel_id);
            } else {

                $this->db->where_in('a.channel_id', $list_channel_id);
            }

            if ($category_id != 0) {
                $this->db->where('a.lead_category_id', $category_id);
            }

            //get status name
            if ($status_id != 0) {
                $this->db->where('b.status_name', $status_name);
            }

            $this->db->group_by('a.lead_id');
            $this->db->where('a.create_date >=', $from . ' 00:00:00');
            $this->db->where('a.create_date <=', $to . ' 23:59:59');
            $this->db->select("a.lead_id, a.lead_name, a.lead_phone, a.lead_email, a.lead_address, a.note, "
                . "CONVERT_TZ(a.create_date, '+00:00', '+07:00') as create_date, "
                . "CONVERT_TZ(a.update_date, '+00:00', '+07:00') as update_date,  "
                . "b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, "
                . "g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name");
            $this->db->join('tbl_status b', 'a.status_id = b.id');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id', 'left');
            $this->db->join('tbl_channel f', 'a.channel_id = f.id');
            $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
            $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
            $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
            $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
            $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
            $data_leads = $this->db->get('tbl_lead a')->result();

//            echo "<pre>";
//            print_r($data_leads);
//            echo "</pre>" ;
//            exit ;

            $list_lead_id = "";
            if (!empty($data_leads)) {
                foreach ($data_leads as $key => $dl) {
                    if ($key + 1 != count($data_leads)) {
                        $list_lead_id .= $dl->lead_id . ",";
                    } else {
                        $list_lead_id .= $dl->lead_id;
                    }
                }

//                print_r($list_lead_id);
                //get data history lead

                $sql = "SELECT lead_id, notes
                        FROM tbl_lead_history
                        WHERE lead_history_id IN (
                            SELECT MAX(lead_history_id)
                            FROM tbl_lead_history
                            WHERE lead_id IN ($list_lead_id)
                            GROUP BY lead_id
                        )";

                $data_hist = $this->db->query($sql);
                $data_history = $data_hist->result();

//                echo "<pre>";
//                print_r($data_history);
//                echo "</pre>";
//                exit;

                $list_history_lead = array();
                if (!empty($data_history)) {
                    foreach ($data_history as $dh) {
//                        array_push($list_history_lead, $dh->lead_id . '|' . $dh->notes);
                        $list_history_lead[$dh->lead_id] = $dh->notes;
//                        array_push($list_history_lead, $push[$dh->lead_id] );
                    }
                }

//                echo "<pre>";
//                print_r($list_history_lead);
//                echo "</pre>";
//                exit;  

                $data = array();
                foreach ($data_leads as $dleads) {
                    $row['lead_id'] = $dleads->lead_id;
                    $row['lead_name'] = $dleads->lead_name;
                    $row['lead_phone'] = $dleads->lead_phone;
                    $row['lead_email'] = $dleads->lead_email;
                    $row['note'] = $dleads->note;
                    $row['create_date'] = $dleads->create_date;
                    $row['update_date'] = $dleads->update_date;
                    $row['status_name'] = $dleads->status_name;
                    $row['sales_officer_name'] = $dleads->sales_officer_name;
                    $row['campaign_name'] = $dleads->campaign_name;
                    $row['channel_name'] = $dleads->channel_name;
                    $row['product_name'] = $dleads->product_name;
                    $row['kota_name'] = $dleads->kota_name;
                    $row['category_name'] = $dleads->category_name;
                    $row['color'] = $dleads->color;
                    $row['icon'] = $dleads->icon;
                    $row['sales_team_name'] = $dleads->sales_team_name;

                    if (isset($list_history_lead[$dleads->lead_id])) {
                        $row['last_history'] = $list_history_lead[$dleads->lead_id];
                    } else {
                        $row['last_history'] = "";
                    }

//                    foreach ($list_history_lead as $lh) {  
//                        $notes = explode('|', $lh);
//                        $lead_id = $notes[0];
//
//                        if ($lead_id == $dleads->lead_id) {
//                            $row['last_history'] = $notes[1];
//                        } 
//                    }

                    array_push($data, $row);
                }
            }

//            echo "<pre>";
//            print_r($data);
//            echo "</pre>";
//            exit;
        } else {
            $data = array();
        }

        return $data;
    }

    public function getCountLeadsbyChannelId($id)
    {

        $data_lead = $this->db->get_where('tbl_lead', array('channel_id' => $id))->result();

        return count($data_lead);
    }

    public function getCountLeadsbySalesOfficerId($id)
    {
        $data_lead = $this->db->get_where('tbl_lead', array('sales_officer_id' => $id))->result();

        return count($data_lead);
    }

    public function getDataLeadByProjectNonSession($project_id)
    {

        $list_channel_id = array();

        $data_channel = $this->ChannelModels->getDataChannelbyProjectId($project_id);

        foreach ($data_channel as $dc) {
            array_push($list_channel_id, $dc->channel_id);
        }


        if (!empty($list_channel_id)) {
            $this->db->order_by('a.create_date', 'desc');
            $this->db->where_in('a.channel_id', $list_channel_id);
            $this->db->select('a.*, b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name');
            $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id', 'left');
            $this->db->join('tbl_channel f', 'a.channel_id = f.id');
            $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
            $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
            $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
            $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
            $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
            $data_leads = $this->db->get('tbl_lead a')->result();
        } else {
            $data_leads = array();
        }


        return $data_leads;
    }

    public function getLeadByProjectExcel($get)
    {

        $campaign_id = $get['campaign_id'];
        $project_date = $get['from'];
        $now_date = $get['to'];
        $project_id = $get['id'];
        $sales_team_id = $get['sales_team_id'];
        $lead_category_id = $get['lead_category_id'];
        $status_id = $get['status_id'];
        $channel_id = $get['channel_id'];
        $sales_officer_id = $get['sales_officer_id'];

        $list_channel_id = array();

        $data_channel = $this->ChannelModels->getDataChannelbyProjectId($project_id);

        foreach ($data_channel as $dc) {
            array_push($list_channel_id, $dc->channel_id);
        }


        if (!empty($list_channel_id)) {
            $this->db->order_by('a.create_date', 'desc');
            $this->db->where_in('a.channel_id', $list_channel_id);
            $this->db->where('a.update_date >=', $project_date . ' 00:00:00');
            $this->db->where('a.update_date <=', $now_date . ' 23:59:59');

            if ($campaign_id != 0) {
                $this->db->where('e.id', $campaign_id);
            }

            if ($sales_team_id != 0) {
                $this->db->where('j.sales_team_id', $sales_team_id);
            }

            if ($lead_category_id != 0) {
                $this->db->where('a.lead_category_id', $lead_category_id);
            }

            if ($status_id != 0) {
                $this->db->where('a.status_id', $status_id);
            }

            if ($channel_id != 0) {
                $this->db->where('a.channel_id', $channel_id);
            }

            if ($sales_officer_id != 0) {
                $this->db->where('a.sales_officer_id', $sales_officer_id);
            }

            $this->db->select('a.*, b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name');
            $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id', 'left');
            $this->db->join('tbl_channel f', 'a.channel_id = f.id');
            $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
            $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
            $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
            $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
            $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
            $data_leads = $this->db->get('tbl_lead a')->result();
        } else {
            $data_leads = array();
        }


        return $data_leads;
    }

    public function getDataLeadByProjectTable($project_id, $session_filter, $session_search)
    {

        $campaign_id = $session_filter['campaign_id'];
        $project_date = $session_filter['from'];
        $now_date = $session_filter['to'];

        $sales_team_id = $session_search['sales_team_id'];
        $lead_category_id = $session_search['lead_category_id'];
        $status_id = $session_search['status_id'];
        $channel_id = $session_search['channel_id'];
        $sales_officer_id = $session_search['sales_officer_id'];
        $type_id = $session_search['type_id'];

        $list_channel_id = array();

        $data_channel = $this->ChannelModels->getDataChannelbyProjectId($project_id);

        foreach ($data_channel as $dc) {
            array_push($list_channel_id, $dc->channel_id);
        }


        if (!empty($list_channel_id)) {
            $this->db->order_by('a.create_date', 'desc');
            $this->db->where_in('a.channel_id', $list_channel_id);
            $this->db->where('a.create_date >=', $project_date . ' 00:00:00');
            $this->db->where('a.create_date <=', $now_date . ' 23:59:59');

            if ($campaign_id != 0) {
                $this->db->where('e.id', $campaign_id);
            }

            if ($sales_team_id != 0) {
                $this->db->where('j.sales_team_id', $sales_team_id);
            }

            if ($lead_category_id != 0) {
                $this->db->where('a.lead_category_id', $lead_category_id);
            }

            if ($status_id != 0) {
                $this->db->where('a.status_id', $status_id);
            }

            if ($channel_id != 0) {
                $this->db->where('a.channel_id', $channel_id);
            }

            if ($sales_officer_id != 0) {
                $this->db->where('a.sales_officer_id', $sales_officer_id);
            }

            if ($type_id != 0) {
                $this->db->where('l.media_category', $type_id);
            }

//            $this->db->where('a.lead_id', 20620);
            $this->db->group_by('a.lead_id');
            $this->db->select("a.lead_id, a.lead_name, a.lead_phone, a.lead_email, a.lead_address, a.note, "
                . "CONVERT_TZ(a.create_date, '+00:00', '+07:00') as create_date, "
                . "CONVERT_TZ(a.update_date, '+00:00', '+07:00') as update_date,  "
                . "b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, "
                . "g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name");
            $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
            $this->db->join('tbl_channel f', 'a.channel_id = f.id');
            $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
            $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
            $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
            $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
            $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
            $this->db->join('tbl_media l', 'l.id = f.channel_media', 'left');
            $data_leads = $this->db->get('tbl_lead a')->result();

            $list_lead_id = "";
            if (!empty($data_leads)) {
                foreach ($data_leads as $key => $dl) {
                    if ($key + 1 != count($data_leads)) {
                        $list_lead_id .= $dl->lead_id . ",";
                    } else {
                        $list_lead_id .= $dl->lead_id;
                    }
                }

//                print_r($list_lead_id);
                //get data history lead

                $sql = "SELECT lead_id, notes
                        FROM tbl_lead_history
                        WHERE lead_history_id IN (
                            SELECT MAX(lead_history_id)
                            FROM tbl_lead_history
                            WHERE lead_id IN ($list_lead_id)
                            GROUP BY lead_id
                        )";

                $data_hist = $this->db->query($sql);
                $data_history = $data_hist->result();

//                echo "<pre>";
//                print_r($data_history);
//                echo "</pre>";
//                exit;

                $list_history_lead = array();
                if (!empty($data_history)) {
                    foreach ($data_history as $dh) {
//                        array_push($list_history_lead, $dh->lead_id . '|' . $dh->notes);
                        $list_history_lead[$dh->lead_id] = $dh->notes;
//                        array_push($list_history_lead, $push[$dh->lead_id] );
                    }
                }

//                echo "<pre>";
//                print_r($list_history_lead);
//                echo "</pre>";
//                exit;  

                $data = array();
                foreach ($data_leads as $dleads) {
                    $row['lead_id'] = $dleads->lead_id;
                    $row['lead_name'] = $dleads->lead_name;
                    $row['lead_phone'] = $dleads->lead_phone;
                    $row['lead_email'] = $dleads->lead_email;
                    $row['note'] = $dleads->note;
                    $row['create_date'] = $dleads->create_date;
                    $row['update_date'] = $dleads->update_date;
                    $row['status_name'] = $dleads->status_name;
                    $row['sales_officer_name'] = $dleads->sales_officer_name;
                    $row['campaign_name'] = $dleads->campaign_name;
                    $row['channel_name'] = $dleads->channel_name;
                    $row['product_name'] = $dleads->product_name;
                    $row['kota_name'] = $dleads->kota_name;
                    $row['category_name'] = $dleads->category_name;
                    $row['color'] = $dleads->color;
                    $row['icon'] = $dleads->icon;
                    $row['sales_team_name'] = $dleads->sales_team_name;

                    if (isset($list_history_lead[$dleads->lead_id])) {
                        $row['last_history'] = $list_history_lead[$dleads->lead_id];
                    } else {
                        $row['last_history'] = "";
                    }

//                    foreach ($list_history_lead as $lh) {  
//                        $notes = explode('|', $lh);
//                        $lead_id = $notes[0];
//
//                        if ($lead_id == $dleads->lead_id) {
//                            $row['last_history'] = $notes[1];
//                        } 
//                    }

                    array_push($data, $row);
                }
            }

//            echo "<pre>";
//            print_r($data);
//            echo "</pre>";
//            exit;
        } else {
            $data = array();
        }

        return $data;
    }

    public function getDataLeadByProject($project_id, $session_filter, $session_search)
    {

        $campaign_id = $session_filter['campaign_id'];
        $project_date = $session_filter['from'];
        $now_date = $session_filter['to'];

        $sales_team_id = $session_search['sales_team_id'];
        $lead_category_id = $session_search['lead_category_id'];
        $status_id = $session_search['status_id'];
        $channel_id = $session_search['channel_id'];
        $sales_officer_id = $session_search['sales_officer_id'];

        $list_channel_id = array();

        $data_channel = $this->ChannelModels->getDataChannelbyProjectId($project_id);

        foreach ($data_channel as $dc) {
            array_push($list_channel_id, $dc->channel_id);
        }


        if (!empty($list_channel_id)) {
            $this->db->order_by('a.create_date', 'desc');
            $this->db->where_in('a.channel_id', $list_channel_id);
            $this->db->where('a.update_date >=', $project_date . ' 00:00:00');
            $this->db->where('a.update_date <=', $now_date . ' 23:59:59');

            if ($campaign_id != 0) {
                $this->db->where('e.id', $campaign_id);
            }

            if ($sales_team_id != 0) {
                $this->db->where('j.sales_team_id', $sales_team_id);
            }

            if ($lead_category_id != 0) {
                $this->db->where('a.lead_category_id', $lead_category_id);
            }

            if ($status_id != 0) {
                $this->db->where('a.status_id', $status_id);
            }

            if ($channel_id != 0) {
                $this->db->where('a.channel_id', $channel_id);
            }

            if ($sales_officer_id != 0) {
                $this->db->where('a.sales_officer_id', $sales_officer_id);
            }

            $this->db->select("a.lead_id, a.lead_name, a.lead_phone, a.lead_email, a.lead_address, a.note, "
                . "CONVERT_TZ(a.create_date, '+00:00', '+07:00') as create_date, "
                . "CONVERT_TZ(a.update_date, '+00:00', '+07:00') as update_date,  "
                . "b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, "
                . "g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name");
            $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id', 'left');
            $this->db->join('tbl_channel f', 'a.channel_id = f.id');
            $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
            $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
            $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id', 'left');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
            $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
            $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
            $data_leads = $this->db->get('tbl_lead a')->result();
        } else {
            $data_leads = array();
        }


        return $data_leads;
    }

    public function getDataCountLeadByProject($project_id, $session_filter)
    {

        $campaign_id = $session_filter['campaign_id'];
        $date = explode(' to ', $session_filter['date_range']);
        $project_date = $date[0];
        $now_date = $date[1];

        $list_channel_id = array();

        $data_channel = $this->ChannelModels->getDataChannelbyProjectId($project_id);

        foreach ($data_channel as $dc) {
            array_push($list_channel_id, $dc->channel_id);
        }

        $this->db->order_by('a.create_date', 'desc');
        $this->db->where_in('a.channel_id', $list_channel_id);
        $this->db->where('update_date >=', $project_date . ' 00:00:00');
        $this->db->where('update_date <=', $now_date . ' 23:59:59');

        $this->db->select('a.*, b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, g.product_name, h.kota_name, i.category_name');
        $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
        $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id', 'left');
        $this->db->join('tbl_channel f', 'a.channel_id = f.id');
        $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
        $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
        $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id');
        $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
        $data_leads = $this->db->get('tbl_lead a')->result();

        return $data_leads;
    }

    public function getDataLeadbyCampaignId($id)
    {

        $role = $this->MainModels->UserSession('role_id');
        $user_id = $this->MainModels->UserSession('user_id');
        $session_dashboard = $this->session->userdata('dashboard');

        $from = $session_dashboard['from'];
        $to = $session_dashboard['to'];

        $userIdRole = $this->MainModels->getIdbyUserIdRoleId($user_id, $role);

        $user_id_role = $userIdRole['id'];

        $list_channel = array();


        if ($role != 3) {
            $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $id))->result();
        } else {

            $list_sales_team_channel = array();
            $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel', array('sales_team_id' => $user_id_role))->result();

            if (!empty($data_sales_team_channel)) {
                foreach ($data_sales_team_channel as $dstc) {
                    array_push($list_sales_team_channel, $dstc->channel_id);
                }
            }

            $this->db->where_in('id', $list_sales_team_channel);
            $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $id))->result();
        }


        foreach ($data_channel as $channel) {
            array_push($list_channel, $channel->id);
        }

        if (!empty($list_channel)) {
            if ($role != 3) {
                $this->db->where_in('a.channel_id', $list_channel);
                $this->db->where('a.update_date >=', $from . ' 00:00:00');
                $this->db->where('a.update_date <=', $to . ' 23:59:59');
                $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                $data_lead = $this->db->get('tbl_lead a')->result();
            } else {
                $list_sales_officer_id = array();
                $data_sales_officer = $this->TeamModels->getDataSalesOfficerBySalesTeamId($user_id_role);

                if (!empty($data_sales_officer)) {
                    foreach ($data_sales_officer as $dso) {
                        array_push($list_sales_officer_id, $dso->sales_officer_id);
                    }

                    $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                }
//                $this->db->where_in('a.channel_id', $list_channel);
//                $this->db->where('a.update_date >=', $from . ' 00:00:00');
//                $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
//                $this->db->where('a.update_date <=', $to . ' 23:59:59');
//                $data_lead = $this->db->get('tbl_lead a')->result();


                $this->db->where_in('a.channel_id', $list_channel);
                $this->db->where('a.update_date >=', $from . ' 00:00:00');
                $this->db->where('a.update_date <=', $to . ' 23:59:59');
                $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                $data_lead = $this->db->get('tbl_lead a')->row();
            }
        } else {
            $data_lead = array();
        }


        return $data_lead;
    }

    public function getLeadByChannelId($channel_id)
    {

        $role = $this->MainModels->UserSession('role_id');
        $user_id = $this->MainModels->UserSession('user_id');

        $userIdRole = $this->MainModels->getIdbyUserIdRoleId($user_id, $role);
        $user_id_role = $userIdRole['id'];

        if ($role == 3) {
            $list_sales_officer_id = array();
            $data_sales_officer = $this->TeamModels->getDataSalesOfficerBySalesTeamId($user_id_role);

            if (!empty($data_sales_officer)) {
                foreach ($data_sales_officer as $dso) {
                    array_push($list_sales_officer_id, $dso->sales_officer_id);
                }

                $this->db->where_in('sales_officer_id', $list_sales_officer_id);
            }
        }
        $data_lead = $this->db->get_where('tbl_lead', array('channel_id' => $channel_id))->result();
        return $data_lead;
    }

    public function getDataLeadByCategorybyProjectId($projectId)
    {

        $session_filter = $this->session->userdata('filter');
        $session_search = $this->session->userdata('search');

        $campaign_id = $session_filter['campaign_id'];

        $project_date = $session_filter['from'];
        $now_date = $session_filter['to'];

        $sales_team_id = $session_search['sales_team_id'];
        $lead_category_id = $session_search['lead_category_id'];
        $status_id = $session_search['status_id'];
        $channel_id = $session_search['channel_id'];
        $sales_officer_id = $session_search['sales_officer_id'];


        $jum = count($this->getDataLeadByProject($projectId, $session_filter, $session_search));

        $list_channel_id = array();

        if ($campaign_id != 0) {
            $data_channel = $this->ChannelModels->getDataChannelbyCampagnId($campaign_id);
        } else {
            $data_channel = $this->ChannelModels->getDataChannelbyProjectId($projectId);
        }


        foreach ($data_channel as $dc) {
            array_push($list_channel_id, $dc->channel_id);
        }

        if (!empty($list_channel_id)) {
            if ($lead_category_id != 0) {
                $this->db->where('lead_category_id', $lead_category_id);
            }
            $this->db->order_by('urutan', 'asc');
            $data_category = $this->db->get('tbl_lead_category')->result();

            $data_chart = array();

            foreach ($data_category as $dct) {

                if ($sales_team_id != 0) {
                    $this->db->where('b.sales_team_id', $sales_team_id);
                    $this->db->join('tbl_sales_officer_group b', 'a.sales_officer_id = b.sales_officer_id');
                }

                if ($channel_id != 0) {
                    $this->db->where('a.channel_id', $channel_id);
                } else {
                    $this->db->where_in('a.channel_id', $list_channel_id);
                }

                if ($sales_officer_id != 0) {
                    $this->db->where('a.sales_officer_id', $sales_officer_id);
                }

                if ($status_id != 0) {
                    $this->db->where('status_id', $status_id);
                }

                $this->db->where('a.lead_category_id', $dct->lead_category_id);
                $this->db->where('a.update_date >=', $project_date . ' 00:00:00');
                $this->db->where('a.update_date <=', $now_date . ' 23:59:59');
                $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                $this->db->select('count(a.lead_id) as total');
                $data_lead_by_category = $this->db->get('tbl_lead a')->row();

                if ($jum != 0) {
                    $percent = round(intval($data_lead_by_category->total / intval($jum) * 100), 2);
                } else {
                    $percent = 0;
                }

                $data = array(
                    'category_name' => $dct->category_name,
                    'total' => $data_lead_by_category->total,
                    'percent' => $percent,
                    'icon' => $dct->icon,
                    'color' => $dct->color,
                    'bg' => $dct->background_color
                );

                array_push($data_chart, $data);
            }
        } else {
            $data_chart = array();
            $data = array();
            array_push($data_chart, $data);
        }

        return $data_chart;
    }

    public function getDataLeadByChannelbyProjectIdSalesTeamId($projectId, $sales_team_id)
    {

        $session_filter = $this->session->userdata('filter');
        $session_search = $this->session->userdata('search');

        $role = $this->MainModels->UserSession('role_id');
        $user_id = $this->MainModels->UserSession('user_id');

        $userIdRole = $this->MainModels->getIdbyUserIdRoleId($user_id, $role);

        $user_id_role = $userIdRole['id'];

        $campaign_id = $session_filter['campaign_id'];
        $date = explode(' to ', $session_filter['date_range']);
        $project_date = $date[0];
        $now_date = $date[1];

        $jum = count($this->getDataLeadByProject($projectId, $session_filter, $session_search));

        $data_chart = array();

        if ($campaign_id != 0) {
            $data_channel = $this->ChannelModels->getDataChannelbyCampagnId($campaign_id);
        } else {
            $data_channel = $this->ChannelModels->getDataChannelbySalesTeamId($sales_team_id);
        }

        $lead_category_id = $session_search['lead_category_id'];
        $status_id = $session_search['status_id'];
        $channel_id = $session_search['channel_id'];
        $sales_officer_id = $session_search['sales_officer_id'];

        foreach ($data_channel as $dch) {

            $list_sales_officer_id = array();
            $data_sales_officer = $this->TeamModels->getDataSalesOfficerBySalesTeamId($user_id_role);

            if (!empty($data_sales_officer)) {
                foreach ($data_sales_officer as $dso) {
                    array_push($list_sales_officer_id, $dso->sales_officer_id);
                }

                $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
            }

            $this->db->where_in('a.channel_id', $dch->channel_id);

            if ($lead_category_id != 0) {
                $this->db->where('a.lead_category_id', $lead_category_id);
            }

            if ($status_id != 0) {
                $this->db->where('a.status_id', $status_id);
            }
            if ($channel_id != 0) {
                $this->db->where('a.channel_id', $channel_id);
            }

            if ($sales_officer_id != 0) {
                $this->db->where('a.sales_officer_id', $sales_officer_id);
            }

            $this->db->where('a.create_date >=', $project_date . ' 00:00:00');
            $this->db->where('a.create_date <=', $now_date . ' 23:59:59');
            $this->db->select('count(a.lead_id) as total');
            $data_lead_by_channel = $this->db->get('tbl_lead a')->row();

            if ($jum != 0) {
                $percent = round(intval($data_lead_by_channel->total / intval($jum) * 100), 2);
            } else {
                $percent = 0;
            }

            $data = array(
                'channel_id' => $dch->channel_id,
                'channel_name' => $dch->channel_name,
                'total' => $data_lead_by_channel->total,
                'percent' => $percent
            );

            array_push($data_chart, $data);
        }

        return $data_chart;
    }

    public function getDataLeadByChannelbyProjectIdNonSession($projectId)
    {

        $session_dashboard = $this->session->userdata('dashboard');

        $from = $session_dashboard['from'];
        $to = $session_dashboard['to'];

        $jum = count($this->getDataLeadByProjectNonSession($projectId));

        $data_chart = array();

        $data_channel = $this->ChannelModels->getDataChannelbyProjectId($projectId);

        foreach ($data_channel as $dch) {
            $this->db->where_in('a.channel_id', $dch->channel_id);

            $this->db->select('count(a.lead_id) as total');
            $this->db->where('a.update_date >=', $from . ' 00:00:00');
            $this->db->where('a.update_date <=', $to . ' 23:59:59');
            $data_lead_by_channel = $this->db->get('tbl_lead a')->row();

            if ($jum != 0) {
                $percent = round(intval($data_lead_by_channel->total / intval($jum) * 100), 2);
            } else {
                $percent = 0;
            }

            $data = array(
                'channel_name' => $dch->channel_name,
                'channel_id' => $dch->channel_id,
                'total' => $data_lead_by_channel->total,
                'percent' => $percent
            );

            array_push($data_chart, $data);
        }

        return $data_chart;
    }

    public function getDataLeadByChannelbyProjectId($projectId)
    {

        $session_filter = $this->session->userdata('filter');
        $session_search = $this->session->userdata('search');

        $campaign_id = $session_filter['campaign_id'];
        $project_date = $session_filter['from'];
        $now_date = $session_filter['to'];

        $sales_team_id = $session_search['sales_team_id'];
        $lead_category_id = $session_search['lead_category_id'];
        $status_id = $session_search['status_id'];
        $channel_id = $session_search['channel_id'];
        $sales_officer_id = $session_search['sales_officer_id'];

        $jum = count($this->getDataLeadByProject($projectId, $session_filter, $session_search));

        $data_chart = array();

        if ($campaign_id != 0) {
            $data_channel = $this->ChannelModels->getDataChannelbyCampagnId($campaign_id);
        } else {
            $data_channel = $this->ChannelModels->getDataChannelbyProjectId($projectId);
        }

        foreach ($data_channel as $dch) {
            $this->db->where_in('a.channel_id', $dch->channel_id);

            if ($sales_team_id != 0) {
                $this->db->where('b.sales_team_id', $sales_team_id);
                $this->db->join('tbl_sales_officer_group b', 'a.sales_officer_id = b.sales_officer_id');
            }

            if ($lead_category_id != 0) {
                $this->db->where('a.lead_category_id', $lead_category_id);
            }

            if ($status_id != 0) {
                $this->db->where('a.status_id', $status_id);
            }
            if ($channel_id != 0) {
                $this->db->where('a.channel_id', $channel_id);
            }

            if ($sales_officer_id != 0) {
                $this->db->where('a.sales_officer_id', $sales_officer_id);
            }
            $this->db->where('a.update_date >=', $project_date . ' 00:00:00');
            $this->db->where('a.update_date <=', $now_date . ' 23:59:59');
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
                'channel_id' => $dch->channel_id,
                'total' => $data_lead_by_channel->total,
                'percent' => $percent
            );

            array_push($data_chart, $data);
        }

        return $data_chart;
    }

    public function getDataLeadByChannelbyProjectIdChart($projectId, $page)
    {

        $session_filter = $this->session->userdata('filter');
        $session_search = $this->session->userdata('search');

        $campaign_id = $session_filter['campaign_id'];
        $project_date = $session_filter['from'];
        $now_date = $session_filter['to'];

        $sales_team_id = $session_search['sales_team_id'];
        $lead_category_id = $session_search['lead_category_id'];
        $status_id = $session_search['status_id'];
        $channel_id = $session_search['channel_id'];
        $sales_officer_id = $session_search['sales_officer_id'];

        $jum = count($this->getDataLeadByProject($projectId, $session_filter, $session_search));

        $data_chart = array();

        if ($campaign_id != 0) {
            $data_channel = $this->ChannelModels->getDataChannelbyCampagnIdChart($campaign_id, $page);
        } else {
            $data_channel = $this->ChannelModels->getDataChannelbyProjectIdChart($projectId, $page);
        }

        foreach ($data_channel as $dch) {
            $this->db->where_in('a.channel_id', $dch->channel_id);

            if ($sales_team_id != 0) {
                $this->db->where('b.sales_team_id', $sales_team_id);
                $this->db->join('tbl_sales_officer_group b', 'a.sales_officer_id = b.sales_officer_id');
            }

            if ($lead_category_id != 0) {
                $this->db->where('a.lead_category_id', $lead_category_id);
            }

            if ($status_id != 0) {
                $this->db->where('a.status_id', $status_id);
            }
            if ($channel_id != 0) {
                $this->db->where('a.channel_id', $channel_id);
            }

            if ($sales_officer_id != 0) {
                $this->db->where('a.sales_officer_id', $sales_officer_id);
            }
            $this->db->where('a.update_date >=', $project_date . ' 00:00:00');
            $this->db->where('a.update_date <=', $now_date . ' 23:59:59');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
            $this->db->join('tbl_lead_category e', 'a.lead_category_id = e.lead_category_id');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
            $this->db->select('count(a.lead_id) as total');
            $data_lead_by_channel = $this->db->get('tbl_lead a')->row();

            if ($jum != 0) {
                $percent = round(intval($data_lead_by_channel->total / intval($jum) * 100), 2);
            } else {
                $percent = 0;
            }

            $data = array(
                'channel_name' => $dch->channel_name,
                'channel_id' => $dch->channel_id,
                'total' => $data_lead_by_channel->total,
                'percent' => $percent
            );

            array_push($data_chart, $data);
        }

        return $data_chart;
    }

    public function getDataLeadByCampaignbyProjectId($projectId)
    {
        $session_filter = $this->session->userdata('filter');
        $session_search = $this->session->userdata('search');

        $role = $this->MainModels->UserSession('role_id');
        $user_id = $this->MainModels->UserSession('user_id');

        $userIdRole = $this->MainModels->getIdbyUserIdRoleId($user_id, $role);

        $user_id_role = $userIdRole['id'];

        $campaign_id = $session_filter['campaign_id'];
        $project_date = $session_filter['from'];
        $now_date = $session_filter['to'];

        $jum = count($this->getDataLeadByProject($projectId, $session_filter, $session_search));

        $data_chart = array();

        if ($campaign_id != 0) {
            $data_campaign = $this->db->get_where('tbl_campaign', array('id' => $campaign_id))->result();
        } else {
            $data_campaign = $this->db->get_where('tbl_campaign', array('project_id' => $projectId))->result();
        }

        foreach ($data_campaign as $dcc) {

            $list_channel_id = array();

            //get data channel
            $data_channel = $this->ChannelModels->getDataChannelbyCampagnId($dcc->id);

            foreach ($data_channel as $dch) {
                array_push($list_channel_id, $dch->channel_id);
            }

            if (!empty($list_channel_id)) {

                if ($role == 3) {
                    $list_sales_officer_id = array();
                    $data_sales_officer = $this->TeamModels->getDataSalesOfficerBySalesTeamId($user_id_role);

                    if (!empty($data_sales_officer)) {
                        foreach ($data_sales_officer as $dso) {
                            array_push($list_sales_officer_id, $dso->sales_officer_id);
                        }

                        $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                    }
                }

                $this->db->where_in('a.channel_id', $list_channel_id);
                $this->db->where('a.update_date >=', $project_date . ' 00:00:00');
                $this->db->where('a.update_date <=', $now_date . ' 23:59:59');
                $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
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
                    'percent' => $percent,
                    'campaign_id' => $dcc->id
                );
            } else {

                $data = array(
                    'campaign_name' => $dcc->campaign_name,
                    'total' => 0,
                    'percent' => 0,
                    'campaign_id' => $dcc->id
                );
            }

            array_push($data_chart, $data);
        }

        return $data_chart;
    }

    public function getDataLeadByCampaignbyProjectIdNonSession($projectId)
    {
        $role = $this->MainModels->UserSession('role_id');
        $user_id = $this->MainModels->UserSession('user_id');
        $session_dashboard = $this->session->userdata('dashboard');

        $from = $session_dashboard['from'];
        $to = $session_dashboard['to'];

        $userIdRole = $this->MainModels->getIdbyUserIdRoleId($user_id, $role);

        $user_id_role = $userIdRole['id'];

        $jum = count($this->getDataLeadByProjectNonSession($projectId));

        $data_chart = array();

        $data_campaign = $this->db->get_where('tbl_campaign', array('project_id' => $projectId))->result();

        foreach ($data_campaign as $dcc) {

            $list_channel_id = array();

            //get data channel
            $data_channel = $this->ChannelModels->getDataChannelbyCampagnId($dcc->id);

            foreach ($data_channel as $dch) {
                array_push($list_channel_id, $dch->channel_id);
            }

            if (!empty($list_channel_id)) {

                if ($role == 3) {
                    $list_sales_officer_id = array();
                    $data_sales_officer = $this->TeamModels->getDataSalesOfficerBySalesTeamId($user_id_role);

                    if (!empty($data_sales_officer)) {
                        foreach ($data_sales_officer as $dso) {
                            array_push($list_sales_officer_id, $dso->sales_officer_id);
                        }

                        $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                    }
                }

                $this->db->where_in('a.channel_id', $list_channel_id);
                $this->db->where('a.update_date >=', $from . ' 00:00:00');
                $this->db->where('a.update_date <=', $to . ' 23:59:59');
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
                    'percent' => $percent,
                    'campaign_id' => $dcc->id
                );
            } else {

                $data = array(
                    'campaign_name' => $dcc->campaign_name,
                    'total' => 0,
                    'percent' => 0,
                    'campaign_id' => $dcc->id
                );
            }

            array_push($data_chart, $data);
        }

        return $data_chart;
    }

    public function getDataLeadBySalesTeam($list_sales_team_id)
    {

        $list_sales_officer = array();
        $data = array();

        $this->db->where_in('sales_team_id', $list_sales_team_id);
        $data_sales_team = $this->db->get('tbl_sales_team')->result();

        if (!empty($data_sales_team)) {

            foreach ($data_sales_team as $dst) {

                $list_sales_officer_id = array();

                $data_sales_offcier_group = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $dst->sales_team_id))->result();

                foreach ($data_sales_offcier_group as $dsog) {
                    array_push($list_sales_officer_id, $dsog->sales_officer_id);
                }

                if (!empty($list_sales_officer_id)) {
                    $this->db->where_in('sales_officer_id', $list_sales_officer_id);
                    $this->db->select('count(lead_id) as total');
                    $count_lead = $this->db->get('tbl_lead')->row('total');
                } else {
                    $count_lead = 0;
                }

                $data_lead_total = $this->getCountLeadbyClientId();

                if (!empty($data_lead_total)) {
                    $jum = count($data_lead_total);

                    if (!empty($count_lead)) {
                        $percent = round(intval($count_lead / intval($jum) * 100), 2);

                        $data_push = array('total' => $count_lead, 'percent' => $percent, 'sales_team_name' => $dst->sales_team_name, 'sales_team_id' => $dst->sales_team_id);
                        array_push($data, $data_push);
                    }
                } else {
                    $jum = 0;
                    $data = array();
                }
            }
        } else {
            $data = array();
        }

        return $data;
    }

    public function getDataLeadBySalesTeamIdCategory($sales_team_id)
    {

        $list_sales_officer = array();
        $data = array();

        $this->db->order_by('urutan', 'asc');
        $data_category = $this->db->get('tbl_lead_category')->result();

        $list_sales_officer_id = array();

        $data_sales_offcier_group = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $sales_team_id))->result();

        foreach ($data_sales_offcier_group as $dsog) {
            array_push($list_sales_officer_id, $dsog->sales_officer_id);
        }

        if (!empty($list_sales_officer_id)) {
            $this->db->where_in('sales_officer_id', $list_sales_officer_id);
            $this->db->select('count(lead_id) as total');
            $data_lead_total = $this->db->get('tbl_lead')->row('total');
        } else {
            $data_lead_total = 0;
        }

        if (!empty($data_category)) {

            foreach ($data_category as $dc) {
                $list_sales_officer_id = array();

                $data_sales_offcier_group = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $sales_team_id))->result();

                foreach ($data_sales_offcier_group as $dsog) {
                    array_push($list_sales_officer_id, $dsog->sales_officer_id);
                }

                if (!empty($list_sales_officer_id)) {
                    $this->db->where('lead_category_id', $dc->lead_category_id);
                    $this->db->where_in('sales_officer_id', $list_sales_officer_id);
                    $this->db->select('count(lead_id) as total');
                    $count_lead = $this->db->get('tbl_lead')->row('total');
                } else {
                    $count_lead = 0;
                }

                if (!empty($data_lead_total)) {

                    if (!empty($count_lead)) {
                        $percent = round(intval($count_lead / intval($data_lead_total) * 100), 2);

                        $data_push = array('total' => $count_lead, 'percent' => $percent, 'category_name' => $dc->category_name, 'color' => $dc->color);
                        array_push($data, $data_push);
                    }
                } else {
                    $jum = 0;
                    $data = array();
                }
            }
        }

        return $data;
    }

    public function getDataLeadBySalesOfficerIdCategory($sales_officer_id)
    {

        $data = array();


        $data_category = $this->db->get('tbl_lead_category')->result();

        $this->db->where('sales_officer_id', $sales_officer_id);
        $this->db->select('count(lead_id) as total');
        $data_lead_total = $this->db->get('tbl_lead')->row('total');

        if (!empty($data_category)) {

            foreach ($data_category as $dc) {
                $this->db->where('lead_category_id', $dc->lead_category_id);
                $this->db->where('sales_officer_id', $sales_officer_id);
                $this->db->select('count(lead_id) as total');
                $count_lead = $this->db->get('tbl_lead')->row('total');

                if (!empty($count_lead)) {
                    $percent = round(intval($count_lead / intval($data_lead_total) * 100), 2);

                    $data_push = array('total' => $count_lead, 'percent' => $percent, 'category_name' => $dc->category_name, 'color' => $dc->color);
                    array_push($data, $data_push);
                }
            }
        }

        return $data;
    }

    public function getDataLeadByCampaignIdCategory($campaign_id)
    {

        $data = array();

        $role = $this->MainModels->UserSession('role_id');
        $user_id = $this->MainModels->UserSession('user_id');

        $userIdRole = $this->MainModels->getIdbyUserIdRoleId($user_id, $role);

        $user_id_role = $userIdRole['id'];

        $this->db->order_by('urutan', 'asc');
        $data_category = $this->db->get('tbl_lead_category')->result();

        $list_channel_id = array();

        $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $campaign_id))->result();

        foreach ($data_channel as $dch) {
            array_push($list_channel_id, $dch->id);
        }

        if (!empty($list_channel_id)) {
            if ($role == 3) {
                $list_sales_officer_id = array();
                $data_sales_officer = $this->TeamModels->getDataSalesOfficerBySalesTeamId($user_id_role);

                if (!empty($data_sales_officer)) {
                    foreach ($data_sales_officer as $dso) {
                        array_push($list_sales_officer_id, $dso->sales_officer_id);
                    }

                    $this->db->where_in('sales_officer_id', $list_sales_officer_id);
                }
            }
            $this->db->where_in('channel_id', $list_channel_id);
            $this->db->select('count(lead_id) as total');
            $data_lead_total = $this->db->get('tbl_lead')->row('total');
        } else {
            $data_lead_total = 0;
        }

        if (!empty($data_category)) {

            foreach ($data_category as $dc) {
                if (!empty($list_channel_id)) {
                    if ($role == 3) {
                        $list_sales_officer_id = array();
                        $data_sales_officer = $this->TeamModels->getDataSalesOfficerBySalesTeamId($user_id_role);

                        if (!empty($data_sales_officer)) {
                            foreach ($data_sales_officer as $dso) {
                                array_push($list_sales_officer_id, $dso->sales_officer_id);
                            }

                            $this->db->where_in('sales_officer_id', $list_sales_officer_id);
                        }
                    }
                    $this->db->where('lead_category_id', $dc->lead_category_id);
                    $this->db->where_in('channel_id', $list_channel_id);
                    $this->db->select('count(lead_id) as total');
                    $count_lead = $this->db->get('tbl_lead')->row('total');
                } else {
                    $count_lead = 0;
                }

                if (!empty($data_lead_total)) {

                    if (!empty($count_lead)) {
                        $percent = round(intval($count_lead / intval($data_lead_total) * 100), 2);

                        $data_push = array('total' => $count_lead, 'percent' => $percent, 'category_name' => $dc->category_name, 'color' => $dc->color, 'bg_color' => $dc->background_color);
                        array_push($data, $data_push);
                    }
                } else {
                    $jum = 0;
                    $data = array();
                }
            }
        }

        return $data;
    }

    public function getDataLeadByChannelIdCategory($channel_id)
    {

        $data = array();

        $role = $this->MainModels->UserSession('role_id');
        $user_id = $this->MainModels->UserSession('user_id');

        $userIdRole = $this->MainModels->getIdbyUserIdRoleId($user_id, $role);

        $user_id_role = $userIdRole['id'];

        $this->db->order_by('urutan', 'asc');
        $data_category = $this->db->get('tbl_lead_category')->result();

        if ($role == 3) {
            $list_sales_officer_id = array();
            $data_sales_officer = $this->TeamModels->getDataSalesOfficerBySalesTeamId($user_id_role);

            if (!empty($data_sales_officer)) {
                foreach ($data_sales_officer as $dso) {
                    array_push($list_sales_officer_id, $dso->sales_officer_id);
                }

                $this->db->where_in('sales_officer_id', $list_sales_officer_id);
            }
        }
        $this->db->where('channel_id', $channel_id);
        $this->db->select('count(lead_id) as total');
        $data_lead_total = $this->db->get('tbl_lead')->row('total');

        if (!empty($data_category)) {

            foreach ($data_category as $dc) {

                if ($role == 3) {
                    $list_sales_officer_id = array();
                    $data_sales_officer = $this->TeamModels->getDataSalesOfficerBySalesTeamId($user_id_role);

                    if (!empty($data_sales_officer)) {
                        foreach ($data_sales_officer as $dso) {
                            array_push($list_sales_officer_id, $dso->sales_officer_id);
                        }

                        $this->db->where_in('sales_officer_id', $list_sales_officer_id);
                    }
                }

                $this->db->where('lead_category_id', $dc->lead_category_id);
                $this->db->where('channel_id', $channel_id);
                $this->db->select('count(lead_id) as total');
                $count_lead = $this->db->get('tbl_lead')->row('total');

                if (!empty($data_lead_total)) {

                    if (!empty($count_lead)) {
                        $percent = round(intval($count_lead / intval($data_lead_total) * 100), 2);

                        $data_push = array('total' => $count_lead, 'percent' => $percent, 'color' => $dc->color, 'category_name' => $dc->category_name);
                        array_push($data, $data_push);
                    }
                } else {
                    $jum = 0;
                    $data = array();
                }
            }
        }

        return $data;
    }

    public function getDataLeadBySalesTeamId($sales_team_id)
    {

        $list_sales_officer = array();
        $data = array();

        $this->db->where('sales_team_id', $sales_team_id);
        $data_sales_team = $this->db->get('tbl_sales_team')->row();


        if (!empty($data_sales_team)) {

            $list_sales_officer_id = array();

            $data_sales_offcier_group = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $data_sales_team->sales_team_id))->result();

            foreach ($data_sales_offcier_group as $dsog) {
                array_push($list_sales_officer_id, $dsog->sales_officer_id);
            }


            if (!empty($list_sales_officer_id)) {
                $this->db->where_in('sales_officer_id', $list_sales_officer_id);
                $this->db->select('count(lead_id) as total');
                $count_lead = $this->db->get('tbl_lead')->row('total');
            } else {
                $count_lead = 0;
            }

            $data_lead_total = $this->getCountLeadbyClientId();

            if (!empty($data_lead_total)) {
                $jum = count($data_lead_total);

                if (!empty($count_lead)) {
                    $percent = round(intval($count_lead / intval($jum) * 100), 2);

                    $data_push = array('total' => $count_lead, 'percent' => $percent, 'sales_team_name' => $data_sales_team->sales_team_name);
                    array_push($data, $data_push);
                }
            } else {
                $jum = 0;
                $data_push = array('total' => $count_lead, 'percent' => '0%', 'sales_team_name' => $data_sales_team->sales_team_name);

                array_push($data, $data_push);
            }
        } else {
            $data = array();
        }

        return $data;
    }

    public function getDataLeadBySalesOfficer($list_sales_officer_id)
    {

        if (!empty($list_sales_officer_id)) {

            $this->db->limit(5);
            $this->db->order_by('point', 'desc');
            $this->db->where_in('sales_officer_id', $list_sales_officer_id);
            $data_sales_officer = $this->db->get('tbl_sales_officer')->result();

            $data = array();

            foreach ($data_sales_officer as $dso) {
                $this->db->where('sales_officer_id', $dso->sales_officer_id);
                $this->db->select('count(lead_id) as total');
                $count_lead = $this->db->get('tbl_lead')->row('total');

                $data_lead_total = $this->getCountLeadbyClientId();

                if (!empty($data_lead_total)) {
                    $jum = count($data_lead_total);

                    if (!empty($count_lead)) {
                        $percent = round(intval($count_lead / intval($jum) * 100), 2);

                        $data_push = array('total' => $count_lead, 'percent' => $percent, 'sales_officer_name' => $dso->sales_officer_name, 'sales_officer_id' => $dso->sales_officer_id);
                        array_push($data, $data_push);
                    }
                } else {
                    $jum = 0;
                    $data = array();
                }
            }
        } else {
            $data = array();
        }


        return $data;
    }

    public function getDataLeadBySalesOfficerNonSession($list_sales_officer_id)
    {

        if (!empty($list_sales_officer_id)) {

            $this->db->limit(5);
            $this->db->order_by('point', 'desc');
            $this->db->where_in('sales_officer_id', $list_sales_officer_id);
            $data_sales_officer = $this->db->get('tbl_sales_officer')->result();

            $data = array();

            foreach ($data_sales_officer as $dso) {
                $this->db->where('sales_officer_id', $dso->sales_officer_id);
                $this->db->select('count(lead_id) as total');
                $count_lead = $this->db->get('tbl_lead')->row('total');

                $data_lead_total = $this->getCountLeadbyClientIdNonSession();


                if (!empty($data_lead_total)) {
                    $jum = count($data_lead_total);

                    if (!empty($count_lead)) {
                        $percent = round(intval($count_lead / intval($jum) * 100), 2);

                        $data_push = array('total' => $count_lead, 'percent' => $percent, 'sales_officer_name' => $dso->sales_officer_name);
                        array_push($data, $data_push);
                    }
                } else {
                    $jum = 0;
                    $data = array();
                }
            }
        } else {
            $data = array();
        }


        return $data;
    }

    public function getDataChartTotalLead($project_id, $from_date, $to_date, $category_id_1, $category_id_2, $time_period)
    {

        $role = $this->MainModels->UserSession('role_id');
        $user_id = $this->MainModels->UserSession('user_id');

        $userIdRole = $this->MainModels->getIdbyUserIdRoleId($user_id, $role);

        $user_id_role = $userIdRole['id'];

        $category = array();

        array_push($category, $category_id_1);
        array_push($category, $category_id_2);

        $xAxis = array();
        $serries = array();
        $total = array();

        if ($time_period == 'MONTH') {
            $time = "DATE_FORMAT(a.update_date,'%m-%Y')";
            $time_select = "DATE_FORMAT(a.update_date,'%M-%Y')";
        } else if ($time_period == 'DAY') {
            $time = "date(a.update_date)";
            $time_select = "DATE_FORMAT(a.update_date,'%d-%M')";
        } else {
            $time = 'YEAR(update_date)';
            $time_select = "YEAR(a.update_date)";
        }

        if ($project_id == 0) {
            if ($role == 3) {
                $data_channel = $this->ChannelModels->getDataChannelStatisticsbySalesTeamId($this->MainModels->getSalesTeamId());
            } else {
                $data_channel = $this->ChannelModels->getDataChannelbyClientId();
            }
        } else {
            $data_channel = $this->ChannelModels->getDataChannelbyProjectId2($project_id);
        }

        $list_channel_id = array();

        foreach ($data_channel as $dch) {
            array_push($list_channel_id, $dch->id);
        }

        if (!empty($list_channel_id)) {

            foreach ($category as $ct) {

                if ($ct != 0) {
                    $category_name = $this->db->get_where('tbl_lead_category', array('lead_category_id' => $ct))->row('category_name');
                } else {
                    $category_name = 'All';
                }


                $data_crot = array(
                    'name' => $category_name,
                    'data' => array()
                );

                if ($role == 3) {
                    $list_sales_officer_id = array();
                    $data_sales_officer = $this->TeamModels->getDataSalesOfficerBySalesTeamId($user_id_role);

                    if (!empty($data_sales_officer)) {
                        foreach ($data_sales_officer as $dso) {
                            array_push($list_sales_officer_id, $dso->sales_officer_id);
                        }

                        $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                    }
                }

                $this->db->where_in('a.channel_id', $list_channel_id);
                if ($ct != 0) {
                    $this->db->where('a.lead_category_id', $ct);
                }
                $this->db->select("$time_select as name, count(lead_id) as value");
                $this->db->group_by("$time");

                if ($from_date != '') {
                    if ($category_name == 'All') {
                        $this->db->where('a.update_date >', $from_date . ' 00:00:00');
                        $this->db->where('a.update_date <', $to_date . ' 23:59:59');
                        $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                    } else {
                        $this->db->where('a.update_date >', $from_date . ' 00:00:00');
                        $this->db->where('a.update_date <', $to_date . ' 23:59:59');
                        $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                    }
                }
                $data = $this->db->get('tbl_lead a')->result();

                if ($role == 3) {
                    $list_sales_officer_id = array();
                    $data_sales_officer = $this->TeamModels->getDataSalesOfficerBySalesTeamId($user_id_role);

                    if (!empty($data_sales_officer)) {
                        foreach ($data_sales_officer as $dso) {
                            array_push($list_sales_officer_id, $dso->sales_officer_id);
                        }

                        $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                    }
                }
                $this->db->where_in('a.channel_id', $list_channel_id);
                if ($ct != 0) {
                    $this->db->where('a.lead_category_id', $ct);
                }
                if ($from_date != '') {
                    if ($category_name == 'All') {
                        $this->db->where('a.update_date >', $from_date . ' 00:00:00');
                        $this->db->where('a.update_date <', $to_date . ' 23:59:59');
                        $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                    } else {
                        $this->db->where('a.update_date >', $from_date . ' 00:00:00');
                        $this->db->where('a.update_date <', $to_date . ' 23:59:59');
                        $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                    }
                }
                $jumlah = $this->db->get('tbl_lead a')->result();
                $jum = array('status' => ' ' . $category_name . ' :', 'jumlah' => count($jumlah));

                array_push($total, $jum);

                foreach ($data as $key => $value_data) {
                    array_push($data_crot['data'], intval($value_data->value));
                    array_push($xAxis, $value_data->name);
                }

                array_push($serries, $data_crot);
            }
        }


        $data_return = array(
            'categories' => $xAxis,
            'series' => $serries,
            'total' => $total
        );

        return $data_return;
    }

    public function getLeadDashboard($project_id, $from_date, $to_date)
    {

        $list_channel_id = array();

        if ($project_id == 0) {
            $data_channel = $this->ChannelModels->getDataChannelbyClientId();
        } else {
            $data_channel = $this->ChannelModels->getDataChannelbyProjectId2($project_id);
        }

        foreach ($data_channel as $dc) {
            array_push($list_channel_id, $dc->id);
        }

        if (!empty($list_channel_id)) {
            $this->db->order_by('a.create_date', 'desc');
            $this->db->where_in('a.channel_id', $list_channel_id);
            $this->db->where('a.update_date >=', $from_date . ' 00:00:00');
            $this->db->where('a.update_date <=', $to_date . ' 23:59:59');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
            $data_leads = $this->db->get('tbl_lead a')->result();
        } else {
            $data_leads = array();
        }

        return $data_leads;
    }

    public function getDataLeadByCategoryDashboard($session_dashboard)
    {

        $project_id = $session_dashboard['project_id'];
        $from_date = $session_dashboard['from'];
        $to_date = $session_dashboard['to'];
        $this->db->order_by('urutan', 'asc');
        $data_category = $this->db->get('tbl_lead_category')->result();

        $jum = count($this->getLeadDashboard($project_id, $from_date, $to_date));

        $list_channel_id = array();

        if ($project_id == 0) {
            $data_channel = $this->ChannelModels->getDataChannelbyClientId();
        } else {
            $data_channel = $this->ChannelModels->getDataChannelbyProjectId2($project_id);
        }

        foreach ($data_channel as $dc) {
            array_push($list_channel_id, $dc->id);
        }

        if (!empty($list_channel_id)) {

            $data_chart = array();

            foreach ($data_category as $dct) {
                $this->db->where_in('a.channel_id', $list_channel_id);
                $this->db->where('a.lead_category_id', $dct->lead_category_id);
                $this->db->where('a.update_date >=', $from_date . ' 00:00:00');
                $this->db->where('a.update_date <=', $to_date . ' 23:59:59');
                $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                $this->db->select('count(a.lead_id) as total');
                $data_lead_by_category = $this->db->get('tbl_lead a')->row();

                if ($jum != 0) {
                    $percent = round(intval($data_lead_by_category->total / intval($jum) * 100), 2);
                } else {
                    $percent = 0;
                }

                $data = array(
                    'category_name' => $dct->category_name,
                    'category_id' => $dct->lead_category_id,
                    'total' => $data_lead_by_category->total,
                    'percent' => $percent,
                    'icon' => $dct->icon,
                    'color' => $dct->color
                );

                array_push($data_chart, $data);
            }
        } else {
            $data_chart = array();
            $data = array();
            array_push($data_chart, $data);
        }

        return $data_chart;
    }

    public function getDataLeadByCampaignIdApiUnseen($campaign_id, $category, $sales_officer_id)
    {

        //get channel 
        $list_channel_id = array();
        $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $campaign_id))->result();

        foreach ($data_channel as $dch) {
            array_push($list_channel_id, $dch->id);
        }

        if (!empty($list_channel_id)) {

            $this->db->where_in('channel_id', $list_channel_id);
            if ($category == 1) {
                $this->db->where('lead_category_id', 1);
            } else if ($category == 0) {
                $status = array(1, 5);
                $this->db->where_not_in('lead_category_id', $status);
            } else {
                $this->db->where('lead_category_id', 5);
            }
            $this->db->where('is_seen', 0);
            $this->db->where('sales_officer_id', $sales_officer_id);
            $data_lead = $this->db->get('tbl_lead')->result();
        } else {
            $data_lead = array();
        }

        return $data_lead;
    }

    public function getDataLeadByCampaignIdApi($campaign_id, $category, $sales_officer_id)
    {

        $list_channel_id = array();
        if ($campaign_id != 0) {
            $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $campaign_id))->result();

            foreach ($data_channel as $dch) {
                array_push($list_channel_id, $dch->id);
            }

            if (!empty($list_channel_id)) {

                $this->db->where_in('channel_id', $list_channel_id);
                if ($category == 1) {
                    $this->db->where('lead_category_id', 1);
                } else if ($category == 0) {
                    $status = array(1, 5);
                    $this->db->where_not_in('lead_category_id', $status);
                } else {
                    $this->db->where('lead_category_id', 5);
                }
                $this->db->where('sales_officer_id', $sales_officer_id);
                $data_lead = $this->db->get('tbl_lead')->result();
            } else {
                $data_lead = array();
            }
        } else {
            if ($category == 1) {
                $this->db->where('lead_category_id', 1);
            } else if ($category == 0) {
                $status = array(1, 5);
                $this->db->where_not_in('lead_category_id', $status);
            } else {
                $this->db->where('lead_category_id', 5);
            }
            $this->db->where('sales_officer_id', $sales_officer_id);
            $data_lead = $this->db->get('tbl_lead')->result();
        }

        //get channel 


        return $data_lead;
    }

    public function getLeadsbyCampaignIdperCategory($campaign_id, $category, $sales_officer_id)
    {

        if ($category != 'onprogress') {
            $this->db->like('category_name', $category, 'after');
            $data_lead_category = $this->db->get('tbl_lead_category')->row();

            $lead_category_id = $data_lead_category->lead_category_id;
        } else {

            $status = array(1, 5);

            $this->db->where_not_in('lead_category_id', $status);
            $data_lead_category = $this->db->get('tbl_lead_category')->result();

            $lead_category_id = array();

            foreach ($data_lead_category as $dlc) {
                array_push($lead_category_id, $dlc->lead_category_id);
            }
        }

        //get channel 
        $list_channel_id = array();
        $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $campaign_id))->result();

        foreach ($data_channel as $dch) {
            array_push($list_channel_id, $dch->id);
        }

        if (!empty($list_channel_id)) {

            $this->db->order_by('a.create_date', 'desc');
            $this->db->where('a.sales_officer_id', $sales_officer_id);
            $this->db->where_in('a.channel_id', $list_channel_id);
            $this->db->where_in('a.lead_category_id', $lead_category_id);
            $this->db->select('a.*, b.media_name, d.status_name, '
                . 'TIMESTAMPDIFF(MINUTE, a.create_date, NOW()) AS minutes, '
                . 'TIMESTAMPDIFF(SECOND, a.create_date, NOW()) AS seconds, '
                . 'TIMESTAMPDIFF(HOUR, a.create_date, NOW()) AS hours, '
                . 'TIMESTAMPDIFF(DAY, a.create_date, NOW()) AS days');
            $this->db->join('tbl_channel c', 'c.id = a.channel_id', 'left');
            $this->db->join('tbl_media b', 'b.id = c.channel_media', 'left');
            $this->db->join('tbl_status d', 'a.status_id = d.id', 'left');
            $data_lead = $this->db->get('tbl_lead a')->result();
        } else {
            $this->db->order_by('a.create_date', 'desc');
            $this->db->where('a.sales_officer_id', $sales_officer_id);
            $this->db->where_in('a.lead_category_id', $lead_category_id);
            $this->db->select('a.*, b.media_name, d.status_name, '
                . 'TIMESTAMPDIFF(MINUTE, a.create_date, NOW()) AS minutes, '
                . 'TIMESTAMPDIFF(SECOND, a.create_date, NOW()) AS seconds, '
                . 'TIMESTAMPDIFF(HOUR, a.create_date, NOW()) AS hours, '
                . 'TIMESTAMPDIFF(DAY, a.create_date, NOW()) AS days');
            $this->db->join('tbl_channel c', 'c.id = a.channel_id', 'left');
            $this->db->join('tbl_media b', 'b.id = c.channel_media', 'left');
            $this->db->join('tbl_status d', 'a.status_id = d.id', 'left');
            $data_lead = $this->db->get('tbl_lead a')->result();
        }

        return $data_lead;
    }

    public function getLeadsbyCampaignIdperCategorySearch($campaign_id, $sales_officer_id, $query)
    {


        //get channel 
        $list_channel_id = array();
        $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $campaign_id))->result();
        $lead_category_id = array(1, 2, 3, 5, 7);

        foreach ($data_channel as $dch) {
            array_push($list_channel_id, $dch->id);
        }

        if (!empty($list_channel_id)) {

            $this->db->like('lead_name', $query, 'after');
            $this->db->order_by('a.create_date', 'desc');
            $this->db->where('a.sales_officer_id', $sales_officer_id);
            $this->db->where_in('a.channel_id', $list_channel_id);
            $this->db->where_in('a.lead_category_id', $lead_category_id);
            $this->db->select('a.*, b.media_name, d.status_name, '
                . 'TIMESTAMPDIFF(MINUTE, a.create_date, NOW()) AS minutes, '
                . 'TIMESTAMPDIFF(SECOND, a.create_date, NOW()) AS seconds, '
                . 'TIMESTAMPDIFF(HOUR, a.create_date, NOW()) AS hours, '
                . 'TIMESTAMPDIFF(DAY, a.create_date, NOW()) AS days');
            $this->db->join('tbl_channel c', 'c.id = a.channel_id', 'left');
            $this->db->join('tbl_media b', 'b.id = c.channel_media', 'left');
            $this->db->join('tbl_status d', 'a.status_id = d.id', 'left');
            $data_lead = $this->db->get('tbl_lead a')->result();
        } else {
            $this->db->like('lead_name', $query, 'after');
            $this->db->order_by('a.create_date', 'desc');
            $this->db->where('a.sales_officer_id', $sales_officer_id);
            $this->db->where_in('a.lead_category_id', $lead_category_id);
            $this->db->select('a.*, b.media_name, d.status_name, '
                . 'TIMESTAMPDIFF(MINUTE, a.create_date, NOW()) AS minutes, '
                . 'TIMESTAMPDIFF(SECOND, a.create_date, NOW()) AS seconds, '
                . 'TIMESTAMPDIFF(HOUR, a.create_date, NOW()) AS hours, '
                . 'TIMESTAMPDIFF(DAY, a.create_date, NOW()) AS days');
            $this->db->join('tbl_channel c', 'c.id = a.channel_id', 'left');
            $this->db->join('tbl_media b', 'b.id = c.channel_media', 'left');
            $this->db->join('tbl_status d', 'a.status_id = d.id', 'left');
            $data_lead = $this->db->get('tbl_lead a')->result();
        }

        return $data_lead;
    }

    public function getLeadsbyCampaignIdperCategoryMainPage($campaign_id, $category, $sales_officer_id)
    {

        if ($category != 'onprogress') {
            $this->db->like('category_name', $category, 'after');
            $data_lead_category = $this->db->get('tbl_lead_category')->row();

            $lead_category_id = $data_lead_category->lead_category_id;
        } else {

            $status = array(1, 5);

            $this->db->where_not_in('lead_category_id', $status);
            $data_lead_category = $this->db->get('tbl_lead_category')->result();

            $lead_category_id = array();

            foreach ($data_lead_category as $dlc) {
                array_push($lead_category_id, $dlc->lead_category_id);
            }
        }

        //get channel 
        $list_channel_id = array();
        $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $campaign_id))->result();

        foreach ($data_channel as $dch) {
            array_push($list_channel_id, $dch->id);
        }

        if (!empty($list_channel_id)) {

            $data_lead = array();

            $this->db->limit(5);
            $this->db->order_by('a.update_date', 'asc');
            $this->db->where('a.lead_category_id', 2);
            $this->db->where_in('a.channel_id', $list_channel_id);
            $this->db->where('a.sales_officer_id', $sales_officer_id);
            $this->db->where_in('a.lead_category_id', $lead_category_id);
            $this->db->select('a.*, b.media_name, d.status_name, '
                . 'TIMESTAMPDIFF(MINUTE, a.create_date, NOW()) AS minutes, '
                . 'TIMESTAMPDIFF(SECOND, a.create_date, NOW()) AS seconds, '
                . 'TIMESTAMPDIFF(HOUR, a.create_date, NOW()) AS hours, '
                . 'TIMESTAMPDIFF(DAY, a.create_date, NOW()) AS days');
            $this->db->join('tbl_channel c', 'c.id = a.channel_id', 'left');
            $this->db->join('tbl_media b', 'b.id = c.channel_media', 'left');
            $this->db->join('tbl_status d', 'a.status_id = d.id', 'left');
            $data_leads_1 = $this->db->get('tbl_lead a')->result();

            if (count($data_lead) < 5) {
                $limit = 5 - intval(count($data_lead));

                foreach ($data_leads_1 as $value_1) {
                    array_push($data_lead, $value_1);
                }

                $this->db->limit($limit);
                $this->db->order_by('a.create_date', 'asc');
                $this->db->where('a.lead_category_id', 7);
                $this->db->where_in('a.channel_id', $list_channel_id);
                $this->db->where('a.sales_officer_id', $sales_officer_id);
                $this->db->where_in('a.lead_category_id', $lead_category_id);
                $this->db->select('a.*, b.media_name, d.status_name, '
                    . 'TIMESTAMPDIFF(MINUTE, a.create_date, NOW()) AS minutes, '
                    . 'TIMESTAMPDIFF(SECOND, a.create_date, NOW()) AS seconds, '
                    . 'TIMESTAMPDIFF(HOUR, a.create_date, NOW()) AS hours, '
                    . 'TIMESTAMPDIFF(DAY, a.create_date, NOW()) AS days');
                $this->db->join('tbl_channel c', 'c.id = a.channel_id', 'left');
                $this->db->join('tbl_media b', 'b.id = c.channel_media', 'left');
                $this->db->join('tbl_status d', 'a.status_id = d.id', 'left');
                $data_leads_2 = $this->db->get('tbl_lead a')->result();

                foreach ($data_leads_2 as $value_2) {
                    array_push($data_lead, $value_2);
                }
            } else {
                foreach ($data_leads_1 as $value_1) {
                    array_push($data_lead, $value_1);
                }
            }
        } else {

//            $category = array(2);

            $data_lead = array();

            $this->db->limit(5);
            $this->db->order_by('a.update_date', 'asc');
            $this->db->where('a.lead_category_id', 2);
            $this->db->where('a.sales_officer_id', $sales_officer_id);
            $this->db->where_in('a.lead_category_id', $lead_category_id);
            $this->db->select('a.*, b.media_name, d.status_name, '
                . 'TIMESTAMPDIFF(MINUTE, a.create_date, NOW()) AS minutes, '
                . 'TIMESTAMPDIFF(SECOND, a.create_date, NOW()) AS seconds, '
                . 'TIMESTAMPDIFF(HOUR, a.create_date, NOW()) AS hours, '
                . 'TIMESTAMPDIFF(DAY, a.create_date, NOW()) AS days');
            $this->db->join('tbl_channel c', 'c.id = a.channel_id', 'left');
            $this->db->join('tbl_media b', 'b.id = c.channel_media', 'left');
            $this->db->join('tbl_status d', 'a.status_id = d.id', 'left');
            $data_leads_1 = $this->db->get('tbl_lead a')->result();

            if (count($data_lead) < 5) {
                $limit = 5 - intval(count($data_lead));

                foreach ($data_leads_1 as $value_1) {
                    array_push($data_lead, $value_1);
                }

                $this->db->limit($limit);
                $this->db->order_by('a.create_date', 'asc');
                $this->db->where('a.lead_category_id', 7);
                $this->db->where('a.sales_officer_id', $sales_officer_id);
                $this->db->where_in('a.lead_category_id', $lead_category_id);
                $this->db->select('a.*, b.media_name, d.status_name, '
                    . 'TIMESTAMPDIFF(MINUTE, a.create_date, NOW()) AS minutes, '
                    . 'TIMESTAMPDIFF(SECOND, a.create_date, NOW()) AS seconds, '
                    . 'TIMESTAMPDIFF(HOUR, a.create_date, NOW()) AS hours, '
                    . 'TIMESTAMPDIFF(DAY, a.create_date, NOW()) AS days');
                $this->db->join('tbl_channel c', 'c.id = a.channel_id', 'left');
                $this->db->join('tbl_media b', 'b.id = c.channel_media', 'left');
                $this->db->join('tbl_status d', 'a.status_id = d.id', 'left');
                $data_leads_2 = $this->db->get('tbl_lead a')->result();

                foreach ($data_leads_2 as $value_2) {
                    array_push($data_lead, $value_2);
                }
            } else {
                foreach ($data_leads_1 as $value_1) {
                    array_push($data_lead, $value_1);
                }
            }
        }

        return $data_lead;
    }

    public function getLeadsbyCampaignIdperCategoryFilter($campaign_id, $category, $sales_officer_id, $channel_id, $status_name, $period)
    {

        switch ($period) {
            case 'Today':
                $date_period = date('d');
                break;
            case 'This Week':
                $date_period = date('W');
                break;
            case 'This Month':
                $date_period = date('m');
                break;
            default:
                break;
        }

        if ($category != 'onprogress') {
            $this->db->like('category_name', $category, 'after');
            $data_lead_category = $this->db->get('tbl_lead_category')->row();

            $lead_category_id = $data_lead_category->lead_category_id;
        } else {

            $status = array(1, 5);

            $this->db->where_not_in('lead_category_id', $status);
            $data_lead_category = $this->db->get('tbl_lead_category')->result();

            $lead_category_id = array();

            foreach ($data_lead_category as $dlc) {
                array_push($lead_category_id, $dlc->lead_category_id);
            }
        }

        //get channel 
        $list_channel_id = array();

        switch ($channel_id) {
            case '':
                $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $campaign_id))->result();
                break;
            case 'null':
                $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $campaign_id))->result();
                break;
            default:
                $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $campaign_id, 'id' => $channel_id))->result();
                break;
        }

//        if ($channel_id != '') {
//            $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $campaign_id, 'id' => $channel_id))->result();
//        } else {
//            $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $campaign_id))->result();
//        }


        foreach ($data_channel as $dch) {
            array_push($list_channel_id, $dch->id);
        }

        if (!empty($list_channel_id)) {

            switch ($status_name) {
                case '':
                    break;
                case 'null':
                    break;
                default:
                    $this->db->where('d.status_name', $status_name);
                    break;
            }

            switch ($period) {
                case '':
                    break;
                case 'null':
                    break;
                default:
                    if ($period == 'Today') {
                        $this->db->where('DAY(a.create_date)', $date_period);
                    } else if ($period == 'This Week') {
                        $this->db->where('WEEK(a.create_date)', $date_period);
                    } else if ($period == 'This Month') {
                        $this->db->where('MONTH(a.create_date)', $date_period);
                    }
                    break;
            }

//            if ($period != '') {
//                if ($period == 'Today') {
//                    $this->db->where('DAY(a.create_date)', $date_period);
//                } else if ($period == 'This Week') {
//                    $this->db->where('WEEK(a.create_date)', $date_period);
//                } else if ($period == 'This Month') {
//                    $this->db->where('MONTH(a.create_date)', $date_period);
//                }
//            }

            $this->db->order_by('a.create_date', 'desc');
            $this->db->where('a.sales_officer_id', $sales_officer_id);
            $this->db->where_in('a.channel_id', $list_channel_id);
            $this->db->where_in('a.lead_category_id', $lead_category_id);
            $this->db->select('a.*, b.media_name, d.status_name, '
                . 'TIMESTAMPDIFF(MINUTE, a.create_date, NOW()) AS minutes, '
                . 'TIMESTAMPDIFF(SECOND, a.create_date, NOW()) AS seconds, '
                . 'TIMESTAMPDIFF(HOUR, a.create_date, NOW()) AS hours, '
                . 'TIMESTAMPDIFF(DAY, a.create_date, NOW()) AS days');
            $this->db->join('tbl_channel c', 'c.id = a.channel_id', 'left');
            $this->db->join('tbl_media b', 'b.id = c.channel_media', 'left');
            $this->db->join('tbl_status d', 'a.status_id = d.id', 'left');
            $data_lead = $this->db->get('tbl_lead a')->result();
        } else {
            $data_lead = array();
        }

        return $data_lead;
    }

    public function getDetailLead($lead_id)
    {

        $this->db->select('a.*, b.media_name, d.status_name, e.category_name, f.product_name, f.product_price, c.channel_name');
        $this->db->join('tbl_channel c', 'c.id = a.channel_id', 'left');
        $this->db->join('tbl_media b', 'b.id = c.channel_media', 'left');
        $this->db->join('tbl_status d', 'a.status_id = d.id', 'left');
        $this->db->join('tbl_lead_category e', 'a.lead_category_id = e.lead_category_id', 'left');
        $this->db->join('tbl_product f', 'a.product_id = f.id', 'left');
        $data_lead = $this->db->get_where('tbl_lead a', array('a.lead_id' => $lead_id))->row();

        return $data_lead;
    }

    public function getHistorybyLeadId($lead_id)
    {

        $this->db->limit('5');
        $this->db->order_by('a.create_date', 'DESC');
        $this->db->select('a.*, b.status_name, c.category_name, TIMESTAMPDIFF(MINUTE, a.create_date, NOW()) AS minutes, '
            . 'TIMESTAMPDIFF(SECOND, a.create_date, NOW()) AS seconds, '
            . 'TIMESTAMPDIFF(HOUR, a.create_date, NOW()) AS hours, '
            . 'TIMESTAMPDIFF(DAY, a.create_date, NOW()) AS days');
        $this->db->join('tbl_status b', 'a.status_id = b.id');
        $this->db->join('tbl_lead_category c', 'a.category_id = c.lead_category_id');
        $data_history = $this->db->get_where('tbl_lead_history a', array('a.lead_id' => $lead_id))->result();

        return $data_history;
    }

    public function getHistoryLead($lead_id)
    {
        $this->db->order_by('a.create_date', 'DESC');
        $this->db->select('a.*, b.status_name, c.category_name, TIMESTAMPDIFF(MINUTE, a.create_date, NOW()) AS minutes, '
            . 'TIMESTAMPDIFF(SECOND, a.create_date, NOW()) AS seconds, '
            . 'TIMESTAMPDIFF(HOUR, a.create_date, NOW()) AS hours, '
            . 'TIMESTAMPDIFF(DAY, a.create_date, NOW()) AS days');
        $this->db->join('tbl_status b', 'a.status_id = b.id');
        $this->db->join('tbl_lead_category c', 'a.category_id = c.lead_category_id');
        $data_history = $this->db->get_where('tbl_lead_history a', array('a.lead_id' => $lead_id))->row('notes');

        return $data_history;
    }

    public function getHistorybyCampaignId($campaign_id, $sales_officer_id)
    {
        //get channel 
        $list_channel_id = array();
        $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $campaign_id))->result();

        foreach ($data_channel as $dch) {
            array_push($list_channel_id, $dch->id);
        }

        if (!empty($list_channel_id)) {

            $list_lead_id = array();

            $this->db->where_in('channel_id', $list_channel_id);
            $this->db->where('sales_officer_id', $sales_officer_id);
            $data_lead = $this->db->get('tbl_lead')->result();

            foreach ($data_lead as $dl) {
                array_push($list_lead_id, $dl->lead_id);
            }

            if (!empty($list_lead_id)) {

                $this->db->order_by('a.create_date', 'DESC');
                $this->db->where_in('a.lead_id', $list_lead_id);
                $this->db->select('a.*, d.lead_name, b.status_name, c.category_name, TIMESTAMPDIFF(MINUTE, a.create_date, NOW()) AS minutes, '
                    . 'TIMESTAMPDIFF(SECOND, a.create_date, NOW()) AS seconds, '
                    . 'TIMESTAMPDIFF(HOUR, a.create_date, NOW()) AS hours, '
                    . 'TIMESTAMPDIFF(DAY, a.create_date, NOW()) AS days');
                $this->db->join('tbl_lead d', 'a.lead_id = d.lead_id');
                $this->db->join('tbl_status b', 'a.status_id = b.id');
                $this->db->join('tbl_lead_category c', 'a.category_id = c.lead_category_id');
                $data_history = $this->db->get_where('tbl_lead_history a', array('a.sales_officer_id' => $sales_officer_id))->result();
            } else {
                $data_history = array();
            }
        } else {
            $data_history = array();
        }

        return $data_history;
    }

    public function getDataLeadbyChannelIdSalesOfficerId($channel_id, $sales_officer_id)
    {

        $this->db->order_by('a.create_date', 'desc');
        $this->db->where('a.sales_officer_id', $sales_officer_id);
        $this->db->where('a.channel_id', $channel_id);
        $this->db->select('a.*, b.media_name, d.status_name, '
            . 'TIMESTAMPDIFF(MINUTE, a.create_date, NOW()) AS minutes, '
            . 'TIMESTAMPDIFF(SECOND, a.create_date, NOW()) AS seconds, '
            . 'TIMESTAMPDIFF(HOUR, a.create_date, NOW()) AS hours, '
            . 'TIMESTAMPDIFF(DAY, a.create_date, NOW()) AS days');
        $this->db->join('tbl_channel c', 'c.id = a.channel_id', 'left');
        $this->db->join('tbl_media b', 'b.id = c.channel_media', 'left');
        $this->db->join('tbl_status d', 'a.status_id = d.id', 'left');
        $data_lead = $this->db->get('tbl_lead a')->result();


        return $data_lead;
    }

    public function getDataLeadStatusbyCampaignIdbySalesOfficerId($campaign_id, $sales_officer_id)
    {

        $list_channel_id = array();
        //get channel by campaign id

        if ($campaign_id != 0) {
            $data_status = $this->StatusModels->getDataStatusByCampaignId($campaign_id);
            $data_channel = $this->ChannelModels->getDataChannelbyCampagnId($campaign_id);

            foreach ($data_channel as $dch) {
                array_push($list_channel_id, $dch->channel_id);
            }

            //get lead total by sales officer id by campaign id
            $this->db->where_in('channel_id', $list_channel_id);
            $jum = $this->db->get_where('tbl_lead', array('sales_officer_id' => $sales_officer_id))->result();

            $data_chart = array();

            //get data lead per status
            foreach ($data_status as $ds) {
                $this->db->where_in('a.channel_id', $list_channel_id);
                $this->db->where('b.id', $ds->id);
                $this->db->where('a.sales_officer_id', $sales_officer_id);
                $this->db->select('count(a.lead_id) as total, b.status_name, c.color');
                $this->db->join('tbl_status b', 'b.id = a.status_id');
                $this->db->join('tbl_master_status c', 'c.status_name = b.status_name');
                $data_lead = $this->db->get('tbl_lead a')->row();

                if ($data_lead->total > 0) {
                    $percent = round(intval($data_lead->total / intval(count($jum)) * 100), 2) . '%';
                    $data_push = array('total' => $data_lead->total, 'status_name' => $data_lead->status_name, 'color' => $data_lead->color, 'percent' => $percent);

                    array_push($data_chart, $data_push);
                }
            }
        } else {
            $data_status = $this->StatusModels->getDataStatusByCampaignId($campaign_id);

            //get lead total by sales officer id by campaign id
            $jum = $this->db->get_where('tbl_lead', array('sales_officer_id' => $sales_officer_id))->result();

            $data_chart = array();

            //get data lead per status    
            foreach ($data_status as $ds) {
                $this->db->where('b.id', $ds->id);
                $this->db->where('a.sales_officer_id', $sales_officer_id);
                $this->db->select('count(a.lead_id) as total, b.status_name, c.color');
                $this->db->join('tbl_status b', 'b.id = a.status_id');
                $this->db->join('tbl_master_status c', 'c.status_name = b.status_name');
                $data_lead = $this->db->get('tbl_lead a')->row();

                if ($data_lead->total > 0) {
                    $percent = round(intval($data_lead->total / intval(count($jum)) * 100), 2) . '%';
                    $data_push = array('total' => $data_lead->total, 'status_name' => $data_lead->status_name, 'color' => $data_lead->color, 'percent' => $percent);

                    array_push($data_chart, $data_push);
                }
            }
        }


        return $data_chart;
    }

    public function getDataLeadbyChannelIdSalesOfficerIdCategory($channel_id, $category, $sales_officer_id)
    {

        if ($category == "All") {

            $data_lead_category = $this->db->get('tbl_lead_category')->result();

            $lead_category_id = array();

            if (!empty($data_lead_category)) {
                foreach ($data_lead_category as $dlc) {
                    array_push($lead_category_id, $dlc->lead_category_id);
                }
            }
        } else {
            $this->db->like('category_name', $category, 'after');
            $data_lead_category = $this->db->get('tbl_lead_category')->row();

            $lead_category_id = $data_lead_category->lead_category_id;
        }


        $this->db->where('a.sales_officer_id', $sales_officer_id);
        $this->db->where('a.channel_id', $channel_id);

        if ($category == 'All') {
            $this->db->where_in('a.lead_category_id', $lead_category_id);
        } else {
            $this->db->where('a.lead_category_id', $lead_category_id);
        }

        $this->db->order_by('a.create_date', 'desc');
        $this->db->select('a.*, b.media_name, d.status_name, '
            . 'TIMESTAMPDIFF(MINUTE, a.create_date, NOW()) AS minutes, '
            . 'TIMESTAMPDIFF(SECOND, a.create_date, NOW()) AS seconds, '
            . 'TIMESTAMPDIFF(HOUR, a.create_date, NOW()) AS hours, '
            . 'TIMESTAMPDIFF(DAY, a.create_date, NOW()) AS days');
        $this->db->join('tbl_channel c', 'c.id = a.channel_id', 'left');
        $this->db->join('tbl_media b', 'b.id = c.channel_media', 'left');
        $this->db->join('tbl_status d', 'a.status_id = d.id', 'left');
        $data_lead = $this->db->get('tbl_lead a')->result();


        return $data_lead;
    }

    public function getDataLeadbyChannelIdSalesOfficerIdStatus($channel_id, $category, $sales_officer_id)
    {

        $this->db->order_by('a.create_date', 'desc');
        $this->db->where('a.sales_officer_id', $sales_officer_id);
        $this->db->where('a.channel_id', $channel_id);
        $this->db->where('d.status_name', 'New Leads');
        $this->db->select('a.*, b.media_name, d.status_name, '
            . 'TIMESTAMPDIFF(MINUTE, a.create_date, NOW()) AS minutes, '
            . 'TIMESTAMPDIFF(SECOND, a.create_date, NOW()) AS seconds, '
            . 'TIMESTAMPDIFF(HOUR, a.create_date, NOW()) AS hours, '
            . 'TIMESTAMPDIFF(DAY, a.create_date, NOW()) AS days');
        $this->db->join('tbl_channel c', 'c.id = a.channel_id', 'left');
        $this->db->join('tbl_media b', 'b.id = c.channel_media', 'left');
        $this->db->join('tbl_status d', 'a.status_id = d.id', 'left');
        $data_lead = $this->db->get('tbl_lead a')->result();


        return $data_lead;
    }

    public function getDataLeadByProjectExcel()
    {

        $list_channel_id = array();

        $data_channel = $this->ChannelModels->getDataChannelbyProjectId($project_id);

        foreach ($data_channel as $dc) {
            array_push($list_channel_id, $dc->channel_id);
        }

        if (!empty($list_channel_id)) {
            $this->db->order_by('a.create_date', 'desc');
            $this->db->where_in('a.channel_id', $list_channel_id);
            $this->db->where('a.create_date >=', $from . ' 00:00:00');
            $this->db->where('a.create_date <=', $to . ' 23:59:59');

            if ($campaign_id != 0) {
                $this->db->where('e.id', $campaign_id);
            }

            if ($sales_team_id != 0) {
                $this->db->where('j.sales_team_id', $sales_team_id);
            }

//            if ($lead_category_id != 0) {
//                $this->db->where('a.lead_category_id', $lead_category_id);
//            }
//
//            if ($status_id != 0) {
//                $this->db->where('a.status_id', $status_id);
//            }

            if ($channel_id != 0) {
                $this->db->where('a.channel_id', $channel_id);
            }

            if ($sales_officer_id != 0) {
                $this->db->where('a.sales_officer_id', $sales_officer_id);
            }

            $this->db->select('a.*, b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name');
            $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id', 'left');
            $this->db->join('tbl_channel f', 'a.channel_id = f.id', 'left');
            $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
            $this->db->join('tbl_campaign e', 'e.id = f.campaign_id', 'left');
            $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id', 'left');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city', 'left');
            $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
            $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
            $data_leads = $this->db->get('tbl_lead a')->result();
        } else {
            $data_leads = array();
        }


        return $data_leads;
    }

    public function getLeadReportClientId($client_id)
    {

        $list_channel_id = array();

        $data_channel = $this->ChannelModels->getDataChannelReportbyClientId($client_id);

        foreach ($data_channel as $dc) {
            array_push($list_channel_id, $dc->id);
        }

        if (!empty($list_channel_id)) {
            $this->db->order_by('create_date', 'desc');
            $this->db->where_in('channel_id', $list_channel_id);
            $data_leads = $this->db->get('tbl_lead')->result();
        } else {
            $data_leads = array();
        }

        return $data_leads;
    }

    public function getDataLeadBySalesTeamReport($list_sales_team_id, $client_id)
    {

        $list_sales_officer = array();
        $data = array();

        $this->db->where_in('sales_team_id', $list_sales_team_id);
        $data_sales_team = $this->db->get('tbl_sales_team')->result();

        if (!empty($data_sales_team)) {

            foreach ($data_sales_team as $dst) {

                $list_sales_officer_id = array();

                $data_sales_offcier_group = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $dst->sales_team_id))->result();

                foreach ($data_sales_offcier_group as $dsog) {
                    array_push($list_sales_officer_id, $dsog->sales_officer_id);
                }

                if (!empty($list_sales_officer_id)) {
                    $this->db->where_in('sales_officer_id', $list_sales_officer_id);
                    $this->db->select('count(lead_id) as total');
                    $count_lead = $this->db->get('tbl_lead')->row('total');
                } else {
                    $count_lead = 0;
                }

                $data_lead_total = $this->LeadModels->getLeadReportClientId($client_id);

                if (!empty($data_lead_total)) {
                    $jum = count($data_lead_total);

                    if (!empty($count_lead)) {
                        $percent = round(intval($count_lead / intval($jum) * 100), 2);

                        $data_push = array('total' => $count_lead, 'percent' => $percent, 'sales_team_name' => $dst->sales_team_name, 'sales_team_id' => $dst->sales_team_id);
                        array_push($data, $data_push);
                    }
                } else {
                    $jum = 0;
                    $data = array();
                }
            }
        } else {
            $data = array();
        }

        return $data;
    }

    public function getDataOnlineOffline($session_dashboard)
    {

        $from_date = $session_dashboard['from'];
        $to_date = $session_dashboard['to'];
        //get channel offline
        $data_channel_offline = $this->ChannelModels->getDataChannelOfflinebyClientId();

        $list_channel_offline = array();

        if (!empty($data_channel_offline)) {
            foreach ($data_channel_offline as $dcof) {
                array_push($list_channel_offline, $dcof->id);
            }
        }

        $this->db->where_in('a.channel_id', $list_channel_offline);
        $this->db->where('a.update_date >=', $from_date . ' 00:00:00');
        $this->db->where('a.update_date <=', $to_date . ' 23:59:59');
        $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
        $data_lead_offline = $this->db->get('tbl_lead a')->result();

        $data_channel_online = $this->ChannelModels->getDataChannelOnlinebyClientId();

        $list_channel_online = array();

        if (!empty($data_channel_online)) {
            foreach ($data_channel_online as $dcon) {
                array_push($list_channel_online, $dcon->id);
            }
        }

        $this->db->where_in('a.channel_id', $list_channel_online);
        $this->db->where('a.update_date >=', $from_date . ' 00:00:00');
        $this->db->where('a.update_date <=', $to_date . ' 23:59:59');
        $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
        $data_lead_online = $this->db->get('tbl_lead a')->result();

        $off = count($data_lead_offline);
        $on = count($data_lead_online);

        $data = array(
            'categories' => array('offline', 'online'),
            'offline' => $off,
            'online' => $on
        );

        return $data;
    }

    public function getDataOnlineOfflineNew($session_dashboard)
    {
        $project_id = $session_dashboard['project_id'];
        $from_date = $session_dashboard['from'];
        $to_date = $session_dashboard['to'];

        $category = array('offline', 'online');
        $jum = count($this->getLeadDashboard($project_id, $from_date, $to_date));

        //get channel offline
        $data_channel_offline = $this->ChannelModels->getDataChannelOfflinebyClientId();
        $list_channel_offline = array();

        if (!empty($data_channel_offline)) {
            foreach ($data_channel_offline as $dcof) {
                array_push($list_channel_offline, $dcof->id);
            }
        }

        if (!empty($list_channel_offline)) {

            $data_chart = array();

            $this->db->where_in('a.channel_id', $list_channel_offline);
            $this->db->where('a.update_date >=', $from_date . ' 00:00:00');
            $this->db->where('a.update_date <=', $to_date . ' 23:59:59');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
            $data_lead_offline = $this->db->get('tbl_lead a')->result();

            if ($jum != 0) {
                $percent_offline = round(intval(count($data_lead_offline) / intval($jum) * 100), 2);
            } else {
                $percent_offline = 0;
            }
        } else {
            $data_chart = array();
            $data = array();
            array_push($data_chart, $data);
        }

        //get channel online
        $data_channel_online = $this->ChannelModels->getDataChannelOnlinebyClientId();
        $list_channel_online = array();

        if (!empty($data_channel_online)) {
            foreach ($data_channel_online as $dcon) {
                array_push($list_channel_online, $dcon->id);
            }
        }

        if (!empty($list_channel_online)) {

            $data_chart = array();

            $this->db->where_in('a.channel_id', $list_channel_online);
            $this->db->where('a.update_date >=', $from_date . ' 00:00:00');
            $this->db->where('a.update_date <=', $to_date . ' 23:59:59');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
            $data_lead_online = $this->db->get('tbl_lead a')->result();

            if ($jum != 0) {
                $percent_online = round(intval(count($data_lead_online) / intval($jum) * 100), 2);
            } else {
                $percent_online = 0;
            }
        } else {
            $data_chart = array();
            $data = array();
            array_push($data_chart, $data);
        }

        $data = array(
            'category_name' => $category,
            'total_offline' => count($data_lead_offline),
            'percent_offline' => $percent_offline,
            'total_online' => count($data_lead_online),
            'percent_online' => $percent_online
        );

        array_push($data_chart, $data);

        return $data_chart;
    }

    public function getDataOnlineOfflineNewSalesTeam($session_dashboard)
    {
        $project_id = $session_dashboard['project_id'];
        $from_date = $session_dashboard['from'];
        $to_date = $session_dashboard['to'];

        $category = array('offline', 'online');
        $jum = count($this->getLeadDashboard($project_id, $from_date, $to_date));

        $session = $this->session->userdata('user');

        //get sales team id 
        $sales_team_id = $this->db->get_where('tbl_sales_team', array('user_id' => $session['user_id']))->row('sales_team_id');

        //get channel offline
        $data_channel_offline = $this->ChannelModels->getDataChannelOfflinebySalesTeamId($sales_team_id);

        //get sales officer by sales team id
        $sales_officer = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $sales_team_id))->result();

        $list_sales_officer_id = array();

        foreach ($sales_officer as $so) {
            array_push($list_sales_officer_id, $so->sales_officer_id);
        }


        $list_channel_offline = array();

        if (!empty($data_channel_offline)) {
            foreach ($data_channel_offline as $dcof) {
                array_push($list_channel_offline, $dcof->id);
            }
        }

        if (!empty($list_channel_offline)) {

            $data_chart = array();

            $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
            $this->db->where_in('a.channel_id', $list_channel_offline);
            $this->db->where('a.update_date >=', $from_date . ' 00:00:00');
            $this->db->where('a.update_date <=', $to_date . ' 23:59:59');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
            $data_lead_offline = $this->db->get('tbl_lead a')->result();

            if ($jum != 0) {
                $percent_offline = round(intval(count($data_lead_offline) / intval($jum) * 100), 2);
            } else {
                $percent_offline = 0;
            }
        } else {
            $data_chart = array();
            $data = array();
            array_push($data_chart, $data);
        }

        //get channel online
        $data_channel_online = $this->ChannelModels->getDataChannelOnlinebySalesTeamId($sales_team_id);
        $list_channel_online = array();

        if (!empty($data_channel_online)) {
            foreach ($data_channel_online as $dcon) {
                array_push($list_channel_online, $dcon->id);
            }
        }

        if (!empty($list_channel_online)) {

            $data_chart = array();

            $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
            $this->db->where_in('a.channel_id', $list_channel_online);
            $this->db->where('a.update_date >=', $from_date . ' 00:00:00');
            $this->db->where('a.update_date <=', $to_date . ' 23:59:59');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
            $data_lead_online = $this->db->get('tbl_lead a')->result();

            if ($jum != 0) {
                $percent_online = round(intval(count($data_lead_online) / intval($jum) * 100), 2);
            } else {
                $percent_online = 0;
            }
        } else {
            $data_chart = array();
            $data = array();
            array_push($data_chart, $data);
        }

        $data = array(
            'category_name' => $category,
            'total_offline' => count($data_lead_offline),
            'percent_offline' => $percent_offline,
            'total_online' => count($data_lead_online),
            'percent_online' => $percent_online
        );

        array_push($data_chart, $data);

        return $data_chart;
    }

    public function getAll($limit, $start)
    {
        $this->db->select('a.*, b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name, p.*, r.*');
        $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
        $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
        $this->db->join('tbl_channel f', 'a.channel_id = f.id');
        $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
        $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
        $this->db->join('tbl_project p', 'p.id = e.project_id');
        $this->db->join('tbl_client r', 'r.client_id = p.client_id');
        $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id', 'left');
        $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
        $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
        $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
        // where
        if (!empty($this->input->get('project_id'))) {
            $this->db->where('p.id', $this->input->get('project_id'));
        }
        if (!empty($this->input->get('client_id'))) {
            $this->db->where('r.client_id', $this->input->get('client_id'));
        }
        if (!empty($this->input->get('campaign_id'))) {
            $this->db->where('campaign_id', $this->input->get('campaign_id'));
        }
        $data_lead = $this->db->get('tbl_lead a', $limit, $start);
        return $data_lead;
    }

    public function jumlahData()
    {
        $this->db->select('a.*, b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name, p.*, r.*');
        $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
        $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
        $this->db->join('tbl_channel f', 'a.channel_id = f.id');
        $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
        $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
        $this->db->join('tbl_project p', 'p.id = e.project_id');
        $this->db->join('tbl_client r', 'r.client_id = p.client_id');
        $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id', 'left');
        $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
        $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
        $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
        if (!empty($this->input->get('project_id'))) {
            $this->db->where('p.id', $this->input->get('project_id'));
        }
        if (!empty($this->input->get('client_id'))) {
            $this->db->where('r.client_id', $this->input->get('client_id'));
        }
        if (!empty($this->input->get('campaign_id'))) {
            $this->db->where('campaign_id', $this->input->get('campaign_id'));
        }
        return $this->db->get('tbl_lead a', '100')->num_rows();
    }

    public function getDataLeadbyProjectId($project_id)
    {

        //get channel by project id
        $channel = $this->ChannelModels->getChannelbyProjectId($project_id);


        if (!empty($channel)) {
            $list_channel = array();
            foreach ($channel as $ch) {
                array_push($list_channel, $ch->id);
            }

            $this->db->where_in('a.channel_id', $list_channel);
            $this->db->select('a.lead_id');
            $this->db->join('tbl_channel c', 'c.id = a.channel_id');
            $this->db->join('tbl_campaign b', 'b.id = c.campaign_id');
            $this->db->join('tbl_lead_category e', 'a.lead_category_id = e.lead_category_id');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
            $data_lead = $this->db->get('tbl_lead a')->result();

        } else {
            $data_lead = array();
        }

        return $data_lead;

    }

}