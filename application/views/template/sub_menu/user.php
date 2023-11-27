<li class="nav-item  
<?php
if ($this->uri->segment(1) == 'user') {
    echo "active";
}
?> ">
    <a href="<?php echo base_url('user'); ?>" class="nav-link ">
        <span class="title">User</span>
    </a>
</li>
<li class="nav-item  
<?php
if ($this->uri->segment(2) == 'payment') {
    echo "active";
}
?> ">
    <a href="<?php echo base_url('user/payment'); ?>" class="nav-link ">
        <span class="title">Payment Method</span>
    </a>
</li>   