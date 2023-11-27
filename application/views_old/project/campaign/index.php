<?php
/* echo "<pre>";
  print_r($this->session->userdata());
  echo "</pre>"; */
$session = $this->session->userdata();
if ($this->session->userdata('search') !== NULL) {
    $session_search = $session['search'];
} else {
    $session_search = array();
}

$data_filter = array(
    'session_search' => $session_search,
    'session' => $session
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
                    <?php if ($this->MainModels->UserSession('role_id') == 2 ||$this->MainModels->UserSession('role_id') == 5) {
                        ?>
                        <button id="sample_editable_1_new" data-toggle="modal" href="#add" type="button" class="btn red btn-md"><i class="fa fa-plus"></i> Add</button>
                    <?php }
                    ?>

<!--                    <button type="button" class="btn green btn-md"><i class="fa fa-file-excel-o"></i>Export</button>-->
                </div>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>    
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
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
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <?php $this->load->view('project/campaign/total_campaign'); ?>
                    </div>
                    <div class="col-md-9 col-lg-9 col-xs-12 col-sm-6">
                        <?php $this->load->view('project/campaign/chart_campaign'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject bold uppercase"> Campaign List </span>
                </div>
                <ul class="nav nav-tabs">
                    <li>
                        <a href="#portlet_tab2" data-toggle="tab"><i class="fa fa-list"></i></a>
                    </li>
                    <li class="active">
                        <a href="#portlet_tab1" data-toggle="tab"><i class="fa fa-clone"></i></a>
                    </li>
                </ul>
            </div>
            <div class="portlet-body">
                <?php $data = array('data_campaign' => $data_campaign); ?>
                <div class="tab-content">
                    <div class="tab-pane active" id="portlet_tab1">
                        <?php
                        $this->load->view('project/campaign/table-view', $data);
                        ?>
                    </div>
                    <div class="tab-pane" id="portlet_tab2">
                        <?php
                        $this->load->view('project/campaign/grid-view', $data);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$data = array('project_id', $project_id);
$this->load->view('project/campaign/form-add-campaign', $data);
$this->load->view('project/campaign/form-edit-campaign', $data);
