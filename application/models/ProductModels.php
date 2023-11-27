<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProductModels extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getDataProductByProjectId($id) {

        $data_product = $this->db->get_where('tbl_product', array('project_id' => $id))->result();

        return $data_product;
    }

    public function addProduct($post) {
        $data_insert = array(
            'product_name' => $post['product_name'],
            'product_detail' => $post['product_detail'],
            'product_price' => $post['price'],
            'create_by' => $this->MainModels->UserSession('user_id'),
            'project_id' => $post['project_id']
        );

        $insert_product = $this->db->insert('tbl_product', $data_insert);

        if ($insert_product) {
            $product_id = $this->db->insert_id();
            $this->MainModels->insert_log('Product Created By ', 2, $product_id);

            $response = 'success';
            $message = '<p class="alert alert-success"> Success Insert Product </p>';
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Insert Product </p>';
        }

        $data_product = array('message' => $message, 'res' => $response);
        return $data_product;
    }

    public function editProduct($post, $filename) {

        $data_update = array(
            'product_name' => $post['product_name'],
            'product_detail' => $post['product_detail_id'],
            'product_detail_en' => $post['product_detail_en'],
            'product_price' => $post['product_price'],
            'kamar_tidur' => $post['kamar_tidur'],
            'kamar_mandi' => $post['kamar_mandi'],
            'location' => $post['location'],
            'cover' => $filename,
            'update_by' => $this->MainModels->UserSession('user_id'),
        );

        $this->db->where('id', $post['product_id']);
        $update_product = $this->db->update('tbl_product', $data_update);

        if ($update_product) {

            $this->MainModels->insert_log('Product Edited By ', 2, $post['product_id']);

            $response = 'success';
            $message = '<p class="alert alert-success"> Success Update Product </p>';
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Update Product </p>';
        }

        $data_product = array('message' => $message, 'res' => $response);
        return $data_product;
    }

    public function insertPicture($post, $filename) {
        $data_insert = array(
            'image_link' => $filename,
            'product_id' => $post['product_id']
        );

        $insert_product_pic = $this->db->insert('tbl_product_image', $data_insert);

        if ($insert_product_pic) {

            $this->MainModels->insert_log('Product Edited By ', 2, $post['product_id']);

            $response = 'success';
            $message = '<p class="alert alert-success"> Success Update Product </p>';
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Update Product </p>';
        }

        $data_product = array('message' => $message, 'res' => $response);
        return $data_product;
    }

}
