<li class="nav-item 
<?php
if ($this->uri->segment(2) == 'sales_officer') {
    echo "active";
}
?>
    ">
    <a href="<?php echo base_url('team/sales_officer'); ?>" class="nav-link ">
        <span class="title">Sales Officer</span>
    </a>
</li>