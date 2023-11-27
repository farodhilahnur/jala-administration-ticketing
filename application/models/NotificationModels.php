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

        $lead_count = $this->db->get_where('tbl_notification', array('sales_officer_id' => $sales_officer_id))->row('lead_count');

        if (!empty($lead_count)) {
            $count = $lead_count;
        } else {
            $count = 0;
        }

        return $count;
    }

    public function getDataCategoryLeadReportByClientId($client_id) {
        $this->db->order_by('urutan', 'asc');
        $data_category = $this->db->get('tbl_lead_category')->result();

        $jum = count($this->LeadModels->getLeadReportClientId($client_id));

        $list_channel_id = array();

        $data_channel = $this->ChannelModels->getDataChannelReportbyClientId($client_id);

        foreach ($data_channel as $dc) {
            array_push($list_channel_id, $dc->id);
        }

        if (!empty($list_channel_id)) {

            $data_chart = array();

            foreach ($data_category as $dct) {
                $this->db->where_in('a.channel_id', $list_channel_id);
                $this->db->where('a.lead_category_id', $dct->lead_category_id);
                $this->db->select('count(a.lead_id) as total');
                $data_lead_by_category = $this->db->get('tbl_lead a')->row();

                if ($jum != 0) {
                    $percent = round(intval($data_lead_by_category->total / intval($jum) * 100), 2);
                } else {
                    $percent = 0;
                }

                $data = array(
                    'category_name' => $dct->category_name,
                    'total' => $data_lead_by_category->total,
                    'percent' => $percent,
                    'icon' => $dct->icon,
                    'color' => $dct->color
                );

                array_push($data_chart, $data);
            }
        } else {
            $data_chart = array();
            $data = array();
            array_push($data_chart, $data);
        }

        return $data_chart;
    }

    public function getLeadStatusReportbyClientId($client_id) {

        $list_project_id = array();
        $data_project = $this->ProjectModels->getDataProjectReportbyClientId($client_id);

        if (!empty($data_project)) {
            foreach ($data_project as $dp) {
                array_push($list_project_id, $dp->id);
            }

            //get status group by name 

            $this->db->order_by('id', 'asc');
            $this->db->where_in('project_id', $list_project_id);
            $this->db->group_by('status_name');
            $data_status = $this->db->get('tbl_status')->result();

            $list_status_name = array();

            if (!empty($data_status)) {
                foreach ($data_status as $ds) {
                    array_push($list_status_name, $ds->status_name);
                }

                $data_channel = $this->ChannelModels->getDataChannelReportbyClientId($client_id);

                if (!empty($data_channel)) {

                    $list_channel_id = array();

                    foreach ($data_channel as $channel) {
                        array_push($list_channel_id, $channel->id);
                    }

                    $jum = count($this->LeadModels->getLeadReportClientId($client_id));

                    $this->db->order_by('b.id', 'asc');
                    $this->db->where_in('a.channel_id', $list_channel_id);
                    $this->db->where_in('b.status_name', $list_status_name);
                    $this->db->select('b.status_name, count(a.lead_id) as total');
                    $this->db->join('tbl_status b', 'a.status_id = b.id');
                    $this->db->group_by('b.status_name');
                    $data_lead = $this->db->get('tbl_lead a')->result();

                    $data_chart = array();

                    if (!empty($data_lead)) {
                        foreach ($data_lead as $dl) {

                            $percent = round(intval($dl->total / intval($jum) * 100), 2);

                            $data_push = array('status_name' => $dl->status_name, 'total' => $dl->total, 'percent' => $percent);

                            array_push($data_chart, $data_push);
                        }
                    } else {
                        $data_chart = array();
                    }
                } else {
                    $data_chart = array();
                }
            } else {
                $data_chart = array();
            }
        } else {
            $data_chart = array();
        }


        return $data_chart;
    }

    public function getDataLeadByChannelReport($client_id) {

        $jum = count($this->LeadModels->getLeadReportClientId($client_id));
        $data_chart = array();

        $data_channel = $this->ChannelModels->getDataChannelReportbyClientId($client_id);

        foreach ($data_channel as $dch) {
            $this->db->where_in('a.channel_id', $dch->id);
            $this->db->select('count(a.lead_id) as total');
            $data_lead_by_channel = $this->db->get('tbl_lead a')->row();

            if ($jum != 0) {
                $percent = round(intval($data_lead_by_channel->total / intval($jum) * 100), 2);
            } else {
                $percent = 0;
            }

            $data = array(
                'channel_name' => $dch->channel_name,
                'total' => $data_lead_by_channel->total,
                'percent' => $percent
            );

            array_push($data_chart, $data);
        }

        return $data_chart;
    }

    public function getDataLeadByCampaignReport($client_id) {

        $data_campaign = $this->CampaignModels->getDataCampaignReportbyClientId($client_id);
        $jum = count($this->LeadModels->getLeadReportClientId($client_id));
        $data_chart = array();

        foreach ($data_campaign as $dcc) {

            $list_channel_id = array();

            //get data channel
            $data_channel = $this->ChannelModels->getDataChannelbyCampagnId($dcc->id);

            foreach ($data_channel as $dch) {
                array_push($list_channel_id, $dch->channel_id);
            }

            if (!empty($list_channel_id)) {
                $this->db->where_in('a.channel_id', $list_channel_id);
                $this->db->select('count(a.lead_id) as total');
                $data_lead_by_channel = $this->db->get('tbl_lead a')->row();

                $list_channel_id = array();

                if ($jum != 0) {
                    $percent = round(intval($data_lead_by_channel->total / intval($jum) * 100), 2);
                } else {
                    $percent = 0;
                }

                $data = array(
                    'campaign_name' => $dcc->campaign_name,
                    'total' => $data_lead_by_channel->total,
                    'percent' => $percent
                );
            } else {

                $data = array(
                    'campaign_name' => $dcc->campaign_name,
                    'total' => 0,
                    'percent' => 0
                );
            }

            array_push($data_chart, $data);
        }

        return $data_chart;
    }

    public function getDataTeamPerformanceReport($client_id) {

        //get data sales team 
        $list_sales_team = array();
        $data_sales_team = $this->db->get_where('tbl_sales_team', array('client_id' => $client_id))->result();

        foreach ($data_sales_team as $dst) {
            array_push($list_sales_team, $dst->sales_team_id);
        }

        $data_chart_team = $this->LeadModels->getDataLeadBySalesTeamReport($list_sales_team, $client_id);

        return $data_chart_team;
    }

    public function getDataSalesPerformanceReport($client_id) {
        
        $data_sales_officer = $this->TeamModels->getDataSalesOfficerByClientId($client_id);

        $list_sales_officer_id = array();

        foreach ($data_sales_officer as $dso) {
            array_push($list_sales_officer_id, $dso->sales_officer_id);
        }

        if (!empty($list_sales_officer_id)) {
            $data_chart_sales_officer = $this->LeadModels->getDataLeadBySalesOfficer($list_sales_officer_id);
        } else {
            $data_chart_sales_officer = array();
        }
        
        return $data_chart_sales_officer ;
    }

}
