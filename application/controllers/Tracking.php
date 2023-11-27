<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking extends CI_Controller {

    public function index() {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        $post = $this->input->post();
        $q = $post['query'];

        //get campaign hit 
        $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $q))->row();
        
        $data_update = array(
            'channel_click' => intval($data_channel->channel_click) + 1
        );

        //+ 1 campaign hit
        $this->db->where('unique_code', $q);
        $update = $this->db->update('tbl_channel', $data_update);


        $html = array("<option value=0 ></option>");
        $data_city = $this->db->get('tbl_kota')->result();

        foreach ($data_city as $value) {
            $option_city = "<option value=$value->kota_id >$value->kota_name</option>";
            array_push($html, $option_city);
        }

        if ($update) {
            $data = array(
                'res' => 200,
                'message' => 'success',
                'redirect' => $data_channel->channel_redirect_url,
                'unique_code' => $q, 
                'htmlCity' => $html
            );
        } else {
            $data = array(
                'res' => 400,
                'message' => 'error',
                'redirect' => 'null',
                'unique_code' => 'null', 
                'htmlCity' => $html
            );
        }

        echo json_encode($data);
    }

}
