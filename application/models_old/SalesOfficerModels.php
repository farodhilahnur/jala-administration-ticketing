<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SalesOfficerModels extends CI_Model {

    public function getDataSalesOfficerUnreceivedbySalesTeamId($id) {
        $this->db->order_by('sales_officer_group_id', 'asc');
        $data_sales_officer = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $id, 'is_gifted' => 0))->row();

        return $data_sales_officer;
    }

    public function getSalesOfficerbyProjectId($project_id) {

        //get data campaign 
        $list_campaign_id = array();
        $data_campaign = $this->db->get_where('tbl_campaign', array('project_id' => $project_id, 'status' => 1))->result();


        foreach ($data_campaign as $dc) {
            array_push(($list_campaign_id), $dc->id);
        }

        if (!empty($list_campaign_id)) {
            //get data channel 
            $list_channel_id = array();
            $this->db->where_in('campaign_id', $list_campaign_id);
            $data_channel = $this->db->get_where('tbl_channel', array('status' => 1))->result();

            foreach ($data_channel as $dch) {
                array_push($list_channel_id, $dch->id);
            }

            if (!empty($list_channel_id)) {
                //get data sales team channel
                $list_sales_team_id = array();
                $this->db->where_in('channel_id', $list_channel_id);
                $data_sales_team = $this->db->get('tbl_sales_team_channel')->result();

                foreach ($data_sales_team as $dst) {
                    array_push($list_sales_team_id, $dst->sales_team_id);
                }

                //get data sales officer group by sales team id
                $list_sales_officer_id = array();
                $this->db->where_in('sales_team_id', $list_sales_team_id);
                $this->db->group_by('sales_officer_id');
                $data_sales_officer_group = $this->db->get('tbl_sales_officer_group')->result();

                foreach ($data_sales_officer_group as $dsog) {
                    array_push($list_sales_officer_id, $dsog->sales_officer_id);
                }

                //get data sales officer
                $this->db->where_in('sales_officer_id', $list_sales_officer_id);
                $data_sales_officer = $this->db->get_where('tbl_sales_officer', array('status' => 1))->result();
            } else {
                $data_sales_officer = array();
            }
        } else {
            $data_sales_officer = array();
        }


        return $data_sales_officer;
    }

    public function getDataSalesOfficerbyClientId() {

        $client_id = $this->MainModels->getClientId();

        $list_sales_team = array();
        $data_sales_team = $this->db->get_where('tbl_sales_team', array('client_id' => $client_id))->result();

        foreach ($data_sales_team as $dst) {
            array_push($list_sales_team, $dst->sales_team_id);
        }

        if (!empty($list_sales_team)) {
            $this->db->where_in('sales_team_id', $list_sales_team);
            $data_sales_officer_group = $this->db->get('tbl_sales_officer_group')->result();

            $list_sales_officer_id = array();

            foreach ($data_sales_officer_group as $dsog) {
                array_push($list_sales_officer_id, $dsog->sales_officer_id);
            }

            if (!empty($list_sales_officer_id)) {
                $this->db->order_by('point', 'DESC');
                $this->db->where_in('sales_officer_id', $list_sales_officer_id);
                $data_sales_officer = $this->db->get('tbl_sales_officer')->result();
            } else {
                $data_sales_officer = array();
            }
        } else {
            $data_sales_officer = array();
        }

        return $data_sales_officer;
    }

    public function getDataSalesOfficerbySalesTeamId($sales_team_id) {
        
        $this->db->where('sales_team_id', $sales_team_id);
        $data_sales_officer_group = $this->db->get('tbl_sales_officer_group')->result();

        $list_sales_officer_id = array();

        foreach ($data_sales_officer_group as $dsog) {
            array_push($list_sales_officer_id, $dsog->sales_officer_id);
        }

        if (!empty($list_sales_officer_id)) {
            $this->db->order_by('point', 'DESC');
            $this->db->where_in('sales_officer_id', $list_sales_officer_id);
            $data_sales_officer = $this->db->get('tbl_sales_officer')->result();
        } else {
            $data_sales_officer = array();
        }


        return $data_sales_officer;
    }

    public function getSalesOfficerbySalesOfficerId($sales_officer_id) {

        $list_sales_team = array();

        $data_sales_officer_group = $this->db->get_where('tbl_sales_officer_group', array('sales_officer_id' => $sales_officer_id))->result();

        if (!empty($data_sales_officer_group)) {
            foreach ($data_sales_officer_group as $dsog) {
                array_push($list_sales_team, $dsog->sales_team_id);
            }

            $this->db->where_in('sales_team_id', $list_sales_team);
            $this->db->where_not_in('sales_officer_id', $sales_officer_id);
            $data_sales_officer = $this->db->get('tbl_sales_officer_group')->result();

            $list_sales_officer = array();

            if (!empty($data_sales_officer)) {
                foreach ($data_sales_officer as $dso) {
                    array_push($list_sales_officer, $dso->sales_officer_id);
                }

                $this->db->where_in('sales_officer_id', $list_sales_officer);
                $data_sales_officer = $this->db->get('tbl_sales_officer')->result();
            } else {
                $data_sales_officer = array();
            }
        } else {
            $data_sales_officer = array();
        }

        return $data_sales_officer;
    }

}
