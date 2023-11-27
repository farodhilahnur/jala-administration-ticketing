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
            $response = 'success';
            $message = '<p class="alert alert-success"> Success Insert Product </p>';
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Insert Product </p>';
        }

        $data_product = array('message' => $message, 'res' => $response);
        return $data_product;
    }

    public function editProduct($post) {

        $data_update = array(
            'product_name' => $post['product_name'],
            'product_detail' => $post['product_detail'],
            'product_price' => $post['price'],
            'update_by' => $this->MainModels->UserSession('user_id'),
        );

        $this->db->where('id', $post['product_id']);
        $update_product = $this->db->update('tbl_product', $data_update);

        if ($update_product) {
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
