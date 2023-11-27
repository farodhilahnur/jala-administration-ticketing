<?php
$session_dashboard = $this->session->userdata('dashboard');


//print_r($session_dashboard);

$from = $session_dashboard['from'];
$to = $session_dashboard['to'];

?>


<div class="row">
    <div class="col-md-12">
        <?php $this->load->view('leads/lead_filter'); ?>
    </div>
</div>
<!--<div class="row">-->
<!--    <div class="col-md-12">-->
<!--        <div class="portlet light">-->
<!--            <div class="portlet-title">-->
<!--                <div class="caption">-->
<!--                    <i class="font-red-sunglo"></i>-->
<!--                    <span class="caption-subject font-red-sunglo bold uppercase">Summary</span>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="portlet-body">-->
<!--                <div class="row">-->
<!--                    <div class="col-md-6 col-xs-12 col-sm-12">-->
<!---->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
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
