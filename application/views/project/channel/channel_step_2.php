<?php
$session_step_1 = $this->session->userdata('step_1');
$category = $session_step_1['category'];
$session_step_2 = $this->session->userdata('step_2');
$channel_name = $session_step_2['channel_name'];
$campaign_channel = $session_step_2['campaign_channel'];
$channel_detail = $session_step_2['channel_detail'];
$lp_url = $session_step_2['lp_url'];
$redirect_url = $session_step_2['redirect_url'];
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-body form">
                <form action="" class="form-horizontal" role="form" method="post">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Channel Name
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" value="<?php echo $channel_name; ?>" class="form-control"
                                       id="channel_name" name="channel_name" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Select Campaign
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <div class="radio-list">
                                    <?php
                                    if (!empty($campaign)) {
                                    }
                                    foreach ($campaign as $key => $c) {
                                        ?>
                                        <label>
                                            <input type="radio" name="campaign_channel" id="optionsRadios22"
                                                   value="<?php echo $c->id; ?>"
                                                <?php if ($c->id == $campaign_channel) {
                                                    echo 'checked';
                                                } ?> required
                                            >
                                            <?php echo $c->campaign_name; ?>
                                        </label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($category == 'Online') {
                            ?>
                            <div class="form-group">
                                <label class="control-label col-md-3">Landing Page Url
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" value="<?php echo $lp_url ; ?>" class="form-control" id="" name="lp_url" required/>
                                    <i style="font-size: 11px;">include http:// or https://</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Redirect Page Url
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" value="<?php echo $redirect_url ; ?>" class="form-control" id="" name="redirect_url" required/>
                                    <i style="font-size: 11px;">include http:// or https://</i>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="form-group">
                            <label class="control-label col-md-3">Description
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                            <textarea class="form-control" cols="5" rows="3" name="channel_detail" id="channel_detail"
                                      required><?php echo $channel_detail; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="step" value="<?php echo $step; ?>">
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button onclick="window.location.href='<?php echo base_url('project/form_add_channel/?id=' . $project_id . '&step=1'); ?>'"
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
