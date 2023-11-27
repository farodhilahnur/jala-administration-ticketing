<div class="row">
    <div class="col-md-8">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-graph font-grey-gallery"></i>
                    <span class="caption-subject bold font-grey-gallery uppercase"> Upload Form </span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"> </a>
                    <a href="" class="fullscreen"> </a>
                </div>
            </div>         
            <div class="portlet-body form">
                <!-- BEGIN FORM-->

                <button onclick="location.href = '<?php echo base_url('assets/excel/template-upload-lead.xlsx'); ?>'" class="btn btn-md btn-info"><span class="fa fa-download"></span> Template</button>
                <form method="post" action="<?php echo base_url('project/import_action_migrate'); ?>" enctype="multipart/form-data" role="form" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Channel</label>
                            <div class="col-md-4">
                                <select name="channel_id" class="form-control">   
                                    <option> -- Select Channel -- </option>
                                    <?php
                                    if ($data_channel) {
                                        foreach ($data_channel as $dch) {
                                            ?>
                                            <option value="<?php echo $dch->channel_id; ?>"><?php echo $dch->channel_name; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <span class="help-block"> only channel upload lead. </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">File</label>
                            <div class="col-md-4">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="input-group input-large">
                                        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                            <span class="fileinput-filename"> </span>
                                        </div>
                                        <span class="input-group-addon btn default btn-file">
                                            <span class="fileinput-new"> Select file </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="file"> </span>
                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                                <span class="help-block"> xls or xlsx file format only. </span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-4">
                                <button type="submit" class="btn green">Submit</button>
                                <button type="button" class="btn default">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>

    </div>
</div>