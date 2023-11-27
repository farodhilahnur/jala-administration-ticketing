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
        <?php
        if (!empty($data_project)) {
            foreach ($data_project as $dp) {
                ?>
                <li class="nav-item <?php
                if (!empty($project_id)) {
                    if ($project_id == $dp->id) {
                        echo 'active';
                    }
                }
                ?>" >
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-folder-alt"></i> <?php echo $dp->project_name; ?>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item <?php
                        if ($this->uri->segment(2) == 'leads') {
                            echo "active";
                        }
                        ?>">
                            <a href="<?php echo base_url('project/leads/?id=' . $dp->id); ?>" class="nav-link">
                                <i class="icon-folder-alt"></i> Lead
                            </a>
                        </li>
                        <li class="nav-item <?php
                        if ($this->uri->segment(2) == 'channel') {
                            echo "active";
                        }
                        ?>">
                            <a href="<?php echo base_url('project/channel/?id=' . $dp->id); ?>" class="nav-link">
                                <i class="icon-folder-alt"></i> Channel
                            </a>
                        </li>
                        <li class="nav-item <?php
                        if ($this->uri->segment(2) == 'campaign') {
                            echo "active";
                        }
                        ?>">
                            <a href="<?php echo base_url('project/campaign/?id=' . $dp->id); ?>" class="nav-link">
                                <i class="icon-folder-alt"></i> Campaign
                            </a>
                        </li>
                        <?php
                        if ($this->MainModels->UserSession('role_id') == 2) {
                            ?>
                            <li class="nav-item <?php
                            if ($this->uri->segment(2) == 'setting') {
                                echo "active";
                            }
                            ?>">
                                <a href="<?php echo base_url('project/setting/?id=' . $dp->id); ?>" class="nav-link">
                                    <i class="icon-wrench"></i> Setting
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <?php
            }
        }
        ?>
        <?php if ($this->MainModels->UserSession('role_id') == 2 || $this->MainModels->UserSession('role_id') == 5) {
            ?>
            <li class="nav-item <?php
            if ($this->uri->segment(1) == 'add_project') {
                echo "active";
            }
            ?> ">
                <a href="<?php echo base_url('project/add_project'); ?>" class="nav-link ">
                    <i class="icon-plus"></i> Add New Project
                </a>
            </li>
        <?php }
        ?>


    </ul>
</li>