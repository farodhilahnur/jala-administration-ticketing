<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SalesTeamModels extends CI_Model {

    public function getSalesTeamChannelbyChannelId($channel_id, $city_id) {
        $this->db->order_by('a.id', 'asc');
        $this->db->where('b.city_id', $city_id);
        $this->db->join('tbl_sales_team_city b', 'a.sales_team_id = b.sales_team_id');
        $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel a', array('a.channel_id' => $channel_id))->row();

        return $data_sales_team_channel;
    }

    public function insertSalesTeamDistribution($param1, $param2, $param3) {
        $data_insert_sales_team_distribution = array(
            'channel_id' => $param1,
            'sales_team_id' => $param2,
            'kota_id' => $param3
        );

        $insert = $this->db->insert('tbl_sales_team_distribution', $data_insert_sales_team_distribution);

        if ($insert) {
            $response = TRUE;
        } else {
            $response = FALSE;
        }

        return $response;
    }

    public function getSalesTeamByProjectId($project_id) {

        //get campaign by project id
        $list_campaign_id = array();
        $data_campaign = $this->db->get_where('tbl_campaign', array('project_id' => $project_id))->result();

        foreach ($data_campaign as $dc) {
            array_push($list_campaign_id, $dc->id);
        }

        if (!empty($list_campaign_id)) {

            $list_channel_id = array();
            $this->db->where_in('campaign_id', $list_campaign_id);
            $data_channel = $this->db->get('tbl_channel')->result();

            foreach ($data_channel as $dch) {
                array_push($list_channel_id, $dch->id);
            }

            if (!empty($list_channel_id)) {

                $list_sales_team_id = array();
                $this->db->where_in('channel_id', $list_channel_id);
                $data_sales_team_channel = $this->db->get('tbl_sales_team_channel')->result();

                foreach ($data_sales_team_channel as $dstc) {

                    array_push($list_sales_team_id, $dstc->sales_team_id);
                }

                if (!empty($list_sales_team_id)) {

                    $this->db->where_in('sales_team_id', $list_sales_team_id);
                    $data_sales_team = $this->db->get('tbl_sales_team')->result();
                } else {
                    $data_sales_team = array();
                }
            } else {
                $data_sales_team = array();
            }
        } else {
            $data_sales_team = array();
        }

        return $data_sales_team;
    }

    public function getDataTopSalesTeam() {

        $sales_team_id = array();
        $data = array();

        $client_id = $this->MainModels->getClientId();

        $this->db->select('sales_team_id');
        $data_sales_team = $this->db->get_where('tbl_sales_team', array('client_id' => $client_id))->result();

        foreach ($data_sales_team as $value) {
            array_push($sales_team_id, $value->sales_team_id);
        }

        if (!empty($sales_team_id)) {
            $this->db->limit(5);
            $this->db->order_by('a.point', 'desc');
            $this->db->select('c.sales_team_name, c.sales_team_id, sum(a.point) as points');
            $this->db->join('tbl_sales_officer_group d', 'd.sales_team_id = c.sales_team_id');
            $this->db->join('tbl_sales_officer a', 'a.sales_officer_id = d.sales_officer_id');
            $this->db->group_by('d.sales_team_id');
            $this->db->where_in('d.sales_team_id', $sales_team_id);
            $data_point = $this->db->get('tbl_sales_team c')->result();

            $this->db->limit(5);
            $this->db->select('count(b.lead_id) as total_leads');
            $this->db->join('tbl_sales_officer_group a', 'a.sales_team_id = c.sales_team_id');
            $this->db->join('tbl_lead b', 'b.sales_officer_id = a.sales_officer_id');
            $this->db->group_by('a.sales_team_id');
            $this->db->where_in('a.sales_team_id', $sales_team_id);
            $data_total_lead = $this->db->get('tbl_sales_team c')->result();

            if (!empty($data_total_lead)) {
                foreach ($data_point as $key => $value) {
                    $data_push = array(
                        'group_id' => $value->sales_team_id,
                        'group_name' => $value->sales_team_name,
                        'points' => intval($value->points),
                        'total_leads' => ''
                            /* 'total_leads' => $data_total_lead[$key]->total_leads */
                    );

                    array_push($data, $data_push);
                }
            } else {
                $data_push = array(
                    'group_id' => $value->sales_team_id,
                    'group_name' => '',
                    'points' => 0,
                    'total_leads' => 0
                );

                array_push($data, $data_push);
            }
        } else {
            $data = array();
        }



        return $data;
    }

}
