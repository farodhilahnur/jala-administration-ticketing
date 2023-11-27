<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class StatusModels extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getDataStatusByProjectId($id) {

        $data_status = $this->db->get_where('tbl_status', array('project_id' => $id))->result();

        return $data_status;
    }

    public function getDataStatusByCampaignId($campaign_id) {

        $project_id = $this->db->get_where('tbl_campaign', array('id' => $campaign_id))->row('project_id');

        $data_status = $this->getDataStatusByProjectId($project_id);

        return $data_status;
    }

    public function editStatus($post) {

        $data_update = array(
            'point' => $post['point'],
            'update_by' => $this->MainModels->UserSession('user_id'),
        );

        $this->db->where('id', $post['status_id']);
        $update_status = $this->db->update('tbl_status', $data_update);

        if ($update_status) {
            $response = 'success';
            $message = '<p class="alert alert-success"> Success Update Status </p>';
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Update Status </p>';
        }

        $data_status = array('message' => $message, 'res' => $response);
        return $data_status;
    }

    public function getStatusAll() {

        $data_project = $this->ProjectModels->getDataProjectbyClientIdNonSession();

        $list_project_id = array();

        if (!empty($data_project)) {
            foreach ($data_project as $dp) {
                array_push($list_project_id, $dp->id);
            }

            $this->db->where_in('project_id', $list_project_id);
            $this->db->group_by('status_name');
            $data_status = $this->db->get('tbl_status')->result();
        } else {
            $data_status = [];
        }

        return $data_status;
    }

}
