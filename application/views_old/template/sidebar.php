<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
        <li class="nav-item 
        <?php
        if ($this->uri->segment(1) == '') {
            echo "active";
        }
        ?>
            ">
            <a href="<?php echo base_url(); ?>" class="nav-link nav-toggle">
                <i class="icon-home"></i>
                <span class="title">Dashboard</span>
            </a>
        </li>
        <?php
        $role_id = $this->MainModels->UserSession('role_id');
        switch ($role_id) {
            case 1:
                ?>
                <li class="heading">
                    <h3 class="uppercase">Master Data</h3>
                </li>
                <?php
                $this->load->view('template/menu/user');
                $this->load->view('template/menu/team');
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

                $this->load->view('template/menu/project_client', $data);
                $this->load->view('template/menu/setting');
                break;
            case 5:

                $client_id = $this->MainModels->getClientId();
                $data_project = $this->MainModels->getDataProject($client_id);

                $data = array('data_project' => $data_project);

                //$this->load->view('template/menu/user');
                $this->load->view('template/menu/team');

                $this->load->view('template/menu/project_client', $data);
                
                break;
            case 3:

                $client_id = $this->MainModels->getClientId();
                $data_project = $this->MainModels->getDataProject($client_id);

                $data = array('data_project' => $data_project);

                //$this->load->view('template/menu/user');
                $this->load->view('template/menu/team');

                $this->load->view('template/menu/project_client', $data);
                
                break;
            default:
                break;
        }
        ?>    
    </ul>
    <!-- END SIDEBAR MENU -->
</div>