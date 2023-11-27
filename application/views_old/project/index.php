<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet light">
            <div class="portlet-body">
                <?php
                $data = array('data_project' => $data_project);
                $this->load->view('project/table-view', $data);
                ?>
            </div>
        </div>
    </div>
</div>
