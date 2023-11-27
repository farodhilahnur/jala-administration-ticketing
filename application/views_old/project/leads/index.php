<?php
/* echo "<pre>";
  print_r($this->session->userdata());
  echo "</pre>"; */
$session = $this->session->userdata();
$session_search = $session['search'];

$data_filter = array(
    'session_search' => $session_search,
    'session' => $session,
);
?>
<div class="row">
    <div class="col-md-7">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <?php $this->load->view('project/filter', $data_filter); ?>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
    <div class="col-md-5">
        <!-- BEGIN SAMPLE FORM PORTLET-->    
        <div style="text-align: right;" class="portlet">
            <div class="portlet-body">
                <div class="btn-group">
                    <!--<button id="sample_editable_1_new" data-toggle="modal" href="#add" type="button" class="btn red btn-md"><i class="fa fa-plus"></i> Add</button>-->
                    <a href="<?php echo base_url('lead/excel/?id=' . $project_id . '&campaign_id=' . $campaign_id . '&channel_id=' . $channel_id . '&sales_team_id=' . $sales_team_id . '&sales_officer_id=' . $sales_officer_id . '&from=' . $project_date . '&to=' . $now); ?>" type="button" class="btn green btn-md"><i class="fa fa-file-excel-o"></i>Export</a>
                    <?php if ($this->MainModels->UserSession('role_id') == 2 || $this->MainModels->UserSession('role_id') == 5) {
                        ?>
                        <button onclick="location.href = '<?php echo base_url('project/import_excel/?id=' . $project_id); ?>'" type="button" class="btn blue btn-md"><i class="fa fa-upload"></i>Import</button>
                        <button onclick="location.href = '<?php echo base_url('project/import_excel_migrate/?id=' . $project_id); ?>'" type="button" class="btn blue btn-md"><i class="fa fa-upload"></i>Migrate</button>
                        <?php
                    }    
                    ?>

                </div>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>    
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
                    <a href="" class="collapse"> </a>
                    <a href="" class="fullscreen"> </a>
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
                        <?php $this->load->view('project/leads/chart_lead_category'); ?>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                        <?php $this->load->view('project/leads/chart_lead_channel'); ?>
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
<?php
$this->load->view('project/channel/form-add-channel');
$this->load->view('project/channel/form-edit-channel');
