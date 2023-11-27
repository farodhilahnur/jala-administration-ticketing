<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Faq_admin extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->load->Model('FaqModels');
		$this->load->helper('text');
    }
    public function index(){
        $datatable_assets = $this->MainModels->getAssets('datatable');
        
        $js = array_merge($datatable_assets['js']);
        $css = array_merge($datatable_assets['css']);
        $data = array(  
            'js' => $js,
            'css' => $css, 
        );    

        $data['tampil_category']=$this->FaqModels->tampil_faq();
        $this->template->load('template', 'administrator/faq_admin',$data);
    }
    public function get_detail_admin($id='')
	{
		$data_detail=$this->FaqModels->detail_admin($id);
		echo json_encode($data_detail);
	}
	public function update_admin()
	{
        $this->send();
		$proses_update=$this->FaqModels->update_admin();
			if($proses_update){
				$this->session->set_flashdata('pesan', '<div class="alert alert-success">SUCCESS</div>');
			} else {
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger">ERROR</div>');
			}
			redirect(base_url('Faq_admin'),'refresh');
    }
    public function send(){
		$config = [
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'protocol'  => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_user' => 'jala.mailsender1@gmail.com',
			'smtp_pass' => 'apahayo123',      
			'smtp_port' => 465,
			'newline'   => "\r\n"
		];

	 $this->load->library('email', $config);
	 $this->email->from('notification@jala.ai','Jala.ai');
	 $to_email = $_POST['email'];
	 $this->email->to($to_email);
	 $this->email->attach($pic);
	 $this->email->subject('UPDATE');
	 $message= $_POST['due_date'];
	 $status= $_POST['status'];
	  if($status == '2'){
		$this->email->message('Halo ' .$to_email.
		'<br> Terima kasih telah mengisi form pengaduan jala, mohon maaf atas kendala yang terjadi, saat ini form pengaduan anda akan diproses. Estimasi penyelesaian ' .$message.
		'<br>Terima Kasih sudah menggunakan Jala.');
	  } else {
		$this->email->message('Halo ' .$to_email.
		'<br>Saat ini pengaduan anda telah selesai diperbaiki. <br> Terimakasih telah menggunakan Jala.');
	  }
	 
		if ($this->email->send()) {
			echo '';
		} else {
			echo '';
		}
	}

	function selanjutnya()
	{
		$id=$this->uri->segment(3);
		$data['data']=$this->FaqModels->per_id($id);
		$this->load->view('administrator/read_more',$data);
	}

	public function readmore(){
		$id= $this->uri->segment(3);
		$data ['data']= $this->FaqModels->GetArtikelId($id);
		$this->load->view('administrator/read_more',$data);
	}

}
    