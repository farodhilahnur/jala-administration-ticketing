<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-body form">
                <form action="" class="form-horizontal" role="form" method="post">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-2">Landing Page Url
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="" name="lp_url" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Redirect Url
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="" name="redirect_url" required/>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="step" value="<?php echo $step; ?>">
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button onclick="window.location.href='<?php echo base_url('project/form_add_channel/?id=' . $project_id . '&step=2'); ?>'"
                                        type="button" class="btn default">Back
                                </button>
                                <button type="submit" class="btn green">Next</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
