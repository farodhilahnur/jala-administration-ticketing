
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Filter</span>
        </div>
    </div>   
    <div class="portlet-body">
        <form class="" role="form" method="get">
            <input type="hidden" name="id" value="<?php echo $project_id; ?>">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <select id="single" name="sales_team_id" class="form-control">
                                <option value="">--sales team--</option>
                                <?php
                                if (!empty($data_sales_team)) {
                                    foreach ($data_sales_team as $dst) {
                                        ?>
                                        <option value="<?php echo $dst->sales_team_id; ?>"
                                        <?php
                                        if ($session_search['sales_team_id'] == $dst->sales_team_id) {
                                            echo "selected";
                                        }
                                        ?>
                                                >
                                                    <?php echo $dst->sales_team_name; ?>
                                        </option>   
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>    
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select id="single" name="lead_category_id" class="form-control">
                                <option value="">--lead category--</option>
                                <?php
                                if (!empty($data_lead_category)) {
                                    foreach ($data_lead_category as $dlc) {
                                        ?>
                                        <option value="<?php echo $dlc->lead_category_id; ?>"
                                        <?php
                                        if ($session_search['lead_category_id'] == $dlc->lead_category_id) {
                                            echo "selected";
                                        }
                                        ?>
                                                >
                                                    <?php echo $dlc->category_name; ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select id="single" name="status_id" class="form-control">
                                <option value="">--status--</option>
                                <?php
                                if (!empty($data_status)) {
                                    foreach ($data_status as $ds) {
                                        ?>
                                        <option value="<?php echo $ds->id; ?>"
                                        <?php
                                        if ($session_search['status_id'] == $ds->id) {
                                            echo "selected";
                                        }
                                        ?>
                                                >
                                                    <?php echo $ds->status_name; ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-2">
                        <div class="form-group">
                            <select id="single" name="channel_id" class="form-control">
                                <option value="">--channel--</option>
                                <?php
                                if (!empty($data_channel)) {
                                    foreach ($data_channel as $dch) {
                                        ?>
                                        <option value="<?php echo $dch->channel_id; ?>"
                                        <?php
                                        if ($session_search['channel_id'] == $dch->channel_id) {
                                            echo "selected";
                                        }
                                        ?>
                                                >
                                                    <?php echo $dch->channel_name; ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-2">
                        <div class="form-group">
                            <select id="single" name="sales_officer_id" class="form-control">
                                <option value="">--sales officer--</option>
                                <?php
                                if (!empty($data_sales_officer)) {
                                    foreach ($data_sales_officer as $dso) {
                                        ?>
                                        <option value="<?php echo $dso->sales_officer_id; ?>"
                                        <?php
                                        if ($session_search['sales_officer_id'] == $dso->sales_officer_id) {
                                            echo "selected";
                                        }
                                        ?>
                                                >
                                                    <?php echo $dso->sales_officer_name; ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-2">
                        <div class="form-group">
                            <button type="submit" name="search" value="1" class="btn btn-md btn-danger"><span class="fa fa-search"></span></button>
                            <button type="button" name="reset" class="btn btn-md btn-success" onclick="location.href = '<?php echo base_url('project/reset_filter/?id=' . $project_id); ?>'">
                                <span class="fa fa-repeat"></span>
                            </button>
                        </div>
                    </div>
                    <!--/span-->
                </div>
            </div>  
        </form>
    </div>
</div>
