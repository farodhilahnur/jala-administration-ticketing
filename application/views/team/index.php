<div class="portlet light ">
    <div class="portlet-body">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_1_1" data-toggle="tab" aria-expanded="true"> Sales Team </a>
            </li>
            <li class="">
                <a href="#tab_1_2" data-toggle="tab" aria-expanded="false"> Sales Officer </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="tab_1_1">
                <?php $this->load->view('team/sales_team'); ?>
            </div>
            <div class="tab-pane fade" id="tab_1_2">
                <?php $this->load->view('team/sales_officer'); ?>
            </div>
        </div>
    </div>
</div>