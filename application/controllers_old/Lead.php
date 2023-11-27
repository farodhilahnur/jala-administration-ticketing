<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Lead extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('LeadModels');
    }

    public function get_first_char($str)
    {
        if ($str) {
            return strtolower(substr($str, 0, 1));
        } else {
            return;
        }
    }
    
    public function post_lead_saumata()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $now = date('y-m-d h:i:s');   
        $tgl = '20'.$now;

        $post = $this->input->post();

        $name = addslashes($post['name']);
//        $address = addslashes($post['address']);
        $phone = addslashes($post['phone']);
        $email = strtolower($post['email']);
//        $city = $post['city'];
        $source = ($post['source']);
        $product = $post['product'];

        $test = $this->get_first_char($phone);

        if ($test == '0') {
            $ptn = '/^0/';  // Regex
            $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
            $rpltxt = '62';  // Replacement string
            $phone_new = preg_replace($ptn, $rpltxt, $str);
        } else {
            $phone_new = '62'.$phone;
        }

        $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $source))->row();

        //get data project
        $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

        $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Leads'))->row('id');

        $data_insert = array(
            'channel_id' => $data_channel->id,
            'lead_name' => $name,
            'lead_phone' => $phone_new,
            'lead_email' => $email,
            'sales_officer_id' => 0,
            'status_id' => $new_leads_id,
            'product_id' => $product
        );

        $insert = $this->db->insert('tbl_lead', $data_insert);

        if ($insert) {
            $data = array(
                'res' => 200,
                'redirect' => $data_channel->channel_redirect_url,
            );
        } else {
            $data = array(
                'res' => 400,
                'redirect' => $data_channel->channel_redirect_url,
            );
        }

        echo json_encode($data);
    }
    
    public function post_puri_orchard()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $now = date('y-m-d h:i:s');
        $tgl = '20'.$now;

        $post = $this->input->post();

        $name = addslashes($post['name']);
//        $address = addslashes($post['address']);
        $phone = addslashes($post['phone']);
        $email = strtolower($post['email']);
