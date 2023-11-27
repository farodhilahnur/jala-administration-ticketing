<?php
$session_step_1 = $this->session->userdata('step_1');
$media_id = $session_step_1['media_id'];
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-body form">
                <form action="" class="form-horizontal" role="form" method="post">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="radio-list">
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-5 online-card">
                                            <div class="col-md-12 title-media">
                                                <h2>Online</h2>
                                            </div>
                                            <?php
                                            if (!empty($online)) {
                                                foreach ($online as $key => $ol) {
                                                    ?>
                                                    <div class="col-md-9 select-media">
                                                        <div class="col-md-1 radio-btn-div">
                                                            <label>
                                                                <input type="radio" name="media_id"
                                                                       id="optionsRadios22"
                                                                       value="<?php echo $ol->id; ?>"
                                                                    <?php if ($ol->id == $media_id) {
                                                                        echo "checked";
                                                                    } ?> required
                                                                >
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <img class="image-media"
                                                                 src="<?php echo 'https://jala.ai/dashboard/assets/picture/media/' . $ol->media_pic; ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h5><?php echo $ol->media_name; ?></h5>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-5 offline-card">
                                            <div class="col-md-12 title-media">
                                                <h2>Offline</h2>
                                            </div>
                                            <?php
                                            if (!empty($offline)) {
                                                foreach ($offline as $key => $of) {
                                                    ?>
                                                    <div class="col-md-9 select-media">
                                                        <div class="col-md-1 radio-btn-div">
                                                            <label>
                                                                <input type="radio" name="media_id"
                                                                       id="optionsRadios22"
                                                                       value="<?php echo $of->id; ?>"
                                                                    <?php if ($of->id == $media_id) {
                                                                        echo "checked";
                                                                    } ?>
                                                                >
                                                            </label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <img class="image-media"
                                                                 src="<?php echo 'https://jala.ai/dashboard/assets/picture/media/' . $of->media_pic; ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h5><?php echo $of->media_name; ?></h5>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="step" value="<?php echo $step; ?>">
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green">Next</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
