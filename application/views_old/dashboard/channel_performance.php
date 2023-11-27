<div style="min-height: 255px;" class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Channel Performance</span>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
            <a href="#portlet-config" data-toggle="modal" class="config"> </a>
        </div>
    </div>   
    <div class="portlet-body">
        <?php
        if (!empty($data_chart_channel)) {
            foreach ($data_chart_channel as $dcch) {
                ?>
                <li style="border: 0px !important;" class="list-group-item">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row"></div>
                            <div class="col-md-4">
                                <?php echo $dcch['channel_name']; ?>
                            </div>
                            <div class="col-md-6">
                                <div style="margin-bottom:0px !important;" class="progress">
                                    <div class="progress-bar progress-bar-success" 
                                         role="progressbar" 
                                         aria-valuenow="<?php echo $dcch['percent']; ?>" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100" 
                                         style="width: <?php echo $dcch['percent'] . '%'; ?>"
                                         >
                                        <span class=""><?php echo $dcch['total']; ?></span>
                                    </div>    
                                </div>
                            </div>
                            <div class="col-md-1"> <?php echo $dcch['percent']; ?>% </div>
                        </div>
                    </div>
                </li>
                <?php
            }
        }
        ?>
    </div>
</div>