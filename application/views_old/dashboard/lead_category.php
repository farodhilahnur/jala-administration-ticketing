<div style="min-height: 255px;" class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Lead Categories</span>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
            <a href="#portlet-config" data-toggle="modal" class="config"> </a>
        </div>
    </div>   
    <div class="portlet-body">
        <?php
        if (!empty($data_chart_category[0])) {
            foreach ($data_chart_category as $dcc) {
                ?>
                <div class="row">
                    <div class="col-md-3">
                        <label><span class="<?php echo $dcc['icon']; ?>"></span><?php echo " " . $dcc['category_name']; ?></label>
                    </div>
                    <div class="col-md-8">
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-<?php echo $dcc['color']; ?>" 
                                 role="progressbar" aria-valuenow="<?php echo $dcc['total']; ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100" 
                                 style="width: <?php echo $dcc['percent'] . '%' ?>;"
                                 >
                                <span class=""> <?php echo $dcc['percent'] . ' %'; ?> </span>    
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"> <?php echo $dcc['total']; ?> </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>