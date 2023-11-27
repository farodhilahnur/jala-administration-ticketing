<li class="nav-item <?php
if ($this->MainModels->UserSession('role_id') == 1) {
    if ($this->uri->segment(1) == 'lead') {
        echo "active";
    }
} else {
    if ($this->uri->segment(1) == 'lead') {
        echo "active";
    }
}
?>  ">
    <a href="<?php echo base_url('lead'); ?>" class="nav-link nav-toggle">
        <i class="icon-notebook"></i>
        <span class="title">Lead</span>
    </a>
    <!--    <ul class="sub-menu">-->
    <!--        --><?php
    //        $role = $this->MainModels->UserSession('role_id');
    //        switch ($role) {
    //            case 1:
    //                break;
    //            case 2:
    //                $this->load->view('template/sub_menu/user');
    //                break;
    //            case 3:
    //                $this->load->view('template/sub_menu/user');
    //                break;
    //            default:
    //                break;
    //        }
    //        ?>
    <!--    </ul>-->
</li>