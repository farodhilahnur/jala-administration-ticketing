<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('UserModels');   
    }

    public function change_phone_number() {


        $sql_62 = "UPDATE tbl_lead 
                   SET lead_phone = CONCAT('62', right(lead_phone, (length(lead_phone) - 1)))  
                   WHERE lead_phone like '08%'";


        $update = $this->db->query($sql_62);


        $sql_ples = "UPDATE tbl_lead
                     SET lead_phone = REPLACE(lead_phone,'+',' ') 
                     WHERE lead_phone like '+%'";


        $update = $this->db->query($sql_ples);   
    }

    public function callback_reminder() {

        $start = date('Y-m-d h:i');
        $now = date('Y-m-d H:i', strtotime('+7 hour +5 minutes', strtotime($start)));
        
        $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
        $this->db->join('tbl_channel b', 'a.channel_id = b.id');
        $this->db->join('tbl_campaign c', 'b.campaign_id = c.id');
        $this->db->select('a.*, b.campaign_id, c.campaign_name, d.sales_officer_deviceid');
        $data_callback = $this->db->get_where('tbl_lead a', array('a.callback' => $now))->result();
        
        if (!empty($data_callback)) {
            foreach ($data_callback as $dc) {
                $sales_officer_id = $dc->sales_officer_id;

                $notif_id = 2;
                //get sales device id 
                $msg = 'Lead ' . $dc->lead_name . ' scheduled for callback';

                $send = $this->sendNotification($sales_officer_id, $dc->sales_officer_deviceid, $msg, 2, $notif_id, $dc->campaign_id, $dc->campaign_name, $dc->lead_id);

                if ($send->success != 0) {
                    echo '<pre>';
                    print_r($send);
                    echo '</pre>';
                } else {
                    echo '<pre>';
                    print_r($send);
                    echo '</pre>';
                }
            }
        }
    }

    public function sendNotification($sales_officer_id, $device_id, $message, $notif_type, $notif_id, $campaign_id, $campaign_name, $lead_id) {
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
            'title' => 'Callback Reminder',
            'click_action' => 'FCM_PLUGIN_ACTIVITY',
        );

        $registrationIds = $device_id;
        // prep the bundle
        $msg = array(
            'body' => $message,
            'title' => 'Jala',
            'subtitle' => 'Callback Notification',
            'tickerText' => 'Callback Notification',
            'vibrate' => true,
            'sound' => true,
            'campaign_id' => $campaign_id,
            'sales_officer_id' => $sales_officer_id,
            'campaign_name' => $campaign_name,
            'notif_type' => $notif_type,
            'notif_id' => $notif_id,
            'lead_id' => $lead_id
        );
        $fields = array(
            'to' => $registrationIds,
            'notification' => $notification,
            'data' => $msg,
        );

        $headers = array(
            'Authorization: key=' . $key,
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

}
