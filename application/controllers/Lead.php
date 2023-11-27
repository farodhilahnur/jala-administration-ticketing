<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Lead extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        ini_set('max_execution_time', 0);

        $this->load->model('LeadModels');
        $this->load->model('SalesTeamModels');
        $this->load->model('SalesOfficerModels');
    }

    public function getLeadPerformanceChannelIn()
    {

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $project_id = $this->input->get('id');
        $page = $this->input->get('page') * 5;

        $session = $this->session->userdata();

        $role = $this->MainModels->UserSession('role_id');

        $client_id = $this->MainModels->getClientId();

        $data_client = $this->db->get_where('tbl_client', array('client_id' => $client_id))->row('create_date');

        $client_date = substr($data_client, 0, 10);


        $now = date('Y-m-d');
        $newDate = date("Y-m-d", strtotime($client_date));
        //$date_range = $newDate . ' to ' . $now;
        $from = $newDate;
        $to = $now;

        //GET CATEGORY
        $this->db->order_by('urutan', 'asc');
        $this->db->select('lead_category_id');
        $data_category = $this->db->get('tbl_lead_category')->result();

        $category_id = array(0);
        foreach ($data_category as $dct) {
            array_push($category_id, $dct->lead_category_id);
        }

        //GET CAMPAIGN
        $campaign_id = $this->CampaignModels->getDataCampaignbyProjectId($project_id);

        //GET CHANNEL
        $channel_id = $this->ChannelModels->getChannelbyCampaignId($campaign_id);

        //GET SALES OFFICER
        $sales_officer_id = array();
        $data_sales_officer = $this->SalesOfficerModels->getSalesOfficerbyProjectId();

        if (!empty($data_sales_officer)) {
            foreach ($data_sales_officer as $dso) {
                array_push($sales_officer_id, $dso->sales_officer_id);
            }

        }

        //GET DETAIL CAMPAIGN
        $this->db->where_in('id', $channel_id);
        $this->db->select('channel_name, ');
        $data_label = $this->db->get('tbl_channel')->result();

        //GET COUNT LEAD PER CAMPAIGN
        $this->db->limit($page);
        $this->db->order_by('count(a.lead_id)', 'desc');
        $this->db->where('a.create_date >=', $from . ' 00:00:00');
        $this->db->where('a.create_date <=', $to . ' 23:59:59');
        $this->db->where_in('c.id', $channel_id);
        if ($role == 3) {
            $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
        }
        $this->db->group_by('c.id');
        $this->db->select('count(a.lead_id) as total, c.channel_name, c.id');
        $this->db->join('tbl_channel c', 'c.id = a.channel_id');
        $this->db->join('tbl_campaign b', 'b.id = c.campaign_id');
        $this->db->join('tbl_lead_category e', 'a.lead_category_id = e.lead_category_id');
        $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
        $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
        $data_label = $this->db->get('tbl_lead a')->result();

        $lbl = array();

        if (!empty($data_label)) {
            foreach ($data_label as $dlb) {
                array_push($lbl, $dlb->channel_name);
            }
        }

        $dataset = array();
        $json = array();
        if (!empty($data_label)) {

            foreach ($category_id as $c) {

                if ($c != 0) {
                    $data_category = $this->db->get_where('tbl_lead_category', array('lead_category_id' => $c))->row();

                    $bg_color = $data_category->background_color;
                    $category_name = $data_category->category_name;
                } else {

                    $bg_color = '#9B9B9B';
                    $category_name = 'All';
                }

                $total = array();

                foreach ($data_label as $dl) {

                    $this->db->where('a.create_date >=', $from . ' 00:00:00');
                    $this->db->where('a.create_date <=', $to . ' 23:59:59');
                    $this->db->where('c.id', $dl->id);
                    if ($role == 3) {
                        $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                    }
                    if ($c != 0) {
                        $this->db->where('a.lead_category_id', $c);
                    }
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
                if ($c == 0) {
                    $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color, 'hidden' => 'true');
                } else {
                    $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color);
                }
                array_push($dataset, $data);
            }

            array_push($json, $dataset);

        }

        array_push($json, $lbl);

        echo json_encode($json);
    }

    public function getLeadPerformanceCampaignIn()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $project_id = $this->input->get('id');
        $page = $this->input->get('page') * 2;

        $session = $this->session->userdata();

        $role = $this->MainModels->UserSession('role_id');

        $client_id = $this->MainModels->getClientId();

        $data_client = $this->db->get_where('tbl_client', array('client_id' => $client_id))->row('create_date');

        $client_date = substr($data_client, 0, 10);


        $now = date('Y-m-d');
        $newDate = date("Y-m-d", strtotime($client_date));
        //$date_range = $newDate . ' to ' . $now;
        $from = $newDate;
        $to = $now;


        //GET CATEGORY
        $this->db->order_by('urutan', 'asc');
        $this->db->select('lead_category_id');
        $data_category = $this->db->get('tbl_lead_category')->result();

        $category_id = array(0);
        foreach ($data_category as $dct) {
            array_push($category_id, $dct->lead_category_id);
        }

        //GET CAMPAIGN
        $campaign_id = $this->CampaignModels->getDataCampaignbyProjectId($project_id);

        //GET CHANNEL
        $channel_id = $this->ChannelModels->getChannelbyCampaignId($campaign_id);

        //GET SALES OFFICER
        $sales_officer_id = array();
        $data_sales_officer = $this->SalesOfficerModels->getSalesOfficerbyProjectId();

        if (!empty($data_sales_officer)) {
            foreach ($data_sales_officer as $dso) {
                array_push($sales_officer_id, $dso->sales_officer_id);
            }

        }

        //GET DETAIL CAMPAIGN
        $this->db->limit($page);
        $this->db->where_in('id', $campaign_id);
        $this->db->select('campaign_name, ');
        $data_label = $this->db->get('tbl_campaign')->result();

        //GET COUNT LEAD PER CAMPAIGN
        $this->db->order_by('count(a.lead_id)', 'desc');
        $this->db->where('a.create_date >=', $from . ' 00:00:00');
        $this->db->where('a.create_date <=', $to . ' 23:59:59');
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

                if ($c != 0) {
                    $data_category = $this->db->get_where('tbl_lead_category', array('lead_category_id' => $c))->row();

                    $bg_color = $data_category->background_color;
                    $category_name = $data_category->category_name;
                } else {

                    $bg_color = '#9B9B9B';
                    $category_name = 'All';
                }


                $total = array();

                foreach ($data_label as $dl) {

                    $this->db->where('a.create_date >=', $from . ' 00:00:00');
                    $this->db->where('a.create_date <=', $to . ' 23:59:59');
                    $this->db->where('b.id', $dl->id);
                    if ($role == 3) {
                        $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                    }
                    if ($c != 0) {
                        $this->db->where('a.lead_category_id', $c);
                    }

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

                if ($c == 0) {
                    $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color, 'hidden' => 'true');
                } else {
                    $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color);
                }

                array_push($dataset, $data);
            }

            array_push($json, $dataset);

        }

        array_push($json, $lbl);


        echo json_encode($json);
    }

    public function getSalesOfficerLeadPerformance()
    {

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $session = $this->session->userdata();
        $page = $this->input->get('page') * 5;


        $client_id = $this->MainModels->getClientId();

        $data_client = $this->db->get_where('tbl_client', array('client_id' => $client_id))->row('create_date');

        $client_date = substr($data_client, 0, 10);


        $now = date('Y-m-d');
        $newDate = date("Y-m-d", strtotime($client_date));
        //$date_range = $newDate . ' to ' . $now;
        $from = $newDate;
        $to = $now;


        //GET CATEGORY
        $this->db->order_by('urutan', 'asc');
        $this->db->select('lead_category_id');
        $data_category = $this->db->get('tbl_lead_category')->result();

        $category_id = array(0);
        foreach ($data_category as $dct) {
            array_push($category_id, $dct->lead_category_id);
        }

        //GET CAMPAIGN
        $campaign_id = $this->CampaignModels->getDataCampaignbyProjectId(0);

        //GET CHANNEL
        $channel_id = $this->ChannelModels->getChannelbyCampaignId($campaign_id);

        //GET SALES OFFICER
        $sales_officer_id = array();
        $data_sales_officer = $this->SalesOfficerModels->getSalesOfficerbyProjectId();

        if (!empty($data_sales_officer)) {
            foreach ($data_sales_officer as $dso) {
                array_push($sales_officer_id, $dso->sales_officer_id);
            }

        }

        //GET COUNT LEAD PER SALES TEAM
        $this->db->limit($page);
        $this->db->order_by('count(a.lead_id)', 'desc');
        $this->db->where('a.create_date >=', $from . ' 00:00:00');
        $this->db->where('a.create_date <=', $to . ' 23:59:59');
        $this->db->where_in('d.sales_officer_id', $sales_officer_id);
        $this->db->where_in('c.id', $channel_id);
        $this->db->group_by('d.sales_officer_id');
        $this->db->select('count(a.lead_id) as total, d.sales_officer_name, d.sales_officer_id');
        $this->db->join('tbl_channel c', 'c.id = a.channel_id');
        $this->db->join('tbl_campaign b', 'b.id = c.campaign_id');
        $this->db->join('tbl_lead_category e', 'a.lead_category_id = e.lead_category_id');
        $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
        $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
        $data_label = $this->db->get('tbl_lead a')->result();

        $lbl = array();

        if (!empty($data_label)) {
            foreach ($data_label as $dlb) {
                array_push($lbl, $dlb->sales_officer_name);
            }
        }

        $dataset = array();
        $json = array();

        if (!empty($data_label)) {

            foreach ($category_id as $c) {

                if ($c != 0) {
                    $data_category = $this->db->get_where('tbl_lead_category', array('lead_category_id' => $c))->row();

                    $bg_color = $data_category->background_color;
                    $category_name = $data_category->category_name;
                } else {

                    $bg_color = '#9B9B9B';
                    $category_name = 'All';
                }

                $total = array();

                foreach ($data_label as $dl) {

                    $this->db->where('a.create_date >=', $from . ' 00:00:00');
                    $this->db->where('a.create_date <=', $to . ' 23:59:59');
                    $this->db->where('d.sales_officer_id', $dl->sales_officer_id);

                    if ($c != 0) {
                        $this->db->where('a.lead_category_id', $c);
                    }

                    $this->db->where_in('c.id', $channel_id);
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

                if ($c == 0) {
                    $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color, 'hidden' => 'true');
                } else {
                    $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color);
                }

                array_push($dataset, $data);
            }

            array_push($json, $dataset);

        }

        array_push($json, $lbl);


        echo json_encode($json);
    }

    public function getSalesTeamLeadPerformance()
    {

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $page = $this->input->get('page') * 5;
        $session = $this->session->userdata();

        $client_id = $this->MainModels->getClientId();

        $data_client = $this->db->get_where('tbl_client', array('client_id' => $client_id))->row('create_date');

        $client_date = substr($data_client, 0, 10);


        $now = date('Y-m-d');
        $newDate = date("Y-m-d", strtotime($client_date));
        //$date_range = $newDate . ' to ' . $now;
        $from = $newDate;
        $to = $now;


        //GET CATEGORY
        $this->db->order_by('urutan', 'asc');
        $this->db->select('lead_category_id');
        $data_category = $this->db->get('tbl_lead_category')->result();

        $category_id = array(0);
        foreach ($data_category as $dct) {
            array_push($category_id, $dct->lead_category_id);
        }

        //GET CAMPAIGN
        $campaign_id = $this->CampaignModels->getDataCampaignbyProjectId(0);

        //GET CHANNEL
        $channel_id = $this->ChannelModels->getChannelbyCampaignId($campaign_id);

        //GET SALES TEAM
        $sales_team_id = array();
        $data_sales_team = $this->SalesTeamModels->getSalesTeambyProjectId(0);

        if (!empty($data_sales_team)) {
            foreach ($data_sales_team as $dst) {
                array_push($sales_team_id, $dst->sales_team_id);
            }

        }

        //GET COUNT LEAD PER SALES TEAM
        $this->db->limit($page);
        $this->db->order_by('count(a.lead_id)', 'desc');
        $this->db->where('a.create_date >=', $from . ' 00:00:00');
        $this->db->where('a.create_date <=', $to . ' 23:59:59');
        $this->db->where_in('z.sales_team_id', $sales_team_id);
        $this->db->where_in('c.id', $channel_id);
        $this->db->group_by('z.sales_team_id');
        $this->db->select('count(a.lead_id) as total, y.sales_team_name, y.sales_team_id');
        $this->db->join('tbl_channel c', 'c.id = a.channel_id');
        $this->db->join('tbl_campaign b', 'b.id = c.campaign_id');
        $this->db->join('tbl_lead_category e', 'a.lead_category_id = e.lead_category_id');
        $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
        $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
        $this->db->join('tbl_sales_officer_group z', 'd.sales_officer_id = z.sales_officer_id', 'left');
        $this->db->join('tbl_sales_team y', 'y.sales_team_id = z.sales_team_id', 'left');
        $data_label = $this->db->get('tbl_lead a')->result();

        $lbl = array();

        if (!empty($data_label)) {
            foreach ($data_label as $dlb) {
                array_push($lbl, $dlb->sales_team_name);
            }
        }

        $dataset = array();
        $json = array();

        if (!empty($data_label)) {

            foreach ($category_id as $c) {

                if ($c != 0) {
                    $data_category = $this->db->get_where('tbl_lead_category', array('lead_category_id' => $c))->row();

                    $bg_color = $data_category->background_color;
                    $category_name = $data_category->category_name;
                } else {

                    $bg_color = '#9B9B9B';
                    $category_name = 'All';
                }

                $total = array();

                foreach ($data_label as $dl) {

                    $this->db->where('a.create_date >=', $from . ' 00:00:00');
                    $this->db->where('a.create_date <=', $to . ' 23:59:59');
                    $this->db->where('y.sales_team_id', $dl->sales_team_id);
                    $this->db->where_in('c.id', $channel_id);

                    if ($c != 0) {
                        $this->db->where('a.lead_category_id', $c);
                    }

                    $this->db->select('count(a.lead_id) as total, e.category_name, e.background_color');
                    $this->db->join('tbl_channel c', 'c.id = a.channel_id');
                    $this->db->join('tbl_campaign b', 'b.id = c.campaign_id');
                    $this->db->join('tbl_lead_category e', 'a.lead_category_id = e.lead_category_id');
                    $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
                    $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                    $this->db->join('tbl_sales_officer_group z', 'd.sales_officer_id = z.sales_officer_id', 'left');
                    $this->db->join('tbl_sales_team y', 'y.sales_team_id = z.sales_team_id', 'left');
                    $data_lead = $this->db->get('tbl_lead a')->result();

                    if (!empty($data_lead)) {
                        foreach ($data_lead as $dle) {
                            array_push($total, $dle->total);
                        }
                    }

                }

                if ($c == 0) {
                    $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color, 'hidden' => 'true');
                } else {
                    $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color);
                }

                array_push($dataset, $data);
            }

            array_push($json, $dataset);

        }

        array_push($json, $lbl);


        echo json_encode($json);
    }

    public function get_first_char($str)
    {
        if ($str) {
            return strtolower(substr($str, 0, 1));
        } else {
            return;
        }
    }

    public function getLeadPerformance()
    {

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

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

        $get = $this->input->get();
        $from = $get['from'];
        $to = $get['to'];
        $project_id = $get['project_id'];
        $type = $get['type'];

        switch ($type) {
            case 1 :

                //GET CATEGORY
                $this->db->order_by('urutan', 'asc');
                $this->db->select('lead_category_id');
                $data_category = $this->db->get('tbl_lead_category')->result();

                $category_id = array(0);
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
                $this->db->where('a.create_date >=', $from . ' 00:00:00');
                $this->db->where('a.create_date <=', $to . ' 23:59:59');
                $this->db->where_in('b.id', $campaign_id);

                if ($role == 3) {
                    $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                }

                $this->db->limit('5');
                $this->db->group_by('b.id');
                $this->db->select('count(a.lead_id) as total, b.campaign_name, b.id');
                $this->db->join('tbl_channel c', 'c.id = a.channel_id');
                $this->db->join('tbl_campaign b', 'b.id = c.campaign_id');
                $this->db->join('tbl_lead_category e', 'a.lead_category_id = e.lead_category_id');
                $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
                $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                $data_label = $this->db->get('tbl_lead a')->result();

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

                        if ($c != 0) {
                            $data_category = $this->db->get_where('tbl_lead_category', array('lead_category_id' => $c))->row();

                            $bg_color = $data_category->background_color;
                            $category_name = $data_category->category_name;
                        } else {

                            $bg_color = '#9B9B9B';
                            $category_name = 'All';
                        }


                        $total = array();

                        foreach ($data_label as $dl) {

                            $this->db->where('a.create_date >=', $from . ' 00:00:00');
                            $this->db->where('a.create_date <=', $to . ' 23:59:59');
                            $this->db->where('b.id', $dl->id);
                            if ($role == 3) {
                                $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                            }
                            if ($c != 0) {
                                $this->db->where('a.lead_category_id', $c);
                            }

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

                        if ($c == 0) {
                            $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color, 'hidden' => 'true');
                        } else {
                            $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color);
                        }


                        array_push($dataset, $data);
                    }

                    array_push($json, $dataset);

                }

                array_push($json, $lbl);

                break;
            case 2 :

                //GET CATEGORY
                $this->db->order_by('urutan', 'asc');
                $this->db->select('lead_category_id');
                $data_category = $this->db->get('tbl_lead_category')->result();

                $category_id = array(0);
                foreach ($data_category as $dct) {
                    array_push($category_id, $dct->lead_category_id);
                }

                //GET CAMPAIGN
                $campaign_id = $this->CampaignModels->getDataCampaignbyProjectId($project_id);

                //GET CHANNEL
                $channel_id = $this->ChannelModels->getChannelbyCampaignId($campaign_id);

                //GET DETAIL CAMPAIGN
                $this->db->where_in('id', $channel_id);
                $this->db->select('channel_name, ');
                $data_label = $this->db->get('tbl_channel')->result();

                //GET COUNT LEAD PER CAMPAIGN
                $this->db->limit('5');
                $this->db->order_by('count(a.lead_id)', 'desc');
                $this->db->where('a.create_date >=', $from . ' 00:00:00');
                $this->db->where('a.create_date <=', $to . ' 23:59:59');
                $this->db->where_in('c.id', $channel_id);
                if ($role == 3) {
                    $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                }
                $this->db->group_by('c.id');
                $this->db->select('count(a.lead_id) as total, c.channel_name, c.id');
                $this->db->join('tbl_channel c', 'c.id = a.channel_id');
                $this->db->join('tbl_campaign b', 'b.id = c.campaign_id');
                $this->db->join('tbl_lead_category e', 'a.lead_category_id = e.lead_category_id');
                $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
                $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                $data_label = $this->db->get('tbl_lead a')->result();

                $lbl = array();

                if (!empty($data_label)) {
                    foreach ($data_label as $dlb) {
                        array_push($lbl, $dlb->channel_name);
                    }
                }

                $dataset = array();
                $json = array();
                if (!empty($data_label)) {

                    foreach ($category_id as $c) {

                        if ($c != 0) {
                            $data_category = $this->db->get_where('tbl_lead_category', array('lead_category_id' => $c))->row();

                            $bg_color = $data_category->background_color;
                            $category_name = $data_category->category_name;
                        } else {

                            $bg_color = '#9B9B9B';
                            $category_name = 'All';
                        }

                        $total = array();

                        foreach ($data_label as $dl) {

                            $this->db->where('a.create_date >=', $from . ' 00:00:00');
                            $this->db->where('a.create_date <=', $to . ' 23:59:59');
                            $this->db->where('c.id', $dl->id);
                            if ($role == 3) {
                                $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                            }
                            if ($c != 0) {
                                $this->db->where('a.lead_category_id', $c);
                            }
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

                        if ($c == 0) {
                            $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color, 'hidden' => 'true');
                        } else {
                            $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color);
                        }

                        array_push($dataset, $data);
                    }

                    array_push($json, $dataset);

                }

                array_push($json, $lbl);

                break;
            case 3 :

                //GET CATEGORY
                $this->db->order_by('urutan', 'asc');
                $this->db->select('lead_category_id');
                $data_category = $this->db->get('tbl_lead_category')->result();

                $category_id = array(0);
                foreach ($data_category as $dct) {
                    array_push($category_id, $dct->lead_category_id);
                }

                //GET CAMPAIGN
                $campaign_id = $this->CampaignModels->getDataCampaignbyProjectId($project_id);

                //GET CHANNEL
                $channel_id = $this->ChannelModels->getChannelbyCampaignId($campaign_id);

                //GET SALES TEAM
                $sales_team_id = array();
                $data_sales_team = $this->SalesTeamModels->getSalesTeambyProjectId($project_id);

                if (!empty($data_sales_team)) {
                    foreach ($data_sales_team as $dst) {
                        array_push($sales_team_id, $dst->sales_team_id);
                    }

                }

                //GET COUNT LEAD PER SALES TEAM
                $this->db->limit('5');
                $this->db->order_by('count(a.lead_id)', 'desc');
                $this->db->where('a.create_date >=', $from . ' 00:00:00');
                $this->db->where('a.create_date <=', $to . ' 23:59:59');
                $this->db->where_in('z.sales_team_id', $sales_team_id);
                $this->db->where_in('c.id', $channel_id);
                if ($role == 3) {
                    $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                }
                $this->db->group_by('z.sales_team_id');
                $this->db->select('count(a.lead_id) as total, y.sales_team_name, y.sales_team_id');
                $this->db->join('tbl_channel c', 'c.id = a.channel_id');
                $this->db->join('tbl_campaign b', 'b.id = c.campaign_id');
                $this->db->join('tbl_lead_category e', 'a.lead_category_id = e.lead_category_id');
                $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
                $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                $this->db->join('tbl_sales_officer_group z', 'd.sales_officer_id = z.sales_officer_id', 'left');
                $this->db->join('tbl_sales_team y', 'y.sales_team_id = z.sales_team_id', 'left');
                $data_label = $this->db->get('tbl_lead a')->result();

                $lbl = array();

                if (!empty($data_label)) {
                    foreach ($data_label as $dlb) {
                        array_push($lbl, $dlb->sales_team_name);
                    }
                }

                $dataset = array();
                $json = array();

                if (!empty($data_label)) {

                    foreach ($category_id as $c) {

                        if ($c != 0) {
                            $data_category = $this->db->get_where('tbl_lead_category', array('lead_category_id' => $c))->row();

                            $bg_color = $data_category->background_color;
                            $category_name = $data_category->category_name;
                        } else {

                            $bg_color = '#9B9B9B';
                            $category_name = 'All';
                        }

                        $total = array();

                        foreach ($data_label as $dl) {

                            $this->db->where('a.create_date >=', $from . ' 00:00:00');
                            $this->db->where('a.create_date <=', $to . ' 23:59:59');
                            $this->db->where('y.sales_team_id', $dl->sales_team_id);
                            $this->db->where_in('c.id', $channel_id);
                            if ($role == 3) {
                                $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                            }
                            if ($c != 0) {
                                $this->db->where('a.lead_category_id', $c);
                            }
                            $this->db->select('count(a.lead_id) as total, e.category_name, e.background_color');
                            $this->db->join('tbl_channel c', 'c.id = a.channel_id');
                            $this->db->join('tbl_campaign b', 'b.id = c.campaign_id');
                            $this->db->join('tbl_lead_category e', 'a.lead_category_id = e.lead_category_id');
                            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
                            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                            $this->db->join('tbl_sales_officer_group z', 'd.sales_officer_id = z.sales_officer_id', 'left');
                            $this->db->join('tbl_sales_team y', 'y.sales_team_id = z.sales_team_id', 'left');
                            $data_lead = $this->db->get('tbl_lead a')->result();

                            if (!empty($data_lead)) {
                                foreach ($data_lead as $dle) {
                                    array_push($total, $dle->total);
                                }
                            }

                        }

                        if ($c == 0) {
                            $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color, 'hidden' => 'true');
                        } else {
                            $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color);
                        }

                        array_push($dataset, $data);
                    }

                    array_push($json, $dataset);

                }

                array_push($json, $lbl);

                break;
            case 4 :

                //GET CATEGORY
                $this->db->order_by('urutan', 'asc');
                $this->db->select('lead_category_id');
                $data_category = $this->db->get('tbl_lead_category')->result();

                $category_id = array(0);
                foreach ($data_category as $dct) {
                    array_push($category_id, $dct->lead_category_id);
                }

                //GET CAMPAIGN
                $campaign_id = $this->CampaignModels->getDataCampaignbyProjectId($project_id);

                //GET CHANNEL
                $channel_id = $this->ChannelModels->getChannelbyCampaignId($campaign_id);

                //GET SALES OFFICER
                $sales_officer_id = array();
                $data_sales_officer = $this->SalesOfficerModels->getSalesOfficerbyProjectId($project_id);

                if (!empty($data_sales_officer)) {
                    foreach ($data_sales_officer as $dso) {
                        array_push($sales_officer_id, $dso->sales_officer_id);
                    }

                }

                //GET COUNT LEAD PER SALES TEAM
                $this->db->limit('5');
                $this->db->order_by('count(a.lead_id)', 'desc');
                $this->db->where('a.create_date >=', $from . ' 00:00:00');
                $this->db->where('a.create_date <=', $to . ' 23:59:59');
                $this->db->where_in('d.sales_officer_id', $sales_officer_id);
                if ($role == 3) {
                    $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                }
                $this->db->where_in('c.id', $channel_id);
                $this->db->group_by('d.sales_officer_id');
                $this->db->select('count(a.lead_id) as total, d.sales_officer_name, d.sales_officer_id');
                $this->db->join('tbl_channel c', 'c.id = a.channel_id');
                $this->db->join('tbl_campaign b', 'b.id = c.campaign_id');
                $this->db->join('tbl_lead_category e', 'a.lead_category_id = e.lead_category_id');
                $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
                $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                $data_label = $this->db->get('tbl_lead a')->result();

                $lbl = array();

                if (!empty($data_label)) {
                    foreach ($data_label as $dlb) {
                        array_push($lbl, $dlb->sales_officer_name);
                    }
                }

                $dataset = array();
                $json = array();

                if (!empty($data_label)) {

                    foreach ($category_id as $c) {

                        if ($c != 0) {
                            $data_category = $this->db->get_where('tbl_lead_category', array('lead_category_id' => $c))->row();

                            $bg_color = $data_category->background_color;
                            $category_name = $data_category->category_name;
                        } else {

                            $bg_color = '#9B9B9B';
                            $category_name = 'All';
                        }

                        $total = array();

                        foreach ($data_label as $dl) {

                            $this->db->where('a.create_date >=', $from . ' 00:00:00');
                            $this->db->where('a.create_date <=', $to . ' 23:59:59');
                            $this->db->where('d.sales_officer_id', $dl->sales_officer_id);
                            if ($role == 3) {
                                $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                            }
                            if ($c != 0) {
                                $this->db->where('a.lead_category_id', $c);
                            }
                            $this->db->where_in('c.id', $channel_id);
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

                        if ($c == 0) {
                            $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color, 'hidden' => 'true');
                        } else {
                            $data = array('label' => $category_name, 'data' => $total, 'backgroundColor' => $bg_color);
                        }

                        array_push($dataset, $data);
                    }

                    array_push($json, $dataset);

                }

                array_push($json, $lbl);

                break;
        }

        echo json_encode($json);

    }

    public function getTopCategory()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

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

        $get = $this->input->get();
        $from = $get['from'];
        $to = $get['to'];
        $project_id = $get['project_id'];

        $channel_id = array();
        $data_channel = $this->ChannelModels->getChannelbyProjectId($project_id);


        if (!empty($data_channel)) {
            foreach ($data_channel as $dc) {
                array_push($channel_id, $dc->id);
            }

            //get lead per category
            $this->db->order_by('count(a.lead_id)', 'desc');
            $this->db->where('a.create_date >=', $from . ' 00:00:00');
            $this->db->where('a.create_date <=', $to . ' 23:59:59');
            $this->db->where_in('a.channel_id', $channel_id);

            if ($role == 3) {
                $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
            }

            $this->db->group_by('a.lead_category_id');
            $this->db->select('count(a.lead_id) as total, b.category_name, b.background_color');
            $this->db->join('tbl_lead_category b', 'a.lead_category_id = b.lead_category_id');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
            $this->db->join('tbl_channel f', 'a.channel_id = f.id');
            $data_lead = $this->db->get('tbl_lead a')->result();

            $label = array();
            $total = array();
            $bg = array();

            if (!empty($data_lead)) {
                foreach ($data_lead as $dl) {
                    array_push($label, $dl->category_name);
                    array_push($total, $dl->total);
                    array_push($bg, $dl->background_color);
                }

                $data = array('label' => $label, 'total' => $total, 'background' => $bg);

            } else {
                $data = array('label' => '', 'total' => 0, 'background' => '#fffff');
            }


        } else {
            $data = array('label' => '', 'total' => 0, 'background' => '#fffff');
        }


        echo json_encode($data);
    }

    public function getTotalLead()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

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

        $get = $this->input->get();
        $from = $get['from'];
        $to = $get['to'];
        $period = $get['period'];
        $project_id = $get['project_id'];

        $channel_id = array();
        $data_channel = $this->ChannelModels->getChannelbyProjectId($project_id);

        if (!empty($data_channel)) {
            foreach ($data_channel as $dc) {
                array_push($channel_id, $dc->id);
            }

            $this->db->order_by('a.create_date', 'asc');
            $this->db->where('a.create_date >=', $from . ' 00:00:00');
            $this->db->where('a.create_date <=', $to . ' 23:59:59');
            $this->db->where_in('a.channel_id', $channel_id);

            if ($role == 3) {
                $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
            }

            if ($period == 'DAY') {
                $this->db->group_by('DAY(a.create_date)');
                $this->db->select('count(a.lead_id) as total, DATE_FORMAT(a.create_date, \'%b %d, %Y\') as date');
            } else if ($period == 'MONTH') {
                $this->db->group_by('MONTH(a.create_date)');
                $this->db->select('count(a.lead_id) as total, DATE_FORMAT(a.create_date, \'%b %Y\') as date');
            } else if ($period == 'YEAR') {
                $this->db->group_by('YEAR(a.create_date)');
                $this->db->select('count(a.lead_id) as total, DATE_FORMAT(a.create_date, \'%Y\') as date');
            } else {
                $this->db->group_by('DAY(a.create_date)');
                $this->db->select('count(a.lead_id) as total, DATE_FORMAT(a.create_date, \'%b %d, %Y\') as date');
            }
            $this->db->join('tbl_lead_category b', 'a.lead_category_id = b.lead_category_id');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
            $this->db->join('tbl_channel f', 'a.channel_id = f.id');
            $data_lead = $this->db->get('tbl_lead a')->result();

            $label = array();
            $total = array();

            if (!empty($data_lead)) {
                foreach ($data_lead as $dl) {
                    array_push($label, $dl->date);
                    array_push($total, $dl->total);
                }

                $data = array('label' => $label, 'total' => $total);

            } else {
                $data = array('label' => '', 'total' => 0);
            }

        } else {
            $data = array('label' => '', 'total' => 0);
        }


        echo json_encode($data);

    }

    // JEJE
    public function post_lead()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $now = date('y-m-d h:i:s');
        $tgl = '20' . $now;

        $post = $this->input->post();

        $name = addslashes($post['name']);
        $phone = addslashes($post['phone']);
        $email = strtolower($post['email']);
        $no_ktp = $post['no_ktp'];
        $address = addslashes($post['address']);
        $city = $post['city'];
        $gender = $post['gender'];
        $source = ($post['source']);
        $note = $post['notes'];

        $test = $this->get_first_char($phone);

        if ($test == '0') {
            $ptn = '/^0/';  // Regex
            $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
            $rpltxt = '62';  // Replacement string
            $phone_new = preg_replace($ptn, $rpltxt, $str);
        } else {
            $phone_new = '62' . $phone;
        }

        $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $source))->row();

        //get data project
        $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

        $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Leads'))->row('id');

        // 3 Field
        // NP
        if ($name != NULL && $phone != NULL && $email == NULL && $address == NULL && $city == NULL && $gender == NULL && $no_ktp == NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => NULL,
                'lead_address' => NULL,
                'lead_city' => NULL,
                'lead_gender' => NULL,
                'no_ktp' => NULL,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPE
        if ($name != NULL && $phone != NULL && $email != NULL && $address == NULL && $city == NULL && $gender == NULL && $no_ktp == NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => $email,
                'lead_address' => NULL,
                'lead_city' => NULL,
                'lead_gender' => NULL,
                'no_ktp' => NULL,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPA
        if ($name != NULL && $phone != NULL && $email == NULL && $address != NULL && $city == NULL && $gender == NULL && $no_ktp == NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => NULL,
                'lead_address' => $address,
                'lead_city' => NULL,
                'lead_gender' => NULL,
                'no_ktp' => NULL,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPC
        if ($name != NULL && $phone != NULL && $email == NULL && $address == NULL && $city != NULL && $gender == NULL && $no_ktp == NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => NULL,
                'lead_address' => NULL,
                'lead_city' => $city,
                'lead_gender' => NULL,
                'no_ktp' => NULL,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPG
        if ($name != NULL && $phone != NULL && $email == NULL && $address == NULL && $city == NULL && $gender != NULL && $no_ktp == NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => NULL,
                'lead_address' => NULL,
                'lead_city' => NULL,
                'lead_gender' => $gender,
                'no_ktp' => NULL,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPK
        if ($name != NULL && $phone != NULL && $email == NULL && $address == NULL && $city == NULL && $gender == NULL && $no_ktp != NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => NULL,
                'lead_address' => NULL,
                'lead_city' => NULL,
                'lead_gender' => NULL,
                'no_ktp' => $no_ktp,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }
        // End 3 Field

        // 4 Field
        // NPEK
        if ($name != NULL && $phone != NULL && $email != NULL && $address == NULL && $city == NULL && $gender == NULL && $no_ktp != NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => $email,
                'lead_address' => NULL,
                'lead_city' => NULL,
                'lead_gender' => NULL,
                'no_ktp' => $no_ktp,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPEA
        if ($name != NULL && $phone != NULL && $email != NULL && $address != NULL && $city == NULL && $gender == NULL && $no_ktp == NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => $email,
                'lead_address' => $address,
                'lead_city' => NULL,
                'lead_gender' => NULL,
                'no_ktp' => NULL,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPEC
        if ($name != NULL && $phone != NULL && $email != NULL && $address == NULL && $city != NULL && $gender == NULL && $no_ktp == NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => $email,
                'lead_address' => NULL,
                'lead_city' => $city,
                'lead_gender' => NULL,
                'no_ktp' => NULL,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPEG
        if ($name != NULL && $phone != NULL && $email != NULL && $address == NULL && $city == NULL && $gender != NULL && $no_ktp == NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => $email,
                'lead_address' => NULL,
                'lead_city' => NULL,
                'lead_gender' => $gender,
                'no_ktp' => NULL,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPKA
        if ($name != NULL && $phone != NULL && $email == NULL && $address != NULL && $city == NULL && $gender == NULL && $no_ktp != NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => NULL,
                'lead_address' => $address,
                'lead_city' => NULL,
                'lead_gender' => NULL,
                'no_ktp' => $no_ktp,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPKC
        if ($name != NULL && $phone != NULL && $email == NULL && $address == NULL && $city != NULL && $gender == NULL && $no_ktp != NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => NULL,
                'lead_address' => NULL,
                'lead_city' => $city,
                'lead_gender' => NULL,
                'no_ktp' => $no_ktp,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPKG
        if ($name != NULL && $phone != NULL && $email == NULL && $address == NULL && $city == NULL && $gender != NULL && $no_ktp != NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => NULL,
                'lead_address' => NULL,
                'lead_city' => NULL,
                'lead_gender' => $gender,
                'no_ktp' => $no_ktp,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPAC
        if ($name != NULL && $phone != NULL && $email == NULL && $address != NULL && $city != NULL && $gender == NULL && $no_ktp == NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => NULL,
                'lead_address' => $address,
                'lead_city' => $city,
                'lead_gender' => NULL,
                'no_ktp' => NULL,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPAG
        if ($name != NULL && $phone != NULL && $email == NULL && $address != NULL && $city == NULL && $gender != NULL && $no_ktp == NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => NULL,
                'lead_address' => $address,
                'lead_city' => NULL,
                'lead_gender' => $gender,
                'no_ktp' => NULL,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPCG
        if ($name != NULL && $phone != NULL && $email == NULL && $address == NULL && $city != NULL && $gender != NULL && $no_ktp == NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => NULL,
                'lead_address' => NULL,
                'lead_city' => $city,
                'lead_gender' => $gender,
                'no_ktp' => NULL,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }
        // End 4 Field

        // 5 Field
        // NPEKA
        if ($name != NULL && $phone != NULL && $email != NULL && $address != NULL && $city == NULL && $gender == NULL && $no_ktp != NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => $email,
                'lead_address' => $address,
                'lead_city' => NULL,
                'lead_gender' => NULL,
                'no_ktp' => $no_ktp,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPEKC
        if ($name != NULL && $phone != NULL && $email != NULL && $address == NULL && $city != NULL && $gender == NULL && $no_ktp != NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => $email,
                'lead_address' => NULL,
                'lead_city' => $city,
                'lead_gender' => NULL,
                'no_ktp' => $no_ktp,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPEKG
        if ($name != NULL && $phone != NULL && $email != NULL && $address == NULL && $city == NULL && $gender != NULL && $no_ktp != NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => $email,
                'lead_address' => NULL,
                'lead_city' => NULL,
                'lead_gender' => $gender,
                'no_ktp' => $no_ktp,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPEAC
        if ($name != NULL && $phone != NULL && $email != NULL && $address != NULL && $city != NULL && $gender == NULL && $no_ktp == NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => $email,
                'lead_address' => $address,
                'lead_city' => $city,
                'lead_gender' => NULL,
                'no_ktp' => NULL,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPEAG
        if ($name != NULL && $phone != NULL && $email != NULL && $address != NULL && $city == NULL && $gender != NULL && $no_ktp == NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => $email,
                'lead_address' => $address,
                'lead_city' => NULL,
                'lead_gender' => $gender,
                'no_ktp' => NULL,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPECG
        if ($name != NULL && $phone != NULL && $email != NULL && $address == NULL && $city != NULL && $gender != NULL && $no_ktp == NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => $email,
                'lead_address' => NULL,
                'lead_city' => $city,
                'lead_gender' => $gender,
                'no_ktp' => NULL,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPKAC
        if ($name != NULL && $phone != NULL && $email == NULL && $address != NULL && $city != NULL && $gender == NULL && $no_ktp != NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => NULL,
                'lead_address' => $address,
                'lead_city' => $city,
                'lead_gender' => NULL,
                'no_ktp' => $no_ktp,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPKAG
        if ($name != NULL && $phone != NULL && $email == NULL && $address != NULL && $city == NULL && $gender != NULL && $no_ktp != NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => NULL,
                'lead_address' => $address,
                'lead_city' => NULL,
                'lead_gender' => $gender,
                'no_ktp' => $no_ktp,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPKCG
        if ($name != NULL && $phone != NULL && $email == NULL && $address == NULL && $city != NULL && $gender != NULL && $no_ktp != NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => NULL,
                'lead_address' => NULL,
                'lead_city' => $city,
                'lead_gender' => $gender,
                'no_ktp' => $no_ktp,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPACG
        if ($name != NULL && $phone != NULL && $email == NULL && $address != NULL && $city != NULL && $gender != NULL && $no_ktp == NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => NULL,
                'lead_address' => $address,
                'lead_city' => $city,
                'lead_gender' => $gender,
                'no_ktp' => NULL,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }
        // End 5 Field

        // 6 Field
        // NPEKAC
        if ($name != NULL && $phone != NULL && $email != NULL && $address != NULL && $city != NULL && $gender == NULL && $no_ktp != NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => $email,
                'lead_address' => $address,
                'lead_city' => $city,
                'lead_gender' => NULL,
                'no_ktp' => $no_ktp,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPEKAG
        if ($name != NULL && $phone != NULL && $email != NULL && $address != NULL && $city == NULL && $gender != NULL && $no_ktp != NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => $email,
                'lead_address' => $address,
                'lead_city' => NULL,
                'lead_gender' => $gender,
                'no_ktp' => $no_ktp,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPEKCG
        if ($name != NULL && $phone != NULL && $email != NULL && $address == NULL && $city != NULL && $gender != NULL && $no_ktp != NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => $email,
                'lead_address' => NULL,
                'lead_city' => $city,
                'lead_gender' => $gender,
                'no_ktp' => $no_ktp,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPEACG
        if ($name != NULL && $phone != NULL && $email != NULL && $address != NULL && $city != NULL && $gender != NULL && $no_ktp == NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => $email,
                'lead_address' => $address,
                'lead_city' => $city,
                'lead_gender' => $gender,
                'no_ktp' => NULL,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }

        // NPKACG
        if ($name != NULL && $phone != NULL && $email == NULL && $address != NULL && $city != NULL && $gender != NULL && $no_ktp != NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => NULL,
                'lead_address' => $address,
                'lead_city' => $city,
                'lead_gender' => $gender,
                'no_ktp' => $no_ktp,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }
        // End 6 Field

        // 7 Field
        // NPEKACG
        if ($name != NULL && $phone != NULL && $email != NULL && $address != NULL && $city != NULL && $gender != NULL && $no_ktp != NULL) {
            $data_insert = array(
                'channel_id' => $data_channel->id,
                'lead_name' => $name,
                'lead_phone' => $phone_new,
                'lead_email' => $email,
                'lead_address' => $address,
                'lead_city' => $city,
                'lead_gender' => $gender,
                'no_ktp' => $no_ktp,
                'note' => $note,
                'sales_officer_id' => 0,
                'status_id' => $new_leads_id
            );
        }
        // End 7 Field

        $insert = $this->db->insert('tbl_lead', $data_insert);

        if ($insert) {
            $data = array(
                'res' => 200,
                'redirect' => $data_channel->channel_redirect_url,
            );
        } else {
            $data = array(
                'res' => 400,
                'redirect' => $data_channel->channel_redirect_url,
            );
        }

        echo json_encode($data);
    }

    // END JEJE

    public function post_lead_jala()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $now = date('y-m-d h:i:s');
        $tgl = '20' . $now;

        $post = $this->input->post();

        $name = addslashes($post['name']);
//        $address = addslashes($post['address']);
        $phone = addslashes($post['phone']);
        $email = strtolower($post['email']);
//        $city = $post['city'];
        $source = ($post['source']);
        $note = $post['note'];

        $test = $this->get_first_char($phone);

        if ($test == '0') {
            $ptn = '/^0/';  // Regex
            $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
            $rpltxt = '62';  // Replacement string
            $phone_new = preg_replace($ptn, $rpltxt, $str);
        } else {
            $phone_new = '62' . $phone;
        }

        $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $source))->row();

        //get data project
        $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

        $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Leads'))->row('id');

        $data_insert = array(
            'channel_id' => $data_channel->id,
            'lead_name' => $name,
            'lead_phone' => $phone_new,
            'lead_email' => $email,
            'sales_officer_id' => 0,
            'status_id' => $new_leads_id,
            'note' => $note
        );

        $insert = $this->db->insert('tbl_lead', $data_insert);

        if ($insert) {
            $data = array(
                'res' => 200,
                'redirect' => $data_channel->channel_redirect_url,
            );
        } else {
            $data = array(
                'res' => 400,
                'redirect' => $data_channel->channel_redirect_url,
            );
        }

        echo json_encode($data);
    }

    public function post_lead_mustika()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $now = date('y-m-d h:i:s');
        $tgl = '20' . $now;

        $post = $this->input->post();

        $name = addslashes($post['name']);
//        $address = addslashes($post['address']);
        $phone = addslashes($post['phone']);
        $email = strtolower($post['email']);
//        $city = $post['city'];
        $source = ($post['source']);
        $notes = $post['alasan'] . ' ' . $post['anggaran'];

        $test = $this->get_first_char($phone);

        if ($test == '0') {
            $ptn = '/^0/';  // Regex
            $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
            $rpltxt = '62';  // Replacement string
            $phone_new = preg_replace($ptn, $rpltxt, $str);
        } else {
            $phone_new = '62' . $phone;
        }

        $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $source))->row();

        //get data project
        $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

        $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Leads'))->row('id');

        $data_insert = array(
            'channel_id' => $data_channel->id,
            'lead_name' => $name,
            'lead_phone' => $phone_new,
            'lead_email' => $email,
            'note' => $notes,
            'sales_officer_id' => 0,
            'status_id' => $new_leads_id
        );

        $insert = $this->db->insert('tbl_lead', $data_insert);

        if ($insert) {
            $data = array(
                'res' => 200,
                'redirect' => $data_channel->channel_redirect_url,
            );
        } else {
            $data = array(
                'res' => 400,
                'redirect' => $data_channel->channel_redirect_url,
            );
        }

        echo json_encode($data);
    }

    public function post_lead_foresque()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $now = date('y-m-d h:i:s');
        $tgl = '20' . $now;

        $post = $this->input->post();

        $name = addslashes($post['name']);
//        $address = addslashes($post['address']);
        $phone = addslashes($post['phone']);
        $email = strtolower($post['email']);
//        $city = $post['city'];
        $source = ($post['source']);

        $test = $this->get_first_char($phone);

        if ($test == '0') {
            $ptn = '/^0/';  // Regex
            $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
            $rpltxt = '62';  // Replacement string
            $phone_new = preg_replace($ptn, $rpltxt, $str);
        } else {
            $phone_new = '62' . $phone;
        }

        $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $source))->row();

        //get data project
        $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

        $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Leads'))->row('id');

        $data_insert = array(
            'channel_id' => $data_channel->id,
            'lead_name' => $name,
            'lead_phone' => $phone_new,
            'lead_email' => $email,
            'note' => $notes,
            'sales_officer_id' => 0,
            'status_id' => $new_leads_id
        );

        $insert = $this->db->insert('tbl_lead', $data_insert);

        if ($insert) {
            $data = array(
                'res' => 200,
                'redirect' => $data_channel->channel_redirect_url,
            );
        } else {
            $data = array(
                'res' => 400,
                'redirect' => $data_channel->channel_redirect_url,
            );
        }

        echo json_encode($data);
    }

    public function post_lead_mpp()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $now = date('y-m-d h:i:s');
        $tgl = '20' . $now;

        $post = $this->input->post();

        $name = addslashes($post['name']);
//        $address = addslashes($post['address']);
        $phone = addslashes($post['phone']);
        $email = strtolower($post['email']);
//        $city = $post['city'];
        $source = ($post['source']);
        $notes = $post['alasan'] . ' ' . $post['anggaran'] . ' ' . $post['cicilan'];

        $test = $this->get_first_char($phone);

        if ($test == '0') {
            $ptn = '/^0/';  // Regex
            $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
            $rpltxt = '62';  // Replacement string
            $phone_new = preg_replace($ptn, $rpltxt, $str);
        } else {
            $phone_new = '62' . $phone;
        }

        $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $source))->row();

        //get data project
        $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

        $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Leads'))->row('id');

        $data_insert = array(
            'channel_id' => $data_channel->id,
            'lead_name' => $name,
            'lead_phone' => $phone_new,
            'lead_email' => $email,
            'note' => $notes,
            'sales_officer_id' => 0,
            'status_id' => $new_leads_id
        );

        $insert = $this->db->insert('tbl_lead', $data_insert);

        if ($insert) {
            $data = array(
                'res' => 200,
                'redirect' => $data_channel->channel_redirect_url,
            );
        } else {
            $data = array(
                'res' => 400,
                'redirect' => $data_channel->channel_redirect_url,
            );
        }

        echo json_encode($data);
    }

    public function post_lead_saumata()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $now = date('y-m-d h:i:s');
        $tgl = '20' . $now;

        $post = $this->input->post();

        $name = addslashes($post['name']);
//        $address = addslashes($post['address']);
        $phone = addslashes($post['phone']);
        $email = strtolower($post['email']);
//        $city = $post['city'];
        $source = ($post['source']);
        $product = $post['product'];

        $test = $this->get_first_char($phone);

        if ($test == '0') {
            $ptn = '/^0/';  // Regex
            $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
            $rpltxt = '62';  // Replacement string
            $phone_new = preg_replace($ptn, $rpltxt, $str);
        } else {
            $phone_new = '62' . $phone;
        }

        $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $source))->row();

        //get data project
        $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

        $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Leads'))->row('id');

        $data_insert = array(
            'channel_id' => $data_channel->id,
            'lead_name' => $name,
            'lead_phone' => $phone_new,
            'lead_email' => $email,
            'sales_officer_id' => 0,
            'status_id' => $new_leads_id,
            'product_id' => $product
        );

        $insert = $this->db->insert('tbl_lead', $data_insert);

        if ($insert) {
            $data = array(
                'res' => 200,
                'redirect' => $data_channel->channel_redirect_url,
            );
        } else {
            $data = array(
                'res' => 400,
                'redirect' => $data_channel->channel_redirect_url,
            );
        }

        echo json_encode($data);
    }

    public function post_puri_orchard()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $now = date('y-m-d h:i:s');
        $tgl = '20' . $now;

        $post = $this->input->post();

        $name = addslashes($post['name']);
//        $address = addslashes($post['address']);
        $phone = addslashes($post['phone']);
        $email = strtolower($post['email']);
//        $city = $post['city'];
        $source = ($post['source']);
        $lead_from = $post['lead_from'];
        $noktp = $post['noktp'];

        $test = $this->get_first_char($phone);

        if ($test == '0') {
            $ptn = '/^0/';  // Regex
            $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
            $rpltxt = '62';  // Replacement string
            $phone_new = preg_replace($ptn, $rpltxt, $str);
        } else {
            $phone_new = '62' . $phone;
        }

        $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $source))->row();

        //get data project
        $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

        $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Leads'))->row('id');

        $data_insert = array(
            'channel_id' => $data_channel->id,
            'lead_name' => $name,
            'lead_phone' => $phone_new,
            'lead_email' => $email,
            'sales_officer_id' => 0,
            'status_id' => $new_leads_id,
            'lead_from' => $lead_from,
            'no_ktp' => $noktp
        );

        $insert = $this->db->insert('tbl_lead', $data_insert);

        if ($insert) {
            $data = array(
                'res' => 200,
                'redirect' => $data_channel->channel_redirect_url,
            );
        } else {
            $data = array(
                'res' => 400,
                'redirect' => $data_channel->channel_redirect_url,
            );
        }

        echo json_encode($data);
    }

    // public function post_lead() {
    //     header('Content-Type: application/json');
    //     header('Access-Control-Allow-Origin: *');

    //     if (!ini_get('date.timezone')) {
    //         date_default_timezone_set('GMT');
    //     }

    //     $now = date('y-m-d h:i:s');
    //     $tgl = '20' . $now;

    //     $post = $this->input->post();

    //     $name = addslashes($post['name']);
    //     $address = addslashes($post['address']);
    //     $phone = addslashes($post['phone']);
    //     $email = strtolower($post['email']);
    //     $city = $post['city'];
    //     $source = ($post['source']);
    //     $notes = $post['notes'];

    //     $test = $this->get_first_char($phone);

    //     if ($test == '0') {
    //         $ptn = '/^0/';  // Regex
    //         $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
    //         $rpltxt = '+62';  // Replacement string
    //         $phone_new = preg_replace($ptn, $rpltxt, $str);
    //     } else {
    //         $phone_new = '+62' . $phone;
    //     }

    //     $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $source))->row();

    //     //get data project
    //     $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

    //     $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Leads'))->row('id');

    //     $data_insert = array(
    //         'channel_id' => $data_channel->id,
    //         'lead_name' => $name,
    //         'lead_address' => $address,
    //         'lead_phone' => $phone_new,
    //         'lead_email' => $email,
    //         'sales_officer_id' => 0,
    //         'status_id' => $new_leads_id,
    //         'lead_city' => $city,
    //         'note' => $notes
    //     );

    //     $insert = $this->db->insert('tbl_lead', $data_insert);

    //     if ($insert) {
    //         $data = array(
    //             'res' => 200,
    //             'redirect' => $data_channel->channel_redirect_url,
    //         );
    //     } else {
    //         $data = array(
    //             'res' => 400,
    //             'redirect' => $data_channel->channel_redirect_url,
    //         );
    //     }

    //     echo json_encode($data);
    // }

    public function post_lead_test()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $now = date('y-m-d h:i:s');
        $tgl = '20' . $now;

        $post = $this->input->post();

        $name = addslashes($post['name']);
        $address = addslashes($post['address']);
        $phone = addslashes($post['phone']);
        $email = strtolower($post['email']);
        $city = $post['city'];
        $source = ($post['source']);

        $test = $this->get_first_char($phone);

        if ($test == '0') {
            $ptn = '/^0/';  // Regex
            $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
            $rpltxt = '+62';  // Replacement string
            $phone_new = preg_replace($ptn, $rpltxt, $str);
        } else {
            $phone_new = '+62' . $phone;
        }

        $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $source))->row();

        //get data project
        $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

        $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Leads'))->row('id');

        $data_insert = array(
            'channel_id' => $data_channel->id,
            'lead_name' => $name,
            'lead_address' => $address,
            'lead_phone' => $phone_new,
            'lead_email' => $email,
            'sales_officer_id' => 0,
            'status_id' => $new_leads_id,
            'lead_city' => $city,
        );

        $insert = $this->db->insert('tbl_lead', $data_insert);

        if ($insert) {
            $data = array(
                'res' => 200,
                'redirect' => $data_channel->channel_redirect_url,
            );
        } else {
            $data = array(
                'res' => 400,
                'redirect' => $data_channel->channel_redirect_url,
            );
        }

        echo json_encode($data);
    }

    public function post_lead_pakuan()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $now = date('y-m-d h:i:s');
        $tgl = '20' . $now;

        $post = $this->input->post();

        $name = addslashes($post['name']);
        $address = addslashes($post['address']);
        $phone = addslashes($post['phone']);
        $email = strtolower($post['email']);
        $note = $post['notes'];
        $city = 1158;
        $source = ($post['source']);

        $test = $this->get_first_char($phone);

        if ($test == '0') {
            $ptn = '/^0/';  // Regex
            $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
            $rpltxt = '+62';  // Replacement string
            $phone_new = preg_replace($ptn, $rpltxt, $str);
        } else {
            $phone_new = '+62' . $phone;
        }

        $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $source))->row();

        //get data project
        $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

        $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Leads'))->row('id');

        $data_insert = array(
            'channel_id' => $data_channel->id,
            'lead_name' => $name,
            'lead_address' => $address,
            'lead_phone' => $phone_new,
            'lead_email' => $email,
            'sales_officer_id' => 0,
            'note' => $note,
            'status_id' => $new_leads_id,
            'lead_city' => $city,
        );

        $insert = $this->db->insert('tbl_lead', $data_insert);

        if ($insert) {
            $data = array(
                'res' => 200,
                'redirect' => $data_channel->channel_redirect_url,
            );
        } else {
            $data = array(
                'res' => 400,
                'redirect' => $data_channel->channel_redirect_url,
            );
        }

        echo json_encode($data);
    }

    public function post_lead_martadinata()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $now = date('y-m-d h:i:s');
        $tgl = '20' . $now;

        $post = $this->input->post();

        $name = addslashes($post['name']);
        $phone = addslashes($post['phone']);
        $email = strtolower($post['email']);
        $city = 1158;
        $source = ($post['source']);

        $test = $this->get_first_char($phone);

        if ($test == '0') {
            $ptn = '/^0/';  // Regex
            $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
            $rpltxt = '62';  // Replacement string
            $phone_new = preg_replace($ptn, $rpltxt, $str);
        } else {
            $phone_new = '62' . $phone;
        }

        $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $source))->row();

        //get data project
        $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

        $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Leads'))->row('id');

        $data_insert = array(
            'channel_id' => $data_channel->id,
            'lead_name' => $name,
            'lead_phone' => $phone_new,
            'lead_email' => $email,
            'sales_officer_id' => 0,
            'lead_category_id' => 1,
            'status_id' => $new_leads_id
//            'lead_city' => $city,
        );

        $insert = $this->db->insert('tbl_lead', $data_insert);

        if ($insert) {
            $data = array(
                'res' => 200,
                'redirect' => $data_channel->channel_redirect_url,
            );
        } else {
            $data = array(
                'res' => 400,
                'redirect' => $data_channel->channel_redirect_url,
            );
        }

        echo json_encode($data);
    }

    public function lead_distribution()
    {

        ini_set('memory_limit', '-1');

        $sql_62 = "UPDATE tbl_lead 
                   SET lead_phone = CONCAT('62', right(lead_phone, (length(lead_phone) - 1)))  
                   WHERE lead_phone like '08%'";


        $update = $this->db->query($sql_62);


        $sql_ples = "UPDATE tbl_lead
                     SET lead_phone = REPLACE(lead_phone,'+',' ') 
                     WHERE lead_phone like '+%'";

        $update = $this->db->query($sql_ples);

        //check lead undelivered and phone number not same
//        $this->db->select('a.*');
        $this->db->join('tbl_channel b', 'b.id = a.channel_id');
        $this->db->join('tbl_campaign c', 'c.id = b.campaign_id');
        $this->db->join('tbl_project d', 'd.id = c.project_id');
        $this->db->group_by('a.lead_phone');
        $this->db->group_by('d.id');
        $data_leads = $this->db->get_where('tbl_lead a')->result();

        $list_lead = array();
        if (!empty($data_leads)) {
            foreach ($data_leads as $dls) {
                array_push($list_lead, $dls->lead_id);
            }
        }

        $this->db->where_in('lead_id', $list_lead);
        $data_lead = $this->db->get_where('tbl_lead', array('sales_officer_id' => 0))->result();

        //check channel participate sales team
        if (!empty($data_lead)) {
            foreach ($data_lead as $a => $dl) {
                $this->db->order_by('a.id', 'asc');
                $this->db->where('b.city_id', $dl->lead_city);
                $this->db->where('c.status', 1);
                $this->db->join('tbl_sales_team c', 'a.sales_team_id = c.sales_team_id');
                $this->db->join('tbl_sales_team_city b', 'a.sales_team_id = b.sales_team_id');
                $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel a', array('a.channel_id' => $dl->channel_id))->row();

                if (!empty($data_sales_team_channel)) {
                    $data_sales_team_distribution = $this->db->get_where('tbl_sales_team_distribution', array('channel_id' => $dl->channel_id))->row();

                    if (empty($data_sales_team_distribution)) {
                        //check sales officer in sales team
                        $data_insert_sales_team_distribution = array(
                            'channel_id' => $dl->channel_id,
                            'sales_team_id' => $data_sales_team_channel->sales_team_id,
                            'kota_id' => $dl->lead_city,
                        );

                        $this->db->insert('tbl_sales_team_distribution', $data_insert_sales_team_distribution);

//                        $this->db->order_by('sales_officer_group_id', 'asc');
//                        //$this->db->where('sales_officer_id >', $data_sales_officer_distribution->sales_officer_id);
//                        $data_sales_officer = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $data_sales_team_channel->sales_team_id, 'is_gifted' => 0))->row();

                        $this->db->select('a.*');
                        $this->db->order_by('a.sales_officer_group_id', 'asc');
                        $this->db->where('b.status', 1);
                        $this->db->where('a.sales_team_id', $data_sales_team_channel->sales_team_id);
                        $this->db->where('a.is_gifted', 0);
                        $this->db->join('tbl_sales_officer b', 'a.sales_officer_id = b.sales_officer_id');
                        $data_sales_officer = $this->db->get('tbl_sales_officer_group a')->row();

                        //check sales officer distribution
                        $data_sales_officer_distribution = $this->db->get_where('tbl_sales_officer_distribution', array('channel_id' => $dl->channel_id))->row();

                        if (empty($data_sales_officer_distribution)) {
                            $data_insert_sales_officer_distribution = array(
                                'sales_officer_id' => $data_sales_officer->sales_officer_id,
                                'channel_id' => $dl->channel_id,
                                'kota_id' => $dl->lead_city,
                            );

                            $this->db->insert('tbl_sales_officer_distribution', $data_insert_sales_officer_distribution);

                            $data_update_sales_officer_group = array('is_gifted' => 1);
                            $this->db->where('sales_officer_id', $data_sales_officer->sales_officer_id);
                            $this->db->update('tbl_sales_officer_group', $data_update_sales_officer_group);

                            //update lead
                            $this->db->where('lead_id', $dl->lead_id);
                            $update = $this->db->update('tbl_lead', array('sales_officer_id' => $data_sales_officer->sales_officer_id));

                            if ($update) {
                                if ($dl->note != '') {

                                    //insert tbl lead history
                                    $data_insert_history = array(
                                        'lead_id' => $dl->lead_id,
                                        'status_id' => $dl->status_id,
                                        'category_id' => $dl->lead_category_id,
                                        'notes' => $dl->note,
                                        'sales_officer_id' => $data_sales_officer->sales_officer_id,
                                        'point' => 0
                                    );

                                    $insert_history = $this->db->insert('tbl_lead_history', $data_insert_history);

                                    if ($insert_history) {
                                        echo "success";
                                    } else {
                                        echo "error";
                                    }
                                }
                            }
                        } else {

                            $this->db->select('a.*');
                            $this->db->order_by('a.sales_officer_group_id', 'asc');
                            $this->db->where('b.status', 1);
                            $this->db->where('a.sales_team_id', $data_sales_team_channel->sales_team_id);
                            $this->db->where('a.is_gifted', 0);
                            $this->db->join('tbl_sales_officer b', 'a.sales_officer_id = b.sales_officer_id');
                            $data_sales_officer = $this->db->get('tbl_sales_officer_group a')->row();

//                            $this->db->order_by('sales_officer_group_id', 'asc');
//                            //$this->db->where('sales_officer_id >', $data_sales_officer_distribution->sales_officer_id);
//                            $data_sales_officer = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $data_sales_team_channel->sales_team_id, 'is_gifted' => 0))->row();

                            $data_update_sales_offcier_distribution = array('sales_officer_id' => $data_sales_officer->sales_officer_id);
                            $this->db->where('channel_id', $dl->channel_id);
                            $this->db->update('tbl_sales_officer_distribution', $data_update_sales_offcier_distribution);

                            $data_update_sales_officer_group = array('is_gifted' => 1);
                            $this->db->where('sales_officer_id', $data_sales_officer->sales_officer_id);
                            $this->db->update('tbl_sales_officer_group', $data_update_sales_officer_group);

                            //update lead
                            $this->db->where('lead_id', $dl->lead_id);
                            $update = $this->db->update('tbl_lead', array('sales_officer_id' => $data_sales_officer->sales_officer_id));

                            if ($update) {
                                if ($dl->note != '') {

                                    //insert tbl lead history
                                    $data_insert_history = array(
                                        'lead_id' => $dl->lead_id,
                                        'status_id' => $dl->status_id,
                                        'category_id' => $dl->lead_category_id,
                                        'notes' => $dl->note,
                                        'sales_officer_id' => $data_sales_officer->sales_officer_id,
                                        'point' => 0
                                    );

                                    $insert_history = $this->db->insert('tbl_lead_history', $data_insert_history);

                                    if ($insert_history) {
                                        echo "success";
                                    } else {
                                        echo "error";
                                    }
                                }
                            }
                        }
                    } else {
                        $this->db->order_by('a.id', 'asc');
                        $this->db->where('a.sales_team_id >', $data_sales_team_distribution->sales_team_id);
                        $this->db->where('b.city_id', $dl->lead_city);
                        $this->db->join('tbl_sales_team_city b', 'a.sales_team_id = b.sales_team_id');
                        $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel a', array('a.channel_id' => $dl->channel_id))->row();

                        if (!empty($data_sales_team_channel)) {
                            $data_update = array('sales_team_id' => $data_sales_team_channel->sales_team_id);

                            $this->db->where('channel_id', $dl->channel_id);
                            $this->db->update('tbl_sales_team_distribution', $data_update);
                        } else {
                            $this->db->order_by('a.id', 'asc');
                            $this->db->where('b.city_id', $dl->lead_city);
                            $this->db->join('tbl_sales_team_city b', 'a.sales_team_id = b.sales_team_id');
                            $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel a', array('a.channel_id' => $dl->channel_id))->row();

                            if (!empty($data_sales_team_channel)) {
                                $data_update = array('sales_team_id' => $data_sales_team_channel->sales_team_id);

                                $this->db->where('channel_id', $dl->channel_id);
                                $this->db->update('tbl_sales_team_distribution', $data_update);
                            }
                        }

                        $this->db->select('a.*');
                        $this->db->order_by('a.sales_officer_group_id', 'asc');
                        $this->db->where('b.status', 1);
                        $this->db->where('a.sales_team_id', $data_sales_team_channel->sales_team_id);
                        $this->db->where('a.is_gifted', 0);
                        $this->db->join('tbl_sales_officer b', 'a.sales_officer_id = b.sales_officer_id');
                        $data_sales_officer = $this->db->get('tbl_sales_officer_group a')->row();

//                        $this->db->order_by('sales_officer_group_id', 'asc');
//                        $data_sales_officer = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $data_sales_team_channel->sales_team_id, 'is_gifted' => 0))->row();
                        //check sales officer distribution
                        $data_sales_officer_distribution = $this->db->get_where('tbl_sales_officer_distribution', array('channel_id' => $dl->channel_id))->row();

                        if (empty($data_sales_officer_distribution)) {
                            $data_insert_sales_officer_distribution = array(
                                'sales_officer_id' => $data_sales_officer->sales_officer_id,
                                'channel_id' => $dl->channel_id,
                                'kota_id' => $dl->lead_city,
                            );

                            $this->db->insert('tbl_sales_officer_distribution', $data_insert_sales_officer_distribution);

                            $data_update_sales_officer_group = array('is_gifted' => 1);
                            $this->db->where('sales_officer_id', $data_sales_officer->sales_officer_id);
                            $this->db->update('tbl_sales_officer_group', $data_update_sales_officer_group);

                            //update lead
                            $this->db->where('lead_id', $dl->lead_id);
                            $update = $this->db->update('tbl_lead', array('sales_officer_id' => $data_sales_officer->sales_officer_id));

                            if ($update) {
                                if ($dl->note != '') {

                                    //insert tbl lead history
                                    $data_insert_history = array(
                                        'lead_id' => $dl->lead_id,
                                        'status_id' => $dl->status_id,
                                        'category_id' => $dl->lead_category_id,
                                        'notes' => $dl->note,
                                        'sales_officer_id' => $data_sales_officer->sales_officer_id,
                                        'point' => 0
                                    );

                                    $insert_history = $this->db->insert('tbl_lead_history', $data_insert_history);

                                    if ($insert_history) {
                                        echo "success";
                                    } else {
                                        echo "error";
                                    }
                                }
                            }
                        } else {

                            $this->db->select('a.*');
                            $this->db->order_by('a.sales_officer_group_id', 'asc');
                            $this->db->where('b.status', 1);
                            $this->db->where('a.sales_team_id', $data_sales_team_channel->sales_team_id);
                            $this->db->where('a.is_gifted', 0);
                            $this->db->join('tbl_sales_officer b', 'a.sales_officer_id = b.sales_officer_id');
                            $data_sales_officer = $this->db->get('tbl_sales_officer_group a')->row();

//                            $this->db->order_by('sales_officer_group_id', 'asc');
//                            //$this->db->where('sales_officer_id >', $data_sales_officer_distribution->sales_officer_id);
//                            $data_sales_officer = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $data_sales_team_channel->sales_team_id, 'is_gifted' => 0))->row();

                            if (!empty($data_sales_officer)) {
                                $data_update_sales_offier_distribution = array('sales_officer_id' => $data_sales_officer->sales_officer_id);
                                $this->db->where('channel_id', $dl->channel_id);
                                $this->db->update('tbl_sales_officer_distribution', $data_update_sales_offier_distribution);

                                $data_update_sales_officer_group = array('is_gifted' => 1);
                                $this->db->where('sales_officer_id', $data_sales_officer->sales_officer_id);
                                $this->db->update('tbl_sales_officer_group', $data_update_sales_officer_group);

                                //update lead
                                $this->db->where('lead_id', $dl->lead_id);
                                $update = $this->db->update('tbl_lead', array('sales_officer_id' => $data_sales_officer->sales_officer_id));

                                if ($update) {
                                    if ($dl->note != '') {

                                        //insert tbl lead history
                                        $data_insert_history = array(
                                            'lead_id' => $dl->lead_id,
                                            'status_id' => $dl->status_id,
                                            'category_id' => $dl->lead_category_id,
                                            'notes' => $dl->note,
                                            'sales_officer_id' => $data_sales_officer->sales_officer_id,
                                            'point' => 0
                                        );

                                        $insert_history = $this->db->insert('tbl_lead_history', $data_insert_history);

                                        if ($insert_history) {
                                            echo "success";
                                        } else {
                                            echo "error";
                                        }
                                    }
                                }
                            } else {
                                $data_update_sales_officer_group = array('is_gifted' => 0);
                                $this->db->where('sales_team_id', $data_sales_team_channel->sales_team_id);
                                $this->db->update('tbl_sales_officer_group', $data_update_sales_officer_group);

                                $this->db->select('a.*');
                                $this->db->order_by('a.sales_officer_group_id', 'asc');
                                $this->db->where('b.status', 1);
                                $this->db->where('a.sales_team_id', $data_sales_team_channel->sales_team_id);
                                $this->db->where('a.is_gifted', 0);
                                $this->db->join('tbl_sales_officer b', 'a.sales_officer_id = b.sales_officer_id');
                                $data_sales_officer = $this->db->get('tbl_sales_officer_group a')->row();

//                                $this->db->order_by('sales_officer_group_id', 'asc');
//                                //$this->db->where('sales_officer_id >', $data_sales_officer_distribution->sales_officer_id);
//                                $data_sales_officer = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $data_sales_team_channel->sales_team_id, 'is_gifted' => 0))->row();

                                $data_update_sales_offier_distribution = array('sales_officer_id' => $data_sales_officer->sales_officer_id);
                                $this->db->where('channel_id', $dl->channel_id);
                                $this->db->update('tbl_sales_officer_distribution', $data_update_sales_offier_distribution);

                                $data_update_sales_officer_group = array('is_gifted' => 1);
                                $this->db->where('sales_officer_id', $data_sales_officer->sales_officer_id);
                                $this->db->update('tbl_sales_officer_group', $data_update_sales_officer_group);

                                //update lead
                                $this->db->where('lead_id', $dl->lead_id);
                                $update = $this->db->update('tbl_lead', array('sales_officer_id' => $data_sales_officer->sales_officer_id));

                                if ($update) {
                                    if ($dl->note != '') {

                                        //insert tbl lead history
                                        $data_insert_history = array(
                                            'lead_id' => $dl->lead_id,
                                            'status_id' => $dl->status_id,
                                            'category_id' => $dl->lead_category_id,
                                            'notes' => $dl->note,
                                            'sales_officer_id' => $data_sales_officer->sales_officer_id,
                                            'point' => 0
                                        );

                                        $insert_history = $this->db->insert('tbl_lead_history', $data_insert_history);

                                        if ($insert_history) {
                                            echo "success";
                                        } else {
                                            echo "error";
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $data_update_lead = array('sales_officer_id' => 1);
                    $this->db->where('lead_id', $dl->lead_id);

                    $update = $this->db->update('tbl_lead', $data_update_lead);
                }
            }
        } else {
            $data_update_lead = array('sales_officer_id' => 1);
            $this->db->where_not_in('lead_id', $list_lead);

            $update = $this->db->update('tbl_lead', $data_update_lead);
//            $data_lead = $this->db->get_where('tbl_lead', array('sales_officer_id' => 0))->result();
            echo 'nothing new leads';
            exit;
        }
    }

    public function follow_up()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $post = $this->input->post();

        $lead_id = addslashes($post['lead_id']);
        $sales_officer_id = addslashes($post['sales_officer_id']);
        $lead_category_id = addslashes($post['lead_category_id']);
        $status_id = strtolower($post['status_id']);
        $product_id = $post['product_id'];
        $notes = $post['lead_notes'];

        //get data sales officer
        //$data_sales_officer = $this->db->get_where('tbl_sales_officer', array('sales_officer_id' => $sales_officer_id))->row();
        //sales officer last point
        //$sales_officer_last_point = floatval($data_sales_officer->point);
        //get old point
        $this->db->order_by('lead_history_id', 'DESC');
        $last_point = $this->db->get_where('tbl_lead_history', array('lead_id' => $lead_id, 'sales_officer_id' => $sales_officer_id))->row('point');

        $calc_point = -1 * intval($last_point);

        //get point
        $data_point = $this->db->get_where('tbl_status', array('id' => $status_id))->row();
        $point = floatval($data_point->point);

        //insert lead history
        $data_insert_lead_history = array(
            'lead_id' => $lead_id,
            'status_id' => $status_id,
            'category_id' => $lead_category_id,
            'notes' => $notes,
            'sales_officer_id' => $sales_officer_id,
            'point' => $point,
        );

        $insert_lead_history = $this->db->insert('tbl_lead_history', $data_insert_lead_history);

        if ($insert_lead_history) {
            $data_insert_sales_officer_activity = array(
                'sales_officer_id' => $sales_officer_id,
                'lead_id' => $lead_id,
                'point' => $point,
            );

            $insert_sales_officer_activity = $this->db->insert('tbl_sales_officer_activity', $data_insert_sales_officer_activity);

            if ($insert_sales_officer_activity) {
                $data_update_lead = array('status_id' => $status_id, 'lead_category_id' => $lead_category_id, 'product_id' => $product_id);

                $this->db->where('lead_id', $lead_id);
                $update_lead = $this->db->update('tbl_lead', $data_update_lead);

                if ($update_lead) {
                    $query_update_agent = "UPDATE tbl_sales_officer SET point=point + $calc_point + $point WHERE sales_officer_id= $sales_officer_id";
                    //$this->db->set('point', 'point + ' . $calc_point , FALSE);
                    //$this->db->where('sales_officer_id', $sales_officer_id);
                    $update_agent = $this->db->query($query_update_agent);

                    if ($update_agent) {
                        $data = array(
                            'res' => 200,
                            'redirect' => base_url(),
                        );
                    }
                }
            }
        } else {
            $data = array(
                'res' => 400,
                'redirect' => base_url(),
            );
        }

        echo json_encode($data);
    }

    public function getDataFollowUpLead()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $id = $this->input->get('id');

        $data_lead = $this->db->get_where('tbl_lead', array('lead_id' => $id))->row();

        $data = array(
            'res' => 200,
            'data' => $data_lead,
        );

        echo json_encode($data);
    }

    public function getDataHistoryLead()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $id = $this->input->get('id');
        $html = '';

        $this->db->order_by('a.create_date', 'desc');
        $this->db->where('a.lead_id', $id);
        $this->db->select("a.*, CONVERT_TZ(a.create_date, '+00:00', '+07:00') as create_date, b.category_name, b.icon, b.color, d.status_name");
        $this->db->join('tbl_status d', 'a.status_id = d.id ');
        $this->db->join('tbl_lead_category b', 'a.category_id = b.lead_category_id');
        $data_history_lead = $this->db->get_where('tbl_lead_history a', array('a.lead_id' => $id))->result();

        foreach ($data_history_lead as $key => $dlh) {
            $num = $key + 1;
            $html .= '<div class="timeline-item">
                            <div class="timeline-badge">
                                <span class="badge badge-roundless badge-success">' . $num . '</span>
                            </div>
                            <div class="timeline-body">
                                <div class="timeline-body-arrow"> </div>
                                <div class="timeline-body-head">
                                    <div class="timeline-body-head-caption">
                                        <a href="javascript:;" class="timeline-body-title font-blue-madison">' . $dlh->status_name . '</a>
                                        <span class="timeline-body-time font-grey-cascade">Called at ' . $dlh->create_date . ' </span>
                                    </div>
                                    <div class="timeline-body-head-actions">    
                                        <label class="label label-md label-' . $dlh->color . '"> <span class="icon ' . $dlh->icon . '"></span>&nbsp;' . $dlh->category_name . '</label>
                                    </div>
                                </div>
                                <div class="timeline-body-content">
                                    <span class="font-grey-cascade"> ' . $dlh->notes . ' </span>  
                                </div>
                            </div>
                        </div>';
        }

        $data = array(
            'res' => 200,
            'data' => $html,
        );

        echo json_encode($data);
    }

    public function getDataTotalLead()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $get = $this->input->get();

        $session_dashboard = $this->session->userdata('dashboard');
        $from_date = $session_dashboard['from'];
        $to_date = $session_dashboard['to'];

        $project_id = $session_dashboard['project_id'];
        $category_id_1 = $session_dashboard['category_id_1'];
        $category_id_2 = $session_dashboard['category_id_2'];
        $time_period = $get['period'];

        $data_lead = $this->LeadModels->getDataChartTotalLead($project_id, $from_date, $to_date, $category_id_1, $category_id_2, $time_period);

        echo json_encode($data_lead);
    }

    public function index()
    {
        $role = $this->MainModels->UserSession('role_id');
        $datatable_assets = $this->MainModels->getAssets('datatable');
        $daterangepicker_assets = $this->MainModels->getAssets('daterangepicker');
        $lead_assets = $this->MainModels->getAssets('leads');
        $lead_in_assets = $this->MainModels->getAssets('leads_in');
        $get = $this->input->get();


        $session_dashboard = $this->session->userdata('dashboard');


        $js = array_merge($datatable_assets['js'], $lead_assets['js'], $daterangepicker_assets['js'], $lead_in_assets['js']);
        $css = array_merge($datatable_assets['css'], $daterangepicker_assets['css']);

        if ($role == 1) {
            $data_lead = '';
            $data_campaign = $this->db->get('tbl_campaign')->result();
            $data_channel = '';

            $data_project = '';
        } else if ($role == 2) {


            $client_id = $this->MainModels->getClientId();

            //data filter

//            $data_project = $this->ProjectModels->getDataProjectbyClientIdNonSession();
            $data_campaign = $this->CampaignModels->getDataCampaignbyClientIdNonSession();
            $data_channel = $this->ChannelModels->getDataChannelbyClientId();
            $data_category = $this->db->get('tbl_lead_category')->result();
            $data_sales_officer = $this->SalesOfficerModels->getDataSalesOfficerbyClientId();


            $data_sales_team = $this->TeamModels->getDataSalesTeambyClientId($client_id);

            //get status
            $data_status = $this->StatusModels->getStatusAll();

            if (isset($get['from'])) {
                $from = $get['from'];
            } else {
                $from = $session_dashboard['from'];
            }

            if (isset($get['to'])) {
                $to = $get['to'];
            } else {
                $to = $session_dashboard['to'];
            }

            if (isset($get['lead_category_id'])) {
                $category_id = $get['lead_category_id'];
            } else {
                $category_id = 0;
            }

            if (isset($get['status_id'])) {
                $status_id = $get['status_id'];
            } else {
                $status_id = 0;
            }

            if (isset($get['sales_team_id'])) {
                $sales_team_id = $get['sales_team_id'];
            } else {
                $sales_team_id = 0;
            }

            if (isset($get['campaign_id'])) {
                $campaign_id = $get['campaign_id'];
            } else {
                $campaign_id = 0;
            }

            if (isset($get['sales_officer_id'])) {
                $sales_officer_id = $get['sales_officer_id'];
            } else {
                $sales_officer_id = 0;
            }

            if (isset($get['channel_id'])) {
                $channel_id = $get['channel_id'];
            } else {
                $channel_id = 0;
            }

            $data_lead = $this->LeadModels->getCountLeadbyClientIdLeadIndex($from, $to, $sales_team_id, $sales_officer_id, $campaign_id, $channel_id, $category_id, $status_id);
        } else if ($role == 3) {
            $data_project = $this->ProjectModels->getDataProjectbyClientIdNonSession();
            $data_campaign = $this->CampaignModels->getDataCampaignbyClientIdNonSession();
            $data_channel = $this->ChannelModels->getDataChannelbyClientId();
            $data_category = $this->db->get('tbl_lead_category')->result();
            $sales_team_id = $this->MainModels->getSalesTeamId();
            $data_status = $this->StatusModels->getStatusAll();

            $data_sales_officer = $this->SalesOfficerModels->getDataSalesOfficerbySalesTeamId($sales_team_id);

            if (isset($get['from'])) {
                $from = $get['from'];
            } else {
                $from = $session_dashboard['from'];
            }

            if (isset($get['to'])) {
                $to = $get['to'];
            } else {
                $to = $session_dashboard['to'];
            }

            if (isset($get['lead_category_id'])) {
                $category_id = $get['lead_category_id'];
            } else {
                $category_id = 0;
            }

            if (isset($get['status_id'])) {
                $status_id = $get['status_id'];
            } else {
                $status_id = 0;
            }


            if (isset($get['campaign_id'])) {
                $campaign_id = $get['campaign_id'];
            } else {
                $campaign_id = 0;
            }

            if (isset($get['sales_officer_id'])) {
                $sales_officer_id = $get['sales_officer_id'];
            } else {
                $sales_officer_id = 0;
            }

            if (isset($get['channel_id'])) {
                $channel_id = $get['channel_id'];
            } else {
                $channel_id = 0;
            }

            $data_lead = $this->LeadModels->getCountLeadbyClientIdLeadIndex($from, $to, $sales_team_id, $sales_officer_id, $campaign_id, $channel_id, $category_id, $status_id);
        }

        $data = array(
            'data_lead' => $data_lead,
            'data_campaign' => $data_campaign,
            'data_channel' => $data_channel,
            'data_lead_category' => $data_category,
            'data_status' => $data_status,
            'data_sales_officer' => $data_sales_officer,
            'data_sales_team' => $data_sales_team,
            'channel_id' => $channel_id,
            'campaign_id' => $campaign_id,
            'category_id' => $category_id,
            'status_id' => $status_id,
            'sales_team_id' => $sales_team_id,
            'sales_officer_id' => $sales_officer_id,
            'from' => $from,
            'to' => $to,
            'js' => $js,
            'css' => $css,
            'total' => count($data_lead),
        );

        $this->template->load('template__', 'leads/index', $data);
    }

    public function send_notif()
    {
        //get data sales officer registered
        $this->db->where('sales_officer_deviceid <>', '');
        $data_sales_officer = $this->db->get('tbl_sales_officer')->result();

        $this->load->model('CampaignModels');

        if (!empty($data_sales_officer)) {
            foreach ($data_sales_officer as $key => $dso) {
                //get data campaign by sales officer
                $data_campaign = $this->CampaignModels->getCampaignBySalesOfficerId($dso->sales_officer_id);

                foreach ($data_campaign as $dc) {
                    $data_new_lead = $this->LeadModels->getDataLeadByCampaignIdApiUnseen($dc['campaign_id'], 1, $dso->sales_officer_id);
                    $total = count($data_new_lead);

                    if ($total != 0) {
                        //get data notification
                        $data_notification = $this->db->get_where('tbl_notification', array('sales_officer_id' => $dso->sales_officer_id, 'campaign_id' => $dc['campaign_id']))->row();

                        if (empty($data_notification)) {
                            $msg = 'There is ' . $total . ' new leads from  (' . $dc['campaign_name'] . ')';
                            $data_insert_notification = array(
                                'sales_officer_id' => $dso->sales_officer_id,
                                'campaign_id' => $dc['campaign_id'],
                                'message' => $msg,
                                'type' => 1,
                                'is_read' => 0,
                                'lead_count' => $total,
                            );

                            $insert_notification = $this->db->insert('tbl_notification', $data_insert_notification);

                            if ($insert_notification) {
                                $notif_id = $this->db->insert_id();
                                $send = $this->sendNotification($dso->sales_officer_id, $dso->sales_officer_deviceid, $msg, 1, $notif_id, $dc['campaign_id'], $dc['campaign_name'], 0);

                                if ($send->success != 0) {
                                    $data_update_notif = array('is_sent' => 1);
                                    $this->db->where('notification_id', $notif_id);
                                    $this->db->update('tbl_notification', $data_update_notif);
                                } else {
                                    echo '<pre>';
                                    print_r($send);
                                    echo '</pre>';
                                }
                            }
                        } else {
                            $notification_id = $data_notification->notification_id;
                            $lead_count = $data_notification->lead_count;

                            if ($total != $lead_count) {
                                $msg = 'There is ' . $total . ' new leads from  (' . $dc['campaign_name'] . ')';
                                $data_update = array(
                                    'lead_count' => $total,
                                    'message' => $msg,
                                    'is_read' => 0,
                                );

                                $this->db->where('notification_id', $notification_id);
                                $update = $this->db->update('tbl_notification', $data_update);

                                if ($update) {
                                    $send = $this->sendNotification($dso->sales_officer_id, $dso->sales_officer_deviceid, $msg, 1, $notification_id, $dc['campaign_id'], $dc['campaign_name'], 0);

                                    if ($send->success != 0) {
                                        $data_update_notif = array('is_sent' => 1);
                                        $this->db->where('notification_id', $notification_id);
                                        $this->db->update('tbl_notification', $data_update_notif);
                                    } else {
                                        echo '<pre>';
                                        print_r($send);
                                        echo '</pre>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function test_not()
    {
        $send = $this->sendNotification('coAevJRz4Gw:APA91bGnAujG8VDCU1vWR6gjdYPrNKkPwnG-0hM1W5RcUiXE7Ibz5wZmXSVvmpl-1PSP-DkvOO4mR7gNPoBsZrbPMLfFYXCu0_vl8F1Kbc2tub_whzsx6U6qUMzA1K7TdrgBWc900TP6', 'TEST', 1, '123', '10', 'JANCOK');

        print_r($send->success);
        exit;
    }

    public function sendNotification($sales_officer_id, $device_id, $message, $notif_type, $notif_id, $campaign_id, $campaign_name, $lead_id)
    {
        // API access key from Google API's Console
        //$send = $this->sendNotification($device_id, $message, $notif_type, $notif_id, $campaign_id, $campaign_name);

        $key = 'AAAAIBosPbk:APA91bGTWNb4J4_cSA6hR1zb_rDAIRAP3NcckBkzBOqc5NTRpn1CW5WTKXWrZVBm58v5_bm4AsVNjWb69u5nyKHadV-b8M9EkHXQWJviIFsGUnP09C8pG09hhpUKzhW27Usjzqii-Jm8';

        $notification = array(
            'body' => $message,
            'content_available' => true,
            'priority' => 'high',
            'title' => 'New Leads',
            'click_action' => 'FCM_PLUGIN_ACTIVITY',
        );

        $registrationIds = $device_id;
        // prep the bundle
        $msg = array(
            'body' => $message,
            'title' => 'Jala',
            'subtitle' => 'New Lead Notification',
            'tickerText' => 'New Lead Notification',
            'vibrate' => true,
            'sound' => true,
            'campaign_id' => $campaign_id,
            'sales_officer_id' => $sales_officer_id,
            'campaign_name' => $campaign_name,
            'notif_type' => $notif_type,
            'notif_id' => $notif_id,
            'lead_id' => $lead_id
        );
        $fields = array(
            'to' => $registrationIds,
            'notification' => $notification,
            'data' => $msg,
        );

        $headers = array(
            'Authorization: key=' . $key,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        $json = json_decode($result);
        curl_close($ch);

        return $json;
    }

    public function excel()
    {

        $get = $this->input->get();
        $role_id = $this->MainModels->UserSession('role_id');

        //get data lead
        $data_lead = $this->LeadModels->getLeadByProjectExcel($get);

        $data = array(
            'data_lead' => $data_lead,
            'title' => 'Leads ' . $get['to'],
        );

        $this->load->view('leads/lead_excel', $data);
    }

    public function getTotalLeadOfflineOnline()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $data_lead_offline = $this->LeadModels->getDataOnlineOffline($this->session->userdata('dashboard'));

        echo json_encode($data_lead_offline);
    }

    public function getLeadPerformanceCampaign()
    {

    }

    public function leadHistory()
    {
        $id = $this->input->get('id');
        $html = '';

        $this->db->order_by('a.create_date', 'desc');
        $this->db->where('a.lead_id', $id);
        $this->db->select("a.*, CONVERT_TZ(a.create_date, '+00:00', '+07:00') as create_date, b.category_name, b.icon, b.color, d.status_name");
        $this->db->join('tbl_status d', 'a.status_id = d.id ');
        $this->db->join('tbl_lead_category b', 'a.category_id = b.lead_category_id');
        $data_history_lead = $this->db->get_where('tbl_lead_history a', array('a.lead_id' => $id))->result();

        foreach ($data_history_lead as $key => $dlh) {
            $num = $key + 1;
            $html .= '<div class="timeline-item">
                            <div class="timeline-badge">
                                <span class="badge badge-roundless badge-success">' . $num . '</span>
                            </div>
                            <div class="timeline-body">
                                <div class="timeline-body-arrow"> </div>
                                <div class="timeline-body-head">
                                    <div class="timeline-body-head-caption">
                                        <a href="javascript:;" class="timeline-body-title font-blue-madison">' . $dlh->status_name . '</a>
                                        <span class="timeline-body-time font-grey-cascade">Called at ' . $dlh->create_date . ' </span>
                                    </div>
                                    <div class="timeline-body-head-actions">    
                                        <label class="label label-md label-' . $dlh->color . '"> <span class="icon ' . $dlh->icon . '"></span>&nbsp;' . $dlh->category_name . '</label>
                                    </div>
                                </div>
                                <div class="timeline-body-content">
                                    <span class="font-grey-cascade"> ' . $dlh->notes . ' </span>  
                                </div>
                            </div>
                        </div>';
        }

        $data = array(
            'res' => 200,
            'data' => $html,
        );

        $this->template->load('template__', 'leads/history_new', $data);
    }


    public function getLead()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        //define variable from get
        $client_id = $this->input->get('client_id');
        $from = $this->input->get('from');
        $to = $this->input->get('to');

        if ($client_id == 35) {
            //get channel by client id
            $this->db->select('d.id as channel_id');
            $this->db->join('tbl_project b', 'a.client_id = b.client_id');
            $this->db->join('tbl_campaign c', 'b.id = c.project_id');
            $this->db->join('tbl_channel d', 'c.id = d.campaign_id');
            $data_channel = $this->db->get_where('tbl_client a', array('a.client_id' => $client_id))->result();

            //store into array

            $channel = array();
            if (!empty($data_channel)) {
                foreach ($data_channel as $dc) {
                    array_push($channel, $dc->channel_id);
                }

                $this->db->order_by('a.create_date', 'desc');

                $this->db->where('a.update_date >=', $from . ' 00:00:00');
                $this->db->where('a.update_date <=', $to . ' 23:59:59');
                $this->db->where_in('a.channel_id', $channel);
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

                if (!empty($data_lead)) {
                    $data = array('message' => 'success grab lead', 'status' => 200, 'data' => array($data_lead));
                } else {
                    $data = array('message' => 'lead is empty or check you params', 'status' => 200, 'data' => array());
                }
            } else {

            }
        } else {
            $data = array('message' => 'not autorizhed', 'status' => 505, 'data' => array());
        }

        echo json_encode($data);
    }


}
