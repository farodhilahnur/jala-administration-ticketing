<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SalesOfficerModels extends CI_Model
{

    public function getDataSalesOfficerUnreceivedbySalesTeamId($id)
    {
        $this->db->order_by('sales_officer_group_id', 'asc');
        $data_sales_officer = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $id, 'is_gifted' => 0))->row();

        return $data_sales_officer;
    }

    public function getSalesOfficerbyProjectId()
    {

        $role = $this->MainModels->UserSession('role_id');
        $sales_team_id = array();

        //get data sales team channel

        if ($role == 3) {
            $sales_team = $this->MainModels->getSalesTeamId();

            array_push($sales_team_id, $sales_team);

            $this->db->where_in('a.sales_team_id', $sales_team_id);
            $this->db->select('a.sales_officer_id, b.sales_officer_name');
            $this->db->join('tbl_sales_officer b', 'a.sales_officer_id = b.sales_officer_id');
            $data_sales_officer = $this->db->get('tbl_sales_officer_group a')->result();
        } else {


            $client_id = $this->MainModels->getClientId();

            //get Sales Team
            $this->db->select('sales_team_id');
            $data_sales_team = $this->db->get_where('tbl_sales_team', array('client_id' => $client_id))->result();


            if (!empty($data_sales_team)) {
                foreach ($data_sales_team as $dst) {
                    array_push($sales_team_id, $dst->sales_team_id);
                }

                $this->db->where_in('a.sales_team_id', $sales_team_id);
                $this->db->select('a.sales_officer_id, b.sales_officer_name');
                $this->db->join('tbl_sales_officer b', 'a.sales_officer_id = b.sales_officer_id');
                $data_sales_officer = $this->db->get('tbl_sales_officer_group a')->result();
            }
        }


        return $data_sales_officer;
    }

    public function getDataSalesOfficerbyClientId()
    {

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

    public function getDataSalesOfficerbyClientAdminId()
    {

        $client_id = $this->MainModels->getClientId();
        $user_id = $this->MainModels->UserSession('user_id');
        $project_id_admin = $this->db->get_where('tbl_client_admin', array('user_id' => $user_id))->row('project_id');
        $list_sales_team = array();

        if ($project_id_admin == 0) {
            $data_sales_team = $this->db->get_where('tbl_sales_team', array('client_id' => $client_id))->result();
        } else {
            $data_sales_team = $this->TeamModels->getDataSalesTeambyClientAdminId();
        }

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

    public function getDataSalesOfficerbySalesTeamId($sales_team_id)
    {

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

    public function getSalesOfficerAll($sales_officer_id)
    {

        $list_sales_team = array();

        $client_id = $this->db->get_where('tbl_sales_officer', array('sales_officer_id' => $sales_officer_id))->row('client_id');

        $data_sales_officer_group = $this->db->get_where('tbl_sales_team', array('client_id' => $client_id))->result();

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

    public function getDataSalesOfficerStatisticsbySalesTeamId($sales_team_id)
    {
        //get data sales officer group
        $data_sales_officer_group = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $sales_team_id))->result();

        $list_sales_officer_id = array();
        if (!empty($data_sales_officer_group)) {
            foreach ($data_sales_officer_group as $dsog) {
                array_push($list_sales_officer_id, $dsog->sales_officer_id);
            }

            $this->db->where_in('sales_officer_id', $list_sales_officer_id);
            $data_sales_officer = $this->db->get('tbl_sales_officer')->result();
        } else {
            $data_sales_officer = array();
        }

        return $data_sales_officer;
    }

}
