<li class="nav-item <?php
if ($this->uri->segment(1) == 'faq_admin') {
    echo "active";
}
?>  ">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="icon-question"></i>
        <span class="title">HELP</span>
        <span class="arrow"></span>
    </a>
    <ul class="sub-menu">
        <li class="nav-item <?php
        if ($this->uri->segment(2) == 'faq_admin') {
            echo "active";
        }
        ?>">
            <a href="<?php echo base_url('faq_admin'); ?>" class="nav-link">
                <i class="icon-question"></i> FAQ
            </a>
        </li>
       
    </ul>
</li>