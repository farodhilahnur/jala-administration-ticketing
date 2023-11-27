<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_management extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (empty($this->MainModels->UserSession('user_id'))) {
            $this->session->set_flashdata('message', '<p style="color:black;" class="alert alert-warning">Login First to Create Session !!!</p>');
            redirect(base_url('login'));
        } else {
            
        }
        $this->load->model('TeamModels');
    }

    public function client() {
        $datatable_assets = $this->MainModels->getAssets('datatable');
        $team_assets = $this->MainModels->getAssets('team');

        $js = array_merge($datatable_assets['js'], $team_assets['js']);
        $css = array_merge($datatable_assets['css']);

        // $data_client = $this->MainModels->getClient();
        $data_client = $this->TeamModels->getDataClientAll();

        $data = array(
            'title' => 'Client',
            'action_add' => base_url('team/add_client'),
            'action_edit' => base_url('team/edit_client'),
            'js' => $js,
            'css' => $css,
            'data_client' => $data_client
        );

        $this->template->load('template', 'administrator/user/client', $data);
    }

    public function add_client() {
        $post = $this->input->post();
        $select2_assets = $this->MainModels->getAssets('select2');

        $js = array_merge($select2_assets['js']);
        $css = array_merge($select2_assets['css']);

        if ($post) {

            $insert_client = $this->TeamModels->addClient($post);
            $this->session->set_flashdata('message', $insert_client['message']);

            redirect(base_url('user_management/client'));
        }

        $data = array(
            'function' => 'add', 
            'js' => $js,
            'css' => $css
        );

        $this->template->load('template', 'administrator/user/form-client', $data);
    }
    public function get_detail_client($client_id='')
	{
        $data_detail=$this->TeamModels->detail_client($client_id);
		echo json_encode($data_detail);
	}
    
	public function update_client()
	{        
			$proses_update=$this->TeamModels->update_client();
			if($proses_update){
				$this->session->set_flashdata('pesan', '<div class="alert alert-success">SUCCESS EDIT</div>');
			} else {
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger">ERROR EDIT</div>');
			}
			redirect(base_url('user_management/client'),'refresh');
		
    } 
    public function edit_client() {

        $post = $this->input->post();

        if ($post) {
            
            $edit_client = $this->TeamModels->EditClientt($post);
            $this->session->set_flashdata('message', $edit_sales_officer['message']);

            redirect(base_url('user_management/client'));
        }

        $select2_assets = $this->MainModels->getAssets('select2');
        $js = array_merge($select2_assets['js']);
        $css = array_merge($select2_assets['css']);


        $data_client = $this->TeamModels->getDataClientAll();


        $data = array(
            'function' => 'edit',
            'data_client' => $data_client,
            'js' => $js,
            'css' => $css
        );

        $this->template->load('template', 'administrator/user/form-client', $data);
    }
}
