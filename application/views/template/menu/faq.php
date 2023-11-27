<li class="nav-item <?php
if ($this->uri->segment(1) == 'faq') {
    echo "active";
}
?>  ">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="icon-question"></i>
        <span class="title">Open Ticket</span>
        <span class="arrow"></span>
    </a>
    <ul class="sub-menu">
        <li class="nav-item <?php
        if ($this->uri->segment(2) == 'faq') {
            echo "active";
        }
        ?>">
            <a href="<?php echo base_url('faq'); ?>" class="nav-link">
                <i class="icon-question"></i> Open Ticket
            </a>
        </li>
        <li class="nav-item <?php
        if ($this->uri->segment(2) == 'faq') {
            echo "active";
        }
        ?>">
            <a href="<?php echo base_url('faq_table'); ?>" class="nav-link">
                <i class="icon-question"></i> Ticketing
            </a>
        </li>
       
    </ul>
</li>