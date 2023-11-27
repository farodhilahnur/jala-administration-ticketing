<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MediaModels extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->model('ProjectModels');
        $this->load->model('CampaignModels');
    }

    public function addMedia($post, $file_name) {

        $data_insert = array(
            'media_name' => $post['media_name'],
            'media_pic' => $file_name,
            'media_category' => $post['media_category_id']
        );

        $insert_media = $this->db->insert('tbl_media', $data_insert);

        if ($insert_media) {
            $response = 'success';
            $message = '<p class="alert alert-success"> Success Add Media </p>';
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Add Media </p>';
        }

        $data_media = array('message' => $message, 'res' => $response);
        return $data_media;
    }
    
    public function editMedia($post, $file_name) {

        if ($file_name == "") {
            $data_update = array(
                'media_name' => $post['media_name'],
                'media_category' => $post['media_category_id'],
            );
        } else {
            $data_update = array(
                'media_name' => $post['media_name'],
                'media_category' => $post['media_category_id'],
                'media_pic' => $file_name
            );
        }


        $this->db->where('id', $post['media_id']);
        $update_media = $this->db->update('tbl_media', $data_update);

        if ($update_media) {
            $response = 'success';
            $message = '<p class="alert alert-success"> Success Update Media </p>';
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Update Media </p>';
        }

        $data_media = array('message' => $message, 'res' => $response);
        return $data_media;
    }

}
