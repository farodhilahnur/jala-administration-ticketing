<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('NotificationModels');
    }

    public function daily() {

        $data_client = $this->db->get_where('tbl_client', array('status' => 1))->result();

        foreach ($data_client as $dc) {

            //lead per category performance 
            $data_lead_category = $this->NotificationModels->getDataCategoryLeadReportByClientId($dc->client_id);
            //lead per status performance
            $data_lead_status = $this->NotificationModels->getLeadStatusReportbyClientId($dc->client_id);
            //channel performance
            $data_channel_performance = $this->NotificationModels->getDataLeadByChannelReport($dc->client_id);
            //campaign performance 
            $data_campaign_performance = $this->NotificationModels->getDataLeadByCampaignReport($dc->client_id);
            //team performance 
            $data_team_performance = $this->NotificationModels->getDataTeamPerformanceReport($dc->client_id);
            //sales performance
            $data_sales_performance = $this->NotificationModels->getDataSalesPerformanceReport($dc->client_id);

            $data = array(
                'data_lead_category' => $data_lead_category,
                'data_lead_status' => $data_lead_status,
                'client_name' => $dc->client_name,
                'channel_performance' => $data_channel_performance,
                'campaign_performance' => $data_campaign_performance,
                'team_performance' => $data_team_performance,
                'sales_performance' => $data_sales_performance
            );

            $message = $this->load->view('notification/daily_report', $data, TRUE);
            $title = "Daily Notification";
            $to = $dc->client_email;
            $send = $this->MainModels->sendmail($message, $title, $to);

            if ($send) {
                echo "success";
                
                $title = "Success Sent Daily Notification";
                $to = $dc->client_email;
                
                $send = $this->MainModels->sendmail('success send daily notification', $title, 'pradhigda17@gmail.com');
                
            } else {
                echo "error";
                
                $title = "Error Sent Daily Notification";
                $to = $dc->client_email;
                
                $send = $this->MainModels->sendmail('error send daily notification', $title, 'pradhigda17@gmail.com');
            }
        }
    }

}
