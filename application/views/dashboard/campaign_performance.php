<div style="min-height: 255px;" class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Campaign Performance</span>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
        </div>
    </div>   
    <div class="portlet-body">
        <?php
        if (!empty($data_chart_campaign)) {
            foreach ($data_chart_campaign as $dccg) {
                ?>
                <li style="border: 0px !important;" class="list-group-item">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <?php echo $dccg['campaign_name']; ?>
                            </div>
                            <div class="col-md-2"><span class="badge badge-success badge-roundless"><?php echo $dccg['total']; ?></span></div>
                            <div class="col-md-6">
                                <div style="margin-bottom:0px !important;" class="progress">
                                    <div class="progress-bar progress-bar-success" 
                                         role="progressbar" 
                                         aria-valuenow="<?php echo $dccg['percent']; ?>" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100" 
                                         style="width: <?php echo $dccg['percent'] . '%'; ?>"
                                         >
<!--                                        <span class=""><?php echo $dccg['total']; ?></span>-->
                                    </div>    
                                </div>
                            </div>
                            <div class="col-md-1"> <?php echo $dccg['percent']; ?>% </div>
                        </div>
                    </div>
                </li>
                <?php
            }
        }
        ?>
    </div>
</div>