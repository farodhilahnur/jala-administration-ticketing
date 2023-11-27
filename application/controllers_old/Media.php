<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CI_Controller {

    function __construct() {
        parent::__construct();

        $session = $this->session->userdata('user');

        if (empty($session['user_id'])) {
            $this->session->set_flashdata('message', '<p style="color:black;" class="alert alert-warning">Login First to Create Session !!!</p>');
            redirect(base_url('login'));
        } else {
            $this->load->model('MediaModels');
        }
    }

    public function index() {

        $get = $this->input->get();
        $role = $this->MainModels->UserSession('role_id');
        $datatable_assets = $this->MainModels->getAssets('datatable');
        $modals_assets = $this->MainModels->getAssets('modals');
        $file_input_assets = $this->MainModels->getAssets('file-input');
        $media_assets = $this->MainModels->getAssets('media');

        $js = array_merge($datatable_assets['js'], $modals_assets['js'], $file_input_assets['js'], $media_assets['js']);
        $css = array_merge($datatable_assets['css'], $modals_assets['css'], $file_input_assets['css'], $media_assets['css']);

        $data_media = $this->db->get('tbl_media')->result();

        $data = array(
            'js' => $js,
            'css' => $css,
            'data_media' => $data_media,
            'action_add' => base_url('media/add'),
            'action_edit' => base_url('media/edit')
        );

        $this->template->load('template', 'media/index', $data);
    }

    public function add_media() {

        $post = $this->input->post();
        $config['upload_path'] = 'assets/picture/media';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('media_picture')) {
            $error = array('error' => $this->upload->display_errors());

            $file_name = '-';

            $insert_channel = $this->MedialModels->addMedia($post, $file_name);
            $this->session->set_flashdata('message', $insert_channel['message']);

            redirect(base_url('media'));
        } else {
            $data = array('upload_data' => $this->upload->data());
            $file_name = $data['upload_data']['file_name'];

            $insert_channel = $this->MediaModels->addMedia($post, $file_name);
            $this->session->set_flashdata('message', $insert_channel['message']);

            redirect(base_url('media'));
        }
    }

    public function edit_media() {
        $post = $this->input->post();
        $config['upload_path'] = 'assets/picture/media';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['encrypt_name'] = TRUE;
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('media_picture')) {
            $error = array('error' => $this->upload->display_errors());
            $message = '<p class="alert alert-danger"> ' . $error['error'] . ' </p>';

            $file_name = '';

            $update_media = $this->MediaModels->editMedia($post, $file_name);
            $this->session->set_flashdata('message', $update_media['message']);

            redirect(base_url('media'));
        } else {
            $data = array('upload_data' => $this->upload->data());

            $file_name = $data['upload_data']['file_name'];

            $update_media = $this->MediaModels->editMedia($post, $file_name);
            $this->session->set_flashdata('message', $update_media['message']);

            redirect(base_url('media'));
        }
    }

    public function getDataMediaEdit() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $id = $this->input->get('id');

        $data_media = $this->db->get_where('tbl_media', array('id' => $id))->row();

        $data = array(
            'res' => 200,
            'data' => $data_media
        );

        echo json_encode($data);
    }

}
