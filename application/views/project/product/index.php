<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption col-md-6">
                    <span class="caption-subject bold uppercase">Product</span>
                </div>
                <div style="text-align: right;" class="col-md-6">
                    <div class="btn-group">
                        <button id="sample_editable_1_new" data-toggle="modal" href="#add-product" type="button" class="btn red btn-md"><i class="fa fa-plus"></i> Add</button>
                        <!--<button type="button" class="btn green btn-md"><i class="fa fa-file-excel-o"></i>Export</button>-->
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <?php
                $data = array('data_product' => $data_product, 'project_id' => $data_project->id);
                $this->load->view('project/setting/table-view-product', $data);
                ?>
            </div>
        </div>
    </div>
</div>
