<?php $role_id = $this->MainModels->UserSession('role_id'); ?>
<!-- BEGIN Portlet PORTLET-->
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Statistics</span>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
            <a href="" class="fullscreen"> </a>
        </div>
    </div>
    <div class="portlet-body">
        <!-- BEGIN DASHBOARD STATS 1-->
        <div class="row">
            <div class="col-md-12">
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <div class="dashboard-stat blue">
                        <div class="visual">
                            <i class="fa fa-book"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="<?php echo count($data_project); ?>"><?php echo count($data_project); ?></span>
                            </div>
                            <div class="desc"> Total <?php echo $this->MainModels->getCaption(count($data_project), 'Project'); ?> </div>
                        </div>
                        <a class="more" href="<?php echo base_url('project'); ?>"> View more 
                            <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <div class="dashboard-stat red">
                        <div class="visual">
                            <i class="fa fa-bullhorn"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="<?php echo count($data_campaign); ?>"><?php echo count($data_campaign); ?></span></div>
                            <div class="desc"> Total <?php echo $this->MainModels->getCaption(count($data_campaign), 'Campaign'); ?> </div>
                        </div>
                        <a class="more" href="<?php echo base_url('campaign'); ?>"> View more 
                            <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <div class="dashboard-stat grey-mint">
                        <div class="visual">
                            <i class="fa fa-bullseye"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="<?php echo count($data_channel); ?>"><?php echo count($data_channel); ?></span>
                            </div>
                            <div class="desc"> Total <?php echo $this->MainModels->getCaption(count($data_channel), 'Channel'); ?> </div>
                        </div>
                        <a class="more" href="<?php echo base_url('channel'); ?>"> View more 
                            <i class="m-icon-swapright m-icon-white"></i>
                        </a>  
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <div class="dashboard-stat yellow">
                        <div class="visual">
                            <i class="fa fa-newspaper-o"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="<?php echo count($data_lead); ?>"></span></div>

                            <div class="desc"> Total <?php echo $this->MainModels->getCaption(count($data_lead), 'Lead'); ?> </div>
                        </div>
                        <a class="more" href="<?php echo base_url('lead'); ?>"> View more 
                            <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>    
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <div class="dashboard-stat green">
                        <div class="visual">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="<?php echo count($data_sales_officer); ?>"></span></div>
                            <div class="desc"> Total <?php echo $this->MainModels->getCaption(count($data_sales_officer), 'Sales Officer'); ?> </div>
                        </div>
                        <a class="more" href="<?php echo base_url('team/sales_officer'); ?>"> View more 
                            <i class="m-icon-swapright m-icon-white"></i>
                        </a>   
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                    <div class="dashboard-stat purple">
                        <div class="visual">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <?php
                                if ($role_id != 3) {
                                    ?>
                                    <span data-counter="counterup" data-value="<?php echo count($data_sales_team); ?>"></span></div>
                                <?php
                            } else {
                                ?>
                                <span data-counter="counterup" data-value="<?php echo 1; ?>"></span></div>
                            <?php
                        }
                        ?>

                        <div class="desc"> Total <?php echo $this->MainModels->getCaption(count($data_sales_team), 'Sales Team'); ?> </div>
                    </div>
                    <a class="more" href="<?php echo base_url('team/sales_team'); ?>"> View more 
                        <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- END Portlet PORTLET-->
