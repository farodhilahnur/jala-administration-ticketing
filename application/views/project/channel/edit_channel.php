<?php
    if ($data_channel->channel_url != NULL){
    ?>
    <style>.select2-search__field{ width: 100% !important }</style>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-user-plus"></i> Channel Form </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('project_new/edit_channel'); ?>" role="form" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Name</label>
                        <div class="col-md-9">
                            <input id="channelName" type="text" name="channel_name" class="form-control" value="<?php echo $data_channel->channel_name; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Landing Page Url</label>
                        <div class="col-md-6">
                            <input id="landingPageUrl" type="text" name="channel_url" class="form-control" value="<?php echo $data_channel->channel_url; ?>">
                        </div>
                        <div class="col-md-2">
                            <input id="uniqueCode" type="text" name="unique_code" class="form-control" value="<?php echo $data_channel->unique_code; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Redirect Page Url</label>
                        <div class="col-md-9">
                            <input id="redirectUrl" type="text" name="channel_redirect_url" class="form-control" value="<?php echo $data_channel->channel_redirect_url; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Description</label>
                        <div class="col-md-9">
                            <textarea id="channelDetail" class="form-control" cols="5" rows="3" name="channel_detail"><?php echo $data_channel->channel_detail; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Participate Team</label>
                        <div class="col-md-9">
                            <ul class="list-group">
                            
                            <?php
                            foreach ($data_sales_team as $value) {
                                ?>
                                <li class="list-group-item">
                                    <label>
                                        <input id="<?php echo $value->sales_team_id; ?>"
                                                type="checkbox"
                                                name="salesTeam[]"
                                                value="<?php echo $value->sales_team_id; ?>"
                                            <?php
                                            if (in_array($value->sales_team_id, $list_sales_team)) {
                                                echo "checked";
                                            }
                                            ?>
                                        />
                                        <?php echo $value->sales_team_name; ?>
                                    </label>
                                </li>
                                <?php
                            }
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                <input type="hidden" name="media_id" id="mediaIdEdit" value="<?php echo $data_channel->channel_media; ?>">
                <input id="channelId" type="hidden" name="channel_id" value="<?php echo $data_channel->id; ?>">
                <div style="background-color: white ; " class="form-actions right">
                    <button type="submit" class="btn green">Submit</button>
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
    <?php
    }
?>
<?php
    if ($data_channel->channel_url == NULL){
    ?>
    <style>.select2-search__field{ width: 100% !important }</style>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-user-plus"></i> Sales Officer Form </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('project_new/edit_channel'); ?>" role="form" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Name</label>
                        <div class="col-md-9">
                            <input id="channelName" type="text" name="channel_name" class="form-control" value="<?php echo $data_channel->channel_name; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Description</label>
                        <div class="col-md-9">
                            <textarea id="channelDetail" class="form-control" cols="5" rows="3" name="channel_detail"><?php echo $data_channel->channel_detail; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Participate Team</label>
                        <div class="col-md-9">
                            <ul class="list-group">
                            <select name="salesTeam[]" id="multiple" class="form-control select2-multiple select2-multiple-st participateSalesTeam" multiple>
                                <?php
                                foreach ($data_sales_team as $value) {
                                    ?>      
                                    <option id="<?php echo 'option-' . $value->sales_team_id; ?>" value="<?php echo $value->sales_team_id; ?>"
                                    <?php
                                    if (in_array($value->sales_team_id, $list_sales_team)) {
                                        echo "selected";
                                    }
                                    ?>
                                            >
                                                <?php echo $value->sales_team_name; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                            </ul>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                <input type="hidden" name="media_id" id="mediaIdEdit" value="<?php echo $data_channel->channel_media; ?>">
                <input id="channelId" type="hidden" name="channel_id" value="<?php echo $data_channel->id; ?>">
                <div style="background-color: white ; " class="form-actions right">
                    <button type="submit" class="btn green">Submit</button>
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
    <?php
    }
?>