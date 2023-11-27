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
