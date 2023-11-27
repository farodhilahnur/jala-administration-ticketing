<li class="nav-item <?php
if ($this->uri->segment(1) == 'project') {
    echo "active";
}
?>  ">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="icon-folder"></i>
        <span class="title">Project</span>
        <span class="arrow"></span>
    </a>
    <ul class="sub-menu">
        <li class="nav-item <?php
        if ($this->uri->segment(2) == 'leads') {
            echo "active";
        }
        ?>">
            <a href="<?php echo base_url('lead'); ?>" class="nav-link">
                <i class="icon-folder-alt"></i> Leads
            </a>
        </li>
        <li class="nav-item <?php
        if ($this->uri->segment(2) == 'channel') {
            echo "active";
        }
        ?>">
            <a href="" class="nav-link">
                <i class="icon-folder-alt"></i> Channel
            </a>
        </li>
        <li class="nav-item <?php
        if ($this->uri->segment(2) == 'campaign') {
            echo "active";
        }
        ?>">
            <a href="" class="nav-link">
                <i class="icon-folder-alt"></i> Campaign
            </a>
        </li>
        <li class="nav-item <?php
        if ($this->uri->segment(2) == 'media') {
            echo "active";
        }
        ?>">
            <a href="<?php echo base_url('media'); ?>" class="nav-link">
                <i class="icon-folder-alt"></i> Media
            </a>
        </li>
    </ul>
</li>