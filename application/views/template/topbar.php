<div class="page-actions hide-topbar">
    <ul class="nav navbar-nav pull-left">
        <li class="dropdown dropdown-user dropdown-dark">
            <a href="<?php echo base_url('dashboard_new'); ?>" class="dropdown-toggle">
                <i class="icon-home"></i>
                <span class="username username-hide-on-mobile"> Dashboard </span>
                <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                <ul class="dropdown-menu dropdown-menu-default">

                    <li>
                        <a href="<?php echo base_url('user/profile'); ?>">
                            <i class="icon-user"></i> My Profile </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url('user/logout'); ?>">
                            <i class="icon-key"></i> Log Out </a>
                    </li>
                </ul>
        </li>
        <?php
        $role_id = $this->MainModels->UserSession('role_id');
        switch ($role_id) {
            case 1:
                ?>
                <?php
                $this->load->view('template/menu/user');
                $this->load->view('template/administrator/user');
                $this->load->view('template/administrator/content');
                $this->load->view('template/menu/project_admin');
                ?>
                <?php
                break;
            case 2:

                $client_id = $this->MainModels->getClientId();
                $data_project = $this->MainModels->getDataProject($client_id);

                $data = array('data_project' => $data_project);

                //$this->load->view('template/menu/user');
                $this->load->view('template/menu/team');
                $this->load->view('template/menu/sales_officer');
                $this->load->view('template/menu/project_new');
                $this->load->view('template/menu/lead');
                $this->load->view('template/menu/setting');
//                $this->load->view('template/menu/help');
                //$this->load->view('template/menu/project_client', $data);
//                $this->load->view('template/menu/faq_help');
                //$this->load->view('template/menu/setting');
                break;
            case 5:

                $user_id = $this->MainModels->UserSession('user_id');


                //get client admin
                $data_client_admin = $this->db->get_where('tbl_client_admin', array('user_id' => $user_id))->row();

                $data_project = $this->MainModels->getDataProjectByAdminClient($data_client_admin->client_admin_id);
                $data = array('data_project' => $data_project);

                //$this->load->view('template/menu/user');
                $this->load->view('template/menu/team');

                $this->load->view('template/menu/project_new', $data);

                break;
            case 3:

//                $this->load->view('template/menu/team');
                $this->load->view('template/menu/sales_officer');
                $this->load->view('template/menu/project_new');
                $this->load->view('template/menu/lead');

                break;
            default:
                break;
        }
        ?>
    </ul>
</div>