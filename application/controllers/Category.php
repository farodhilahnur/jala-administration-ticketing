<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->Model('CategoryModels');
    }
    public function index(){
        $datatable_assets = $this->MainModels->getAssets('datatable');
        
        $js = array_merge($datatable_assets['js']);
        $css = array_merge($datatable_assets['css']);
        $data = array(  
            'js' => $js,
            'css' => $css, 
        );    

        $data['tampil_category']=$this->CategoryModels->tampil_cat();
        $this->template->load('template', 'administrator/content/category', $data);
    }

    public function add_category(){

		$post = $this->input->post();
        $config['upload_path'] = 'assets/picture/mobile';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = TRUE;
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('category_picture')) {
            $error = array('error' => $this->upload->display_errors());

            $file_name = '-';

            $insert_channel = $this->CategoryModels->insert_db($post, $file_name);
            $this->session->set_flashdata('message', $insert_channel['message']);

            redirect(base_url('category'));
        } else {
            $data = array('upload_data' => $this->upload->data());
            $file_name = $data['upload_data']['file_name'];

            $insert_channel = $this->CategoryModels->insert_db($post, $file_name);
            $this->session->set_flashdata('message', $insert_channel['message']);

            redirect(base_url('category'));
        }
    }
    public function get_detail_category($lead_category_id='')
	{
		$data_detail=$this->CategoryModels->detail_category($lead_category_id);
		echo json_encode($data_detail);
	}
	public function update_category()
	{
       // check jika input file image ada
        if ($_FILES['update_img']['name']) {                        
            $config['upload_path'] = 'assets/picture/mobile';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            $config['overwrite'] = TRUE;

            $this->load->library('upload', $config);
            // check jika file gagal upload atau tidak sesuai validasi
            if (!$this->upload->do_upload('update_img')) {
                $error = array('error' => $this->upload->display_errors());            
                $this->session->set_flashdata('pesan', $error);
                redirect(base_url('category'),'refresh');

            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
                // check jika validasi input lainnya
                // if ($this->form_validation->run() == FALSE) {
                //     $this->session->set_flashdata('pesan', validation_errors());
                //     redirect(base_url('index.php/category'),'refresh');
                // } else {
                    $proses_update=$this->CategoryModels->update_category($file_name);
                    if($proses_update){
                        $this->session->set_flashdata('pesan', '<div class="alert alert-success">SUCCESS UPDATE</div>');
                    } else {
                        $this->session->set_flashdata('pesan', '<div class="alert alert-danger">ERROR UPDATE</div>');
                    }
                    redirect(base_url('category'),'refresh');
                // }
            }
        } else{
            // check jika validasi input lainnya
            // if ($this->form_validation->run() == FALSE) {
            //     $this->session->set_flashdata('pesan', validation_errors());
            //     redirect(base_url('index.php/category'),'refresh');
            // } else {
                $file_name = null;
                $proses_update=$this->CategoryModels->update_category($file_name);
                if($proses_update){
                        $this->session->set_flashdata('pesan', '<div class="alert alert-success">SUCCESS UPDATE</div>');
                        } else {
                            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">ERROR UPDATE</div>');
                        }
                        
                
                redirect(base_url('category'),'refresh');
            // }
        }
    }
    
    public function hapus_category($lead_category_id='')
	{
		$hapus=$this->CategoryModels->hapus($lead_category_id);
		if($hapus){
			$this->session->set_flashdata('pesan', '<div class="alert alert-success">SUCCESS DELETE</div>');
			} else {
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger">ERROR DELETE</div>');
			}
			redirect(base_url('category'),'refresh');
	}

   
}
    