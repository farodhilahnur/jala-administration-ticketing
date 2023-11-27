<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LeadModelsNew extends CI_Model
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
            $this->db->where('a.create_date >=', $from . ' 00:00:00');
            $this->db->where('a.create_date <=', $to . ' 23:59:59');

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
            $this->db->where('a.create_date >=', $from . ' 00:00:00');
            $this->db->where('a.create_date <=', $to . ' 23:59:59');

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
            $this->db->where('a.create_date >=', $from . ' 00:00:00');
            $this->db->where('a.create_date <=', $to . ' 23:59:59');
            $this->db->where_in('a.channel_id', $list_channel_id);
            $this->db->select('a.*, b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name');
            $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
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
            $this->db->where('a.create_date >=', $from . ' 00:00:00');
            $this->db->where('a.create_date <=', $to . ' 23:59:59');
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
            $this->db->where('a.create_date >=', $from . ' 00:00:00');
            $this->db->where('a.create_date <=', $to . ' 23:59:59');
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

    public function getDataLeadbyProjectId($project_id)
    {

        //get channel by project id
        $channel = $this->ChannelModels->getChannelbyProjectId($project_id);



        if (!empty($channel)) {
            $list_channel = array();
            foreach ($channel as $ch){
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

        return $data_lead ;

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
                $this->db->where('a.create_date >=', $project_date . ' 00:00:00');
                $this->db->where('a.create_date <=', $now_date . ' 23:59:59');
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
                $this->db->where('a.create_date >=', $from . ' 00:00:00');
                $this->db->where('a.create_date <=', $to . ' 23:59:59');
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
                $this->db->where('a.create_date >=', $from . ' 00:00:00');
                $this->db->where('a.create_date <=', $to . ' 23:59:59');
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

}