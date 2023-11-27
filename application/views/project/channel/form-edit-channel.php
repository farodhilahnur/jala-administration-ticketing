<div class="modal fade" id="edit" tabindex="-1" role="add" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Form Channel</h4>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">
                    <form enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('project/edit_channel'); ?>" role="form" method="post">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-9">
                                    <input id="channelName" type="text" name="channel_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Landing Page Url</label>
                                <div class="col-md-6">
                                    <input id="landingPageUrl" type="text" name="channel_url" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <input id="uniqueCode" type="text" name="unique_code" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Redirect Page Url</label>
                                <div class="col-md-9">
                                    <input id="redirectUrl" type="text" name="channel_redirect_url" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Detail</label>
                                <div class="col-md-9">
                                    <textarea id="channelDetail" class="form-control" cols="5" rows="3" name="channel_detail"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Participate Team</label>
                                <div class="col-md-9">
                                    <select name="salesTeam[]" id="multiple" class="form-control select2-multiple select2-multiple-st participateSalesTeam" multiple>
                                        <?php
                                        foreach ($data_sales_team as $value) {
                                            ?>      
                                            <option id="<?php echo 'option-' . $value->sales_team_id; ?>" value="<?php echo $value->sales_team_id; ?>"
                                            <?php
//                                            if (in_array($value->sales_team_id, $list_sales_team)) {
//                                                echo "selected";
//                                            }
                                            ?>
                                                    >
                                                        <?php echo $value->sales_team_name; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                        <input type="hidden" name="media_id" id="mediaIdEdit" value="">
                        <input id="channelId" type="hidden" name="channel_id" value="">
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
