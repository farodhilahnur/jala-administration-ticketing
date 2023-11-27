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

        if ($campaign_id != 0) {
            $project_id = $this->db->get_where('tbl_campaign', array('id' => $campaign_id))->row('project_id');
            $data_status = $this->getDataStatusByProjectId($project_id);
        } 



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

            $this->MainModels->insert_log('Status Edited By ', 3, $post['status_id']);

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

    public function simpan_status(){
		$object=array(
			'status_name'=>$this->input->post('status_name'),
            'detail'=>$this->input->post('detail'),
            'color'=>$this->input->post('color'),
            'urutan'=>$this->input->post('urutan'),
            'detail_en'=>$this->input->post('detail_en'),
            'create_by' => $this->MainModels->UserSession('user_id')
		);
		return $this->db->insert('tbl_master_status', $object);
    }

    public function update_status(){
        
            $dt_up_level=array(
                'status_name'=>$this->input->post('status_name'),
                'color'=>$this->input->post('color'),
                'detail'=>$this->input->post('detail'),
                'urutan'=>$this->input->post('urutan'),
                'detail_en'=>$this->input->post('detail_en'),
                'update_by' => $this->MainModels->UserSession('user_id')
            );
            return $this->db->where('id',$this->input->post('id'))->update('tbl_master_status', $dt_up_level);
    
        }
        public function detail_status($id)
        {
            return $this->db->where('id',$id)->get('tbl_master_status')->row();
    }

    public function hapus($id)
    {
            return $this->db->where('id',$id)->delete('tbl_master_status');
    }
	    

}
