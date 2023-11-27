<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-body form">
                <form action="" class="form-horizontal" role="form" method="post">
                    <div class="form-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <!-- Default panel contents -->
                                        <div class="panel-heading">
                                            <h2 class="panel-title">Available Sales Team</h2>
                                        </div>
                                        <div class="panel-body">

                                        </div>
                                        <ul class="list-group">
                                            <?php
                                            $session_step_4 = $this->session->userdata('step_4');
                                            foreach ($sales_team as $key => $st) {
                                                if(!empty($session_step_4)){
                                                    $checked = $session_step_4['sales_team'];
                                                } else {
                                                    $checked = array();
                                                }
                                                ?>
                                                <li class="list-group-item">
                                                    <label>
                                                        <input id="<?php echo $key; ?>"
                                                               type="checkbox"
                                                               name="sales_team[]"
                                                               value="<?php echo $st->sales_team_id; ?>"
                                                            <?php
                                                            if (in_array($st->sales_team_id, $checked)) {
                                                                echo "checked";
                                                            }
                                                            ?>
                                                        />
                                                        <?php echo $st->sales_team_name; ?>
                                                    </label>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="step" value="<?php echo $step; ?>">
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button onclick="window.location.href='<?php echo base_url('project/form_add_channel/?id=' . $project_id . '&step=3'); ?>'"
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
