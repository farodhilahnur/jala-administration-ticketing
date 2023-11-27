<!-- BEGIN Portlet PORTLET-->
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Team Performance</span>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
            <a href="#portlet-config" data-toggle="modal" class="config"> </a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="tabbable-custom ">
            <ul class="nav nav-tabs ">
                <li class="active">
                    <a href="#tab_5_1" data-toggle="tab"> Top Sales Officer </a>
                </li>
                <?php
                if ($this->MainModels->UserSession('role_id') != 3) {
                    ?>
                    <li>
                        <a href="#tab_5_2" data-toggle="tab"> Top Sales Team </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <div class="tab-content">
                <?php $this->load->view('dashboard/top_sales_officer'); ?>
                <?php $this->load->view('dashboard/top_sales_team'); ?>
            </div>
        </div>
    </div>
</div>
<!-- END Portlet PORTLET-->