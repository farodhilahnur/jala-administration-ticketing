<?php
/* echo "<pre>";
  $session_dashboard = $this->session->userdata('dashboard');

  print_r($session_dashboard);

  echo "</pre>"; */
$role = $this->MainModels->UserSession('role_id');
//echo $role ;
?>
<div class="row">
    <div class="col-md-7">
        <?php $this->load->view('dashboard/dashboard_filter'); ?>
    </div>    
</div>
<div class="row">
    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 ">     
        <?php $this->load->view('dashboard/dashboard_stats'); ?>
    </div>
</div>
<!-- BEGIN : HIGHCHARTS -->
<div class="row">
    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 ">
        <?php $this->load->view('dashboard/leads_total'); ?>
    </div>
</div>
<?php
if ($role != 3) {
    ?>
    <div class="row">
        <div class="col-md-6 col-xs-12 col-lg-6 col-sm-12">
            <?php $this->load->view('dashboard/campaign_performance'); ?>    
        </div>
        <div class="col-md-6 col-xs-12 col-lg-6 col-sm-12">
            <?php $this->load->view('dashboard/channel_performance'); ?>    
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12 col-lg-6 col-sm-12">
            <?php $this->load->view('dashboard/lead_category'); ?>    
        </div>
        <div class="col-md-6 col-xs-12 col-lg-6 col-sm-12">
            <?php $this->load->view('dashboard/lead_status'); ?>    
        </div>
    </div>
    <?php
}
?>

<div class="row">
    <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
        <?php $this->load->view('dashboard/team_performance'); ?>    
    </div>
</div>
