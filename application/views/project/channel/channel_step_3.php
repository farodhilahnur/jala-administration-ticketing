<?php
$session_step_1 = $this->session->userdata('step_1');

$category = $session_step_1['category'];
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-body form">
                <form action="" class="form-horizontal" role="form" method="post">
                    <div class="form-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <?php
                                if ($category == 'Online') {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <!-- Default panel contents -->
                                            <div class="panel-heading">
                                                <h2 class="panel-title">Available Field</h2>
                                            </div>
                                            <div class="panel-body">

                                            </div>
                                            <ul class="list-group">
                                                <?php
                                                foreach ($field as $key => $f) {
                                                    $session_step_3 = $this->session->userdata('step_3');
                                                    if (!empty($session_step_3)) {
                                                        $checked = $session_step_3['field'];
                                                    } else {
                                                        $checked = array(1, 2);
                                                    }
                                                    ?>
                                                    <li class="list-group-item">
                                                        <label>
                                                            <input id="<?php echo $key; ?>>"
                                                                   type="checkbox"
                                                                   name="field[]"
                                                                   value="<?php echo $key + 1; ?>"
                                                                <?php if (in_array($key + 1, $checked)) {
                                                                    echo "checked";
                                                                } ?>
                                                            />
                                                            <?php echo $f; ?>
                                                        </label>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>

                                    <?php
                                } else {
                                    ?>
                                    <div class="col-md-6">
                                        <p style="text-align: center;font-size: 30px;margin-bottom: 50px;color: black;">Available soon</p>
                                        <p style="text-align: center;">Channel Offline can't choose field right now, this feature is under construction</p>
                                        <p style="text-align: center;">Please click Next</p>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="col-md-3"></div>
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
