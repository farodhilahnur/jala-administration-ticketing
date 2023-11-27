<?php
$session_dashboard = $this->session->userdata('dashboard');
?>
<div style="min-height: 255px;" class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Offline vs Online Leads</span>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
        </div>
    </div>   

    <div class="portlet-body">
        <?php
        if (!empty($data_chart_lead_offline_online)) {
            ?>
            <li style="border: 0px !important;" class="list-group-item">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-1">
                            <a style="text-decoration:none;color: black;" href="<?php echo base_url('project/leads/?id=' . $session_dashboard['default_project_id'] . '&campaign_id=0&from=' . $session_dashboard['from'] . '&to=' . $session_dashboard['to'] . '&sales_team_id=&lead_category_id=&status_id=&type_id=3&channel_id=&sales_officer_id=&search=1'); ?>">
                                Offline
                            </a>
                        </div>
                        <div class="col-md-1"><span class="badge badge-success badge-roundless"><?php echo $data_chart_lead_offline_online[0]['total_offline']; ?></span></div>
                        <div class="col-md-9">
                            <div style="margin-bottom:0px !important;" class="progress">
                                <div class="progress-bar progress-bar-success" 
                                     role="progressbar" 
                                     aria-valuenow="<?php echo $data_chart_lead_offline_online[0]['percent_offline']; ?>" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100" 
                                     style="width: <?php echo $data_chart_lead_offline_online[0]['percent_offline'] . '%'; ?>"
                                     >
    <!--                                        <span class=""><?php echo $dccg['total']; ?></span>-->
                                </div>    
                            </div>
                        </div>
                        <div class="col-md-1"> <?php echo $data_chart_lead_offline_online[0]['percent_offline']; ?> % </div>
                    </div>
                </div>
            </li>
            <li style="border: 0px !important;" class="list-group-item">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-1">
                            <a style="text-decoration:none;color: black;" href="<?php echo base_url('project/leads/?id=' . $session_dashboard['default_project_id'] . '&campaign_id=0&from=' . $session_dashboard['from'] . '&to=' . $session_dashboard['to'] . '&sales_team_id=&lead_category_id=&status_id=&type_id=1&channel_id=&sales_officer_id=&search=1'); ?>">
                                Online
                            </a>
                        </div>
                        <div class="col-md-1"><span class="badge badge-success badge-roundless"><?php echo $data_chart_lead_offline_online[0]['total_online']; ?></span></div>
                        <div class="col-md-9">
                            <div style="margin-bottom:0px !important;" class="progress">
                                <div class="progress-bar progress-bar-success" 
                                     role="progressbar" 
                                     aria-valuenow="<?php echo $data_chart_lead_offline_online[0]['percent_online']; ?>" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100" 
                                     style="width: <?php echo $data_chart_lead_offline_online[0]['percent_online'] . '%'; ?>"
                                     >
    <!--                                        <span class=""><?php echo $dccg['total']; ?></span>-->
                                </div>    
                            </div>
                        </div>
                        <div class="col-md-1"> <?php echo $data_chart_lead_offline_online[0]['percent_online']; ?> % </div>
                    </div>
                </div>
            </li>
            <?php
        }
        ?>
    </div>
</div>