<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Campaign</span>
            </div>
    </div>
    <div class="portlet-body">
        <?php
        if (!empty($data_chart_campaign)) {
            foreach ($data_chart_campaign as $dcc) {
                ?>
                <li style="border: 0px !important;" class="list-group-item">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row"></div>
                            <div class="col-md-4">
                                <?php echo $dcc['campaign_name']; ?>
                            </div>
                            <div class="col-md-6">
                                <div style="margin-bottom:0px !important;" class="progress">
                                    <div class="progress-bar progress-bar-success" 
                                         role="progressbar" 
                                         aria-valuenow="<?php echo $dcc['percent']; ?>" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100" 
                                         style="width: <?php echo $dcc['percent'] . '%'; ?>"
                                         >
                                        <span class=""><?php echo $dcc['total']; ?></span>
                                    </div>    
                                </div>
                            </div>
                            <div class="col-md-1"> <?php echo $dcc['percent']; ?>% </div>
                        </div>
                    </div>
                </li>
                <?php
            }
        }
        ?>
    </div>
</div>