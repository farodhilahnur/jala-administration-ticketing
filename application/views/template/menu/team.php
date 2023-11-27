<li class="nav-item <?php
if ($this->uri->segment(1) == 'team') {
    echo "active";
}
?>  ">
    <a href="<?php echo base_url('team/sales_team'); ?>" class="nav-link nav-toggle">
        <i class="icon-users"></i>
        <span class="title">Team</span>
    </a>
</li>