<?php
$session_dashboard = $this->session->userdata('dashboard');
?>
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
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label>
                                <span class="<?php echo $dcc['icon']; ?>"></span>
                                <a style="text-decoration:none;color: black;" href="<?php echo base_url('project/leads/?id=' . $session_dashboard['default_project_id'] . '&campaign_id=0&from=' . $session_dashboard['from'] . '&to=' . $session_dashboard['to'] . '&sales_team_id=&lead_category_id=' . $dcc['category_id'] . '&type_id=&status_id=&channel_id=&sales_officer_id=&search=1'); ?>">
                                    <?php echo " " . $dcc['category_name']; ?>
                                </a>   
                            </label>
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



<!--http://jala.ai/jala-staging/project/leads/?id=57&campaign_id=0&from=2019-03-06&to=2019-05-14&sales_team_id=&lead_category_id=&status_id=&channel_id=&sales_officer_id=&search=1-->