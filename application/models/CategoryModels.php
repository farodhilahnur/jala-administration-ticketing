<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryModels extends CI_Model {

    public function tampil_cat(){
        $tm=$this->db->get('tbl_lead_category')->result();
        return $tm;
    }

	 public function insert_db($post, $file_name)
	{
            $data_insert = array(
                'lead_category_id'=>$this->input->post('lead_category_id'),
                'mobile_icon' => $file_name,
				'category_name'=>$this->input->post('category_name'),
			    'icon'=>$this->input->post('icon'),
			    'color'=>$this->input->post('color'),
                'urutan'=>$this->input->post('urutan'),
                'background_color'=>$this->input->post('background_color'),
            );
    
            $insert_media = $this->db->insert('tbl_lead_category', $data_insert);
    
            if ($insert_media) {
                $response = 'success';
                $message = '<p class="alert alert-success"> Success Add Category </p>';
            } else {
                $response = 'error';
                $message = '<p class="alert alert-danger"> Error Add Category </p>';
            }
    
            $data_media = array('message' => $message, 'res' => $response);
            return $data_media;	
    }
    public function detail_category($lead_category_id)
	{
		return $this->db->where('lead_category_id',$lead_category_id)->get('tbl_lead_category')->row();
	}
	public function update_category($file_name)
	{
		if ($file_name){
            $dt_up_level=array(
                'category_name'=>$this->input->post('category_name'),
                'icon'=>$this->input->post('icon'),
                'color'=>$this->input->post('color'),
                'background_color'=>$this->input->post('background_color'),
                'mobile_icon'=>$file_name,
                'urutan'=>$this->input->post('urutan'),
            );
        } else {
            $dt_up_level=array(
                'category_name'=>$this->input->post('category_name'),
                'icon'=>$this->input->post('icon'),
                'color'=>$this->input->post('color'),
                'background_color'=>$this->input->post('background_color'),
                'urutan'=>$this->input->post('urutan'),
            );
        }
            
	    return $this->db->where('lead_category_id',$this->input->post('lead_category_id'))->update('tbl_lead_category', $dt_up_level);
    }
    
    public function hapus($lead_category_id)
	{
		return $this->db->where('lead_category_id',$lead_category_id)->delete('tbl_lead_category');
	}


}
