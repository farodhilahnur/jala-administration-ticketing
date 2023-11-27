<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('ProductModels');
    }

    public function getDataChartProduct() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $this->load->model('ChannelModels');

        //get data product by project id

        $session_filter = $this->session->userdata('filter');
        $campaign_id = $session_filter['campaign_id'];
        $date = explode(' to ', $session_filter['date_range']);
        $project_date = $date[0];
        $now_date = $date[1];

        $id = $this->input->get('id');

        $list_product_id = array();
        $list_channel_id = array();

        $data_product = $this->db->get_where('tbl_product', array('project_id' => $id))->result();

        foreach ($data_product as $dp) {
            array_push($list_product_id, $dp->id);
        }

        if ($campaign_id != 0) {
            $data_channel = $this->ChannelModels->getDataChannelbyCampagnId($campaign_id);
        } else {
            $data_channel = $this->ChannelModels->getDataChannelbyProjectId($id);
        }

        foreach ($data_channel as $dc) {
            array_push($list_channel_id, $dc->channel_id);
        }

        //get data lead by product

        $this->db->where_in('a.channel_id', $list_channel_id);
        $this->db->where_in('a.product_id', $list_product_id);
        $this->db->where('a.create_date >=', $project_date . ' 00:00:00');
        $this->db->where('a.create_date <=', $now_date . ' 23:59:59');
        $this->db->select('b.product_name as country, count(a.lead_id) as value');
        $this->db->join('tbl_product b', 'a.product_id = b.id');
        $this->db->group_by('a.product_id');
        $data_lead = $this->db->get('tbl_lead a')->result();

        $data = array(
            'res' => 200,
            'data' => $data_lead,
            'count' => count($data_lead)
        );

        echo json_encode($data);
    }

    public function detail() {

        $post = $this->input->post();
        $datatable_assets = $this->MainModels->getAssets('datatable');
        $file_input_assets = $this->MainModels->getAssets('file-input');
        $data_product = $this->db->get_where('tbl_product', array('id' => $this->input->get('id')))->row();
        $data_product_pic = $this->db->get_where('tbl_product_image', array('product_id' => $this->input->get('id')))->result();

        $js = array_merge($datatable_assets['js'], $file_input_assets['js']);
        $css = array_merge($datatable_assets['css'], $file_input_assets['css']);

        if ($post) {
            $config['upload_path'] = 'assets/picture/product';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['encrypt_name'] = true;
            $config['overwrite'] = true;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('cover')) {
                $error = array('error' => $this->upload->display_errors());
                $message = '<p class="alert alert-danger"> ' . $error['error'] . ' </p>';
                $this->session->set_flashdata('message', $message);

                $default_pic = array('https://jala.ai/dashboard/assets/picture/product/default.jpg');

                $random = array_rand($default_pic);

                $file_name = $default_pic[$random];

                $update_product = $this->ProductModels->editProduct($post, $file_name);
                $this->session->set_flashdata('message', $update_product['message']);

                redirect(base_url('project/setting/?id=' . $post['project_id']));
            } else {
                $data = array('upload_data' => $this->upload->data());

                $config['image_library'] = 'gd2';
                $config['source_image'] = 'assets/picture/product/' . $data['upload_data']['file_name'];
                $config['create_thumb'] = false;
                $config['maintain_ratio'] = false;
                $config['quality'] = '100%';
                $config['width'] = 600;
                $config['height'] = 250;
                $config['new_image'] = 'assets/picture/' . $data['upload_data']['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                $file_name = 'https://jala.ai/dashboard/assets/picture/product/' . $data['upload_data']['file_name'];

                $update_product = $this->ProductModels->editProduct($post, $file_name);
                $this->session->set_flashdata('message', $update_product['message']);

                redirect(base_url('project_new/setting/?id=' . $post['project_id']));
            }
        }

        $data = array(
            'js' => $js,
            'css' => $css,
            'data_product' => $data_product, 
            'data_product_image' => $data_product_pic
        );

        $this->template->load('template__', 'project/product_detail', $data);
    }

    public function add_picture() {
        
        $post = $this->input->post();
        $config['upload_path'] = 'assets/picture/product';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = true;
        $config['overwrite'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('picture')) {
            $error = array('error' => $this->upload->display_errors());
            $message = '<p class="alert alert-danger"> ' . $error['error'] . ' </p>';
            $this->session->set_flashdata('message', $message);

            $default_pic = array('https://jala.ai/dashboard/assets/picture/product/default.jpg');

            $random = array_rand($default_pic);

            $file_name = $default_pic[$random];

            $insert_product_pic = $this->ProductModels->insertPicture($post, $file_name);
            $this->session->set_flashdata('message', $insert_product_pic['message']);

            redirect(base_url('project_new/setting/?id=' . $post['project_id']));
        } else {
            $data = array('upload_data' => $this->upload->data());

            $config['image_library'] = 'gd2';
            $config['source_image'] = 'assets/picture/product/' . $data['upload_data']['file_name'];
            $config['create_thumb'] = false;
            $config['maintain_ratio'] = false;
            $config['quality'] = '100%';
            $config['width'] = 600;
            $config['height'] = 250;
            $config['new_image'] = 'assets/picture/' . $data['upload_data']['file_name'];
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();

            $file_name = 'https://jala.ai/dashboard/assets/picture/product/' . $data['upload_data']['file_name'];

            $insert_product_pic = $this->ProductModels->insertPicture($post, $file_name);
            $this->session->set_flashdata('message', $insert_product_pic['message']);

            redirect(base_url('project_new/setting/?id=' . $post['project_id']));
        }
    }

}
