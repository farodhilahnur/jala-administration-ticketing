<li class="nav-item 
<?php
if ($this->uri->segment(2) == 'status') {
    echo "active";
}
?>
    ">
    <a href="<?php echo base_url('content_management/status'); ?>" class="nav-link ">
        <span class="title">Status</span>
    </a>
    <!-- <a href="<?php echo base_url('category'); ?>" class="nav-link ">
        <span class="title">Category</span>
    </a> -->
</li>