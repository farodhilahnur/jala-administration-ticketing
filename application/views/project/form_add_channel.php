<div class="row">
    <?php
    $active_step = $step;
    $done_step = $step - 1;
    $session_step_1 = $this->session->userdata('step_1');
    $category = $session_step_1['category'];
    ?>
    <div class="col-md-12">
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-green bold uppercase">Add Channel</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="mt-element-step">
                    <div class="row step-line">
                        <div class="col-md-2 mt-step-col first
                        <?php
                        if ($active_step == 1) {
                            echo 'active';
                        }

                        if ($active_step > 1) {
                            echo 'done';
                        }
                        ?>
                            ">
                            <div class="mt-step-number bg-white">1</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Media</div>
                            <div class="mt-step-content font-grey-cascade">Choose your channel media</div>
                        </div>
                        <div class="col-md-2 mt-step-col
                        <?php
                        if ($active_step == 2) {
                            echo 'active';
                        }

                        if ($active_step > 2) {
                            echo 'done';
                        }
                        ?>
                            ">
                            <div class="mt-step-number bg-white">2</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Information</div>
                            <div class="mt-step-content font-grey-cascade">Information channel name, campaign, and
                                detail
                            </div>
                        </div>
                        <div class="col-md-2 mt-step-col
                        <?php
                        if ($active_step == 3) {
                            echo 'active';
                        }

                        if ($active_step > 3) {
                            echo 'done';
                        }
                        ?>
                            ">
                            <div class="mt-step-number bg-white">3</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Field</div>
                            <div class="mt-step-content font-grey-cascade">Select field that's use in form to generate
                                lead
                            </div>
                        </div>
                        <div class="col-md-2 mt-step-col
                        <?php
                        if ($active_step == 4) {
                            echo 'active';
                        }

                        if ($active_step > 4) {
                            echo 'done';
                        }
                        ?>
                            ">
                            <div class="mt-step-number bg-white">4</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Team</div>
                            <div class="mt-step-content font-grey-cascade">Select your participate Sales Team</div>
                        </div>
                        <div class="col-md-2 mt-step-col
                        <?php
                        if ($active_step == 5) {
                            echo 'active';
                        }

                        if ($active_step > 5) {
                            echo 'done';
                        }
                        ?>
                        ">
                            <div class="mt-step-number bg-white">5</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Review</div>
                            <div class="mt-step-content font-grey-cascade">Please check your data before the system
                                launch the channel
                            </div>
                        </div>
                        <div class="col-md-2 mt-step-col last">
                            <div class="mt-step-number bg-white">6</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Launch</div>
                            <?php
                            if ($category == 'Online') {
                                ?>
                                <div class="mt-step-content font-grey-cascade">Read the guide for add script to your
                                    website
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                if ($step == 1) {
                    $this->load->view('project/channel/channel_step_1');
                } else if ($step == 2) {
                    $this->load->view('project/channel/channel_step_2');
                } else if ($step == 3) {
                    $this->load->view('project/channel/channel_step_3');
                } else if ($step == 4) {
                    $this->load->view('project/channel/channel_step_4');
                } else if ($step == 5) {
                    $this->load->view('project/channel/channel_step_5');
                } else if ($step == 6) {
                    $this->load->view('project/channel/channel_step_6');
                }
                ?>
            </div>
        </div>
    </div>
</div>
