<li class="nav-item <?php
if ($this->MainModels->UserSession('role_id') == 1) {
    if ($this->uri->segment(1) == 'help') {
        echo "active";
    }
} else {
    if ($this->uri->segment(1) == 'help') {
        echo "active";
    }
}
?>  ">
    <a href="<?php echo base_url('faq'); ?>" class="nav-link nav-toggle">
        <i class="icon-wrench"></i>
        <span class="title">Help</span>
    </a>
</li>