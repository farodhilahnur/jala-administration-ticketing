<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Faq extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->Model('FaqModels');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $datatable_assets = $this->MainModels->getAssets('datatable');

        $js = array_merge($datatable_assets['js']);
        $css = array_merge($datatable_assets['css']);
        $data = array(
            'js' => $js,
            'css' => $css,
        );

        // $session=$this->session->userdata();
        // print_r($session);
        // exit;
        $data['tampil_faq'] = $this->FaqModels->tampil_faq();
        $this->template->load('template__', 'faq/faq', $data);
    }

    public function tambah_proses()
    {
        // $config = array();
        // $config['upload_path'] = './assets/picture/faq';
        // $config['allowed_types']    = 'jpg|jpeg|png|gif';
        // $config['overwrite'] = TRUE;
        $this->load->library('upload');
        $dataInfo = array();
        $files = $_FILES;
        $cpt = count($_FILES['userfile']['name']);
        // print_r($_FILES);
        // exit;
        for ($i = 0; $i < $cpt; $i++) {
            $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
            $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
            $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
            $_FILES['userfile']['size'] = $files['userfile']['size'][$i];

            $this->upload->initialize($this->set_upload_options());
            $this->upload->do_upload('userfile');
            $dataInfo[$i] = $this->upload->data();
        }
        $data = array(
            'id' => $this->input->post('id'),
            'user_id' => $this->MainModels->UserSession('user_id'),
            'email' => $this->MainModels->UserSession('email'),
            'title' => $this->input->post('title'),
            'category' => $this->input->post('category'),
            'detail' => $this->input->post('detail'),
            'client_id' => $this->MainModels->getClientId('client_id'),
            'image' => $dataInfo[0]['file_name'],
            'image2' => $dataInfo[1]['file_name'],
            'image3' => $dataInfo[2]['file_name'],
        );
        $this->send();
        $this->FaqModels->insert($data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success">
			Thank you for filling in the form. Please wait for the next process, we will notifiy by email</div>');
        redirect(base_url('faq'));
    }

    private function set_upload_options()
    {
        $config = array();
        $config['upload_path'] = './assets/picture/faq/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';

        return $config;
    }

    public function send()
    {
        $config = [
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_user' => 'jala.mailsender1@gmail.com',
            'smtp_pass' => 'apahayo123',
            'smtp_port' => 465,
            'charset' => 'iso-8859-1',
            'newline' => "\r\n"
        ];


        //  $pic=$_POST['file'];
        $title = $_POST['category'];
        $message = $_POST['detail'];
        $to_email = array('farodhilahnur@gmail.com');

        $this->load->library('email', $config);
        $this->email->from('no-reply@gmail.com', 'Jala.ai');
        $this->email->to($to_email);
        $this->email->attach('');
        $this->email->subject($title);
        $this->email->message('' . $message .
            '<br><br> http://jala.ai/jala-admin/faq_admin');

        // Tampilkan pesan sukses atau error
        if ($this->email->send()) {
            echo 'Sukses! email berhasil dikirim.';
        } else {
            echo 'Error! email tidak dapat dikirim.';
        }
    }

    public function viewtable()
    {
        $datatable_assets = $this->MainModels->getAssets('datatable');

        $js = array_merge($datatable_assets['js']);
        $css = array_merge($datatable_assets['css']);
        $data = array(
            'js' => $js,
            'css' => $css,
        );
        $data['tampil_faq_client'] = $this->FaqModels->getFaqClient();
        $this->template->load('template', 'faq/table-view', $data);
    }

}
    