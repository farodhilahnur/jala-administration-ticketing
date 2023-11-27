<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FaqModels extends CI_Model {

    public function tampil_faq(){
        $this->db->select('a.*, b.client_name, c.email');
        $this->db->join('tbl_client b', 'b.user_id = a.user_id');
        $this->db->join('tbl_user c', 'c.user_id = a.user_id');
        $tm=$this->db->get('tbl_faq a')->result();
        return $tm;
    }

    public function getFaqClient(){

        $client_id = $this->MainModels->getClientId();

        $data_faq = $this->db->get_where('tbl_faq', array('client_id' => $client_id))->result();

        if (!empty($data_faq)) {
            $data = $data_faq;
        } else {
            $data = array();
        }

        return $data;

    }

    public function insert_db($post, $file_name)
	{
            $data_insert = array(
                'id'=>$this->input->post('id'),
                'user_id' => $this->MainModels->UserSession('user_id'),
                'email'=>$this->input->post('email'), 
                'title'=>$this->input->post('title'),
                'category'=>$this->input->post('category'),
                'image' => $file_name,
                'detail'=>$this->input->post('detail'),
                'client_id' => $this->MainModels->getClientId('client_id'),
            );
    
            $insert_media = $this->db->insert('tbl_faq', $data_insert);
    
            if ($insert_media) {
                $response = 'success';
                // $message = '<p class="alert alert-success"> Success Add </p>';
            } else {
                $response = 'error';
                // $message = '<p class="alert alert-danger"> Error Add</p>';
            }
    
            $data_media = array('res' => $response);
            return $data_media;	
    }

    public function detail_admin($id)
	{
		return $this->db->where('id',$id)->get('tbl_faq')->row();
	}
	public function update_admin()
	{
		$dt_up_admin=array(
            // 'user_id'=>$this->input->post('user_id'),
            'status'=>$this->input->post('status'),
            'due_date'=>$this->input->post('due_date'),
		);
	    return $this->db->where('id',$this->input->post('id'))->update('tbl_faq', $dt_up_admin);
	}

    function tampil()
    {
        $query=$this->db->get(‘artikel’);
        if($query ->num_rows()>0)
    {
        return $query->result();
    }
        else
        {
        return array();
        }
    }

    function per_id($id)
    {
        $this->db->where('id',$id);
        $query=$this->db->get('tbl_faq');
        return $query->result();
    }
    public function GetArtikelId($id){
        $id= $this->db->select('*')
                        ->from('tbl_faq')
                        ->where('id',$id)
                        ->get();
        return $id;

    }
    public function add_record($data){
        $this->db->insert('tbl_faq', $data);
        return;
    }
     function insert($data)
    {
      $this->db->insert('tbl_faq', $data);
    }
}
