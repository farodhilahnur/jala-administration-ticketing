<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class NotificationModels extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->model('ChannelModels');
        $this->load->model('ProjectModels');
        $this->load->model('CampaignModels');
        $this->load->model('TeamModels');
        $this->load->model('StatusModels');
    }

    public function getNotificationbySalesOfficerId($sales_officer_id) {

        //get data notification by sales officer id

        $this->db->select('a.*, b.campaign_name, TIMESTAMPDIFF(MINUTE, a.update_date, NOW()) AS minutes, '
                . 'TIMESTAMPDIFF(SECOND, a.update_date, NOW()) AS seconds, '
                . 'TIMESTAMPDIFF(HOUR, a.update_date, NOW()) AS hours, '
                . 'TIMESTAMPDIFF(DAY, a.update_date, NOW()) AS days');
        $this->db->join('tbl_campaign b', 'a.campaign_id = b.id');
        $data_notification = $this->db->get_where('tbl_notification a', array('sales_officer_id' => $sales_officer_id))->result();

        if (!empty($data_notification)) {
            $data = $data_notification;
        } else {
            $data = [];
        }
        return $data;
    }
    
    public function getNotificationbySalesOfficerIdUnread($sales_officer_id) {

        //get data notification by sales officer id

//        $this->db->select('a.*, b.campaign_name, TIMESTAMPDIFF(MINUTE, a.update_date, NOW()) AS minutes, '
//                . 'TIMESTAMPDIFF(SECOND, a.update_date, NOW()) AS seconds, '
//                . 'TIMESTAMPDIFF(HOUR, a.update_date, NOW()) AS hours, '
//                . 'TIMESTAMPDIFF(DAY, a.update_date, NOW()) AS days');
//        $this->db->join('tbl_campaign b', 'a.campaign_id = b.id');
//        $data_notification = $this->db->get_where('tbl_notification a', array('sales_officer_id' => $sales_officer_id, 'is_read' => 0))->result();
        
        $this->db->select('lead_count');
        $data_count = $this->db->get_where('tbl_notification', array('sales_officer_id' => $sales_officer_id))->row();

        return $data_count;
    }

}
