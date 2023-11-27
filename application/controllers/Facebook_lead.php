<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook_lead extends CI_Controller {

    public function index() {

        $data_facebook_lead = $this->db->get_where('facebook_lead', array('flag' => 0))->result();
        $error = array();
        
        if (!empty($data_facebook_lead)) {
            foreach ($data_facebook_lead as $data) {

                $this->db->order_by('kota_id', 'desc');
                $this->db->like('kota_name', $data->city);
                $this->db->or_like('alias', $data->city);
                $city_id = $this->db->get('tbl_kota')->row('kota_id');

                
                if (!empty($city_id)) {

                    $data_update_city = array('city' => $city_id);

                    $this->db->where('id_facebook_lead', $data->id_facebook_lead);
                    $update_city = $this->db->update('facebook_lead', $data_update_city);
                    
                    if (!$update_city) {
                        $bugs = array(
                            'id' => $data->id_facebook_lead,
                            'message' => 'error update city in id' . $data->id_facebook_lead
                        );

                        array_push($error, $bugs);
                        //$this->sendmail('error when update city', 'notif error tbl_city');
                    } else {
                        
                        //get data status 

                        $data_channel = $this->db->get_where('tbl_channel', array('id' => $data->campaign_id))->row();

                        //get data project
                        $project_id = $this->db->get_where('tbl_campaign', array('id' => $data_channel->campaign_id))->row('project_id');

                        $new_leads_id = $this->db->get_where('tbl_status', array('project_id' => $project_id, 'status_name' => 'New Leads'))->row('id');

                        $query = "INSERT INTO `jala-new-production`.tbl_lead 
                     (channel_id, lead_name, lead_phone, lead_email, create_date, status_id, lead_city, lead_category_id) 
                     SELECT $data->campaign_id, fullname, phone_number, email, CONVERT_TZ(created_time, '+07:00', '+00:00'), $new_leads_id, city, 1
                     FROM `jala-new-production`.facebook_lead 
                     WHERE flag = 0 AND id_facebook_lead = $data->id_facebook_lead ";
                        
                        $insert_lead = $this->db->query($query);

                        if (!$insert_lead) {
                            $bugs = array(
                                'id' => $data->id_facebook_lead,
                                'message' => 'error insert table lead id' . $data->id_facebook_lead
                            );

                            array_push($error, $bugs);
                            //$this->sendmail('error when insert into tbl_lead', 'notif error tbl_lead');
                        } else {

                            $data_update_flag = array('flag' => 1);
                            $this->db->where('id_facebook_lead', $data->id_facebook_lead);
                            $update_flag = $this->db->update('facebook_lead', $data_update_flag);

                            if (!$update_flag) {
                                $bugs = array(
                                    'id' => $data->id_facebook_lead,
                                    'message' => 'error update flag in id' . $data->id_facebook_lead
                                );

                                array_push($error, $bugs);

                                //$this->sendmail('error when update flag', 'error update flag');
                            } else {
                                $query_phone = "update tbl_lead set lead_phone = replace(lead_phone, '+', '') where lead_phone like '%+6%' ;";
                                $update_phone = $this->db->query($query_phone);

                                if (!$update_phone) {
                                    $bugs = array(
                                        'id' => $data->id_facebook_lead,
                                        'message' => 'error update phone_number in id' . $data->id_facebook_lead
                                    );
                                }
                            }
                        }
                    }
                }
            }

            if (!empty($error)) {
                $this->sendmail($error, 'notify error in facebook lead form');
            } else {
                $this->sendmail('success scheduler', 'notify success in facebook lead form');
            }
        }
    }

    private function sendmail($message, $title) {

        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user'] = 'pradhigda20@gmail.com';
        $config['smtp_pass'] = 'yayan717';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'text'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not      

        $this->email->initialize($config);

        $this->email->from('notification@gmail.com', $title);
        $this->email->to('pradhigda31@gmail.com');

        $this->email->subject('Notification');
        $this->email->message($message);

        $send = $this->email->send();

        if ($send) {
            return true;
        } else {
            return false;
        }
    }

}
