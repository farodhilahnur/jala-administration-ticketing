<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-wrench"></i>
                    <span class="caption-subject bold uppercase">Project Setting</span>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="<?php echo base_url('project/edit_project/?id=' . $data_project->id); ?>" class="form-horizontal" method="post">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Name</label>
                            <div class="col-md-6">
                                <input name="project_name" type="text" class="form-control" value="<?php echo $data_project->project_name; ?>">
                            </div>
                        </div>    
                        <div class="form-group">
                            <label class="col-md-2 control-label">Detail</label>    
                            <div class="col-md-6">
                                <textarea name="project_detail" class="form-control" name="project_detail" ><?php echo $data_project->project_detail; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Status</label>
                            <div class="col-md-6">
                                <div class="radio-list">
                                    <label>
                                        <div class="radio" id="uniform-optionsRadios22">
                                            <span class="">
                                                <input type="radio" name="status" id="optionsRadios22" value="1" <?php
                                                if ($data_project->status == 1) {
                                                    echo "checked";
                                                }
                                                ?>>
                                            </span>   
                                        </div> Active 
                                    </label>
                                    <label>
                                        <div class="radio" id="uniform-optionsRadios23">
                                            <span class="">
                                                <input type="radio" name="status" id="optionsRadios23" value="2" <?php
                                                if ($data_project->status == 2) {
                                                    echo "0";
                                                }
                                                ?>>
                                            </span>
                                        </div> Inactive 
                                    </label>
                                </div>
            <!--<input type="checkbox" class="make-switch" data-on-text="&nbsp;Active&nbsp;" data-off-text="&nbsp;Inactive&nbsp;"> -->
                            </div>    
                        </div>
                    </div>
                    <input type="hidden" name="project_id" value="<?php echo $data_project->id; ?>">
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-4">
                                <button type="submit" class="btn green">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 ">
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
    <div class="col-md-6 ">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption col-md-6">
                    <span class="caption-subject bold uppercase">Status</span>
                </div>
            </div>
            <div class="portlet-body">
                <?php
                $data = array('data_status' => $data_status);
                $this->load->view('project/setting/table-view-status', $data);
                ?>
            </div>
        </div>
    </div>
</div>
