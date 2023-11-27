<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Categories</span>
        </div>
    </div>   
    <div class="portlet-body">
        <?php
        if (!empty($data_chart_category)) {
            foreach ($data_chart_category as $dcc) {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label><span class="<?php echo $dcc['icon']; ?>"></span><?php echo " " . $dcc['category_name']; ?></label>
                        </div>
                        <div class="col-md-2"><span class="badge badge-default"><?php echo $dcc['total']; ?></span></div>
                        <div class="col-md-6">
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-<?php echo $dcc['color']; ?>"
                                     role="progressbar" aria-valuenow="<?php echo $dcc['total']; ?>"
                                     aria-valuemin="0"
                                     aria-valuemax="100"
                                     style="width: <?php echo $dcc['percent'] . '%' ?>;"
                                     >
        <!--                                <span class=""> <?php echo $dcc['percent'] . ' %'; ?> </span>    -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"> <?php echo $dcc['percent'] . '%'; ?> </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>