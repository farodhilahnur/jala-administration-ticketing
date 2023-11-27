<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Content_management extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (empty($this->MainModels->UserSession('user_id'))) {
            $this->session->set_flashdata('message', '<p style="color:black;" class="alert alert-warning">Login First to Create Session !!!</p>');
            redirect(base_url('login'));
        } else {
            
        }
        $this->load->model('StatusModels','mstatus');
    }
    
    public function status() {
        $datatable_assets = $this->MainModels->getAssets('datatable');
        
        $js = array_merge($datatable_assets['js']);
        $css = array_merge($datatable_assets['css']);

        $this->db->order_by('urutan', 'asc');
        $data_status = $this->db->get('tbl_master_status')->result();
        
        $data = array(
            'title' => 'Status',    
            'action_add' => base_url('team/add_client'),
            'action_edit' => base_url('team/edit_client'),
            'js' => $js,
            'css' => $css, 
            'data_status' => $data_status
        );       
  
        $this->template->load('template', 'administrator/content/status', $data);
    }

    public function tambah(){
        if($this->input->post('simpan')){
			if($this->mstatus->simpan_status()){
				$this->session->set_flashdata('pesan', '<div class="alert alert-success">SUCCESS ADD</div>');
				redirect('content_management/status','refresh');
			} else {
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger">ERROR ADD</div>');
				redirect('content_management/status','refresh');
			}
		}
    }


    public function get_detail_status($id='')
	{
        $data_detail=$this->mstatus->detail_status($id);
		echo json_encode($data_detail);
	}
    
	public function update_status()
	{
			$proses_update=$this->mstatus->update_status();
			if($proses_update){
				$this->session->set_flashdata('pesan', '<div class="alert alert-success">SUCCESS EDIT</div>');
			} else {
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger">ERROR EDIT</div>');
			}
			redirect(base_url('content_management/status'),'refresh');
		
    }  
    public function hapus_status($id='')
	{
		$hapus=$this->mstatus->hapus($id);
		if($hapus){
			$this->session->set_flashdata('pesan', '<div class="alert alert-success">SUCCESS Delete</div>');
			} else {
				$this->session->set_flashdata('pesan', 'gagal hapus data');
			}
			redirect(base_url('content_management/status'),'refresh');
	}


}
    