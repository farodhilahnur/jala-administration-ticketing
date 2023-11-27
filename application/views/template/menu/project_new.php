<li class="nav-item <?php
if ($this->uri->segment(1) == 'project') {
    echo "active";
}
?>  ">
    <a href="<?php echo base_url('project_new'); ?>" class="nav-link nav-toggle">
        <i class="icon-notebook"></i>
        <span class="title">Project</span>
    </a>
</li>