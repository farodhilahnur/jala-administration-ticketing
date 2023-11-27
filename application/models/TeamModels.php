<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TeamModels extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->model('UserModels');
    }

    public function getDataSalesTeamAll() {

        $this->db->select('a.*, b.client_name');
        $this->db->join('tbl_client b', 'a.client_id = b.client_id');
        $data_sales_team = $this->db->get('tbl_sales_team a')->result();

        return $data_sales_team;
    }

    public function getDataSalesTeambyClientId($client_id) {

        $this->db->select('a.*, b.client_name');
        $this->db->join('tbl_client b', 'a.client_id = b.client_id');
        $data_sales_team = $this->db->get_where('tbl_sales_team a', array('a.client_id' => $client_id))->result();

        return $data_sales_team;
    }

    public function getDataSalesTeambyClientAdminId() {

        $list_channel = array();
        $data_channel = $this->ChannelModels->getDataChannelbyClientAdminId();

        if (!empty($data_channel)) {
            foreach ($data_channel as $dch) {
                array_push($list_channel, $dch->id);
            }
        }

        $list_sales_team_id = array();
        $this->db->where_in('channel_id', $list_channel);
        $data_sales_team_channel = $this->db->get('tbl_sales_team_channel')->result();

        if (!empty($data_sales_team_channel)) {

            foreach ($data_sales_team_channel as $dstc) {
                array_push($list_sales_team_id, $dstc->sales_team_id);
            }

            if (!empty($list_sales_team_id)) {
                $this->db->where_in('sales_team_id', $list_sales_team_id);
                $this->db->select('a.*, b.client_name');
                $this->db->join('tbl_client b', 'a.client_id = b.client_id');
                $data_sales_team = $this->db->get('tbl_sales_team a')->result();
            } else {
                $data_sales_team = array();
            }
        }

        return $data_sales_team;
    }

    public function getDataSalesOfficerBySalesTeamId($id) {

        $this->db->select('a.*');
        $this->db->join('tbl_sales_officer a', 'b.sales_officer_id = a.sales_officer_id');
        $data_sales_officer = $this->db->get_where('tbl_sales_officer_group b', array('b.sales_team_id' => $id))->result();

        return $data_sales_officer;
    }

    public function addSalesTeam($post) {

        $role = $this->MainModels->UserSession('role_id');

        $data_insert_user = array(
            'email' => $post['email'],
            'password' => md5($post['password']),
            'role_id' => 3,
            'create_by' => $this->MainModels->UserSession('user_id')
        );

        $insert_user = $this->db->insert('tbl_user', $data_insert_user);

        if ($insert_user) {

            $user_id = $this->db->insert_id();

            if ($this->MainModels->UserSession('role_id') == 1) {
                $data_insert_sales_team = array(
                    'sales_team_name' => $post['salesTeamName'],
                    'client_id' => $post['client_id'],
                    'sales_team_address' => $post['address'],
                    'sales_team_email' => $post['email'],
                    'sales_team_phone' => $post['phone'],
                    'sales_team_pic' => $post['picname'],
                    'create_by' => $this->MainModels->UserSession('user_id'),
                    'user_id' => $user_id
                );
            } else {

                if ($role != 5) {
                    $client_id = $this->db->get_where('tbl_client', array('user_id' => $this->MainModels->UserSession('user_id')))->row('client_id');
                } else {
                    $client_id = $this->db->get_where('tbl_client_admin', array('user_id' => $this->MainModels->UserSession('user_id')))->row('client_id');
                }

                $data_insert_sales_team = array(
                    'sales_team_name' => $post['salesTeamName'],
                    'client_id' => $client_id,
                    'sales_team_address' => $post['address'],
                    'sales_team_email' => $post['email'],
                    'sales_team_phone' => $post['phone'],
                    'sales_team_pic' => $post['picname'],
                    'create_by' => $this->MainModels->UserSession('user_id'),
                    'user_id' => $user_id
                );
            }

            $insert_sales_team = $this->db->insert('tbl_sales_team', $data_insert_sales_team);

            if ($insert_sales_team) {

                $sales_team_id = $this->db->insert_id();

                $this->MainModels->insert_log('Sales Team Added By ', 4, $sales_team_id);

                if (isset($post['coverageArea'])) {
                    $coverage_area = $post['coverageArea'];
                } else {
                    $data_kota = $this->db->get('tbl_kota')->result();

                    $coverage_area = array();

                    foreach ($data_kota as $dk) {
                        array_push($coverage_area, $dk->kota_id);
                    }
                }

                foreach ($coverage_area as $ca) {
                    $city_id = $ca;

                    $data_insert_city = array(
                        'sales_team_id' => $sales_team_id,
                        'city_id' => $city_id
                    );

                    $insertCity = $this->db->insert('tbl_sales_team_city', $data_insert_city);

                    if ($insertCity) {
                        $message = '<p class="alert alert-success">Success Add Sales Team</p>';
                    } else {
                        $message = '<p class="alert alert-danger">Error Add Sales Team</p>';
                    }
                }
            } else {
                $response = 'error';
                $message = '<p class="alert alert-danger"> Error Add Sales Team </p>';
            }
        }

        $data = array('response' => $response, 'message' => $message);
        return $data;
    }

    public function EditSalesTeam($post) {

        if ($post['password'] != "") {
            $data_update_user = array(
                'email' => $post['email'],
                'password' => md5($post['password']),
                'update_by' => $this->MainModels->UserSession('user_id')
            );
        } else {
            $data_update_user = array(
                'email' => $post['email'],
                'update_by' => $this->MainModels->UserSession('user_id')
            );
        }

        $this->db->where('user_id', $post['user_id']);
        $update_user = $this->db->update('tbl_user', $data_update_user);

        if ($update_user) {

            $user_id = $post['user_id'];

            if ($this->MainModels->UserSession('role_id') == 1) {

                if (isset($post['coverageArea'])) {
                    $data_update_sales_team = array(
                        'sales_team_name' => $post['salesTeamName'],
                        'client_id' => $post['client_id'],
                        'sales_team_address' => $post['address'],
                        'sales_team_email' => $post['email'],
                        'sales_team_phone' => $post['phone'],
                        'sales_team_pic' => $post['picname'],
                        'update_by' => $this->MainModels->UserSession('user_id'),
                        'is_all_city' => 0
                    );
                } else {
                    $data_update_sales_team = array(
                        'sales_team_name' => $post['salesTeamName'],
                        'client_id' => $post['client_id'],
                        'sales_team_address' => $post['address'],
                        'sales_team_email' => $post['email'],
                        'sales_team_phone' => $post['phone'],
                        'sales_team_pic' => $post['picname'],
                        'update_by' => $this->MainModels->UserSession('user_id')
                    );
                }
            } else {
                if (isset($post['coverageArea'])) {
                    $data_update_sales_team = array(
                        'sales_team_name' => $post['salesTeamName'],
                        'sales_team_address' => $post['address'],
                        'sales_team_email' => $post['email'],
                        'sales_team_phone' => $post['phone'],
                        'sales_team_pic' => $post['picname'],
                        'update_by' => $this->MainModels->UserSession('user_id'),
                        'is_all_city' => 0
                    );
                } else {
                    $data_update_sales_team = array(
                        'sales_team_name' => $post['salesTeamName'],
                        'sales_team_address' => $post['address'],
                        'sales_team_email' => $post['email'],
                        'sales_team_phone' => $post['phone'],
                        'sales_team_pic' => $post['picname'],
                        'update_by' => $this->MainModels->UserSession('user_id')
                    );
                }
            }

            $this->db->where('sales_team_id', $post['sales_team_id']);
            $update_sales_team = $this->db->update('tbl_sales_team', $data_update_sales_team);

            if ($update_sales_team) {

                $sales_team_id = $post['sales_team_id'];

                $this->MainModels->insert_log('Sales Team Edited By ', 4, $sales_team_id);

                $this->db->where('sales_team_id', $post['sales_team_id']);
                $delete = $this->db->delete('tbl_sales_team_city');

                if ($delete) {
                    if (isset($post['coverageArea'])) {
                        $coverage_area = $post['coverageArea'];
                    } else {
                        $data_kota = $this->db->get('tbl_kota')->result();

                        $coverage_area = array();

                        foreach ($data_kota as $dk) {
                            array_push($coverage_area, $dk->kota_id);
                        }
                    }

                    foreach ($coverage_area as $ca) {
                        $city_id = $ca;

                        $data_insert_city = array(
                            'sales_team_id' => $sales_team_id,
                            'city_id' => $city_id
                        );

                        $insertCity = $this->db->insert('tbl_sales_team_city', $data_insert_city);

                        if ($insertCity) {
                            $message = '<p class="alert alert-success">Success Add Sales Team</p>';
                        } else {
                            $message = '<p class="alert alert-danger">Error Add Sales Team</p>';
                        }
                    }
                }
            } else {
                $response = 'error';
                $message = '<p class="alert alert-danger"> Error Add Sales Team </p>';
            }
        }

        $data = array('response' => $response, 'message' => $message);
        return $data;
    }

    public function getDataSalesOfficerAll() {
        $this->db->select('a.*, b.client_name');
        $this->db->join('tbl_client b', 'a.client_id = b.client_id');
        $data_sales_officer = $this->db->get('tbl_sales_officer a')->result();

        return $data_sales_officer;
    }

    public function getDataSalesOfficerByClientId($client_id) {

        $data_sales_team = $this->db->get_where('tbl_sales_team', array('client_id' => $client_id))->result();
        $list_sales_team = array();

        foreach ($data_sales_team as $dst) {
            array_push($list_sales_team, $dst->sales_team_id);
        }

        if (!empty($list_sales_team)) {
            $this->db->where_in('sales_team_id', $list_sales_team);
            $data_sales_officer_group = $this->db->get('tbl_sales_officer_group')->result();
            $list_sales_officer = array();

            if (!empty($data_sales_officer_group)) {
                foreach ($data_sales_officer_group as $dsog) {
                    array_push($list_sales_officer, $dsog->sales_officer_id);
                }

                $this->db->where_in('sales_officer_id', $list_sales_officer);
                $data_sales_officer = $this->db->get('tbl_sales_officer')->result();
            } else {
                $data_sales_officer = [];
            }
        } else {
            $data_sales_officer = [];
        }



        return $data_sales_officer;
    }

    public function addSalesOfficer($post) {

        $data_insert_user = array(
            'email' => $post['email'],
            'password' => md5($post['password']),
            'role_id' => 4,
            'create_by' => $this->MainModels->UserSession('user_id')
        );

        $insert_user = $this->db->insert('tbl_user', $data_insert_user);

        if ($insert_user) {

            $user_id = $this->db->insert_id();


            if ($post['gender'] == 'male') {
                $gender = 1;
            } else {
                $gender = 2;
            }

            if ($this->MainModels->UserSession('role_id') == 1) {
                $data_insert_sales_officer = array(
                    'sales_officer_name' => $post['salesOfficerName'],
                    'sales_officer_address' => $post['address'],
                    'sales_officer_email' => $post['email'],
                    'sales_officer_phone' => $post['phone'],
                    'client_id' => $post['client_id'],
                    'sales_officer_gender' => $gender,
                    'sales_officer_password' => md5($post['password']),
                    'create_by' => $this->MainModels->UserSession('user_id'),
                    'user_id' => $user_id
                );
            } else {

                $client_id = $this->MainModels->getClientId();

                $data_insert_sales_officer = array(
                    'sales_officer_name' => $post['salesOfficerName'],
                    'sales_officer_address' => $post['address'],
                    'sales_officer_email' => $post['email'],
                    'sales_officer_phone' => $post['phone'],
                    'sales_officer_gender' => $gender,
                    'client_id' => $client_id,
                    'sales_officer_password' => md5($post['password']),
                    'create_by' => $this->MainModels->UserSession('user_id'),
                    'user_id' => $user_id
                );
            }


            $insert_sales_officer = $this->db->insert('tbl_sales_officer', $data_insert_sales_officer);

            if ($insert_sales_officer) {

                $sales_officer_id = $this->db->insert_id();


                $this->MainModels->insert_log('Sales Officer Added By ', 5, $sales_officer_id);

                if ($this->MainModels->UserSession('role_id') == 3) {
                    $sales_team = $this->MainModels->getSalesTeamId();

                    $data_insert_sales_officer_group = array(
                        'sales_officer_id' => $sales_officer_id,
                        'sales_team_id' => $sales_team
                    );

                    $insertGroup = $this->db->insert('tbl_sales_officer_group', $data_insert_sales_officer_group);

                    if ($insertGroup) {
                        $message = '<p class="alert alert-success">Success Add Sales Officer</p>';
                    } else {
                        $message = '<p class="alert alert-danger">Error Add Sales Officer</p>';
                    }
                } else {
                    $sales_team = $post['salesTeam'];

                    foreach ($sales_team as $st) {

                        $data_insert_sales_officer_group = array(
                            'sales_officer_id' => $sales_officer_id,
                            'sales_team_id' => $st
                        );

                        $insertGroup = $this->db->insert('tbl_sales_officer_group', $data_insert_sales_officer_group);

                        if ($insertGroup) {
                            $message = '<p class="alert alert-success">Success Add Sales Officer</p>';
                        } else {
                            $message = '<p class="alert alert-danger">Error Add Sales Officer</p>';
                        }
                    }
                }
            } else {
                $response = 'error';
                $message = '<p class="alert alert-danger"> Error Add Sales Officer </p>';
            }
        }

        $data = array('response' => $response, 'message' => $message);
        return $data;
    }

    public function editSalesOfficer($post) {

        if ($post['password'] != "") {
            $data_update_user = array(
                'email' => $post['email'],
                'password' => md5($post['password']),
                'update_by' => $this->MainModels->UserSession('user_id')
            );
        } else {
            $data_update_user = array(
                'email' => $post['email'],
                'update_by' => $this->MainModels->UserSession('user_id')
            );
        }

        $this->db->where('user_id', $post['user_id']);
        $update_user = $this->db->update('tbl_user', $data_update_user);

        if ($update_user) {

            if ($post['gender'] == 'male') {
                $gender = 1;
            } else {
                $gender = 2;
            }

            if ($post['password'] != "") {
                $data_update_sales_officer = array(
                    'sales_officer_name' => $post['salesOfficerName'],
                    'sales_officer_address' => $post['address'],
                    'sales_officer_email' => $post['email'],
                    'sales_officer_phone' => $post['phone'],
                    'sales_officer_gender' => $gender,
                    'sales_officer_password' => md5($post['password']),
                    'update_by' => $this->MainModels->UserSession('user_id')
                );
            } else {
                $data_update_sales_officer = array(
                    'sales_officer_name' => $post['salesOfficerName'],
                    'sales_officer_address' => $post['address'],
                    'sales_officer_email' => $post['email'],
                    'sales_officer_phone' => $post['phone'],
                    'sales_officer_gender' => $gender,
                    'update_by' => $this->MainModels->UserSession('user_id')
                );
            }

            $this->db->where('sales_officer_id', $post['sales_officer_id']);
            $update_sales_officer = $this->db->update('tbl_sales_officer', $data_update_sales_officer);

            if ($update_sales_officer) {

                $this->MainModels->insert_log('Sales Officer Edited By ', 5, $post['sales_officer_id']);

                $response = 'success';
                $message = '<p class="alert alert-success">Success Edit Sales Officer</p>';

                if ($this->MainModels->UserSession('role_id') != 3) {
                    $this->db->where('sales_officer_id', $post['sales_officer_id']);
                    $delete = $this->db->delete('tbl_sales_officer_group');

                    if ($delete) {
                        $sales_officer_id = $post['sales_officer_id'];
                        $sales_team = $post['salesTeam'];

                        foreach ($sales_team as $st) {

                            $data_insert_sales_officer_group = array(
                                'sales_officer_id' => $sales_officer_id,
                                'sales_team_id' => $st
                            );

                            $insertGroup = $this->db->insert('tbl_sales_officer_group', $data_insert_sales_officer_group);

                            if ($insertGroup) {
                                $response = 'success';
                                $message = '<p class="alert alert-success">Success Edit Sales Officer</p>';
                            } else {
                                $response = 'error';
                                $message = '<p class="alert alert-danger">Error Edit Sales Officer Group</p>';
                            }
                        }
                    } else {
                        $response = 'error';
                        $message = '<p class="alert alert-danger"> Error Delete Sales Officer Group </p>';
                    }
                }
            } else {
                $response = 'error';
                $message = '<p class="alert alert-danger"> Error Edit Sales Officer </p>';
            }
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Edit User </p>';
        }

        $data = array('response' => $response, 'message' => $message);
        return $data;
    }

    public function getDataClientAll() {
        $data_client = $this->db->get('tbl_client')->result();

        return $data_client;
    }

    public function addClient($post) {

        $data_insert_user = array(
            'email' => $post['email'],
            'password' => md5($post['password']),
            'role_id' => 2,
            'create_by' => $this->MainModels->UserSession('user_id')
        );

        $insert_user = $this->db->insert('tbl_user', $data_insert_user);

        if ($insert_user) {

            $user_id = $this->db->insert_id();

            $data_insert_client = array(
                'client_name' => $post['name'],
                'client_address' => $post['address'],
                'client_email' => $post['email'],
                'client_phone' => $post['phone'],
                'pic' => $post['picname'],
                'industry_type' => $post['industry_type'],
                // 'duration' => $post['iduartion'], 
                'quota' => $post['quota'],
                'create_by' => $this->MainModels->UserSession('user_id'),
                'user_id' => $user_id
            );

            $insert_client = $this->db->insert('tbl_client', $data_insert_client);

            if ($insert_client) {
                $client_id = $this->db->insert_id();

                $this->MainModels->insert_log('Client Added By ', 6, $client_id);

                $response = 'success';
                $message = '<p class="alert alert-success">Success Add Client</p>';
            } else {
                $response = 'error';
                $message = '<p class="alert alert-danger"> Error Add Client </p>';
            }
        }

        $data = array('response' => $response, 'message' => $message);
        return $data;
    }

    public function getCountSalesOfficerbySalesTeamId($id) {
        $data_sales_officer = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $id))->result();

        return count($data_sales_officer);
    }

    public function getCountChannelbySalesTeamId($id) {
        $data_channel = $this->db->get_where('tbl_sales_team_channel', array('sales_team_id' => $id))->result();

        return count($data_channel);
    }

    public function deleteSalesTeam() {
        $id = $this->input->get('id');

        //get data sales team 
        $user_id = $this->db->get_where('tbl_sales_team', array('sales_team_id' => $id))->row('user_id');

        //delete sales officer group
        $this->db->where('sales_team_id', $id);
        $delete_sales_officer_group = $this->db->delete('tbl_sales_officer_group');

        if ($delete_sales_officer_group) {
            //delete sales team channel
            $this->db->where('sales_team_id', $id);
            $delete_sales_team_channel = $this->db->delete('tbl_sales_team_channel');

            if ($delete_sales_team_channel) {
                //delete sales team city
                $this->db->where('sales_team_id', $id);
                $delete_sales_team_city = $this->db->delete('tbl_sales_team_city');

                if ($delete_sales_team_city) {
                    //delete sales team city
                    $this->db->where('sales_team_id', $id);
                    $delete_sales_team_distribution = $this->db->delete('tbl_sales_team_distribution');

                    if ($delete_sales_team_distribution) {
                        $this->db->where('sales_team_id', $id);
                        $delete_sales_team = $this->db->delete('tbl_sales_team');

                        if ($delete_sales_team) {
                            //delete tbl user
                            $delete_user = $this->UserModels->deleteUser($user_id);

                            if ($delete_user['status'] == 200) {

                                $this->MainModels->insert_log('Sales Team Deleted By ', 5, $id);

                                $response = 'success';
                                $message = '<p class="alert alert-success">Success Delete Sales Team</p>';
                            } else {
                                $response = 'error';
                                $message = '<p class="alert alert-danger"> Error Delete user </p>';
                            }
                        } else {
                            $response = 'error';
                            $message = '<p class="alert alert-danger"> Error Delete Sales Team</p>';
                        }
                    } else {
                        $response = 'error';
                        $message = '<p class="alert alert-danger"> Error Delete Sales Team Distribution </p>';
                    }
                } else {
                    $response = 'error';
                    $message = '<p class="alert alert-danger"> Error Delete Sales Team City </p>';
                }
            } else {
                $response = 'error';
                $message = '<p class="alert alert-danger"> Error Delete Sales Team Channel</p>';
            }
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Delete Sales Officer Group </p>';
        }

        $data = array('response' => $response, 'message' => $message);

        return $data;
    }

    public function update_client() {
        $data_client_on_user = $this->db->where('client_id', $this->input->post('client_id'))->get('tbl_client')->row();
        // $data_client_on = $this->db->where('user_id', $this->input->post('user_id'))->get('tbl_user')->row();        

        if ($this->input->post('password') != "") {
            $data_update_user = array(
                'email' => $this->input->post('client_email'),
                'password' => md5($this->input->post('password')),
                'update_by' => $this->MainModels->UserSession('user_id')
            );
        } else {
            $data_update_user = array(
                'email' => $this->input->post('client_email'),
                'update_by' => $this->MainModels->UserSession('user_id')
                    // 'role_id' => 2,
                    // 'create_by' => $this->MainModels->UserSession('user_id')
            );
        }

        $update_user = $this->db->where('email', $data_client_on_user->client_email)->update('tbl_user', $data_update_user);

        $dt_up_level = array(
            'client_name' => $this->input->post('client_name'),
            'client_address' => $this->input->post('client_address'),
            'client_email' => $this->input->post('client_email'),
            'client_phone' => $this->input->post('client_phone'),
            'pic' => $this->input->post('pic'),
            'industry_type' => $this->input->post('industry_type'),
            'duration' => $this->input->post('duration'),
            'quota' => $this->input->post('quota'),
                // 'update_by' => $this->MainModels->UserSession('user_id'),
                // 'user_id' => $user_id,
        );
        $update_client = $this->db->where('client_id', $this->input->post('client_id'))->update('tbl_client', $dt_up_level);

        if ($update_client && $update_user) {
            return true;
        }
        // return $data_update_user;
        // return $this->db->where('client_id',$this->input->post('client_id'))->update('tbl_client', $dt_up_level);
    }

    public function detail_client($client_id) {
        return $this->db->where('client_id', $client_id)->get('tbl_client')->row();
    }

}
