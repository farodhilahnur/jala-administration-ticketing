<?php
$session = $this->session->userdata();
$step_1 = $session['step_1'];
$step_2 = $session['step_2'];
$step_3 = $session['step_3'];
$step_4 = $session['step_4'];

//get data for media name and category
$category = $step_1['category'];
$media_id = $step_1['media_id'];
$media_name = $this->db->get_where('tbl_media', array('id' => $media_id))->row('media_name');

//get data for information
$channel_name = $step_2['channel_name'];
$campaign_id = $step_2['campaign_channel'];
$campaign_name = $this->db->get_where('tbl_campaign', array('id' => $campaign_id))->row('campaign_name');

if ($category == 'Online'){
    $lp_url = $step_2['lp_url'];
    $r_url = $step_2['redirect_url'];
}

$detail = $step_2['channel_detail'];

//get data for field
$field = $step_3['field'];

//get data sales team
$sales_team = $step_4['sales_team'];

?>
<?php
    if ($category == 'Online') {
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-body form">
                        <form action="" class="form-horizontal" role="form" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Media
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" value="<?php echo $media_name; ?>" class="form-control"
                                                    name="media_name" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Category
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" value="<?php echo $category; ?>" class="form-control"
                                                    name="category" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Channel Name
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" value="<?php echo $channel_name; ?>" class="form-control"
                                                    name="channel_name" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Description
                                            </label>
                                            <div class="col-md-6">
                                    <textarea class="form-control" cols="5" rows="3" name="channel_detail" id="channel_detail"
                                            readonly><?php echo $detail; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Campaign Name
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" value="<?php echo $campaign_name; ?>" class="form-control"
                                                    name="campaign_name" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Landing Page Url
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" value="<?php echo $lp_url; ?>" class="form-control"
                                                    name="lp_url" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Redirect Page Url
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" value="<?php echo $r_url; ?>" class="form-control"
                                                    name="r_url" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php
                                        if (!empty($field)) {
                                            foreach ($field as $key => $f) {
                                                $field_name = $this->MainModels->getDisplayNameField($f);
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-4">Field <?php echo $key + 1; ?>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <input type="text" value="<?php echo $field_name; ?>"
                                                                    class="form-control"
                                                                    name="field[]" readonly/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        if (!empty($sales_team)) {
                                            foreach ($sales_team as $key => $st) {
                                                $sales_team_name = $this->db->get_where('tbl_sales_team', array('sales_team_id' => $st))->row('sales_team_name');
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Sales Team <?php echo $key + 1; ?>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <input type="text" value="<?php echo $sales_team_name; ?>"
                                                                    class="form-control"
                                                                    name="sales_team[]" readonly/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="step" value="<?php echo $step; ?>">
                            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button onclick="window.location.href='<?php echo base_url('project/form_add_channel/?id=' . $project_id . '&step=4'); ?>'"
                                                type="button" class="btn default">Back
                                        </button>
                                        <button type="submit" class="btn green">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
?>
<?php
    if ($category == 'Offline') {
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-body form">
                        <form action="" class="form-horizontal" role="form" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Media
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" value="<?php echo $media_name; ?>" class="form-control"
                                                    name="media_name" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Category
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" value="<?php echo $category; ?>" class="form-control"
                                                    name="category" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Channel Name
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" value="<?php echo $channel_name; ?>" class="form-control"
                                                    name="channel_name" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Description
                                            </label>
                                            <div class="col-md-6">
                                    <textarea class="form-control" cols="5" rows="3" name="channel_detail" id="channel_detail"
                                            readonly><?php echo $detail; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Campaign Name
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" value="<?php echo $campaign_name; ?>" class="form-control"
                                                    name="campaign_name" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php
                                        if (!empty($field)) {
                                            foreach ($field as $key => $f) {
                                                $field_name = $this->MainModels->getDisplayNameField($f);
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-4">Field <?php echo $key + 1; ?>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <input type="text" value="<?php echo $field_name; ?>"
                                                                    class="form-control"
                                                                    name="field[]" readonly/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        if (!empty($sales_team)) {
                                            foreach ($sales_team as $key => $st) {
                                                $sales_team_name = $this->db->get_where('tbl_sales_team', array('sales_team_id' => $st))->row('sales_team_name');
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Sales Team <?php echo $key + 1; ?>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <input type="text" value="<?php echo $sales_team_name; ?>"
                                                                    class="form-control"
                                                                    name="sales_team[]" readonly/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="step" value="<?php echo $step; ?>">
                            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button onclick="window.location.href='<?php echo base_url('project/form_add_channel/?id=' . $project_id . '&step=4'); ?>'"
                                                type="button" class="btn default">Back
                                        </button>
                                        <button type="submit" class="btn green">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
?>