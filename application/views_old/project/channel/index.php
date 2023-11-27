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
                    <?php if ($this->MainModels->UserSession('role_id') == 2 || $this->MainModels->UserSession('role_id') == 5) {
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
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="dashboard-stat2 bordered">
                            <div class="display">
                                <div class="number">
                                    <h3 class="font-red-haze">
                                        <span data-counter="counterup" data-value="<?php echo count($data_channel); ?>"><?php echo count($data_channel); ?></span>
                                        <small class="font-red-haze"><?php echo $this->MainModels->getCaption(count($data_channel), 'Channel'); ?></small>
                                    </h3>
                                    <small>TOTAL </small>
                                </div>
                                <div class="icon">
                                    <!--<i class="icon-pie-chart"></i>-->
                                </div>
                            </div>
                            <div class="progress-info">   
                                <div class="status">
                                    <div class="status-title"> 
                                        <?php
                                        $date = explode(' to ', $session['filter']['date_range']);
                                        $new_project_date = date("M d, Y", strtotime($date[0]));
                                        $new_now_date = date("M d, Y", strtotime($date[1]));
                                        echo $new_project_date . ' - ' . $new_now_date;
                                        ?> 
                                    </div>
                                </div>      
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="font-red-sunglo"></i>
                                    <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $this->MainModels->getCaption(count($data_chart_channel), 'Channel'); ?></span>
                                </div>
                            </div>   
                            <div class="portlet-body">
                                <?php
                                if (!empty($data_chart_channel)) {
                                    foreach ($data_chart_channel as $key => $dcch) {
                                        ?>
                                        <div class="panel-group accordion" id="accordion-<?php echo $key; ?>">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion<?php echo $key; ?>" href="#collapse_<?php echo $key; ?>" aria-expanded="false"> 
                                                            <div class="row">
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
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_<?php echo $key; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                    <div class="panel-body">
                                                        <?php
                                                        $channel_id = $dcch['channel_id'];
                                                        $data_chart_channel_category = $this->LeadModels->getDataLeadByChannelIdCategory($channel_id);
                                                        foreach ($data_chart_channel_category as $dccc) {
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
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
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
                    <span class="caption-subject bold uppercase"> Channel List </span>
                </div>
                <ul class="nav nav-tabs">
                    <li>
                        <a href="#portlet_tab2" data-toggle="tab"><i class="fa fa-clone"></i></a>
                    </li>
                    <li class="active">
                        <a href="#portlet_tab1" data-toggle="tab"><i class="fa fa-list"></i></a>
                    </li>
                </ul>
            </div>
            <div class="portlet-body">
                <?php $data = array('data_channel' => $data_channel); ?>
                <div class="tab-content">
                    <div class="tab-pane active" id="portlet_tab1">
                        <?php
                        $this->load->view('project/channel/table-view', $data);
                        ?>
                    </div>
                    <div class="tab-pane" id="portlet_tab2">
                        <?php
                        $this->load->view('project/channel/grid-view', $data);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('project/channel/form-add-channel');
$this->load->view('project/channel/form-edit-channel');
