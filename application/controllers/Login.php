<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('UserModels');
    }

    public function index() {

        $post = $this->input->post();

        if ($post) {

            $param = array('email' => $post['email'], 'password' => $post['password'], 'tbl_name' => 'tbl_user',);

            $check_login = $this->UserModels->checkUserLogin($param);
            $this->session->set_userdata('user', $check_login['session']);
            $this->session->set_userdata('dashboard', $check_login['session_dashboard']);
            $this->session->set_flashdata('message', $check_login['message']);
            redirect($check_login['redirect']);
        }

        $this->template->load('login', 'user/login');
    }

    public function forgot() {

        $post = $this->input->post();

        if ($post) {
            $email = $this->input->post('mail');
            $data_user = $this->db->get_where('tbl_user', array('email' => $email))->row();

            if (!empty($data_user)) {
                $user_id_enc = $this->encryption->encrypt($data_user->user_id);
                $user_id_encode = base64_encode($user_id_enc);
                $link = base_url('login/reset_password/?id=' . $user_id_encode);
                $title = "Forgot Password";
                $message = '<p>please click link bellow to reset your password</p><a href=' . $link . '>Reset Password</a>';
                $to = $email;
                $send = $this->MainModels->sendmail($message, $title, $to);

                if ($send) {
                    $this->session->set_flashdata('message', '<p style="color:black"; class="alert alert-success">Check Your Email !!!</p>');
                    redirect(base_url('login'));
                } else {
                    $err = $this->email->print_debugger();
                    $this->session->set_flashdata('message', '<p style="color:black"; class="alert alert-warning">Error when Send Email !!! ' . $err . ' </p>');
                    redirect(base_url('login'));
                }
            } else {
                $this->session->set_flashdata('message', '<p style="color:black"; class="alert alert-warning">Email tidak terdaftar !!! </p>');
                redirect(base_url('login'));
            }
        }

        $this->template->load('login', 'user/forgot');
    }

    public function reset_password() {

        $post = $this->input->post();

        if ($post) {

            $password = md5($post['password']);
            $user_id_decode = base64_decode($post['user_id']);
            $user_id_decrypt = $this->encryption->decrypt($user_id_decode);

            $data_update_password = array('password' => $password);

            $this->db->where('user_id', $user_id_decrypt);
            $update = $this->db->update('tbl_user', $data_update_password);

            if ($update) {
                $response = 'success';
                $message = '<p class="alert alert-success"> Success Change Password </p>';
            } else {
                $response = 'error';
                $message = '<p class="alert alert-danger"> Error Change Password </p>';
            }

            $this->session->set_flashdata('message', $message);
            redirect(base_url('login'));
        }

        $this->template->load('login', 'user/reset_password');
    }
    
    public function change_password() {

        $post = $this->input->post();

        if ($post) {

            $password = md5($post['password']);
            $token = $post['token'];

            $data_update_password = array('sales_officer_password' => $password);
            
            $this->db->where('sales_officer_token', $token);
            $update = $this->db->update('tbl_sales_officer', $data_update_password);

            if ($update) {
                $response = 'success';
                $message = '<p class="alert alert-success"> Success Change Password </p>';
            } else {
                $response = 'error';
                $message = '<p class="alert alert-danger"> Error Change Password </p>';
            }

            $this->session->set_flashdata('message', $message);
            redirect(base_url('login/thanks'));
        }

        $this->template->load('login', 'user/change_password');
    }
    
    public function thanks(){
        $this->template->load('login', 'user/thanks_password');
    }

}
