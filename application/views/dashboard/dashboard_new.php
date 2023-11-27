<?php $role_id = $this->MainModels->UserSession('role_id'); ?>
<!-- BEGIN Portlet PORTLET-->

<?php $this->load->view('component/dashboard/filter'); ?>

<?php $this->load->view('component/dashboard/statistics'); ?>

<?php $this->load->view('component/dashboard/top_category'); ?>

<?php $this->load->view('component/dashboard/lead_total'); ?>

<?php $this->load->view('component/dashboard/lead_online_offline'); ?>

<?php $this->load->view('component/dashboard/performance_chart'); ?>
<!-- END Portlet PORTLET-->


<!--<canvas id="performancesSalesTeam"></canvas>-->
<!--<canvas id="performancesSalesOfficer"></canvas>-->