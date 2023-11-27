<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class SiswaModel extends CI_Model
{
    // Fungsi untuk melakukan proses upload file
    public function upload_file($filename)
    {
        $this->load->library('upload'); // Load librari upload

        $config['upload_path'] = 'assets/excel/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '100000';
        $config['overwrite'] = true;
        $config['file_name'] = $filename;

        $this->upload->initialize($config); // Load konfigurasi uploadnya
        if ($this->upload->do_upload('file')) { // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');

            return $return;
        } else {
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());

            return $return;
        }
    }

    // Buat sebuah fungsi untuk melakukan insert lebih dari 1 data
    public function insert_multiple($data)
    {
        $this->db->insert_batch('tbl_lead', $data);
    }

    public function insert_multiple_history($data)
    {
        $this->db->insert_batch('tbl_lead_history', $data);
    }
}
