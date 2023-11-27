<li class="nav-item <?php
if ($this->uri->segment(1) == 'team') {
    echo "active";
}
?>  ">
    <a href="<?php echo base_url('team/sales_officer'); ?>" class="nav-link nav-toggle">
        <i class="icon-user"></i>
        <span class="title">Sales Officer</span>
    </a>
</li>