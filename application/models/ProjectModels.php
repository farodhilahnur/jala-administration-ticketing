<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProjectModels extends CI_Model {

    public function editProject($post) {

        $data_edit = array('project_name' => $post['project_name'], 'project_detail' => $post['project_detail'], 'status' => $post['status']);
        $this->db->where('id', $post['project_id']);
        $update = $this->db->update('tbl_project', $data_edit);

        if ($update) {
            
            $this->MainModels->insert_log('Project Edited By ', 1, $post['project_id']);
            
            $res = 200;   
            $message = '<p class="alert alert-success"> Success edit project  !!!  </p>';
        } else {
            $res = 400;
            $message = '<p class="alert alert-danger"> Error edit project  !!!  </p>';
        }

        $data = array('res' => $res, 'message' => $message);
        return $data;
    }

    public function getDataProjectbyClientId($session_dashboard) {

        $project_id = $session_dashboard['project_id'];
        $client_id = $this->MainModels->getClientId();

        if ($project_id == 0) {
            $data_project = $this->db->get_where('tbl_project', array('client_id' => $client_id))->result();
        } else {
            $data_project = $this->db->get_where('tbl_project', array('id' => $project_id))->result();
        }

        return $data_project;
    }
    
    public function getDataProjectbyClientAdminId($session_dashboard) {

        $project_id = $session_dashboard['project_id'];
        $client_id = $this->MainModels->UserSession('user_id');
        $user_id = $this->MainModels->UserSession('user_id');
        $project_id_admin = $this->db->get_where('tbl_client_admin', array('user_id' => $user_id))->row('project_id');

        if ($project_id_admin == 0) {
            $data_project = $this->db->get_where('tbl_project', array('client_id' => $client_id))->result();
        } else {
            $data_project = $this->db->get_where('tbl_project', array('id' => $project_id_admin))->result();
        }

        return $data_project;
    }

    public function getDataProjectReportbyClientId($client_id) {


        $data_project = $this->db->get_where('tbl_project', array('client_id' => $client_id))->result();

        return $data_project;
    }
   
    public function getDataProjectbyClientIdNonSession() {

        $client_id = $this->MainModels->getClientId();

        $this->db->select('id, project_name, project_detail, status, DATE_FORMAT(create_at, \'%b %d, %Y\') as date');
        $data_project = $this->db->get_where('tbl_project', array('client_id' => $client_id))->result();

        if (!empty($data_project)) {
            $data = $data_project;
        } else {
            $data = array();
        }

        return $data;
    }
    public function produklocaliniyessii() {

        $user_id = $this->MainModels->UserSession('user_id');
        $client_id = $this->db->get_where('tbl_client_admin', array('user_id' => $user_id))->row('client_id');
        $project_id_admin = $this->db->get_where('tbl_client_admin', array('user_id' => $user_id))->row('project_id');

        $this->db->select('*,  DATE_FORMAT(create_at, \'%b %d, %Y\') as date'); //deklarasi date
        if ($project_id_admin == 0) {
            $data_project = $this->db->get_where('tbl_project', array('client_id' => $client_id))->result();
        } else {
            $data_project = $this->db->get_where('tbl_project', array('id' => $project_id_admin))->result();
        }

        return $data_project;
    }

    public function getStatusbyClientId($session_dashboard) {

        $list_project_id = array();
        $data_project = $this->getDataProjectbyClientId($session_dashboard);
        $from_date = $session_dashboard['from'];
        $to_date = $session_dashboard['to'];

        if (!empty($data_project)) {
            foreach ($data_project as $dp) {
                array_push($list_project_id, $dp->id);
            }

            //get status group by name 

            $this->db->order_by('id', 'asc');
            $this->db->where_in('project_id', $list_project_id);
            $this->db->group_by('status_name');
            $data_status = $this->db->get('tbl_status')->result();

            $list_status_name = array();

            if (!empty($data_status)) {
                foreach ($data_status as $ds) {
                    array_push($list_status_name, $ds->status_name);
                }

                if ($session_dashboard['project_id'] == 0) {
                    $data_channel = $this->ChannelModels->getDataChannelbyClientIdNonSession();
                } else {
                    $data_channel = $this->ChannelModels->getDataChannelbyProjectId2($session_dashboard['project_id']);
                }

                if (!empty($data_channel)) {

                    $list_channel_id = array();

                    foreach ($data_channel as $channel) {
                        array_push($list_channel_id, $channel->id);
                    }

                    $jum = count($this->LeadModels->getCountLeadbyClientId());

                    $this->db->order_by('b.id', 'asc');
                    $this->db->where_in('a.channel_id', $list_channel_id);
                    $this->db->where_in('b.status_name', $list_status_name);
                    $this->db->where('a.update_date >=', $from_date . ' 00:00:00');
                    $this->db->where('a.update_date <=', $to_date . ' 23:59:59');
                    $this->db->select('b.status_name, count(a.lead_id) as total, b.id as status_id');
                    $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                    $this->db->join('tbl_status b', 'a.status_id = b.id');
                    $this->db->group_by('b.status_name');
                    $data_lead = $this->db->get('tbl_lead a')->result();

                    $data_chart = array();

                    if (!empty($data_lead)) {
                        foreach ($data_lead as $dl) {

                            $percent = round(intval($dl->total / intval($jum) * 100), 2);

                            $data_push = array('status_name' => $dl->status_name, 'total' => $dl->total, 'percent' => $percent, 'status_id' => $dl->status_id );

                            array_push($data_chart, $data_push);
                        }
                    } else {
                        $data_chart = array();
                    }
                } else {
                    $data_chart = array();
                }
            } else {
                $data_chart = array();
            }
        } else {
            $data_chart = array();
        }


        return $data_chart;
    }

    public function getProjectbySalesTeamId($sales_team_id) {

        //get sales team participated in channel
        $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel', array('sales_team_id' => $sales_team_id))->result();

        $list_channel = array();

        if (!empty($data_sales_team_channel)) {
            foreach ($data_sales_team_channel as $dstc) {
                array_push($list_channel, $dstc->channel_id);
            }

            //get data campaign by channel id
            $this->db->where_in('id', $list_channel);
            $this->db->select('campaign_id');
            $this->db->distinct();
            $data_campaign = $this->db->get('tbl_channel')->result();

            $list_campaign = array();
            if (!empty($data_campaign)) {
                foreach ($data_campaign as $dc) {
                    array_push($list_campaign, $dc->campaign_id);
                }

                //get data project by campaign id
                $this->db->where_in('id', $list_campaign);
                $this->db->select('project_id');
                $this->db->distinct();
                $data_project = $this->db->get('tbl_campaign')->result();

                $list_project = array();
                if (!empty($data_project)) {
                    foreach ($data_project as $dp) {
                        array_push($list_project, $dp->project_id);
                    }

                    //get data project
                    $this->db->where_in('id', $list_project);
                    $data = $this->db->get('tbl_project')->result();
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

    public function getDataProjectStatisticsbySalesTeamId($sales_team_id) {
        //get sales team participated in channel

        $session_filter = $this->session->userdata('dashboard');
        $project_id = $session_filter['project_id'];

        $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel', array('sales_team_id' => $sales_team_id))->result();

        $list_channel = array();

        if (!empty($data_sales_team_channel)) {
            foreach ($data_sales_team_channel as $dstc) {
                array_push($list_channel, $dstc->channel_id);
            }

            //get data campaign by channel id
            $this->db->where_in('id', $list_channel);
            $this->db->select('campaign_id');
            $this->db->distinct();
            $data_campaign = $this->db->get('tbl_channel')->result();

            $list_campaign = array();
            if (!empty($data_campaign)) {
                foreach ($data_campaign as $dc) {
                    array_push($list_campaign, $dc->campaign_id);
                }

                //get data project by campaign id
                $this->db->where_in('id', $list_campaign);
                $this->db->select('project_id');
                $this->db->distinct();
                $data_project = $this->db->get('tbl_campaign')->result();

                $list_project = array();
                if (!empty($data_project)) {
                    foreach ($data_project as $dp) {
                        array_push($list_project, $dp->project_id);
                    }

                    //get data project

                    if ($project_id == 0) {
                        $this->db->where_in('id', $list_project);
                    } else {
                        $this->db->where('id', $project_id);
                    }

                    $data = $this->db->get('tbl_project')->result();
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

}
