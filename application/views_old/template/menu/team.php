<li class="nav-item <?php
if ($this->uri->segment(1) == 'team') {
    echo "active";
}
?>  ">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="icon-user"></i>
        <span class="title">Team</span>
        <span class="arrow"></span>
    </a>
    <ul class="sub-menu">
        <?php
        $role = $this->MainModels->UserSession('role_id');
        switch ($role) {
            case 1:
                $this->load->view('template/sub_menu/client');
                $this->load->view('template/sub_menu/sales_team');
                $this->load->view('template/sub_menu/sales_officer');
                break;
            case 2:
                $this->load->view('template/sub_menu/sales_team');
                $this->load->view('template/sub_menu/sales_officer');
                break;
            case 5:
                $this->load->view('template/sub_menu/sales_team');
                $this->load->view('template/sub_menu/sales_officer');
                break;
            case 3:
                $this->load->view('template/sub_menu/sales_officer');
                break;
            default:
                break;
        }
        ?>
    </ul>
</li>