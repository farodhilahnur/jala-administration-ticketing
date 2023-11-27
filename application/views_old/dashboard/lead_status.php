<div style="min-height: 255px;" class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Lead Status</span>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
            <a href="#portlet-config" data-toggle="modal" class="config"> </a>
        </div>
    </div>   
    <div class="portlet-body">
        <?php
        if (!empty($data_chart_status)) {
            foreach ($data_chart_status as $dcs) {
                $color = $this->db->get_where('tbl_master_status', array('status_name' => $dcs['status_name']))->row('color');
                ?>
                <li style="border: 0px !important;" class="list-group-item">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row"></div>
                            <div class="col-md-4">
                                <?php echo $dcs['status_name']; ?>
                            </div>
                            <div class="col-md-6">
                                <div style="margin-bottom:0px !important;" class="progress">
                                    <div class="progress-bar progress-bar-success" 
                                         role="progressbar" 
                                         aria-valuenow="<?php echo $dcs['percent']; ?>" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100" 
                                         style="width: <?php
                                         echo $dcs['percent'] . '% ;';
                                         echo "background-color:" . $color;
                                         ?>"
                                         >
                                        <span class=""><?php echo $dcs['total']; ?></span>
                                    </div>    
                                </div>
                            </div>
                            <div class="col-md-1"> <?php echo $dcs['percent']; ?>% </div>
                        </div>
                    </div>
                </li>
                <?php
            }
        }
        ?>
    </div>
</div>