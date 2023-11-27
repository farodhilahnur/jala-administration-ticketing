<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $this->MainModels->getCaption(count($data_chart_campaign), 'Campaign'); ?></span>
        </div>
    </div>   
    <div class="portlet-body">
        <?php
        if (!empty($data_chart_campaign)) {
            foreach ($data_chart_campaign as $key => $dcc) {
                ?>
                <div class="panel-group accordion" id="accordion-<?php echo $key; ?>">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion<?php echo $key; ?>" href="#collapse_<?php echo $key; ?>" aria-expanded="false"> 
                                    <div class="row">
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
                                </a>
                            </h4>
                        </div>
                        <div id="collapse_<?php echo $key; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">

                                <?php
                                $campaign_id = $dcc['campaign_id'];
                                $data_chart_campaign_category = $this->LeadModels->getDataLeadByCampaignIdCategory($campaign_id);

                                foreach ($data_chart_campaign_category as $dccc) {
                                    ?>
                                    <li style="border: 0px !important;" class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row"></div>
                                                <div class="col-md-4">
                                                    <?php echo $dccc['category_name']; ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <div style="margin-bottom:0px !important;" class="progress">
                                                        <div class="progress-bar progress-bar-success" 
                                                             role="progressbar" 
                                                             aria-valuenow="<?php echo $dccc['percent']; ?>" 
                                                             aria-valuemin="0" 
                                                             aria-valuemax="100" 
                                                             style="width: <?php echo $dccc['percent'] . '%'; ?>"
                                                             >
                                                            <span class=""><?php echo $dccc['total']; ?></span>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="col-md-1"> <?php echo $dccc['percent']; ?>% </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--                <li style="border: 0px !important;" class="list-group-item">
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
                                </li>-->
                <?php
            }
        }
        ?>
    </div>
</div>