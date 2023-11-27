<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProjectModels extends CI_Model {

    public function editProject($post) {

        $data_edit = array('project_name' => $post['project_name'], 'project_detail' => $post['project_detail'], 'status' => $post['status']);
        $this->db->where('id', $post['project_id']);
        $update = $this->db->update('tbl_project', $data_edit);

        if ($update) {
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

    public function getDataProjectbyClientIdNonSession() {

        $client_id = $this->MainModels->getClientId();

        $data_project = $this->db->get_where('tbl_project', array('client_id' => $client_id))->result();


        return $data_project;
    }

    public function getStatusbyClientId($session_dashboard) {

        $list_project_id = array();
        $data_project = $this->getDataProjectbyClientId($session_dashboard);

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

                $data_channel = $this->ChannelModels->getDataChannelbyClientIdNonSession();


                if (!empty($data_channel)) {
                    
                    $list_channel_id = array();
                    
                    foreach ($data_channel as $channel) {
                        array_push($list_channel_id, $channel->id);
                    }
                    
                    $jum = count($this->LeadModels->getCountLeadbyClientId());

                    $this->db->order_by('b.id', 'asc');
                    $this->db->where_in('a.channel_id', $list_channel_id);
                    $this->db->where_in('b.status_name', $list_status_name);
                    $this->db->select('b.status_name, count(a.lead_id) as total');
                    $this->db->join('tbl_status b', 'a.status_id = b.id');
                    $this->db->group_by('b.status_name');
                    $data_lead = $this->db->get('tbl_lead a')->result();

                    $data_chart = array();

                    if (!empty($data_lead)) {
                        foreach ($data_lead as $dl) {

                            $percent = round(intval($dl->total / intval($jum) * 100), 2);

                            $data_push = array('status_name' => $dl->status_name, 'total' => $dl->total, 'percent' => $percent);

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

}
