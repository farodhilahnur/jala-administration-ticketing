<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (empty($this->MainModels->UserSession('user_id'))) {
            $this->session->set_flashdata('message', '<p style="color:black;" class="alert alert-warning">Login First to Create Session !!!</p>');
            redirect(base_url('login'));
        } else {
            $this->load->model('UserModels');
            $this->load->model('ProjectModels');
            $this->load->model('SalesOfficerModels');
            $this->load->model('LeadModels');
            $this->load->model('ProjectModels');
        }
    }

    public function index() {

        $role = $this->MainModels->UserSession('role_id');
        $datatable_assets = $this->MainModels->getAssets('datatable');
        $modals_assets = $this->MainModels->getAssets('modals');
        $user_assets = $this->MainModels->getAssets('user');
        $data_project = $this->ProjectModels->getDataProjectbyClientIdNonSession();

        $js = array_merge($datatable_assets['js'], $modals_assets['js'], $user_assets['js']);
        $css = array_merge($datatable_assets['css'], $modals_assets['css']);

        if ($role == 1) {
            $data_role = $this->db->get_where('tbl_role', array('status' => 1))->result();
            $data_user = $this->UserModels->getDataUserAll();
            $data_project = array();
            $active_menu = 'user';
        } else if ($role == 2) {
            $filter_role = array('admin', 'client', 'sales_team', 'sales_officer');
            $this->db->where_not_in('role_name', $filter_role);
            $data_role = $this->db->get_where('tbl_role', array('status' => 1))->result();
            $client_id = $this->MainModels->getClientId();
            $data_user = $this->UserModels->getDataUserByClientId($client_id);
            $data_project = $this->ProjectModels->getDataProjectbyClientIdNonSession();
            $active_menu = 'setting';
        } else if ($role == 3) {
            $filter_role = array('admin', 'client', 'admin_client');
            $this->db->where_not_in('role_name', $filter_role);
            $data_role = $this->db->get_where('tbl_role', array('status' => 1))->result();
            $sales_team_id = $this->MainModels->getClientId();
            $data_user = $this->UserModels->getDataUserBySalesTeamId($client_id);
            $data_project = array();
            $active_menu = 'setting';
        }

        $data = array(
            'title' => 'User',
            'data_project' => $data_project,
            'action_add' => base_url('user/add'),
            'action_edit' => base_url('user/edit'),
            'data_user' => $data_user,
            'data_role' => $data_role,
            'active_menu' => $active_menu,
            'js' => $js,
            'css' => $css
        );

        $this->template->load('template__', 'user/index', $data);
    }

    public function payment() {

        $datatable_assets = $this->MainModels->getAssets('datatable');
        $modals_assets = $this->MainModels->getAssets('modals');
        $user_assets = $this->MainModels->getAssets('user');
        $file_input_assets = $this->MainModels->getAssets('file-input');

        $data_payment = $this->db->get_where('tbl_payment', array('status' => 1))->result();

        $js = array_merge($datatable_assets['js'], $modals_assets['js'], $user_assets['js'], $file_input_assets['js']);
        $css = array_merge($datatable_assets['css'], $modals_assets['css'], $file_input_assets['css']);

        $client_id = $this->MainModels->getClientId();
        $active_menu = 'payment';

        $data = array(
            'title' => 'User Payment',
            'action_add' => base_url('user/add'),
            'action_edit' => base_url('user/edit'),
            'active_menu' => $active_menu,
            'client_id' => $client_id,
            'data_payment' => $data_payment,
            'js' => $js,
            'css' => $css
        );

        $this->template->load('template', 'user/payment', $data);
    }

    public function add_payment() {

        $post = $this->input->post();

        $config['upload_path'] = 'assets/picture/payment';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = true;
        $config['overwrite'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('qr_code')) {
            $error = array('error' => $this->upload->display_errors());
            $message = '<p class="alert alert-danger"> ' . $error['error'] . ' </p>';
            $this->session->set_flashdata('message', $message['message']);

            redirect(base_url('user/payment'));
        } else {
            $data = array('upload_data' => $this->upload->data());

            $config['image_library'] = 'gd2';
            $config['source_image'] = 'assets/picture/payment/' . $data['upload_data']['file_name'];
            $config['create_thumb'] = false;
            $config['maintain_ratio'] = false;
            $config['quality'] = '100%';
            $config['width'] = 400;
            $config['height'] = 400;
            $config['new_image'] = 'assets/picture/' . $data['upload_data']['file_name'];
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();

            $file_name = 'https://jala.ai/dashboard/assets/picture/payment/' . $data['upload_data']['file_name'];

            $insert_payment = $this->UserModels->addPayment($post, $file_name);
            $this->session->set_flashdata('message', $insert_payment['message']);

            redirect(base_url('user/payment'));
        }
    }

    public function add() {

        $post = $this->input->post();

        $insert_user = $this->UserModels->addUser($post);
        $this->session->set_flashdata('message', $insert_user['message']);

        redirect(base_url('user'));
    }

    public function edit() {

        $post = $this->input->post();

        $update_user = $this->UserModels->UpdateUser($post);
        $this->session->set_flashdata('message', $update_user['message']);

        redirect(base_url('user'));
    }

    public function logout() {
        $this->session->sess_destroy();
        echo "<script>alert('terimakasih admin')</script>";
        redirect(base_url('login'));
    }

    public function getDataUserEdit() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $id = $this->input->get('id');

        $data_user = $this->db->get_where('tbl_user', array('user_id' => $id))->row();

        $data = array(
            'res' => 200,
            'data' => $data_user
        );

        echo json_encode($data);
    }

    public function validate_email() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $email = $this->input->get('email');

        $data_user = $this->db->get_where('tbl_user', array('email' => $email))->row();

        if (!empty($data_user)) {
            $res = 200;
        } else {
            $res = 400;
        }

        $data = array(
            'res' => $res
        );

        echo json_encode($data);
    }

    public function profile() {

        $datatable_assets = $this->MainModels->getAssets('datatable');
        $profile_assets = $this->MainModels->getAssets('profile');
        $file_input_assets = $this->MainModels->getAssets('file-input');

        $js = array_merge($datatable_assets['js'], $profile_assets['js'], $file_input_assets['js']);
        $css = array_merge($datatable_assets['css'], $profile_assets['css'], $file_input_assets['css']);

        if ($this->MainModels->UserSession('role_id') == 2) {
            $client_id = $this->MainModels->getClientId();
            $data_profile = $this->UserModels->getUserProfilebyUserId();

            $total_project = count($this->ProjectModels->getDataProjectbyClientIdNonSession());
            $data_sales_team = $this->db->get_where('tbl_sales_team', array('client_id' => $client_id))->result();
            $data_sales_officer = $this->SalesOfficerModels->getDataSalesOfficerbyClientId();
            $data_lead = $this->LeadModels->getCountLeadbyClientId();
        } else if ($this->MainModels->UserSession('role_id') == 5) {

            $client_id = $this->MainModels->getClientId();
            $data_profile = $this->UserModels->getUserProfilebyUserId();

            $total_project = count($this->ProjectModels->getDataProjectbyClientIdNonSession());
            $data_sales_team = $this->db->get_where('tbl_sales_team', array('client_id' => $client_id))->result();
            $data_sales_officer = $this->SalesOfficerModels->getDataSalesOfficerbyClientId();
            $data_lead = $this->LeadModels->getCountLeadbyClientId();
        }


        $data = array(
            'data_profile' => $data_profile,
            'total_project' => $total_project,
            'total_sales_team' => count($data_sales_team),
            'total_sales_officer' => count($data_sales_officer),
            'total_lead' => count($data_lead),
            'js' => $js,
            'css' => $css
        );

        $this->template->load('template__', 'user/profile', $data);
    }

    public function change_profile() {

        $post = $this->input->post();
        $config['upload_path'] = 'assets/picture/user';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['encrypt_name'] = TRUE;
        $config['overwrite'] = TRUE;


        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('picture_link')) {
            $error = array('error' => $this->upload->display_errors());
            $message = '<p class="alert alert-danger"> ' . $error['error'] . ' </p>';

            $file_name = '';

            $update_profile = $this->UserModels->editProfile($post, $file_name);
            $this->session->set_flashdata('message', $update_profile['message']);

            redirect(base_url('user/profile'));
        } else {
            $data = array('upload_data' => $this->upload->data());

            $file_name = 'https://jala.ai/jala-new/assets/picture/user/' . $data['upload_data']['file_name'];

            $update_profile = $this->UserModels->editProfile($post, $file_name);
            $this->session->set_flashdata('message', $update_profile['message']);

            redirect(base_url('user/profile'));
        }
    }

}
