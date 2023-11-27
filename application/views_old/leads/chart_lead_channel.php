<div style="min-height: 255px;" class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Channel</span>
        </div>
        <!--<div class="tools">
            <form class="form-inline" role="form">
                <div class="form-group">
                    <select name="campaign_id" id="single" class="form-control">
                        <option value="">--select status--</option>
        <?php
        foreach ($data_campaign as $dc) {
            ?>      
                                                <option value="<?php echo $dc->id; ?>"
                                                        >
            <?php echo $dc->campaign_name; ?>
                                                </option>
            <?php
        }
        ?>
                    </select>    
                </div>
                <button class="btn btn-md btn-default"><i class="fa fa-search"></i></button>
            </form>
        </div>-->
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
