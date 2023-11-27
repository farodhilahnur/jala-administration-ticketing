<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserModels extends CI_Model {

    public function getDataUserAll() {
        $this->db->order_by('create_at', 'desc');
        $data_user = $this->db->get('tbl_user')->result();

        return $data_user;
    }

    public function getDataUserByUserId($user_id) {
        $data_user = $this->db->get_where('tbl_user', array('user_id' => $user_id))->result();

        return $data_user;
    }

    public function getDataUserByClientId($client_id) {
        $list_user_id = array();
        $data_sales_team = $this->db->get_where('tbl_sales_team', array('client_id' => $client_id))->result();

        foreach ($data_sales_team as $dt) {
            array_push($list_user_id, $dt->user_id);
        }

        $data_sales_officer = $this->db->get_where('tbl_sales_officer', array('client_id' => $client_id))->result();

        foreach ($data_sales_officer as $dso) {
            array_push($list_user_id, $dso->user_id);
        }

        $data_client_admin = $this->db->get_where('tbl_client_admin', array('client_id' => $client_id))->result();

        foreach ($data_client_admin as $dca) {
            array_push($list_user_id, $dca->user_id);
        }

        if (!empty($list_user_id)) {
            $this->db->where_in('user_id', $list_user_id);
            $data_user = $this->db->get('tbl_user')->result();
        } else {
            $data_user = array();
        }


        return $data_user;
    }

    public function checkUserLogin($param) {

        $email = $param['email'];
        $password = md5($param['password']);
        $tbl_name = $param['tbl_name'];

        $check_login = $this->db->get_where($tbl_name, array('email' => $email, 'password' => $password, 'status' => 1))->row();
        $client_id = $this->db->get_where('tbl_client', array('user_id' => $check_login->user_id))->row('client_id');


        $this->db->order_by('create_at', 'desc');
        $project_id = $this->db->get_where('tbl_project', array('client_id' => $client_id))->row('id');

        if (!empty($check_login)) {
            $data_session = array(
                'user_id' => $check_login->user_id,
                'email' => $check_login->email,
                'role_id' => $check_login->role_id,
            );

            $client_date = substr($check_login->create_at, 0, 10);
            $now = date('Y-m-d');
            $newDate = date("Y-m-d", strtotime($client_date));
            $substract_month = date("Y-m-d", strtotime("-2 months"));
            //$date_range = $newDate . ' to ' . $now;
            $from = $substract_month;
            $to = $now;

            if ($check_login->role_id == 5) {
                
                $project_id_admin = $this->db->get_where('tbl_client_admin', array('user_id' => $check_login->user_id))->row('project_id');
                
                $data_session_dashboard = array(
                    'project_id' => $project_id_admin,
                    'default_project_id' => $project_id,
                    'from' => $from,
                    'to' => $to,
                    'category_id_1' => 0,
                    'category_id_2' => 0      
                );
            } else {
                $data_session_dashboard = array(
                    'project_id' => 0,
                    'default_project_id' => $project_id,
                    'from' => $from,
                    'to' => $to,
                    'category_id_1' => 0,
                    'category_id_2' => 0
                );
            }



            $message = '<p class="alert alert-success">Welcome ' . $param['email'] . ' </p>';
            $redirect = base_url();
        } else {
            $data_session = null;
            $data_session_dashboard = null;
            $message = '<p style="color:black;" class="alert alert-danger"> Password Salah !!! </p>';
            $redirect = base_url('login');
        }

        $data = array('session' => $data_session, 'session_dashboard' => $data_session_dashboard, 'message' => $message, 'redirect' => $redirect);
        return $data;
    }

    public function checkLoginApiProd($param) {
        $email = $param['username'];
        $password = $param['password'];
        $tbl_name = $param['tbl_name'];

        $check_login = $this->db->get_where($tbl_name, array('sales_officer_email' => $email, 'sales_officer_password' => $password, 'status' => 1))->row();

        if (!empty($check_login)) {
            $length = 1;
            $sales_officer_id = $check_login->sales_officer_id;

            //get client name
            $this->db->where('b.sales_officer_id', $sales_officer_id);
            $this->db->select('a.client_name, a.industry_type');
            $this->db->join('tbl_sales_team c', 'c.sales_team_id = b.sales_team_id');
            $this->db->join('tbl_client a', 'a.client_id = c.client_id ');
            $client_name = $this->db->get('tbl_sales_officer_group b')->row();

            $status = 200;
        } else {
            $length = 0;
            $status = 400;
            $client_name = "";
        }

        $data = array('status' => $status, 'length' => $length, 'data' => $check_login, 'client_name' => $client_name->client_name, 'industry_type' => $client_name->industry_type);
        return $data;
    }

    public function checkLoginApi($param) {

        $email = $param['username'];
        $password = $param['password'];
        $tbl_name = $param['tbl_name'];
        $device_id = $param['device_id'];

        $check_login = $this->db->get_where($tbl_name, array('sales_officer_email' => $email, 'sales_officer_password' => $password))->row();

        $sales_officer_id = $check_login->sales_officer_id;

        //get client name
        $this->db->where('b.sales_officer_id', $sales_officer_id);
        $this->db->select('a.client_name, a.industry_type');
        $this->db->join('tbl_sales_team c', 'c.sales_team_id = b.sales_team_id');
        $this->db->join('tbl_client a', 'a.client_id = c.client_id ');
        $client_name = $this->db->get('tbl_sales_officer_group b')->row();

        if (!empty($check_login)) {

            /* $queryCheckExistDeviceId = "SELECT sales_officer_deviceid FROM tbl_sales_officer WHERE sales_officer_deviceid = '$device_id'";
              $existDeviceId_ = $this->db->query($queryCheckExistDeviceId);
              $existDeviceId = $existDeviceId_->row(); */

            $this->db->select('sales_officer_deviceid');
            $existDeviceId = $this->db->get_where('tbl_sales_officer', array('sales_officer_deviceid' => $device_id))->row('sales_officer_deviceid');

            if ($existDeviceId != "") {
                $setDeviceIdEmpty = "UPDATE tbl_sales_officer SET sales_officer_deviceid = '' WHERE sales_officer_deviceid = '$device_id'";
                $this->db->query($setDeviceIdEmpty);
            }

            if (!empty($check_login)) {
                $token = $this->MainModels->generateRandomString();
                $refreshtoken = $this->MainModels->generateRandomString();
                $query = "UPDATE tbl_sales_officer "
                        . "SET sales_officer_token='$token',"
                        . "sales_officer_tokenexpire=DATE_ADD(now(), INTERVAL 9 HOUR),"
                        . "sales_officer_refreshtoken='$refreshtoken',"
                        . "sales_officer_refreshtokenexpire=DATE_ADD(now(), INTERVAL 2 DAY),"
                        . "sales_officer_deviceid='$device_id' "
                        . "WHERE sales_officer_id=" . $check_login->sales_officer_id;
                $this->db->query($query);

                $status = 200;
            }
        } else {
            $status = 400;
        }
                
        $data = array('status' => $status, 'length' => count($check_login), 'data' => $check_login, 'client_name' => $client_name->client_name, 'industry_type' => $client_name->industry_type);
        return $data;
    }

    public function addUser($post) {

        $name = $post['name'];
        $email = $post['email'];
        $phone = $post['phone'];
        $address = $post['address'];
        $password = md5($post['password']);
        $industry_type = $post['industry_type'];
        $role_id = $post['role_id'];
        $project_id = $post['project_id'];

        $logged_user_id = $this->MainModels->UserSession('user_id');

        $data_insert = array(
            'email' => $email,
            'password' => $password,
            'role_id' => $role_id,
            'create_by' => $logged_user_id
        );

        $insert = $this->db->insert('tbl_user', $data_insert);

        if ($insert) {
            $user_id = $this->db->insert_id();

            switch ($role_id) {
                case 2:

                    $data_insert_client = array(
                        'user_id' => $user_id,
                        'client_email' => $email,
                        'client_name' => $name,
                        'client_phone' => $phone,
                        'client_address' => $address,
                        'industry_type' => $industry_type,
                        'create_by' => $logged_user_id
                    );

                    $insert_client = $this->db->insert('tbl_client', $data_insert_client);

                    if ($insert_client) {
                        $response = 'success';
                        $message = '<p class="alert alert-success"> Success Add Client </p>';
                    } else {
                        $response = 'error';
                        $message = '<p class="alert alert-danger"> Error Add Client </p>';
                    }

                    break;
                case 5:

                    $client_id = $this->MainModels->getClientId();

                    $data_insert_admin_client = array(
                        'user_id' => $user_id,
                        'client_admin_email' => $email,
                        'client_admin_name' => $name,
                        'client_admin_phone' => $phone,
                        'client_admin_address' => $address,
                        'create_by' => $logged_user_id,
                        'client_id' => $client_id,
                        'project_id' => $project_id
                    );

                    $insert_admin_client = $this->db->insert('tbl_client_admin', $data_insert_admin_client);

                    if ($insert_admin_client) {
                        $response = 'success';
                        $message = '<p class="alert alert-success"> Success Add Admin </p>';
                    } else {
                        $response = 'error';
                        $message = '<p class="alert alert-danger"> Error Add Admin </p>';
                    }

                    break;
                default:
                    break;
            }
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Add User </p>';
        }

        $data = array('response' => $response, 'message' => $message);
        return $data;
    }

    public function updateUser($post) {

        if ($post['password'] != '') {
            $username = $post['username'];
            $password = md5($post['password']);

            $data_update = array(
                'email' => $username,
                'password' => $password,
                'update_by' => $this->MainModels->UserSession('user_id')
            );
        } else {
            $username = $post['username'];

            $data_update = array(
                'email' => $username,
                'update_by' => $this->MainModels->UserSession('user_id')
            );
        }

        $this->db->where('user_id', $post['user_id']);
        $update = $this->db->update('tbl_user', $data_update);

        if ($update) {
            $response = 'success';
            $message = '<p class="alert alert-success"> Success Edit User </p>';
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Edit User </p>';
        }

        $data = array('response' => $response, 'message' => $message);
        return $data;
    }

    public function getUserProfilebyUserId() {

        $role_id = $this->MainModels->UserSession('role_id');
        $user_id = $this->MainModels->UserSession('user_id');

        switch ($role_id) {
            case 2:
                $client_id = $this->MainModels->getClientId();
                $data_profile = $this->db->get_where('tbl_client', array('client_id' => $client_id))->row();
                break;
            case 5:
                $client_id = $this->MainModels->getClientId();
                $data_profile = $this->db->get_where('tbl_client_admin', array('client_id' => $client_id))->row();
                break;

            default:
                break;
        }


        return $data_profile;
    }

    public function editProfile($post, $filename) {
        $name = $post['name'];
        $address = $post['address'];
        $phone = $post['phone'];
        $pic = $post['pic'];
        $email = $post['email'];

        switch ($this->MainModels->UserSession('role_id')) {
            case 2:
                $tbl_name = 'tbl_client';
                if ($filename != '') {
                    $data_edit = array(
                        'client_name' => $name,
                        'client_address' => $address,
                        'client_phone' => $phone,
                        'client_email' => $email,
                        'pic' => $pic,
                        'picture_link' => $filename
                    );
                } else {
                    $data_edit = array(
                        'client_name' => $name,
                        'client_address' => $address,
                        'client_phone' => $phone,
                        'client_email' => $email,
                        'pic' => $pic
                    );
                }

                break;
            case 5:
                $tbl_name = 'tbl_client_admin';
                if ($filename != '') {
                    $data_edit = array(
                        'client_admin_name' => $name,
                        'client_admin_address' => $address,
                        'client_admin_phone' => $phone,
                        'client_admin_email' => $email,
                        'pic' => $pic,
                        'picture_link' => $filename
                    );
                } else {
                    $data_edit = array(
                        'client_admin_name' => $name,
                        'client_admin_address' => $address,
                        'client_admin_phone' => $phone,
                        'client_admin_email' => $email,
                        'pic' => $pic
                    );
                }
                break;
            default:
                break;
        }

        $this->db->where('user_id', $this->MainModels->UserSession('user_id'));
        $update = $this->db->update($tbl_name, $data_edit);

        if ($update) {

            if ($post['password'] != '') {
                $data_update_user = array('password' => md5($post['password']));

                $this->db->where('user_id', $this->MainModels->UserSession('user_id'));
                $update_user = $this->db->update('tbl_user', $data_update_user);

                if ($update_user) {
                    $response = 'success';
                    $message = '<p class="alert alert-success"> Success Update Profile </p>';
                } else {
                    $response = 'error';
                    $message = '<p class="alert alert-danger"> Error Update Profile </p>';
                }
            } else {
                $response = 'success';
                $message = '<p class="alert alert-success"> Success Update Profile </p>';
            }
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Update Profile </p>';
        }

        $data_profile = array('message' => $message, 'res' => $response);
        return $data_profile;
    }

    public function getProfileSalesOfficerId($sales_officer_id) {

        $data_sales_officer = $this->db->get_where('tbl_sales_officer', array('sales_officer_id' => $sales_officer_id))->row();

        return $data_sales_officer;
    }

    public function deleteUser($id) {

        $this->db->where('user_id', $id);
        $delete = $this->db->delete('tbl_user');

        if ($delete) {
            $status = 200;
        } else {
            $status = 400;
        }

        $data = array('status' => $status);

        return $data;
    }

    public function addPayment($post, $filename) {

        $data_insert = array(
            'image_link' => $filename,
            'type' => $post['type'],
            'client_id' => $post['client_id']
        );

        $insert = $this->db->insert('tbl_payment', $data_insert);

        if ($insert) {
            $response = 'success';
            $message = '<p class="alert alert-success"> Success Update Payment </p>';
        } else {
            $response = 'error';
            $message = '<p class="alert alert-danger"> Error Update Payment </p>';
        }

        $data_payment = array('message' => $message, 'res' => $response);
        return $data_payment;
    }

}
