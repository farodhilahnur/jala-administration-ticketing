<div class="modal fade" id="add" tabindex="-1" role="add" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Form Channel</h4>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">
                    <form enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('project/add_channel'); ?>" role="form" method="post">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-9">
                                    <input type="text" name="channel_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Campaign</label>
                                <div class="col-md-9">
                                    <select name="campaign_id" id="single" class="form-control select2 select2-campaign">
                                        <option value="">--select campaign--</option>
                                        <?php
                                        foreach ($data_campaign as $dc) {
                                            ?>      
                                            <option value="<?php echo $dc->id; ?>"
                                                    >
                                                        <?php echo $dc->campaign_name; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Media</label>    
                                <div class="col-md-9">
                                    <select name="media_id" id="single" class="form-control select2 mediaSelect">
                                        <option value="">--select media--</option>
                                        <?php
                                        foreach ($data_media as $dm) {
                                            ?>      
                                            <option value="<?php echo $dm->id; ?>"
                                                    >
                                                        <?php echo $dm->media_name; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div style="display: block;" id="landingPageUrlField" class="form-group">
                                <label class="col-md-3 control-label">Landing Page Url</label>
                                <div class="col-md-9">
                                    <input id="landingPageUrlInput" type="text" name="channel_url" class="form-control" required>
                                    <i>include http:// or https://</i>
                                </div>
                            </div>
                            <div style="display: block ;" id="redirectPageUrlField" class="form-group">
                                <label class="col-md-3 control-label">Redirect Page Url</label>
                                <div class="col-md-9">
                                    <input id="redirectPageUrlInput" type="text" name="channel_redirect_url" class="form-control" required>
                                    <i>include http:// or https://</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Detail</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" cols="5" rows="3" name="channel_detail"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Participate Sales Team</label>
                                <div class="col-md-9">
                                    <select name="sales_team[]" id="multiple" class="form-control select2-multiple select2-multiple-st" multiple>
                                        <?php
                                        foreach ($data_sales_team as $value) {
                                            ?>      
                                            <option value="<?php echo $value->sales_team_id; ?>">
                                                <?php echo $value->sales_team_name; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Picture</label>
                                <div class="col-md-9">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"> Select image </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="channel_picture"> </span>
                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                        <div style="background-color: white ; " class="form-actions right">
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
