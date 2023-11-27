<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MainModels extends CI_Model
{

    public function getAssets($params)
    {

        switch ($params) {
            case 'datatable':
                $js = array(
                    'assets/global/scripts/datatable.js',
                    'assets/global/plugins/datatables/datatables.min.js',
                    'assets/global/plugins/datatables/dataTables.buttons.min.js',
                    'assets/global/plugins/datatables/buttons.flash.min.js',
                    'assets/global/plugins/datatables/buttons.html5.min.js',
                    'assets/global/plugins/datatables/buttons.print.min.js',
                    'assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js',
                    'assets/pages/scripts/table-datatables-managed.js'
                );
                $css = array(
                    'assets/global/plugins/datatables/datatables.min.css',
                    'assets/global/plugins/datatables/buttons.dataTables.min.css',
                    'assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css'
                );
                break;
            case 'markdown':
                $js = array(
                    'assets/pages/scripts/components-editors.min.js',
                    'assets/global/plugins/bootstrap-markdown/lib/markdown.js',
                    'assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js'
                );
                $css = array(
                    'assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css'
                );
                break;
            case 'modals' :
                $js = array(
                    'assets/global/plugins/jquery-ui/jquery-ui.min.js',
                    'assets/pages/scripts/ui-modals.js'
                );
                $css = array('');
                break;
            case 'profile' :
                $js = array(
                    'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js',
                    'assets/global/plugins/jquery.sparkline.min.js',
                    'assets/pages/scripts/profile.js'
                );
                $css = array(
                    'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css',
                    'assets/pages/css/profile.css'
                );
                break;
            case 'daterangepicker' :
                $js = array(
                    'assets/global/plugins/moment.min.js',
                    'assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js',
                    'assets/pages/scripts/components-date-time-pickers.js',
                    'assets/global/plugins/bootstrap-daterangepicker/bootstrap-datepicker.min.js'
                );
                $css = array(
                    'assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css'
                );
                break;
            case 'counterup':
                $js = array(
                    "assets/global/plugins/counterup/jquery.waypoints.min.js",
                    "assets/global/plugins/counterup/jquery.counterup.min.js"
                );
                $css = array();
                break;
            case 'select2' :
                $js = array(
                    'assets/global/plugins/select2/js/select2.full.min.js',
                    'assets/pages/scripts/components-select2.js'
                );
                $css = array(
                    'assets/global/plugins/select2/css/select2.css',
                    'assets/global/plugins/select2/css/select2-bootstrap.min.css'
                );
                break;
            case 'file-input' :
                $js = array(
                    'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js'
                );
                $css = array(
                    'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'
                );
                break;
            case 'switch' :
                $js = array(
                    'assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
                    'assets/pages/scripts/components-bootstrap-switch.js'
                );
                $css = array(
                    'assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css'
                );
                break;
            case 'user' :
                $js = array(
                    'assets/custom/user.js',
                );
                $css = array();
                break;
            case 'leads' :
                $js = array(
                    'assets/custom/leads.js',
                );
                $css = array();
                break;
            case 'leads_in' :
                $js = array(
                    'assets/custom/leadIn.js',
                );
                $css = array();
                break;
            case 'project_setting' :
                $js = array(
                    'assets/custom/project_setting.js',
                );
                $css = array();
                break;
            case 'project' :
                $js = array(
                    'assets/custom/project.js',
                );
                $css = array(
                    'assets/custom/project.css',
                );
                break;
            case 'team' :
                $js = array(
                    'assets/custom/team.js',
                );
                $css = array(
                    'assets/custom/team.css',
                );
                break;
            case 'sales_officer' :
                $js = array(
                    'assets/custom/js/sales_officer.js',
                );
                $css = array();
                break;
            case 'media' :
                $js = array(
                    'assets/custom/media.js',
                );
                $css = array();
                break;
            case 'campaign' :
                $js = array(
                    'assets/custom/campaign.js',
                );
                $css = array();
                break;
            case 'channel' :
                $js = array(
                    'assets/custom/channel.js',
                );
                $css = array();
                break;
            case 'dashboard' :
                $js = array(
//                    'assets/custom/dashboard.js',
                    'assets/custom/js/dashboard.js'
                );
                $css = array();
                break;
            case 'form-wizard':
                $js = array(
                    'assets/pages/scripts/form-wizard.js',
                    'assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js',
                    'assets/global/plugins/jquery-validation/js/jquery.validate.min.js',
                    'assets/global/plugins/jquery-validation/js/additional-methods.min.js'
                );
                $css = array();
                break;
            case 'add_channel':
                $js = array();
                $css = array(
                    'assets/custom/css/add_channel.css'
                );
                break;
            case 'input-mask':
                $js = array(
                    'assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js',
                    'assets/pages/scripts/form-input-mask.js'
                );
                $css = array();
                break;
            case 'lead_migration':
                $js = array(
                    'assets/pages/scripts/lead_migration.js',
                    'assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js',
                    'assets/global/plugins/jquery-validation/js/jquery.validate.min.js',
                    'assets/global/plugins/jquery-validation/js/additional-methods.min.js'
                );
                $css = array();
                break;
            case 'amcharts':
                $js = array(
                    'assets/global/plugins/amcharts/amcharts/amcharts.js',
                    'assets/global/plugins/amcharts/amcharts/serial.js',
                    'assets/global/plugins/amcharts/amcharts/radar.js',
                    'assets/global/plugins/amcharts/amcharts/themes/light.js',
                    'assets/global/plugins/amcharts/ammap/ammap.js',
                    'assets/global/plugins/amcharts/amstockcharts/amstock.js',
                    'assets/pages/scripts/charts-amcharts.js',
                    'assets/global/plugins/amcharts/amcharts/pie.js'
                );
                $css = array();
                break;
            case 'highcharts':
                $js = array(
                    'assets/global/plugins/highcharts/js/highcharts.js',
                    'assets/global/plugins/highcharts/js/highcharts-3d.js',
                    'assets/global/plugins/highcharts/js/highcharts-more.js',
                    'assets/pages/scripts/charts-highcharts.js'
                );
                $css = array();
                break;
            case 'code_editor' :
                $js = array(
                    'assets/global/plugins/codemirror/lib/codemirror.js',
                    'assets/global/plugins/codemirror/mode/javascript/javascript.js',
                    'assets/global/plugins/codemirror/mode/htmlmixed/htmlmixed.js',
                    'assets/global/plugins/codemirror/mode/css/css.js',
                    'assets/pages/scripts/components-code-editors.js'
                );

                $css = array(
                    'assets/global/plugins/codemirror/lib/codemirror.css',
                    'assets/global/plugins/codemirror/theme/neat.css',
                    'assets/global/plugins/codemirror/theme/ambiance.css',
                    'assets/global/plugins/codemirror/theme/material.css',
                    'assets/global/plugins/codemirror/theme/neo.css'
                );
                break;
            default:
                break;
        }

        $data = array(
            'js' => $js,
            'css' => $css,
            'action_add' => base_url('master_data/add_genset')
        );

        return $data;
    }

    public function mappingTable($tbl, $param1)
    {

        switch ($tbl) {
            case 'tbl_user':
                $field_id = 'user_id';
                $redirect = 'user';
                $message = 'user';
                break;
            case 'tbl_sales_officer':
                $field_id = 'sales_officer_id';
                $redirect = 'team/sales_officer';
                $message = 'sales officer';
                break;
            case 'tbl_sales_team':
                $field_id = 'sales_team_id';
                $redirect = 'team/sales_team';
                $message = 'sales team';
                break;
            case 'tbl_media':
                $field_id = 'id';
                $redirect = 'media';
                $message = 'media';
                break;
            case 'tbl_channel':
                $field_id = 'id';
                $redirect = 'project_new/channel/?id=' . $param1;
                $message = 'project';
                break;
            case 'tbl_campaign':
                $field_id = 'id';
                $redirect = 'project_new/campaign/?id=' . $param1;
                $message = 'project';
                break;
            case 'tbl_product':
                $field_id = 'id';
                $redirect = 'project_new/setting/?id=' . $param1;
                $message = 'product';
                break;
            case 'tbl_status':
                $field_id = 'id';
                $redirect = 'project_new/setting/?id=' . $param1;
                $message = 'status';
                break;
            case 'tbl_payment':
                $field_id = 'id';
                $redirect = 'user/payment/';
                $message = 'Payment';
                break;
            default:
                break;
        }

        $data = array(
            'field_id' => $field_id,
            'redirect' => $redirect,
            'message' => $message
        );

        return $data;
    }

    public function UserSession($var)
    {
        $session = $this->session->userdata('user');

        return $session[$var];
    }

    public function sendmail($message, $title, $to)
    {

        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_port'] = '465';
        $config['smtp_timeout'] = '100';
        $config['smtp_user'] = 'jala.mailsender1@gmail.com';
        $config['smtp_pass'] = 'apahayo123';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html'; // or html
        //$config['validation'] = TRUE; // bool whether to validate email or not
        $config['charset'] = 'iso-8859-1';

        $this->email->initialize($config);

        $this->email->from('notification@jala.ai', $title);
        $this->email->to($to);

        $this->email->subject('Notification');
        $this->email->message($message);

        $send = $this->email->send();


        if ($send) {
            return "jancok";
        } else {
            $err = $this->email->print_debugger();
            return $err;
        }
    }

    public function getCoverageAreaBySalesTeamId($sales_team_id)
    {

        $this->db->select('b.kota_name');
        $this->db->join('tbl_kota b', 'a.city_id = b.kota_id');
        $data_coverage_area = $this->db->get_where('tbl_sales_team_city a', array('a.sales_team_id' => $sales_team_id))->result();

        return $data_coverage_area;
    }

    public function getSalesTeamBySalesOfficerId($sales_officer_id)
    {
        $this->db->select('b.sales_team_name');
        $this->db->join('tbl_sales_team b', 'b.sales_team_id = a.sales_team_id');
        $data_sales_team = $this->db->get_where('tbl_sales_officer_group a', array('a.sales_officer_id' => $sales_officer_id))->result();

        return $data_sales_team;
    }

    public function getClientId()
    {

        $role = $this->UserSession('role_id');

        switch ($role) {
            case 1:
                $client_id = 0;
                break;
            case 2:
                $client_id = $this->db->get_where('tbl_client', array('user_id' => $this->MainModels->UserSession('user_id')))->row('client_id');
                break;
            case 3:
                $client_id = $this->db->get_where('tbl_sales_team', array('user_id' => $this->MainModels->UserSession('user_id')))->row('client_id');
                break;
            case 4:
                $client_id = $this->db->get_where('tbl_sales_officer', array('user_id' => $this->MainModels->UserSession('user_id')))->row('client_id');
                break;
            case 5:
                $client_id = $this->db->get_where('tbl_client_admin', array('user_id' => $this->MainModels->UserSession('user_id')))->row('client_id');
                break;
            default:
                break;
        }

        return $client_id;
    }

    public function getSalesTeamId()
    {

        $sales_team_id = $this->db->get_where('tbl_sales_team', array('user_id' => $this->MainModels->UserSession('user_id')))->row('sales_team_id');

        return $sales_team_id;
    }

    public function getDataProject($id)
    {
        $data_project = $this->db->get_where('tbl_project', array('client_id' => $id))->result();

        return $data_project;
    }

    public function getDataProjectByAdminClient($id)
    {

        $data_admin_client = $this->db->get_where('tbl_client_admin', array('client_admin_id' => $id))->row();

        if (!empty($data_admin_client)) {
            if ($data_admin_client->project_id != 0) {
                $data_project = $this->db->get_where('tbl_project', array('id' => $data_admin_client->project_id))->result();
            } else {
                $data_project = $this->db->get_where('tbl_project', array('client_id' => $data_admin_client->client_id))->result();
            }
        }

        return $data_project;
    }

    public function generateRandomString($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function getCaption($count, $string)
    {
        if ($count > 1) {
            $string = $string . 's';
        } else {
            $string = $string;
        }

        return $string;
    }

    public function getIdbyUserIdRoleId($user_id, $role_id)
    {

        switch ($role_id) {
            case 1:
                $tbl_name = 'tbl_user';
                $id = 'user_id';
                break;
            case 2:
                $tbl_name = 'tbl_client';
                $id = 'client_id';
                break;
            case 3:
                $tbl_name = 'tbl_sales_team';
                $id = 'sales_team_id';
                break;
            case 4:
                $tbl_name = 'tbl_sales_officer';
                $id = 'sales_officer_id';
                break;
            case 5:
                $tbl_name = 'tbl_client_admin';
                $id = 'client_admin_id';
                break;
            default:
                break;
        }

        $id = $this->db->get_where($tbl_name, array('user_id' => $user_id))->row($id);

        $id_user = array('id' => $id);

        return $id_user;
    }

    public function getProfilePicturebyUserId()
    {

        $user_id = $this->UserSession('user_id');
        $role_id = $this->UserSession('role_id');

        switch ($role_id) {
            case 1 :
                $profile_picture = '';
                break;
            case 2:
                $profile_picture = $this->db->get_where('tbl_client', array('user_id' => $user_id))->row('picture_link');
                break;
            case 3:
                $profile_picture = $this->db->get_where('tbl_sales_team', array('user_id' => $user_id))->row('picture_link');
                break;
            case 4:
                $profile_picture = $this->db->get_where('tbl_sales_officer', array('user_id' => $user_id))->row('picture_link');
                break;
            case 5:
                $profile_picture = $this->db->get_where('tbl_client_admin', array('user_id' => $user_id))->row('picture_link');
                break;
            default:
                break;
        }

        return $profile_picture;
    }

    public function insert_log($log_name, $log_type, $id)
    {
        $data_insert = array(
            'log_name' => $log_name,
            'log_type' => $log_type,
            'user_id' => $this->UserSession('user_id'),
            'id' => $id
        );

        $insert_log = $this->db->insert('tbl_log', $data_insert);

        if ($insert_log) {
            $status = 200;
        } else {
            $status = 400;
        }

        $data = array('status' => $status);

        return $data;
    }

    public function getOnlineOffline()
    {

        $client_id = $this->getClientId();

        print_r($client_id);

        //get channel offline
        $offline = array(3, 5, 6, 9);
        $this->db->where_in('channel_media', $offline);
        $list_channel_offline = $this->db->get_where('');

        exit;
    }

    public function getClient()
    {

        $this->db->select('client_name, client_id, client_address, client_phone, client_email, pic, picture_link, create_date, status, industry_type');
        $data_client = $this->db->get('tbl_client')->result();

        return $data_client;
    }

    public function gen_table()
    {

    }

    public function getDataProjectbySalesTeamId($sales_team)
    {

        $list_campaign = array();


        $this->db->group_by('c.campaign_id');
        $this->db->select('c.campaign_id');
        $this->db->join('tbl_channel c', 'c.id = a.channel_id');
        $data_campaign = $this->db->get_where('tbl_sales_team_channel a', array('a.sales_team_id' => $sales_team))->result();

        if (!empty($data_campaign)) {
            foreach ($data_campaign as $dch) {
                array_push($list_campaign, $dch->campaign_id);
            }

            $this->db->group_by('a.project_id');
            $this->db->where_in('a.id', $list_campaign);
            $this->db->select('a.project_id as id, b.project_name');
            $this->db->join('tbl_project b ', 'a.project_id = b.id');
            $data_project = $this->db->get('tbl_campaign a')->result();

            return $data_project;

        }
    }

    public function getNameField($param)
    {

        switch ($param) {
            case 1 :
                $name = 'name';
                break;
            case 2 :
                $name = 'phone';
                break;
            case 3 :
                $name = 'email';
                break;
            case 4 :
                $name = 'no_ktp';
                break;
            case 5 :
                $name = 'address';
                break;
            case 6 :
                $name = 'city';
                break;
            case 7 :
                $name = 'gender';
                break;
            case 8 :
                $name = 'notes';
                break;
        }

        return $name;

    }

    public function getDisplayNameField($param)
    {

        switch ($param) {
            case 1 :
                $name = 'Name';
                break;
            case 2 :
                $name = 'Phone';
                break;
            case 3 :
                $name = 'Email';
                break;
            case 4 :
                $name = 'No KTP';
                break;
            case 5 :
                $name = 'Address';
                break;
            case 6 :
                $name = 'City';
                break;
            case 7 :
                $name = 'Gender';
                break;
            case 8 :
                $name = 'Note';
                break;
        }

        return $name;

    }

}
