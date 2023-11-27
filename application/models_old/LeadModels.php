<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LeadModels extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->model('ChannelModels');
        $this->load->model('ProjectModels');
        $this->load->model('CampaignModels');
        $this->load->model('TeamModels');
        $this->load->model('StatusModels');
    }

    public function getCountLeadbyClientId() {

        $data_channel = $this->ChannelModels->getDataChannelbyClientId();

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

    public function getCountLeadbyClientIdNonSession() {

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

    public function getCountLeadbyClientIdLeadIndex($sales_team_id, $sales_officer_id, $campaign_id, $channel_id) {

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

    public function getCountLeadsbyChannelId($id) {

        $data_lead = $this->db->get_where('tbl_lead', array('channel_id' => $id))->result();

        return count($data_lead);
    }

    public function getCountLeadsbySalesOfficerId($id) {
        $data_lead = $this->db->get_where('tbl_lead', array('sales_officer_id' => $id))->result();

        return count($data_lead);
    }

    public function getDataLeadByProject($project_id, $session_filter, $session_search) {

        $campaign_id = $session_filter['campaign_id'];
        $date = explode(' to ', $session_filter['date_range']);
        $project_date = $date[0];
        $now_date = $date[1];

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

    public function getDataCountLeadByProject($project_id, $session_filter) {

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
        $this->db->where('create_date >=', $project_date . ' 00:00:00');
        $this->db->where('create_date <=', $now_date . ' 23:59:59');

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

    public function getDataLeadbyCampaignId($id) {

        $role = $this->MainModels->UserSession('role_id');
        $user_id = $this->MainModels->UserSession('user_id');

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
                $this->db->where_in('channel_id', $list_channel);
                $data_lead = $this->db->get('tbl_lead')->result();
            } else {
                $list_sales_officer_id = array();
                $data_sales_officer = $this->TeamModels->getDataSalesOfficerBySalesTeamId($user_id_role);

                if (!empty($data_sales_officer)) {
                    foreach ($data_sales_officer as $dso) {
                        array_push($list_sales_officer_id, $dso->sales_officer_id);
                    }

                    $this->db->where_in('sales_officer_id', $list_sales_officer_id);
                }
                $this->db->where_in('channel_id', $list_channel);
                $data_lead = $this->db->get('tbl_lead')->result();
            }
        } else {
            $data_lead = array();
        }



        return $data_lead;
    }

    public function getLeadByChannelId($channel_id) {

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

    public function getDataLeadByCategorybyProjectId($projectId) {

        $session_filter = $this->session->userdata('filter');
        $session_search = $this->session->userdata('search');

        $campaign_id = $session_filter['campaign_id'];
        $date = explode(' to ', $session_filter['date_range']);
        $project_date = $date[0];
        $now_date = $date[1];

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

    public function getDataLeadByChannelbyProjectIdSalesTeamId($projectId, $sales_team_id) {

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

    public function getDataLeadByChannelbyProjectId($projectId) {

        $session_filter = $this->session->userdata('filter');
        $session_search = $this->session->userdata('search');

        $campaign_id = $session_filter['campaign_id'];
        $date = explode(' to ', $session_filter['date_range']);
        $project_date = $date[0];
        $now_date = $date[1];

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
                'channel_name' => $dch->channel_name,
                'channel_id' => $dch->channel_id,
                'total' => $data_lead_by_channel->total,
                'percent' => $percent
            );

            array_push($data_chart, $data);
        }

        return $data_chart;
    }

    public function getDataLeadByCampaignbyProjectId($projectId) {
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
                $this->db->where('a.create_date >=', $project_date . ' 00:00:00');
                $this->db->where('a.create_date <=', $now_date . ' 23:59:59');
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

    public function getDataLeadBySalesTeam($list_sales_team_id) {

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

    public function getDataLeadBySalesTeamIdCategory($sales_team_id) {

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

    public function getDataLeadBySalesOfficerIdCategory($sales_officer_id) {

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

    public function getDataLeadByCampaignIdCategory($campaign_id) {

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

                        $data_push = array('total' => $count_lead, 'percent' => $percent, 'category_name' => $dc->category_name);
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

    public function getDataLeadByChannelIdCategory($channel_id) {

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

                        $data_push = array('total' => $count_lead, 'percent' => $percent, 'category_name' => $dc->category_name);
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

    public function getDataLeadBySalesTeamId($sales_team_id) {

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

    public function getDataLeadBySalesOfficer($list_sales_officer_id) {

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

    public function getDataLeadBySalesOfficerNonSession($list_sales_officer_id) {

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

    public function getDataChartTotalLead($project_id, $from_date, $to_date, $category_id_1, $category_id_2, $time_period) {

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
            $time = "DATE_FORMAT(update_date,'%m-%Y')";
            $time_select = "DATE_FORMAT(update_date,'%M-%Y')";
        } else if ($time_period == 'DAY') {
            $time = "date(update_date)";
            $time_select = "DATE_FORMAT(update_date,'%d-%M')";
        } else {
            $time = 'YEAR(update_date)';
            $time_select = "YEAR(update_date)";
        }

        if ($project_id == 0) {
            $data_channel = $this->ChannelModels->getDataChannelbyClientId();
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

                        $this->db->where_in('sales_officer_id', $list_sales_officer_id);
                    }
                }

                $this->db->where_in('channel_id', $list_channel_id);
                if ($ct != 0) {
                    $this->db->where('lead_category_id', $ct);
                }
                $this->db->select("$time_select as name, count(lead_id) as value");
                $this->db->group_by("$time");
                if ($from_date != '') {
                    $this->db->where('create_date >', $from_date . ' 00:00:00');
                    $this->db->where('update_date <', $to_date . ' 23:59:59');
                }
                $data = $this->db->get('tbl_lead')->result();

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
                if ($ct != 0) {
                    $this->db->where('lead_category_id', $ct);
                }
                if ($from_date != '') {
                    $this->db->where('create_date >', $from_date . ' 00:00:00');
                    $this->db->where('update_date <', $to_date . ' 23:59:59');
                }
                $jumlah = $this->db->get('tbl_lead')->result();
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

    public function getLeadDashboard($project_id, $from_date, $to_date) {

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
            $this->db->order_by('create_date', 'desc');
            $this->db->where_in('channel_id', $list_channel_id);
            $this->db->where('create_date >=', $from_date . ' 00:00:00');
            $this->db->where('create_date <=', $to_date . ' 23:59:59');
            $data_leads = $this->db->get('tbl_lead')->result();
        } else {
            $data_leads = array();
        }

        return $data_leads;
    }

    public function getDataLeadByCategoryDashboard($session_dashboard) {

        $project_id = $session_dashboard['project_id'];
        $date = explode(' to ', $session_dashboard['date_range']);
        $from_date = $date[0];
        $to_date = $date[1];
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
                $this->db->where('a.create_date >=', $from_date . ' 00:00:00');
                $this->db->where('a.create_date <=', $to_date . ' 23:59:59');
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

    public function getDataLeadByCampaignIdApiUnseen($campaign_id, $category, $sales_officer_id) {

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

    public function getDataLeadByCampaignIdApi($campaign_id, $category, $sales_officer_id) {

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
            $this->db->where('sales_officer_id', $sales_officer_id);
            $data_lead = $this->db->get('tbl_lead')->result();
        } else {
            $data_lead = array();
        }

        return $data_lead;
    }

    public function getLeadsbyCampaignIdperCategory($campaign_id, $category, $sales_officer_id) {

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
            $data_lead = array();
        }

        return $data_lead;
    }

    public function getLeadsbyCampaignIdperCategoryFilter($campaign_id, $category, $sales_officer_id, $channel_id, $status_name, $period) {

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

        if ($channel_id != '') {
            $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $campaign_id, 'id' => $channel_id))->result();
        } else {
            $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $campaign_id))->result();
        }


        foreach ($data_channel as $dch) {
            array_push($list_channel_id, $dch->id);
        }

        if (!empty($list_channel_id)) {

            if ($status_name != '') {
                $this->db->where('d.status_name', $status_name);
            }

            if ($period != '') {
                if ($period == 'Today') {
                    $this->db->where('DAY(a.create_date)', $date_period);
                } else if ($period == 'This Week') {
                    $this->db->where('WEEK(a.create_date)', $date_period);
                } else if ($period == 'This Month') {
                    $this->db->where('MONTH(a.create_date)', $date_period);
                }
            }

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

    public function getDetailLead($lead_id) {

        $this->db->select('a.*, b.media_name, d.status_name, e.category_name, f.product_name');
        $this->db->join('tbl_channel c', 'c.id = a.channel_id', 'left');
        $this->db->join('tbl_media b', 'b.id = c.channel_media', 'left');
        $this->db->join('tbl_status d', 'a.status_id = d.id', 'left');
        $this->db->join('tbl_lead_category e', 'a.lead_category_id = e.lead_category_id', 'left');
        $this->db->join('tbl_product f', 'a.product_id = f.id', 'left');
        $data_lead = $this->db->get_where('tbl_lead a', array('a.lead_id' => $lead_id))->row();

        return $data_lead;
    }

    public function getHistorybyLeadId($lead_id) {

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

    public function getHistoryLead($lead_id) {
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

    public function getHistorybyCampaignId($campaign_id, $sales_officer_id) {
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

    public function getDataLeadbyChannelIdSalesOfficerId($channel_id, $sales_officer_id) {

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

    public function getDataLeadStatusbyCampaignIdbySalesOfficerId($campaign_id, $sales_officer_id) {

        $list_channel_id = array();
        //get channel by campaign id

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


        return $data_chart;
    }

    public function getDataLeadbyChannelIdSalesOfficerIdCategory($channel_id, $category, $sales_officer_id) {

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

    public function getDataLeadbyChannelIdSalesOfficerIdStatus($channel_id, $category, $sales_officer_id) {

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

    public function getDataLeadByProjectExcel($project_id, $campaign_id, $channel_id, $sales_team_id, $sales_officer_id, $from, $to) {

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

}
