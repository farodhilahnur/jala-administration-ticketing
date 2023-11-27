<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function getDataChartProduct() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $this->load->model('ChannelModels');
        
        //get data product by project id

        $session_filter = $this->session->userdata('filter');
        $campaign_id = $session_filter['campaign_id'];
        $date = explode(' to ', $session_filter['date_range']);
        $project_date = $date[0];
        $now_date = $date[1];

        $id = $this->input->get('id');

        $list_product_id = array();
        $list_channel_id = array();

        $data_product = $this->db->get_where('tbl_product', array('project_id' => $id))->result();

        foreach ($data_product as $dp) {
            array_push($list_product_id, $dp->id);
        }

        if ($campaign_id != 0) {
            $data_channel = $this->ChannelModels->getDataChannelbyCampagnId($campaign_id);
        } else {
            $data_channel = $this->ChannelModels->getDataChannelbyProjectId($id);
        }
        
        foreach ($data_channel as $dc) {
            array_push($list_channel_id, $dc->channel_id);
        }

        //get data lead by product

        $this->db->where_in('a.channel_id', $list_channel_id);
        $this->db->where_in('a.product_id', $list_product_id);
        $this->db->where('a.create_date >=', $project_date . ' 00:00:00');
        $this->db->where('a.create_date <=', $now_date . ' 23:59:59');
        $this->db->select('b.product_name as country, count(a.lead_id) as value');
        $this->db->join('tbl_product b', 'a.product_id = b.id');
        $this->db->group_by('a.product_id');
        $data_lead = $this->db->get('tbl_lead a')->result();

        $data = array(
            'res' => 200,
            'data' => $data_lead,
            'count' => count($data_lead)
        );

        echo json_encode($data);
    }

}
