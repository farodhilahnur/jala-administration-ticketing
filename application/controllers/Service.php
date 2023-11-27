<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('UserModels');
        $this->load->model('CampaignModels');
        $this->load->model('NotificationModels');
    }

    public function login() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $email = strtolower($post->username);
        $password = strtolower($post->password);
        $tbl_name = 'tbl_sales_officer';

        $param = array('username' => $email, 'password' => $password, 'tbl_name' => $tbl_name);

        $sales_officer_login = $this->UserModels->checkLoginApiProd($param);

        echo json_encode($sales_officer_login);
    }

    public function loginBack() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $email = strtolower($post->username);
        $password = strtolower($post->password);
        $device_id = $post->device_id;
        $tbl_name = 'tbl_sales_officer';

        $param = array('username' => $email, 'password' => $password, 'tbl_name' => $tbl_name, 'device_id' => $device_id);

        $sales_officer_login = $this->UserModels->checkLoginApi($param);

        echo json_encode($sales_officer_login);
    }

    public function postLeadOffline() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');

        $json = file_get_contents('php://input');
        $post = json_decode($json);


        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $channel_id = $post->channel_id;
        $name = addslashes($post->name);
        $no_ktp = addslashes($post->no_ktp);
        $phone = addslashes($post->phone);
        $email = strtolower($post->email);
        $city = $post->city;
        $address = addslashes($post->address);
        $category = addslashes($post->category);
        $status = addslashes($post->status);
        $product = addslashes($post->product);
        $notes = addslashes($post->notes);
        $sales_officer_id = $post->sales_officer_id;
        $callback = $post->callback;

        $data_insert = array(
            'channel_id' => $channel_id,
            'lead_name' => $name,
            'no_ktp' => $no_ktp,
            'lead_phone' => $phone,
            'lead_email' => $email,
            'lead_address' => $address,
            'lead_category_id' => $category,
            'status_id' => $status,
            'product_id' => $product,
            'sales_officer_id' => $sales_officer_id,
            'lead_city' => $city,
            'callback' => $callback
        );

        $insert = $this->db->insert('tbl_lead', $data_insert);

        if ($insert) {

            $lead_id = $this->db->insert_id();
            $this->db->order_by('lead_history_id', 'DESC');
            $last_point = $this->db->get_where('tbl_lead_history', array('lead_id' => $lead_id, 'sales_officer_id' => $sales_officer_id))->row('point');

            $calc_point = -1 * intval($last_point);

            //get point 
            $data_point = $this->db->get_where('tbl_status', array('id' => $status))->row();
            $point = floatval($data_point->point);

            //insert lead history
            $data_insert_lead_history = array(
                'lead_id' => $lead_id,
                'status_id' => $status,
                'category_id' => $category,
                'notes' => $notes,
                'sales_officer_id' => $sales_officer_id,
                'point' => $point
            );

            $insert_lead_history = $this->db->insert('tbl_lead_history', $data_insert_lead_history);

            if ($insert_lead_history) {

                $data_insert_sales_officer_activity = array(
                    'sales_officer_id' => $sales_officer_id,
                    'lead_id' => $lead_id,
                    'point' => $point
                );

                $insert_sales_officer_activity = $this->db->insert('tbl_sales_officer_activity', $data_insert_sales_officer_activity);

                if ($insert_sales_officer_activity) {

                    $data_update_lead = array('status_id' => $status, 'lead_category_id' => $category, 'product_id' => $product);

                    $this->db->where('lead_id', $lead_id);
                    $update_lead = $this->db->update('tbl_lead', $data_update_lead);

                    if ($update_lead) {

                        $query_update_agent = "UPDATE tbl_sales_officer SET point=point + $calc_point + $point WHERE sales_officer_id= $sales_officer_id";
                        //$this->db->set('point', 'point + ' . $calc_point , FALSE);
                        //$this->db->where('sales_officer_id', $sales_officer_id);
                        $update_agent = $this->db->query($query_update_agent);

                        if ($update_agent) {

                            $data = array(
                                'res' => 200
                            );
                        }
                    }
                }
            } else {
                $data = array(
                    'res' => 400
                );
            }
        } else {
            $data = array(
                'res' => 400,
            );
        }

        echo json_encode($data);
    }

    public function getDetailCampaign() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $campaign_id = $this->input->get('id');
        $sales_officer_id = $this->input->get('agent_id');

        $get_detail_campaign = $this->CampaignModels->getDetailCampaignbyId($campaign_id, $sales_officer_id);

        $data = array('status' => 200, 'count' => count($get_detail_campaign), 'data' => $get_detail_campaign);

        echo json_encode($data);
    }

    public function getProjectIdbySalesOfficer() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $sales_officer_id = $this->input->get('id');

        $this->db->select('c.id as project_id');
        $this->db->join('tbl_project c', 'a.client_id = c.client_id');
        $data_project = $this->db->get_where('tbl_sales_officer a', array('a.sales_officer_id' => $sales_officer_id))->result();

        $data = array('status' => 200, 'count' => count($data_project), 'data' => $data_project);

        echo json_encode($data);
    }

    public function getDetailProduct() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $product_id = $this->input->get('id');

        $data_product = $this->db->get_where('tbl_product', array('id' => $product_id))->row();

        $data_picture = $this->db->get_where('tbl_product_image', array('product_id' => $product_id))->result();

        if (!empty($data_picture)) {
            $picture = $data_picture;
        } else {
            $picture = array();
        }


        $data = array('status' => 200, 'count' => count($data_product), 'data' => $data_product, 'picture' => $data_picture);

        echo json_encode($data);
    }

    public function follow_up() {
//        header('Access-Control-Allow-Headers: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $lead_id = addslashes($post->lead_id);
        $sales_officer_id = addslashes($post->agent_id);
        $lead_category_id = addslashes($post->category_id);
        $status_id = strtolower($post->status_id);
        $product_id = $post->product_id;
        $notes = $post->note;
        $callback = $post->callback;

        $this->db->order_by('lead_history_id', 'DESC');
        $last_point = $this->db->get_where('tbl_lead_history', array('lead_id' => $lead_id, 'sales_officer_id' => $sales_officer_id))->row('point');

        $calc_point = -1 * intval($last_point);

        //get point 
        $data_point = $this->db->get_where('tbl_status', array('id' => $status_id))->row();
        $point = floatval($data_point->point);

        //insert lead history
        $data_insert_lead_history = array(
            'lead_id' => $lead_id,
            'status_id' => $status_id,
            'category_id' => $lead_category_id,
            'notes' => $notes,
            'sales_officer_id' => $sales_officer_id,
            'point' => $point
        );

        $insert_lead_history = $this->db->insert('tbl_lead_history', $data_insert_lead_history);

        if ($insert_lead_history) {

            $data_insert_sales_officer_activity = array(
                'sales_officer_id' => $sales_officer_id,
                'lead_id' => $lead_id,
                'point' => $point
            );

            $insert_sales_officer_activity = $this->db->insert('tbl_sales_officer_activity', $data_insert_sales_officer_activity);

            if ($insert_sales_officer_activity) {

                if ($callback != ' ') {
                    $data_update_lead = array('status_id' => $status_id, 'lead_category_id' => $lead_category_id, 'product_id' => $product_id, 'callback' => $callback);
                } else {
                    $data_update_lead = array('status_id' => $status_id, 'lead_category_id' => $lead_category_id, 'product_id' => $product_id);
                }
                   

                $this->db->where('lead_id', $lead_id);
                $update_lead = $this->db->update('tbl_lead', $data_update_lead);

                if ($update_lead) {

                    $query_update_agent = "UPDATE tbl_sales_officer SET point=point + $calc_point + $point WHERE sales_officer_id= $sales_officer_id";
                    //$this->db->set('point', 'point + ' . $calc_point , FALSE);
                    //$this->db->where('sales_officer_id', $sales_officer_id);
                    $update_agent = $this->db->query($query_update_agent);

                    if ($update_agent) {

                        $data = array(
                            'status' => 200
                        );
                    }
                }
            }
        } else {
            $data = array(
                'status' => 400
            );
        }

        echo json_encode($data);
    }

    public function post_lead_booking() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');

        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $campaign_id = $post->cpg_id;

        $project_id = $this->db->get_where('tbl_campaign', array('id' => $campaign_id))->row('project_id');
        $get_status = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'Booking'))->row('id');

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $channel_id = $post->channel_id;
        $name = addslashes($post->name);
        $no_ktp = addslashes($post->no_ktp);
        $phone = addslashes($post->phone);
        $email = strtolower($post->email);
        $product_id = $post->product_id;
        $city = 1158;
        $address = addslashes($post->address);
        $category = addslashes($post->category);
        $status = $get_status;
        $product = addslashes($post->product_id);
        $notes = addslashes($post->notes);
        $sales_officer_id = $post->sales_officer_id;
        $transaction_id = $post->transaction_id;
        $payment_method = $post->payment_method;

        $data_insert = array(
            'channel_id' => $channel_id,
            'lead_name' => $name,
            'no_ktp' => $no_ktp,
            'lead_phone' => $phone,
            'lead_email' => $email,
            'lead_address' => $address,
            'lead_category_id' => $category,
            'status_id' => $status,
            'product_id' => $product,
            'sales_officer_id' => $sales_officer_id,
            'product_id' => $product_id,
            'lead_city' => $city,
            'transaction_id' => $transaction_id,
            'payment_method' => $payment_method
        );

        $insert = $this->db->insert('tbl_lead', $data_insert);

        if ($insert) {

            $lead_id = $this->db->insert_id();
            $this->db->order_by('lead_history_id', 'DESC');
            $last_point = $this->db->get_where('tbl_lead_history', array('lead_id' => $lead_id, 'sales_officer_id' => $sales_officer_id))->row('point');

            $calc_point = -1 * intval($last_point);

            //get point 
            $data_point = $this->db->get_where('tbl_status', array('id' => $status))->row();
            $point = floatval($data_point->point);

            //insert lead history
            $data_insert_lead_history = array(
                'lead_id' => $lead_id,
                'status_id' => $status,
                'category_id' => $category,
                'notes' => $notes,
                'sales_officer_id' => $sales_officer_id,
                'point' => $point
            );

            $insert_lead_history = $this->db->insert('tbl_lead_history', $data_insert_lead_history);

            if ($insert_lead_history) {

                $data_insert_sales_officer_activity = array(
                    'sales_officer_id' => $sales_officer_id,
                    'lead_id' => $lead_id,
                    'point' => $point
                );

                $insert_sales_officer_activity = $this->db->insert('tbl_sales_officer_activity', $data_insert_sales_officer_activity);

                if ($insert_sales_officer_activity) {

                    $data_update_lead = array('status_id' => $status, 'lead_category_id' => $category, 'product_id' => $product);

                    $this->db->where('lead_id', $lead_id);
                    $update_lead = $this->db->update('tbl_lead', $data_update_lead);

                    if ($update_lead) {

                        $query_update_agent = "UPDATE tbl_sales_officer SET point=point + $calc_point + $point WHERE sales_officer_id= $sales_officer_id";
                        //$this->db->set('point', 'point + ' . $calc_point , FALSE);
                        //$this->db->where('sales_officer_id', $sales_officer_id);
                        $update_agent = $this->db->query($query_update_agent);

                        if ($update_agent) {

                            $data = array(
                                'res' => 200,
                                'lead_id' => $lead_id
                            );
                        }
                    }
                }
            } else {
                $data = array(
                    'res' => 400,
                    'lead_id' => 0
                );
            }
        } else {
            $data = array(
                'res' => 400,
                'lead_id' => 0
            );
        }

        echo json_encode($data);
    }

    public function booking_action() {
//        header('Access-Control-Allow-Headers: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $campaign_id = $post->cpg_id;

        $project_id = $this->db->get_where('tbl_campaign', array('id' => $campaign_id))->row('project_id');
        $get_status = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'Booking'))->row('id');

        $lead_id = addslashes($post->lead_id);
        $sales_officer_id = addslashes($post->agent_id);
        $lead_category_id = addslashes($post->category_id);
        $status_id = $get_status;
        $notes = $post->note;
        $transaction_id = $post->transaction_id;
        $payment_method = $post->payment_method;
        $ktp = $post->no_ktp;
        $no_telp = $post->lead_phone;
        $email = $post->lead_email;
        $alamat = $post->lead_address;


        $this->db->order_by('lead_history_id', 'DESC');
        $last_point = $this->db->get_where('tbl_lead_history', array('lead_id' => $lead_id, 'sales_officer_id' => $sales_officer_id))->row('point');

        $calc_point = -1 * intval($last_point);

        //get point 
        $data_point = $this->db->get_where('tbl_status', array('id' => $status_id))->row();
        $point = floatval($data_point->point);

        //insert lead history
        $data_insert_lead_history = array(
            'lead_id' => $lead_id,
            'category_id' => $lead_category_id,
            'notes' => $notes,
            'sales_officer_id' => $sales_officer_id,
            'point' => $point
        );

        $insert_lead_history = $this->db->insert('tbl_lead_history', $data_insert_lead_history);

        if ($insert_lead_history) {

            $data_insert_sales_officer_activity = array(
                'sales_officer_id' => $sales_officer_id,
                'lead_id' => $lead_id,
                'point' => $point
            );

            $insert_sales_officer_activity = $this->db->insert('tbl_sales_officer_activity', $data_insert_sales_officer_activity);

            if ($insert_sales_officer_activity) {

                $data_update_lead = array(
                    'status_id' => $status_id,
                    'lead_category_id' => $lead_category_id,
                    'transaction_id' => $transaction_id,
                    'payment_method' => $payment_method,
                    'lead_phone' => $no_telp,
                    'no_ktp' => $ktp,
                    'lead_email' => $email,
                    'lead_address' => $alamat
                );

                $this->db->where('lead_id', $lead_id);
                $update_lead = $this->db->update('tbl_lead', $data_update_lead);

                if ($update_lead) {

                    $query_update_agent = "UPDATE tbl_sales_officer SET point=point + $calc_point + $point WHERE sales_officer_id= $sales_officer_id";
                    //$this->db->set('point', 'point + ' . $calc_point , FALSE);
                    //$this->db->where('sales_officer_id', $sales_officer_id);
                    $update_agent = $this->db->query($query_update_agent);

                    if ($update_agent) {

                        $data = array(
                            'status' => 200
                        );
                    }
                }
            }
        } else {
            $data = array(
                'status' => 400
            );
        }

        echo json_encode($data);
    }

    public function getListCampaign() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $sales_officer_id = $this->input->get('id');

        $get_campaign = $this->CampaignModels->getCampaignBySalesOfficerId($sales_officer_id);

        $data = array('status' => 200, 'count' => count($get_campaign), 'data' => $get_campaign);

        echo json_encode($data);
    }

    public function getListCampaignNew() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $sales_officer_id = $this->input->get('id');

        $get_campaign = $this->CampaignModels->getCampaignBySalesOfficerIdNew($sales_officer_id);

        echo json_encode($data);
    }

    public function getLeadCategorybyCampaignId() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $campaign_id = $this->input->get('id');
        $sales_officer_id = $this->input->get('agent_id');

        $data_lead_category = $this->CampaignModels->getLeadCategorybyCampaignId($campaign_id, $sales_officer_id);

        $data = array('status' => 200, 'count' => count($data_lead_category), 'data' => $data_lead_category);

        echo json_encode($data);
    }

    public function getChannelStatisticsbyCampaignId() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $campaign_id = $this->input->get('id');
        $sales_officer_id = $this->input->get('agent_id');

        $data_channel_statistics = $this->ChannelModels->getDataChannelLeadbyCampaignId($campaign_id, $sales_officer_id);
        $data = array('status' => 200, 'count' => count($data_channel_statistics), 'data' => $data_channel_statistics);

        echo json_encode($data);
    }

    public function getLeadsbyCampaignIdperCategory() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $sales_officer_id = $this->input->get('agent_id');
        $category = $this->input->get('category');
        $campaign_id = $this->input->get('id');

        $data_lead = $this->LeadModels->getLeadsbyCampaignIdperCategory($campaign_id, $category, $sales_officer_id);
        $data = array('status' => 200, 'count' => count($data_lead), 'data' => $data_lead);

        echo json_encode($data);
    }

    public function getLeadsbyCampaignIdperCategorySearch() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $sales_officer_id = $this->input->get('agent_id');
        $campaign_id = $this->input->get('id');
        $string = $this->input->get('query');

        $data_lead = $this->LeadModels->getLeadsbyCampaignIdperCategorySearch($campaign_id, $sales_officer_id, $string);
        $data = array('status' => 200, 'count' => count($data_lead), 'data' => $data_lead);

        echo json_encode($data);
    }

    public function getLeadsbyCampaignIdperCategoryMainPage() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $sales_officer_id = $this->input->get('agent_id');
        $category = $this->input->get('category');
        $campaign_id = $this->input->get('id');

        $data_lead = $this->LeadModels->getLeadsbyCampaignIdperCategoryMainPage($campaign_id, $category, $sales_officer_id);
        $data = array('status' => 200, 'count' => count($data_lead), 'data' => $data_lead);

        echo json_encode($data);
    }

    public function getLeadsbyCampaignIdperCategoryFilter() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $sales_officer_id = $this->input->get('agent_id');
        $category = $this->input->get('category');
        $campaign_id = $this->input->get('id');
        $channel_id = $this->input->get('channel_id');
        $status_id = $this->input->get('status_id');
        $period = $this->input->get('period');

        $data_lead = $this->LeadModels->getLeadsbyCampaignIdperCategoryFilter($campaign_id, $category, $sales_officer_id, $channel_id, $status_id, $period);
        $data = array('status' => 200, 'count' => count($data_lead), 'data' => $data_lead);

        echo json_encode($data);
    }

    public function getDetailLead() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $lead_id = $this->input->get('id');

        $data_detail_lead = $this->LeadModels->getDetailLead($lead_id);
        $data = array('status' => 200, 'count' => count($data_detail_lead), 'data' => $data_detail_lead);

        echo json_encode($data);
    }

    public function getDataCategory() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $data_category = $this->db->get('tbl_lead_category')->result();
        $data = array('status' => 200, 'count' => count($data_category), 'data' => $data_category);

        echo json_encode($data);
    }

    public function getStatusbyCampaignId() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $campaign_id = $this->input->get('id');

        $data_status = $this->CampaignModels->getStatusbyCampaignId($campaign_id);
        $data = array('status' => 200, 'count' => count($data_status), 'data' => $data_status);

        echo json_encode($data);
    }

    public function getProductbyCampaignId() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $campaign_id = $this->input->get('id');

        $data_product = $this->CampaignModels->getProductbyCampaignId($campaign_id);
        $data = array('status' => 200, 'count' => count($data_product), 'data' => $data_product);

        echo json_encode($data);
    }

    public function getHistorybyLeadId() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $lead_id = $this->input->get('id');

        $data_history = $this->LeadModels->getHistorybyLeadId($lead_id);
        $data = array('status' => 200, 'count' => count($data_history), 'data' => $data_history);

        echo json_encode($data);
    }

    public function getHistorybyCampaignId() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $campaign_id = $this->input->get('id');
        $sales_officer_id = $this->input->get('agent_id');

        $data_history = $this->LeadModels->getHistorybyCampaignId($campaign_id, $sales_officer_id);
        $data = array('status' => 200, 'count' => count($data_history), 'data' => $data_history);

        echo json_encode($data);
    }

    public function getNotificationbySalesOfficerId() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        //$campaign_id = $this->input->get('id');
        $sales_officer_id = $this->input->get('id');

        $data_notification = $this->NotificationModels->getNotificationbySalesOfficerId($sales_officer_id);
        $data = array('status' => 200, 'count' => count($data_notification), 'data' => $data_notification);

        echo json_encode($data);
    }

    public function getLeadbyChannelIdSalesOfficerId() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $channel_id = $this->input->get('channel_id');
        $sales_officer_id = $this->input->get('agent_id');

        $data_lead_channel = $this->LeadModels->getDataLeadbyChannelIdSalesOfficerId($channel_id, $sales_officer_id);
        $data = array('status' => 200, 'count' => count($data_lead_channel), 'data' => $data_lead_channel);

        echo json_encode($data);
    }

    public function getStatisticsStatus() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $campaign_id = $this->input->get('campaign_id');
        $sales_officer_id = $this->input->get('agent_id');

        $data_lead_status = $this->LeadModels->getDataLeadStatusbyCampaignIdbySalesOfficerId($campaign_id, $sales_officer_id);
        $data = array('status' => 200, 'count' => count($data_lead_status), 'data' => $data_lead_status);

        echo json_encode($data);
    }

    public function getLeadsbyChannelIdperCategory() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $channel_id = $this->input->get('id');
        $sales_officer_id = $this->input->get('agent_id');
        $category_name = $this->input->get('category');

        $data_lead_channel_category = $this->LeadModels->getDataLeadbyChannelIdSalesOfficerIdCategory($channel_id, $category_name, $sales_officer_id);
        $data = array('status' => 200, 'count' => count($data_lead_channel_category), 'data' => $data_lead_channel_category);

        echo json_encode($data);
    }

    public function getLeadsbyChannelIdperStatus() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $channel_id = $this->input->get('id');
        $sales_officer_id = $this->input->get('agent_id');
        $category_name = $this->input->get('category');

        $data_lead_channel_category = $this->LeadModels->getDataLeadbyChannelIdSalesOfficerIdStatus($channel_id, $category_name, $sales_officer_id);
        $data = array('status' => 200, 'count' => count($data_lead_channel_category), 'data' => $data_lead_channel_category);

        echo json_encode($data);
    }

    public function getChannelOfflinebyCampaignId() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $campaign_id = $this->input->get('id');
        $sales_officer_id = $this->input->get('agent_id');

        $data_channel_statistics = $this->ChannelModels->getDataChannelOfflineLeadbyCampaignId($campaign_id, $sales_officer_id);
        $data = array('status' => 200, 'count' => count($data_channel_statistics), 'data' => $data_channel_statistics);

        echo json_encode($data);
    }

    public function readNewLeads() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $campaign_id = $this->input->get('id');
        $sales_officer_id = $this->input->get('agent_id');

        //get campaign name
        $campaign_name = $this->db->get_where('tbl_campaign', array('id' => $campaign_id))->row('campaign_name');

        //get data notif 
        $data_notif = $this->db->get_where('tbl_notification', array('sales_officer_id' => $sales_officer_id, 'campaign_id' => $campaign_id))->row();

        if (!empty($data_notif)) {
            if ($data_notif->is_read == 0) {
                $data_update = array('message' => 'There is 0 new leads from ' . $campaign_name, 'is_read' => 1, 'lead_count' => 0);

                $this->db->where('notification_id', $data_notif->notification_id);
                $update_notif = $this->db->update('tbl_notification', $data_update);

                if ($update_notif) {

                    $data_update_lead = array(
                        'is_seen' => 1
                    );

                    $list_lead = array();

                    $data_new_lead = $this->LeadModels->getDataLeadByCampaignIdApi($campaign_id, 1, $sales_officer_id);

                    foreach ($data_new_lead as $dl) {
                        array_push($list_lead, $dl->lead_id);
                    }

                    $this->db->where_in('lead_id', $list_lead);
                    $update = $this->db->update('tbl_lead', $data_update_lead);

                    if ($update) {
                        $status = 200;
                    } else {
                        $status = 400;
                    }
                } else {
                    $status = 400;
                }
            } else {
                $data_update = array('message' => 'There is 0 new leads from ' . $campaign_name, 'is_read' => 1, 'lead_count' => 0);

                $this->db->where('notification_id', $data_notif->notification_id);
                $update_notif = $this->db->update('tbl_notification', $data_update);

                $status = 200;
            }
        } else {

            $status = 200;
        }

        $data = array('status' => $status);

        echo json_encode($data);
    }

    public function getProfilebySalesOfficerId() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $sales_officer_id = $this->input->get('id');

        $get_profile = $this->UserModels->getProfileSalesOfficerId($sales_officer_id);

        $data = array('status' => 200, 'count' => count($get_profile), 'data' => $get_profile);

        echo json_encode($data);
    }

    public function getCountNotificationUnRead() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $sales_officer_id = $this->input->get('id');

        $lead_count = $this->NotificationModels->getNotificationbySalesOfficerIdUnread($sales_officer_id);

        $data = array('status' => 200, 'count' => $lead_count);

        echo json_encode($data);
    }

    public function wa_clicked() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $lead_id = $this->input->get('id');

        //get wa called existing 
        $wa_lead_clicked = $this->db->get_where('tbl_lead', array('lead_id' => $lead_id))->row('wa_called');

        if (!empty($wa_lead_clicked)) {
            $wa_clicked_new = intval($wa_lead_clicked) + 1;
        } else {
            $wa_clicked_new = 1;
        }

        $data_update = array(
            'wa_called' => $wa_clicked_new
        );

        $this->db->where('lead_id', $lead_id);
        $update = $this->db->update('tbl_lead', $data_update);

        if ($update) {
            $data = array(
                'res' => 200,
                'message' => 'success',
            );
        } else {
            $data = array(
                'res' => 400,
                'message' => 'error',
            );
        }

        echo json_encode($data);
    }

    public function phone_clicked() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $lead_id = $this->input->get('id');

        //get wa called existing 
        $wa_lead_clicked = $this->db->get_where('tbl_lead', array('lead_id' => $lead_id))->row('phone_called');

        if (!empty($wa_lead_clicked)) {
            $wa_clicked_new = intval($wa_lead_clicked) + 1;
        } else {
            $wa_clicked_new = 1;
        }

        $data_update = array(
            'phone_called' => $wa_clicked_new
        );

        $this->db->where('lead_id', $lead_id);
        $update = $this->db->update('tbl_lead', $data_update);

        if ($update) {
            $data = array(
                'res' => 200,
                'message' => 'success',
            );
        } else {
            $data = array(
                'res' => 400,
                'message' => 'error',
            );
        }

        echo json_encode($data);
    }

    public function getNotificationDetail() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');


        $campaign_id = $this->input->get('id');
        $sales_officer_od = $this->input->get('agent_id');

        //get channel 
        $data_channel = $this->db->get_where('tbl_channel', array('campaign_id' => $campaign_id))->result();

        $channel_id = array();

        if (!empty($data_channel)) {
            foreach ($data_channel as $channels) {
                array_push($channel_id, $channels->id);
            }


            $this->db->where('a.sales_officer_id', $sales_officer_od);
            $this->db->order_by('a.create_date', 'desc');
            $this->db->where_in('a.channel_id', $channel_id);
            $this->db->where('is_seen', 0);
            $this->db->select('a.*, b.status_name, d.sales_officer_name, e.campaign_name, f.channel_name, f.channel_media, g.product_name, h.kota_name, i.category_name, i.color, i.icon, j.sales_team_name, z.media_name');
            $this->db->join('tbl_status b', 'a.status_id = b.id', 'left');
            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id', 'left');
            $this->db->join('tbl_channel f', 'a.channel_id = f.id');
            $this->db->join('tbl_product g', 'a.product_id = g.id', 'left');
            $this->db->join('tbl_campaign e', 'e.id = f.campaign_id');
            $this->db->join('tbl_lead_category i', 'i.lead_category_id = a.lead_category_id');
            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
            $this->db->join('tbl_sales_officer_group k', 'k.sales_officer_id = a.sales_officer_id', 'left');
            $this->db->join('tbl_sales_team j', 'k.sales_team_id = j.sales_team_id', 'left');
            $this->db->join('tbl_media z', 'f.channel_media = z.id', 'left');
            $data_lead = $this->db->get('tbl_lead a')->result();

            $res = 200;
            $count = count($data_lead);
        } else {
            $data_lead = array();
            $res = 400;
            $count = 0;
        }

        $data = array('res' => $res, 'count' => $count, 'data' => $data_lead);

        echo json_encode($data);
    }

    public function changeProfile() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $sales_officer_id = $post->sales_officer_id;
        $profile_name = $post->profile_name;
        $profile_password = $post->profile_newpassword;
        $profile_phone = $post->profile_phone;

        $data_update = array(
            'sales_officer_name' => $profile_name,
            'sales_officer_password' => $profile_password,
            'sales_officer_phone' => $profile_phone
        );

        $this->db->where('sales_officer_id', $sales_officer_id);
        $update = $this->db->update('tbl_sales_officer', $data_update);

        if ($update) {
            $res = 200;
        } else {
            $res = 400;
        }

        $data = array('res' => $res);


        echo json_encode($data);
    }

    public function changeProfileName() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $sales_officer_id = $post->sales_officer_id;
        $profile_name = $post->profile_name;
        $profile_phone = $post->profile_phone;

        $data_update = array(
            'sales_officer_name' => $profile_name,
            'sales_officer_phone' => $profile_phone
        );

        $this->db->where('sales_officer_id', $sales_officer_id);
        $update = $this->db->update('tbl_sales_officer', $data_update);

        if ($update) {
            $message = "Profile has been changed";
            $res = 200;
        } else {
            $message = "Internal Server Error contact your support";
            $res = 400;
        }

        $data = array('res' => $res, 'message' => $message);


        echo json_encode($data);
    }

    public function forgotPassword() {

        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $sales_officer_email = $post->email;

        //get data sales officer 
        $data_sales_officer = $this->db->get_where('tbl_sales_officer', array('sales_officer_email' => $sales_officer_email))->row();

        if (!empty($data_sales_officer)) {
            $email = $data_sales_officer->sales_officer_email;
            $sales_officer_id = $data_sales_officer->sales_officer_id;
            $token = $data_sales_officer->sales_officer_token;

            $body = '<h4>Please click link below to change your password</h4>'
                    . '<br><a href="https://jala.ai/dashboard/login/change_password/?id=' . $sales_officer_id . '">change password</a>'
                    . '<br><p>and is this your token ' . $token . ' </p>';

            $send_mail = $this->MainModels->sendmail($body, 'Forgot Password', $email);

            if ($send_mail) {
                $res = 200;
            } else {
                $res = 400;
            }
        } else {
            $res = 400;
        }

        $data = array('res' => $res);

        echo json_encode($data);
    }

    public function test_email() {

        $email = $this->input->get('mail');

        //get data sales officer 
        $body = '<h4>Please click link below to change your password</h4>'
                . '<br><a href="https://jala.ai/dashboard/user/change_password/?id=' . $email . '">change email</a>';

        $send_mail = $this->MainModels->sendmail($body, 'Forgot Password', $email);

        if ($send_mail) {
            print_r($send_mail);
            exit;
        } else {
            print_r($send_mail);
            exit;
        }
    }

    public function getCampaignIdbyLeadId() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $lead_id = $this->input->get('id');

        $this->db->select('b.campaign_id');
        $this->db->join('tbl_channel b', 'b.id = a.channel_id');
        $campaign_id = $this->db->get_where('tbl_lead a', array('a.lead_id' => $lead_id))->row('campaign_id');

        $data = array('campaign_id' => $campaign_id);

        echo json_encode($data);
    }

    public function getPaymentClientId() {
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $client_id = $this->input->get('id');

        $data_payment = $this->db->get_where('tbl_payment', array('client_id' => $client_id))->result();

        $data = array('status' => 200, 'count' => count($data_payment), 'data' => $data_payment);

        echo json_encode($data);
    }

}
