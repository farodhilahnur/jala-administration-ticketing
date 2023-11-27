<div class="row">
    <div class="col-md-10">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <?php //$this->load->view('project/filter', $data_filter); ?>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
    <div class="col-md-2">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div style="text-align: right;" class="portlet">
            <div class="portlet-body">
                <div class="btn-group">
                    <button id="sample_editable_1_new" data-toggle="modal" href="#add" type="button" class="btn red btn-md"><i class="fa fa-plus"></i> Add</button>
                    <button type="button" class="btn green btn-md"><i class="fa fa-file-excel-o"></i>Export</button>
                </div>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>    
</div>
<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase"> Media List </span>
                </div>
            </div>
            <div class="portlet-body">
                <?php
                $data = array('data_media' => $data_media);
                $this->load->view('media/table-view', $data);
                ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('media/form-add-media', $data);
$this->load->view('media/form-edit-media', $data);
