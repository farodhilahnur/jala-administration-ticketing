<li class="nav-item 
<?php
if ($this->uri->segment(2) == 'client') {
    echo "active";
}
?>
    ">
    <a href="<?php echo base_url('user_management/client'); ?>" class="nav-link ">
        <span class="title">Client</span>
    </a>
</li>