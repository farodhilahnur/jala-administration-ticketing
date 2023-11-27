<?php
$session = $this->session->userdata();
$session_search = $session['search'];
$session_filter = $session['filter'];

$data_filter = array(
    'session_search' => $session_search,
    'session' => $session,
);
?>
<div class="row">
    <!-- <div class="col-md-12"> -->
    <!-- BEGIN SAMPLE FORM PORTLET-->
    <?php //$this->load->view('project/filter', $data_filter); ?>
    <!-- END SAMPLE FORM PORTLET-->
    <!-- </div> -->
</div>
<div class="row">
    <div class="col-md-12">    
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-graph font-grey-gallery"></i>
                    <span class="caption-subject bold font-grey-gallery uppercase"> Summary </span>
                </div>
                <div class="tools">
                    <div class="btn-group">
<!--                        <a href="--><?php
//                        echo base_url('lead/excel/?id=' . $project_id . ''
//                                . '&campaign_id=' . $session_filter['campaign_id'] . ''
//                                . '&channel_id=' . $session_search['channel_id'] . ''
//                                . '&sales_team_id=' . $session_search['sales_team_id'] . ''
//                                . '&sales_officer_id=' . $session_search['sales_officer_id'] . ''
//                                . '&from=' . $session_filter['from'] . ''
//                                . '&to=' . $session_filter['to'] . ''
//                                . '&lead_category_id=' . $session_search['lead_category_id'] . ''
//                                . '&status_id=' . $session_search['status_id']);
//                        ?><!--" -->
<!--                           type="button" -->
<!--                           class="btn green btn-md"><i class="fa fa-file-excel-o"></i>Export-->
<!--                        </a>-->
<!--                        <a href="<?php echo base_url('lead/excel/?id=' . $project_id); ?>" 
                          type="button" 
                          class="btn green btn-md">
                           <i class="fa fa-file-excel-o"></i>Export
                       </a>-->
                        <?php if ($this->MainModels->UserSession('role_id') == 2 || $this->MainModels->UserSession('role_id') == 5) {
                            ?>
                            <button onclick="location.href = '<?php echo base_url('project_new/import_excel/?id=' . $project_id); ?>'" type="button" class="btn blue btn-md"><i class="fa fa-upload"></i>Import</button>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </div>         
            <div class="portlet-body">    
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <?php $this->load->view('project/leads/lead_total'); ?>    
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                        <?php $this->load->view('project/leads/lead_filter'); ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <?php $this->load->view('project/leads/chart_lead_category_new'); ?>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                        <?php $this->load->view('project/leads/chart_lead_channel_new'); ?>
                    </div>
                    <!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="font-red-sunglo"></i>
                                    <span class="caption-subject font-red-sunglo bold uppercase">Product</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div id="chart_7" class="chart" style="height: 300px;"> </div>
                            </div>
                        </div>         
                    </div>-->

                </div>
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet light">
            <div class="portlet-body">
                <?php
                $data = array('data_lead' => $data_lead);
                $this->load->view('project/leads/table-view', $data);
                ?>
            </div>
        </div>
    </div>
</div>
