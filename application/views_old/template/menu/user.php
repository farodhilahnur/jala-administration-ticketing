<li class="nav-item 
<?php
if ($this->uri->segment(1) == 'user') {
    echo "active";
}
?>
    ">
    <a href="<?php echo base_url('user'); ?>" class="nav-link nav-toggle">
        <i class="icon-users"></i>
        <span class="title">User</span>
    </a>
</li>