//        $city = $post['city'];
        $source = ($post['source']);
        $lead_from = $post['lead_from'];
        $noktp = $post['noktp'];

        $test = $this->get_first_char($phone);

        if ($test == '0') {
            $ptn = '/^0/';  // Regex
            $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
            $rpltxt = '62';  // Replacement string
            $phone_new = preg_replace($ptn, $rpltxt, $str);
        } else {
            $phone_new = '62'.$phone;
        }

        $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $source))->row();

        //get data project
        $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

        $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Leads'))->row('id');

        $data_insert = array(
            'channel_id' => $data_channel->id,
            'lead_name' => $name,
            'lead_phone' => $phone_new,
            'lead_email' => $email,
            'sales_officer_id' => 0,
            'status_id' => $new_leads_id,
            'lead_from' => $lead_from, 
            'no_ktp' => $noktp  
        );

        $insert = $this->db->insert('tbl_lead', $data_insert);

        if ($insert) {
            $data = array(
                'res' => 200,
                'redirect' => $data_channel->channel_redirect_url,
            );
        } else {
            $data = array(
                'res' => 400,
                'redirect' => $data_channel->channel_redirect_url,
            );
        }

        echo json_encode($data);
    }
    
    public function post_lead()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $now = date('y-m-d h:i:s');
        $tgl = '20'.$now;

        $post = $this->input->post();

        $name = addslashes($post['name']);
        $address = addslashes($post['address']);
        $phone = addslashes($post['phone']);
        $email = strtolower($post['email']);
        $city = $post['city'];
        $source = ($post['source']);

        $test = $this->get_first_char($phone);

        if ($test == '0') {
            $ptn = '/^0/';  // Regex
            $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
            $rpltxt = '+62';  // Replacement string
            $phone_new = preg_replace($ptn, $rpltxt, $str);
        } else {
            $phone_new = '+62'.$phone;
        }

        $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $source))->row();

        //get data project
        $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

        $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Lead'))->row('id');

        $data_insert = array(
            'channel_id' => $data_channel->id,
            'lead_name' => $name,
            'lead_address' => $address,
            'lead_phone' => $phone_new,
            'lead_email' => $email,
            'sales_officer_id' => 0,
            'status_id' => $new_leads_id,
            'lead_city' => $city,
        );

        $insert = $this->db->insert('tbl_lead', $data_insert);

        if ($insert) {
            $data = array(
                'res' => 200,
                'redirect' => $data_channel->channel_redirect_url,
            );
        } else {
            $data = array(
                'res' => 400,
                'redirect' => $data_channel->channel_redirect_url,
            );
        }

        echo json_encode($data);
    }
    
    public function post_lead_pakuan()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $now = date('y-m-d h:i:s');
        $tgl = '20'.$now;

        $post = $this->input->post();
           
        $name = addslashes($post['name']);
        $address = addslashes($post['address']);
        $phone = addslashes($post['phone']);
        $email = strtolower($post['email']);
        $note = $post['notes'];
        $city = 1158;
        $source = ($post['source']);

        $test = $this->get_first_char($phone);

        if ($test == '0') {
            $ptn = '/^0/';  // Regex
            $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
            $rpltxt = '+62';  // Replacement string
            $phone_new = preg_replace($ptn, $rpltxt, $str);
        } else {
            $phone_new = '+62'.$phone;
        }

        $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $source))->row();

        //get data project
        $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

        $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Leads'))->row('id');

        $data_insert = array(
            'channel_id' => $data_channel->id,
            'lead_name' => $name,
            'lead_address' => $address,
            'lead_phone' => $phone_new,
            'lead_email' => $email,
            'sales_officer_id' => 0,
            'note' => $note,
            'status_id' => $new_leads_id,
            'lead_city' => $city,
        );

        $insert = $this->db->insert('tbl_lead', $data_insert);

        if ($insert) {
            $data = array(
                'res' => 200,
                'redirect' => $data_channel->channel_redirect_url,
            );
        } else {
            $data = array(
                'res' => 400,
                'redirect' => $data_channel->channel_redirect_url,
            );
        }

        echo json_encode($data);
    }
    
    public function post_lead_martadinata()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        if (!ini_get('date.timezone')) {
            date_default_timezone_set('GMT');
        }

        $now = date('y-m-d h:i:s');
        $tgl = '20'.$now;

        $post = $this->input->post();
        
        $name = addslashes($post['name']);
        $phone = addslashes($post['phone']);
        $email = strtolower($post['email']);
        $city = 1158;
        $source = ($post['source']);

        $test = $this->get_first_char($phone);

        if ($test == '0') {
            $ptn = '/^0/';  // Regex
            $str = $phone; //Your input, perhaps $_POST['textbox'] or whatever
            $rpltxt = '62';  // Replacement string
            $phone_new = preg_replace($ptn, $rpltxt, $str);
        } else {
            $phone_new = '62'.$phone;
        }

        $data_channel = $this->db->get_where('tbl_channel', array('unique_code' => $source))->row();
        
        //get data project
        $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

        $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Leads'))->row('id');

        $data_insert = array(
            'channel_id' => $data_channel->id,
            'lead_name' => $name,
            'lead_phone' => $phone_new,
            'lead_email' => $email,
            'sales_officer_id' => 0,
            'lead_category_id' => 1,
            'status_id' => $new_leads_id
//            'lead_city' => $city,
        );
        
        $insert = $this->db->insert('tbl_lead', $data_insert);
        
        if ($insert) {
            $data = array(
                'res' => 200,
                'redirect' => $data_channel->channel_redirect_url,
            );
        } else {
            $data = array(
                'res' => 400,
                'redirect' => $data_channel->channel_redirect_url,
            );
        }
        
        echo json_encode($data);
    }

    public function lead_distribution()
    {
        //check lead undelivered
        $data_lead = $this->db->get_where('tbl_lead', array('sales_officer_id' => 0))->result();

        //check channel participate sales team
        if (!empty($data_lead)) {
            foreach ($data_lead as $a => $dl) {
                $this->db->order_by('a.id', 'asc');
                $this->db->where('b.city_id', $dl->lead_city);
                $this->db->join('tbl_sales_team_city b', 'a.sales_team_id = b.sales_team_id');
                $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel a', array('a.channel_id' => $dl->channel_id))->row();

                if (!empty($data_sales_team_channel)) {
                    $data_sales_team_distribution = $this->db->get_where('tbl_sales_team_distribution', array('channel_id' => $dl->channel_id))->row();

                    if (empty($data_sales_team_distribution)) {
                        //check sales officer in sales team
                        $data_insert_sales_team_distribution = array(
                            'channel_id' => $dl->channel_id,
                            'sales_team_id' => $data_sales_team_channel->sales_team_id,
                            'kota_id' => $dl->lead_city,
                        );

                        $this->db->insert('tbl_sales_team_distribution', $data_insert_sales_team_distribution);

                        $this->db->order_by('sales_officer_group_id', 'asc');
                        $data_sales_officer = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $data_sales_team_channel->sales_team_id, 'is_gifted' => 0))->row();

                        //check sales officer distribution
                        $data_sales_officer_distribution = $this->db->get_where('tbl_sales_officer_distribution', array('channel_id' => $dl->channel_id))->row();

                        if (empty($data_sales_officer_distribution)) {
                            $data_insert_sales_officer_distribution = array(
                                'sales_officer_id' => $data_sales_officer->sales_officer_id,
                                'channel_id' => $dl->channel_id,
                                'kota_id' => $dl->lead_city,
                            );

                            $this->db->insert('tbl_sales_officer_distribution', $data_insert_sales_officer_distribution);

                            $data_update_sales_officer_group = array('is_gifted' => 1);
                            $this->db->where('sales_officer_id', $data_sales_officer->sales_officer_id);
                            $this->db->update('tbl_sales_officer_group', $data_update_sales_officer_group);

                            //update lead
                            $this->db->where('lead_id', $dl->lead_id);
                            $this->db->update('tbl_lead', array('sales_officer_id' => $data_sales_officer->sales_officer_id));
                        } else {
                            $this->db->order_by('sales_officer_group_id', 'asc');
                            //$this->db->where('sales_officer_id >', $data_sales_officer_distribution->sales_officer_id);
                            $data_sales_officer = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $data_sales_team_channel->sales_team_id, 'is_gifted' => 0))->row();

                            $data_update_sales_offcier_distribution = array('sales_officer_id' => $data_sales_officer->sales_officer_id);
                            $this->db->where('channel_id', $dl->channel_id);
                            $this->db->update('tbl_sales_officer_distribution', $data_update_sales_offcier_distribution);

                            $data_update_sales_officer_group = array('is_gifted' => 1);
                            $this->db->where('sales_officer_id', $data_sales_officer->sales_officer_id);
                            $this->db->update('tbl_sales_officer_group', $data_update_sales_officer_group);

                            //update lead
                            $this->db->where('lead_id', $dl->lead_id);
                            $this->db->update('tbl_lead', array('sales_officer_id' => $data_sales_officer->sales_officer_id));
                        }
                    } else {
                        $this->db->order_by('a.id', 'asc');
                        $this->db->where('a.sales_team_id >', $data_sales_team_distribution->sales_team_id);
                        $this->db->where('b.city_id', $dl->lead_city);
                        $this->db->join('tbl_sales_team_city b', 'a.sales_team_id = b.sales_team_id');
                        $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel a', array('a.channel_id' => $dl->channel_id))->row();

                        if (!empty($data_sales_team_channel)) {
                            $data_update = array('sales_team_id' => $data_sales_team_channel->sales_team_id);

                            $this->db->where('channel_id', $dl->channel_id);
                            $this->db->update('tbl_sales_team_distribution', $data_update);
                        } else {
                            $this->db->order_by('a.id', 'asc');
                            $this->db->where('b.city_id', $dl->lead_city);
                            $this->db->join('tbl_sales_team_city b', 'a.sales_team_id = b.sales_team_id');
                            $data_sales_team_channel = $this->db->get_where('tbl_sales_team_channel a', array('a.channel_id' => $dl->channel_id))->row();

                            if (!empty($data_sales_team_channel)) {
                                $data_update = array('sales_team_id' => $data_sales_team_channel->sales_team_id);

                                $this->db->where('channel_id', $dl->channel_id);
                                $this->db->update('tbl_sales_team_distribution', $data_update);
                            }
                        }

                        $this->db->order_by('sales_officer_group_id', 'asc');
                        $data_sales_officer = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $data_sales_team_channel->sales_team_id, 'is_gifted' => 0))->row();

                        //check sales officer distribution
                        $data_sales_officer_distribution = $this->db->get_where('tbl_sales_officer_distribution', array('channel_id' => $dl->channel_id))->row();

                        if (empty($data_sales_officer_distribution)) {
                            $data_insert_sales_officer_distribution = array(
                                'sales_officer_id' => $data_sales_officer->sales_officer_id,
                                'channel_id' => $dl->channel_id,
                                'kota_id' => $dl->lead_city,
                            );

                            $this->db->insert('tbl_sales_officer_distribution', $data_insert_sales_officer_distribution);

                            $data_update_sales_officer_group = array('is_gifted' => 1);
                            $this->db->where('sales_officer_id', $data_sales_officer->sales_officer_id);
                            $this->db->update('tbl_sales_officer_group', $data_update_sales_officer_group);

                            //update lead
                            $this->db->where('lead_id', $dl->lead_id);
                            $this->db->update('tbl_lead', array('sales_officer_id' => $data_sales_officer->sales_officer_id));
                        } else {
                            $this->db->order_by('sales_officer_group_id', 'asc');
                            //$this->db->where('sales_officer_id >', $data_sales_officer_distribution->sales_officer_id);
                            $data_sales_officer = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $data_sales_team_channel->sales_team_id, 'is_gifted' => 0))->row();

                            if (!empty($data_sales_officer)) {
                                $data_update_sales_offier_distribution = array('sales_officer_id' => $data_sales_officer->sales_officer_id);
                                $this->db->where('channel_id', $dl->channel_id);
                                $this->db->update('tbl_sales_officer_distribution', $data_update_sales_offier_distribution);

                                $data_update_sales_officer_group = array('is_gifted' => 1);
                                $this->db->where('sales_officer_id', $data_sales_officer->sales_officer_id);
                                $this->db->update('tbl_sales_officer_group', $data_update_sales_officer_group);

                                //update lead
                                $this->db->where('lead_id', $dl->lead_id);
                                $this->db->update('tbl_lead', array('sales_officer_id' => $data_sales_officer->sales_officer_id));
                            } else {
                                $data_update_sales_officer_group = array('is_gifted' => 0);
                                $this->db->where('sales_team_id', $data_sales_team_channel->sales_team_id);
                                $this->db->update('tbl_sales_officer_group', $data_update_sales_officer_group);

                                $this->db->order_by('sales_officer_group_id', 'asc');
                                //$this->db->where('sales_officer_id >', $data_sales_officer_distribution->sales_officer_id);
                                $data_sales_officer = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $data_sales_team_channel->sales_team_id, 'is_gifted' => 0))->row();

                                $data_update_sales_offier_distribution = array('sales_officer_id' => $data_sales_officer->sales_officer_id);
                                $this->db->where('channel_id', $dl->channel_id);
                                $this->db->update('tbl_sales_officer_distribution', $data_update_sales_offier_distribution);

                                $data_update_sales_officer_group = array('is_gifted' => 1);
                                $this->db->where('sales_officer_id', $data_sales_officer->sales_officer_id);
                                $this->db->update('tbl_sales_officer_group', $data_update_sales_officer_group);

                                //update lead
                                $this->db->where('lead_id', $dl->lead_id);
                                $this->db->update('tbl_lead', array('sales_officer_id' => $data_sales_officer->sales_officer_id));
                            }
                        }
                    }
                } else {
                    $data_update_lead = array('sales_officer_id' => 1);
                    $this->db->where('lead_id', $dl->lead_id);

                    $update = $this->db->update('tbl_lead', $data_update_lead);
                }
            }
        } else {
            echo 'nothing new leads';
            exit;
        }
    }

    public function follow_up()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $post = $this->input->post();

        $lead_id = addslashes($post['lead_id']);
        $sales_officer_id = addslashes($post['sales_officer_id']);
        $lead_category_id = addslashes($post['lead_category_id']);
        $status_id = strtolower($post['status_id']);
        $product_id = $post['product_id'];
        $notes = $post['lead_notes'];

        //get data sales officer
        //$data_sales_officer = $this->db->get_where('tbl_sales_officer', array('sales_officer_id' => $sales_officer_id))->row();
        //sales officer last point
        //$sales_officer_last_point = floatval($data_sales_officer->point);
        //get old point
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
            'point' => $point,
        );

        $insert_lead_history = $this->db->insert('tbl_lead_history', $data_insert_lead_history);

        if ($insert_lead_history) {
            $data_insert_sales_officer_activity = array(
                'sales_officer_id' => $sales_officer_id,
                'lead_id' => $lead_id,
                'point' => $point,
            );

            $insert_sales_officer_activity = $this->db->insert('tbl_sales_officer_activity', $data_insert_sales_officer_activity);

            if ($insert_sales_officer_activity) {
                $data_update_lead = array('status_id' => $status_id, 'lead_category_id' => $lead_category_id, 'product_id' => $product_id);

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
                            'redirect' => base_url(),
                        );
                    }
                }
            }
        } else {
            $data = array(
                'res' => 400,
                'redirect' => base_url(),
            );
        }

        echo json_encode($data);
    }

    public function getDataFollowUpLead()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $id = $this->input->get('id');

        $data_lead = $this->db->get_where('tbl_lead', array('lead_id' => $id))->row();

        $data = array(
            'res' => 200,
            'data' => $data_lead,
        );

        echo json_encode($data);
    }

    public function getDataHistoryLead()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $id = $this->input->get('id');
        $html = '';

        $this->db->order_by('a.create_date', 'desc');
        $this->db->where('a.lead_id', $id);
        $this->db->select('a.*, b.category_name, b.icon, b.color, d.status_name');
        $this->db->join('tbl_status d', 'a.status_id = d.id ');
        $this->db->join('tbl_lead_category b', 'a.category_id = b.lead_category_id');
        $data_history_lead = $this->db->get_where('tbl_lead_history a', array('a.lead_id' => $id))->result();

        foreach ($data_history_lead as $key => $dlh) {
            $num = $key + 1;
            $html .= '<div class="timeline-item">
                            <div class="timeline-badge">
                                <span class="badge badge-roundless badge-success">'.$num.'</span>
                            </div>
                            <div class="timeline-body">
                                <div class="timeline-body-arrow"> </div>
                                <div class="timeline-body-head">
                                    <div class="timeline-body-head-caption">
                                        <a href="javascript:;" class="timeline-body-title font-blue-madison">'.$dlh->status_name.'</a>
                                        <span class="timeline-body-time font-grey-cascade">Called at 10-12-2018 </span>
                                    </div>
                                    <div class="timeline-body-head-actions">
                                        <label class="label label-md label-'.$dlh->color.'"> <span class="icon '.$dlh->icon.'"></span>&nbsp;'.$dlh->category_name.'</label>
                                    </div>
                                </div>
                                <div class="timeline-body-content">
                                    <span class="font-grey-cascade"> '.$dlh->notes.' </span>
                                </div>
                            </div>
                        </div>';
        }

        $data = array(
            'res' => 200,
            'data' => $html,
        );

        echo json_encode($data);
    }

    public function getDataTotalLead()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $get = $this->input->get();

        $session_dashboard = $this->session->userdata('dashboard');
        $date = explode(' to ', $session_dashboard['date_range']);
        $from_date = $date[0];
        $to_date = $date[1];

        $project_id = $session_dashboard['project_id'];
        $category_id_1 = $session_dashboard['category_id_1'];
        $category_id_2 = $session_dashboard['category_id_2'];
        $time_period = $get['period'];

        $data_lead = $this->LeadModels->getDataChartTotalLead($project_id, $from_date, $to_date, $category_id_1, $category_id_2, $time_period);

        echo json_encode($data_lead);
    }

    public function index()
    {
        $role = $this->MainModels->UserSession('role_id');
        $datatable_assets = $this->MainModels->getAssets('datatable');
        $lead_assets = $this->MainModels->getAssets('leads');
        $get = $this->input->get();

        $js = array_merge($datatable_assets['js'], $lead_assets['js']);
        $css = array_merge($datatable_assets['css']);

        if ($role == 1) {
            $data_lead = '';
            $data_campaign = $this->db->get('tbl_campaign')->result();
            $data_channel = '';

            $data_project = '';
        } else {
            $data_project = $this->ProjectModels->getDataProjectbyClientIdNonSession();
            $data_campaign = $this->CampaignModels->getDataCampaignbyClientIdNonSession();
            $data_channel = $this->ChannelModels->getDataChannelbyClientId();

            if (isset($get['sales_team_id'])) {
                $sales_team_id = $get['sales_team_id'];
            } else {
                $sales_team_id = 0;
            }

            if (isset($get['campaign_id'])) {
                $campaign_id = $get['campaign_id'];
            } else {
                $campaign_id = 0;
            }

            if (isset($get['sales_officer_id'])) {
                $sales_officer_id = $get['sales_officer_id'];
            } else {
                $sales_officer_id = 0;
            }

            if (isset($get['channel_id'])) {
                $channel_id = $get['channel_id'];
            } else {
                $channel_id = 0;
            }

            $data_lead = $this->LeadModels->getCountLeadbyClientIdLeadIndex($sales_team_id, $sales_officer_id, $campaign_id, $channel_id);
        }

        $data = array(
            'data_lead' => $data_lead,
            'data_campaign' => $data_campaign,
            'data_channel' => $data_channel,
            'js' => $js,
            'css' => $css,
            'total' => count($data_lead),
        );

        $this->template->load('template', 'leads/index', $data);
    }

    public function send_notif()
    {
        //get data sales officer registered
        $this->db->where('sales_officer_deviceid <>', '');
        $data_sales_officer = $this->db->get('tbl_sales_officer')->result();

        $this->load->model('CampaignModels');

        if (!empty($data_sales_officer)) {
            foreach ($data_sales_officer as $key => $dso) {
                //get data campaign by sales officer
                $data_campaign = $this->CampaignModels->getCampaignBySalesOfficerId($dso->sales_officer_id);

                foreach ($data_campaign as $dc) {
                    $data_new_lead = $this->LeadModels->getDataLeadByCampaignIdApiUnseen($dc['campaign_id'], 1, $dso->sales_officer_id);
                    $total = count($data_new_lead);

                    if ($total != 0) {
                        //get data notification
                        $data_notification = $this->db->get_where('tbl_notification', array('sales_officer_id' => $dso->sales_officer_id, 'campaign_id' => $dc['campaign_id']))->row();

                        if (empty($data_notification)) {
                            $msg = 'There is '.$total.' new leads from  ('.$dc['campaign_name'].')';
                            $data_insert_notification = array(
                                'sales_officer_id' => $dso->sales_officer_id,
                                'campaign_id' => $dc['campaign_id'],
                                'message' => $msg,
                                'type' => 1,
                                'is_read' => 0,
                                'lead_count' => $total,
                            );

                            $insert_notification = $this->db->insert('tbl_notification', $data_insert_notification);

                            if ($insert_notification) {
                                $notif_id = $this->db->insert_id();
                                $send = $this->sendNotification($dso->sales_officer_id, $dso->sales_officer_deviceid, $msg, 1, $notif_id, $dc['campaign_id'], $dc['campaign_name']);

                                if ($send->success != 0) {
                                    $data_update_notif = array('is_sent' => 1);
                                    $this->db->where('notification_id', $notif_id);
                                    $this->db->update('tbl_notification', $data_update_notif);
                                } else {
                                    echo '<pre>';
                                    print_r($send);
                                    echo '</pre>';
                                }
                            }
                        } else {
                            $notification_id = $data_notification->notification_id;
                            $lead_count = $data_notification->lead_count;

                            if ($total != $lead_count) {
                                $msg = 'There is '.$total.' new leads from  ('.$dc['campaign_name'].')';
                                $data_update = array(
                                    'lead_count' => $total,
                                    'message' => $msg,
                                    'is_read' => 0,
                                );

                                $this->db->where('notification_id', $notification_id);
                                $update = $this->db->update('tbl_notification', $data_update);

                                if ($update) {
                                    $send = $this->sendNotification($dso->sales_officer_id, $dso->sales_officer_deviceid, $msg, 1, $notification_id, $dc['campaign_id'], $dc['campaign_name']);

                                    if ($send->success != 0) {
                                        $data_update_notif = array('is_sent' => 1);
                                        $this->db->where('notification_id', $notification_id);
                                        $this->db->update('tbl_notification', $data_update_notif);
                                    } else {
                                        echo '<pre>';
                                        print_r($send);
                                        echo '</pre>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function test_not()
    {
        $send = $this->sendNotification('coAevJRz4Gw:APA91bGnAujG8VDCU1vWR6gjdYPrNKkPwnG-0hM1W5RcUiXE7Ibz5wZmXSVvmpl-1PSP-DkvOO4mR7gNPoBsZrbPMLfFYXCu0_vl8F1Kbc2tub_whzsx6U6qUMzA1K7TdrgBWc900TP6', 'TEST', 1, '123', '10', 'JANCOK');

        print_r($send->success);
        exit;
    }

    public function sendNotification($sales_officer_id, $device_id, $message, $notif_type, $notif_id, $campaign_id, $campaign_name)
    {
        // API access key from Google API's Console
        //$send = $this->sendNotification($device_id, $message, $notif_type, $notif_id, $campaign_id, $campaign_name);

        $key = 'AAAAIBosPbk:APA91bGTWNb4J4_cSA6hR1zb_rDAIRAP3NcckBkzBOqc5NTRpn1CW5WTKXWrZVBm58v5_bm4AsVNjWb69u5nyKHadV-b8M9EkHXQWJviIFsGUnP09C8pG09hhpUKzhW27Usjzqii-Jm8';

        //{
        // "to" : "coAevJRz4Gw:APA91bGnAujG8VDCU1vWR6gjdYPrNKkPwnG-0hM1W5RcUiXE7Ibz5wZmXSVvmpl-1PSP-DkvOO4mR7gNPoBsZrbPMLfFYXCu0_vl8F1Kbc2tub_whzsx6U6qUMzA1K7TdrgBWc900TP6",
        // "notification" : {
        //	 "body" : "great match!",
        //	 "content_available" : true,
        //	 "priority" : "high",
        //	 "title" : "Portugal vs. Denmark"
        // },
        // "data" : {
//     "body" : "Sending Notification Body From Data test",
//     "title": "Notification Title from Data",
//     "key_1" : "Value for key_1",
//     "key_2" : "Value for key_2"
        // }
        //}

        $notification = array(
            'body' => $message,
            'content_available' => true,
            'priority' => 'high',
            'title' => 'New Leads',
            'click_action' => 'FCM_PLUGIN_ACTIVITY',
        );

        $registrationIds = $device_id;
        // prep the bundle
        $msg = array(
            'body' => $message,
            'title' => 'Jala',
            'subtitle' => 'New Lead Notification',
            'tickerText' => 'New Lead Notification',
            'vibrate' => 1,
            'sound' => 1,
            'campaign_id' => $campaign_id,
            'sales_officer_id' => $sales_officer_id,
            'campaign_name' => $campaign_name,
            'notif_type' => $notif_type,
            'notif_id' => $notif_id,
        );
        $fields = array(
            'to' => $registrationIds,
            'notification' => $notification,
            'data' => $msg,
        );

        $headers = array(
            'Authorization: key='.$key,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        $json = json_decode($result);
        curl_close($ch);

        return $json;
    }

    public function excel()
    {
        $get = $this->input->get();
        $role = $this->MainModels->UserSession('role_id');
        $from = $get['from'];
        $to = $get['to'];

        if ($role == 1) {
            $project_id = 0;
            $data_lead = '';
            $data_campaign = $this->db->get('tbl_campaign')->result();
            $data_sales_officer = '';
            $data_status = '';
            $data_product = '';
            $data_sales_team = '';
            $data_channel = '';

            $data_lead_by_category = '';
            $data_lead_by_channel = '';
            $data_project = '';
        } elseif ($role == 2 || $role == 5) {
            $get = $this->input->get();
            $project_id = $get['id'];
            $data_project = $this->db->get_where('tbl_project', array('id' => $project_id))->row();

            $project_date = substr($data_project->create_at, 0, 10);
            $now = date('Y-m-d');
            $newDate = date('Y-m-d', strtotime($project_date));

            if (isset($get['campaign_id'])) {
                $campaign_id = $get['campaign_id'];
            } else {
                $campaign_id = 0;
            }

            if ($get['sales_team_id'] != null) {
                $sales_team_id = $get['sales_team_id'];
            } else {
                $sales_team_id = 0;
            }

//            if ($get['lead_category_id'] != null) {
//                $lead_category_id = $get['category_id'];
//            } else {
//                $lead_category_id = 0;
//            }
//
//            if ($get['status_id'] != null) {
//                $status_id = $get['status_id'];
//            } else {
//                $status_id = 0;
//            }

            if ($get['channel_id'] != null) {
                $channel_id = $get['channel_id'];
            } else {
                $channel_id = 0;
            }

            if ($get['sales_officer_id'] != null) {
                $sales_officer_id = $get['sales_officer_id'];
            } else {
                $sales_officer_id = 0;
            }

            $data_lead = $this->LeadModels->getDataLeadByProjectExcel($project_id, $campaign_id, $channel_id, $sales_team_id, $sales_officer_id, $from, $to);
            $data_campaign = $this->CampaignModels->getCampaignbyProjectId($project_id);

            if (!empty($data_campaign)) {
                $data_channel = $this->ChannelModels->getDataChannelbyProjectId($project_id);

                if (empty($data_channel)) {
                    $this->session->set_flashdata('message', '<p class="alert alert-warning">Create Channel First !!!</p>');
                    redirect(base_url('project/channel/?id='.$project_id));
                }
            } else {
                $this->session->set_flashdata('message', '<p class="alert alert-warning">Create Campaign First !!!</p>');
                redirect(base_url('project/campaign/?id='.$project_id));
            }
        } elseif ($role == 3) {
            $get = $this->input->get();
            $project_id = $get['id'];
            $data_project = $this->db->get_where('tbl_project', array('id' => $project_id))->row();

            $role_id = $this->MainModels->UserSession('role_id');
            $user_id = $this->MainModels->UserSession('user_id');

            $sales_team = $this->MainModels->getIdbyUserIdRoleId($user_id, $role_id);
            $sales_team_id = $sales_team['id'];

            $project_date = substr($data_project->create_at, 0, 10);
            $now = date('Y-m-d');
            $newDate = date('Y-m-d', strtotime($project_date));

            if (isset($get['campaign_id'])) {
                $data_session_filter = array('campaign_id' => $get['campaign_id'], 'date_range' => $get['date_range']);
                $this->session->set_userdata('filter', $data_session_filter);
            } else {
                $data_session_filter = array('campaign_id' => 0, 'date_range' => $newDate.' to '.$now);
                $this->session->set_userdata('filter', $data_session_filter);
            }

            if (isset($get['search'])) {
                if ($get['lead_category_id'] != null) {
                    $lead_category_id = $get['lead_category_id'];
                } else {
                    $lead_category_id = 0;
                }

                if ($get['status_id'] != null) {
                    $status_id = $get['status_id'];
                } else {
                    $status_id = 0;
                }

                if ($get['channel_id'] != null) {
                    $channel_id = $get['channel_id'];
                } else {
                    $channel_id = 0;
                }

                if ($get['sales_officer_id'] != null) {
                    $sales_officer_id = $get['sales_officer_id'];
                } else {
                    $sales_officer_id = 0;
                }

                $data_session_search = array('sales_team_id' => $sales_team_id, 'lead_category_id' => $lead_category_id, 'status_id' => $status_id, 'channel_id' => $channel_id, 'sales_officer_id' => $sales_officer_id);
                $this->session->set_userdata('search', $data_session_search);
            } else {
                $data_session_search = array('sales_team_id' => $sales_team_id, 'lead_category_id' => 0, 'status_id' => 0, 'channel_id' => 0, 'sales_officer_id' => 0);
                $this->session->set_userdata('search', $data_session_search);
            }

            $session_filter = $this->session->userdata('filter');
            $session_search = $this->session->userdata('search');

            $data_lead = $this->LeadModels->getDataLeadByProject($project_id, $session_filter, $session_search);

            $data_campaign = $this->CampaignModels->getCampaignbyProjectId($project_id);

            if (!empty($data_campaign)) {
                $data_channel = $this->ChannelModels->getDataChannelbyProjectId($project_id);

                if (empty($data_channel)) {
                    $this->session->set_flashdata('message', '<p class="alert alert-warning">Create Channel First !!!</p>');
                    redirect(base_url('project/channel/?id='.$project_id));
                }
            } else {
                $this->session->set_flashdata('message', '<p class="alert alert-warning">Create Campaign First !!!</p>');
                redirect(base_url('project/campaign/?id='.$project_id));
            }

            $data_sales_officer = $this->SalesOfficerModels->getSalesOfficerbyProjectId($project_id);
            $data_status = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status' => 1))->result();
            $data_product = $this->db->get_where('tbl_product', array('project_id' => $project_id, 'status' => 1))->result();
            $data_sales_team = $this->SalesTeamModels->getSalesTeamByProjectId($project_id);

            $data_lead_by_category = $this->LeadModels->getDataLeadByCategorybyProjectId($project_id);
            $data_lead_by_channel = $this->LeadModels->getDataLeadByChannelbyProjectId($project_id);
            $data_lead_by_campaign = $this->LeadModels->getDataLeadByCampaignbyProjectId($project_id);
        }

        $data_lead_category = $this->db->get_where('tbl_lead_category')->result();

        $data = array(
            'project_id' => $project_id,
            'now' => $now,
            'project_date' => $newDate,
            'data_lead' => $data_lead,
            'data_campaign' => $data_campaign,
            'data_lead_category' => $data_lead_category,
            'data_channel' => $data_channel,
            'total' => count($data_lead),
            'campaign_id' => $campaign_id,
            'title' => 'Leads '.$now,
        );

        $this->load->view('leads/lead_excel', $data);
    }
}
