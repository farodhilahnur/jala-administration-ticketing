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
        }
    }

    public function index() {

        $role = $this->MainModels->UserSession('role_id');
        $datatable_assets = $this->MainModels->getAssets('datatable');
        $modals_assets = $this->MainModels->getAssets('modals');
        $user_assets = $this->MainModels->getAssets('user');


        $js = array_merge($datatable_assets['js'], $modals_assets['js'], $user_assets['js']);
        $css = array_merge($datatable_assets['css'], $modals_assets['css']);

        if ($role == 1) {
            $data_user = $this->UserModels->getDataUserAll();
            $active_menu = 'user';
        } else if ($role == 2) {
            $client_id = $this->MainModels->getClientId();
            $data_user = $this->UserModels->getDataUserByClientId($client_id);
            $active_menu = 'setting';
        } else if ($role == 3) {
            $sales_team_id = $this->MainModels->getClientId();
            $data_user = $this->UserModels->getDataUserBySalesTeamId($client_id);
            $active_menu = 'setting';
        }

        $data = array(
            'title' => 'User',
            'action_add' => base_url('user/add'),
            'action_edit' => base_url('user/edit'),
            'data_user' => $data_user,
            'active_menu' => $active_menu,
            'js' => $js,
            'css' => $css
        );

        $this->template->load('template', 'user/index', $data);
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

        $client_id = $this->MainModels->getClientId();
        $data_profile = $this->UserModels->getUserProfilebyUserId();

        $total_project = count($this->ProjectModels->getDataProjectbyClientIdNonSession());
        $data_sales_team = $this->db->get_where('tbl_sales_team', array('client_id' => $client_id))->result();
        $data_sales_officer = $this->SalesOfficerModels->getDataSalesOfficerbyClientId();
        $data_lead = $this->LeadModels->getCountLeadbyClientId();

        $data = array(
            'data_profile' => $data_profile,
            'total_project' => $total_project,
            'total_sales_team' => count($data_sales_team),
            'total_sales_officer' => count($data_sales_officer),
            'total_lead' => count($data_lead),
            'js' => $js,
            'css' => $css
        );

        $this->template->load('template', 'user/profile', $data);
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
