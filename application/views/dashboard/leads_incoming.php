<?php
$session_dashboard = $this->session->userdata('dashboard');
?>
<!-- BEGIN Portlet PORTLET-->
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Total Incoming Leads</span>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
            <a href="" class="fullscreen"> </a>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="btn-toolbar margin-bottom-10">
                    <div class="btn-group btn-group-sm btn-group-solid">
                        <button id="btnDay" type="button" value="DAY" class="btn btn-sm btn-time btn-danger active">Day</button>
                        <button id="btnMonth" type="button" value="MONTH" class="btn btn-sm btn-time btn-danger">Month</button>
                        <button id="btnYear" type="button" value="YEAR" class="btn btn-sm btn-time btn-danger">Year</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <div id="chartLeadTotals" style="height:425px;"></div>
    </div>
</div>
<!-- END Portlet PORTLET-->