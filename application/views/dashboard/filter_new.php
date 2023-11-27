<!-- BEGIN SAMPLE FORM PORTLET-->
<?php

$user_session = $this->session->userdata('user');


$session_dashboard = $this->session->userdata('dashboard');
$project_id = $session_dashboard['project_id'];
$from = $session_dashboard['from'];
$to = $session_dashboard['to'];
?>
<div style="box-shadow: none;margin-bottom: 0px" class="portlet">
    <div style="padding: 15px 15px 0px 15px;" class="portlet-body">
        <form class="" role="form">
            <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <select id="projectSelect" name="project_id" class="form-control">
                            <option value="">--select project--</option>
                            <?php
                            if ($user_session['role_id'] != 5) {
                                ?>
                                <option value="0"
                                    <?php
                                    if ($project_id == 0) {
                                        echo "selected";
                                    }
                                    ?> > All
                                </option>
                                <?php
                            }
                            ?>

                            <?php
                            if (!empty($data_project_filter)) {
                                foreach ($data_project_filter as $dpr) {
                                    ?>
                                    <option value="<?php echo $dpr->id; ?>"
                                        <?php
                                        if ($dpr->id == $session_dashboard['project_id']) {
                                            echo "selected";
                                        }
                                        ?>
                                    >
                                        <?php echo $dpr->project_name; ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-9 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <div class="input-group date-picker input-daterange" data-date="10/11/2012"
                             data-date-format="yyyy-mm-dd">
                            <input id="fromDateFilter" type="text" class="form-control" value="<?php echo $from; ?>" name="from">
                            <span class="input-group-addon"> to </span>
                            <input id="endDateFilter" type="text" class="form-control" value="<?php echo $to; ?>" name="to"></div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6 col-sm-6">
                    <div class="form-group">
                        <button id="filter-btn" type="submit" class="btn btn-md btn-default"><span class="fa fa-search"></span></button>
                        <button type="button" name="reset" class="btn btn-md btn-success"
                                onclick="location.href = '<?php echo base_url('dashboard_new/resetFilter/'); ?>'">
                            <span class="fa fa-repeat"></span>
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
<!-- END SAMPLE FORM PORTLET-->