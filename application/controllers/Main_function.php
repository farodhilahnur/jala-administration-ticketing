<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main_function extends CI_Controller {

    function __construct() {
        parent::__construct();

        $session = $this->session->userdata('user');

        if (empty($session['user_id'])) {
            $this->session->set_flashdata('notif_access', '<p class="alert alert-warning">Login First to Create Session !!!</p>');
            redirect(base_url('login'));
        }
    }

    public function delete_data() {
        $get = $this->input->get();

        $id = $get['id'];
        $tbl_name = $get['tbl_name'];

        $param1 = [];

        $tbl_assets = $this->MainModels->mappingTable($tbl_name, $param1);

        $this->db->where($tbl_assets['field_id'], $id);
        $delete = $this->db->delete($tbl_name);

        if ($delete) {

//            if ($tbl_name == 'tbl_user') {
//                $role_id = $this->db->get_where('tbl_user', array('user_id' => $id))->row('role_id');
//                
//                switch ($role_id) {
//                    case 2:
//                        $this->db->where('user_id', $id);
//                        $delete_user = $this->db->delete('tbl_client');
//                        break;
//                    case 4
//                    default:
//                        break;
//                }
//            }

            $this->session->set_flashdata('message', '<p class="alert alert-success"> Success delete ' . $tbl_assets['message'] . ' !!!  </p>');
            redirect(base_url($tbl_assets['redirect']));
        } else {
            $this->session->set_flashdata('message', '<p class="alert alert-danger"> Error delete ' . $tbl_assets->message . ' !!!  </p>');
            redirect(base_url($tbl_assets['redirect']));
        }
    }

    public function set_status() {
        $get = $this->input->get();

        $id = $get['id'];
        $tbl_name = $get['tbl_name'];

        $status = $get['status'];

        if ($status == 1) {
            $notes = 'enabled';
        } else {
            $notes = 'disabled';
        }

        if ($tbl_name == 'tbl_campaign' || $tbl_name == 'tbl_channel' || $tbl_name == 'tbl_product' || $tbl_name == 'tbl_status') {
            $project_id = $get['param1'];
            $tbl_assets = $this->MainModels->mappingTable($tbl_name, $project_id);
        } else {
            $param1 = "";
            $tbl_assets = $this->MainModels->mappingTable($tbl_name, $param1);
        }


        $data_update = array(
            'status' => $status
        );

        $this->db->where($tbl_assets['field_id'], $id);
        $update = $this->db->update($tbl_name, $data_update);

        if ($update) {

            $caption = explode('_', $tbl_name);
            $kata = ucfirst($caption[1]);
            $this->MainModels->insert_log($kata . ' ' . $notes . ' By ', 0, $id);

            $this->session->set_flashdata('message', '<p class="alert alert-success"> Success ' . $notes . ' ' . $tbl_assets['message'] . ' !!!  </p>');
            redirect(base_url($tbl_assets['redirect']));
        } else {
            $this->session->set_flashdata('message', '<p class="alert alert-danger"> Error ' . $notes . ' ' . $tbl_assets->message . ' !!!  </p>');
            redirect(base_url($tbl_assets['redirect']));
        }
    }

    public function croth() {


        $mess = array();
        for ($a = 0; $a < 100000; $a++) {

            $rand = $this->MainModels->generateRandomString();

            $data_insert = array(
                'code' => $rand
            );

            $insert = $this->db->insert('tbl_reno', $data_insert);

            if ($insert) {
                $res = 'masok';
            } else {
                $res = "error";
            }
            array_push($mess, $res);
        }


        print_r($mess);
        exit;
    }

}
