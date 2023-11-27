<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Filter</span>
        </div>
    </div>
    <div class="portlet-body">
        <form class="" role="form" method="get">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN SAMPLE FORM PORTLET-->
                        <div class="portlet" style="box-shadow: none; margin-bottom: 0">
                            <div class="portlet-body row">
                                <!--        <form class="form-inline" role="form">-->
                                <div class="form-group col-md-4">
                                    <select id="campaignSelect" name="campaign_id" class="form-control">
                                        <option value="">--select campaign--</option>
                                        <option value="0">All
                                        </option>
                                        <?php
                                        foreach ($data_campaign as $dc) {
                                            ?>
                                            <option value="<?php echo $dc->id; ?>"
                                                <?php if ($campaign_id == $dc->id) {
                                                    echo 'selected';
                                                } ?>
                                            >
                                                <?php echo $dc->campaign_name; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <div class="input-group input-large date-picker input-daterange"
                                             data-date="10/11/2012" data-date-format="yyyy-mm-dd">
                                            <input type="text" class="form-control"
                                                   value="<?php echo $from; ?>" name="from">
                                            <span class="input-group-addon"> to </span>
                                            <input type="text" class="form-control"
                                                   value="<?php echo $to; ?>" name="to"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END SAMPLE FORM PORTLET-->
                    </div>
                </div>
                <div class="row">
                    <?php
                    if ($this->MainModels->UserSession('role_id') == 2) {
                        ?>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select id="single" name="sales_team_id" class="form-control">
                                    <option value="">--sales team--</option>
                                    <?php
                                    if (!empty($data_sales_team)) {
                                        foreach ($data_sales_team as $dst) {
                                            ?>
                                            <option value="<?php echo $dst->sales_team_id; ?>"
                                                <?php if ($sales_team_id == $dst->sales_team_id) {
                                                    echo "selected";
                                                } ?>
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
                        <?php
                    }
                    ?>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select id="single" name="lead_category_id" class="form-control">
                                <option value="">--lead category--</option>
                                <?php
                                if (!empty($data_lead_category)) {
                                    foreach ($data_lead_category as $dlc) {
                                        ?>
                                        <option value="<?php echo $dlc->lead_category_id; ?>"
                                            <?php if ($category_id == $dlc->lead_category_id) {
                                                echo 'selected';
                                            } ?>
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
                            <select id="single" name="type_id" class="form-control">
                                <option value="">--type--</option>
                                <option value="3">Offline</option>
                                <option value="1">Online</option>
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
                                            <?php if ($status_id == $ds->id) {
                                                echo 'selected';
                                            } ?>
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
                                        <option value="<?php echo $dch->id; ?>"
                                            <?php if ($channel_id == $dch->id) {
                                                echo 'selected';
                                            } ?>
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
                                            <?php if ($sales_officer_id == $dso->sales_officer_id) {
                                                echo "selected";
                                            } ?>
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
                            <button type="submit" name="search" value="1" class="btn btn-md btn-danger"><span
                                        class="fa fa-search"></span></button>
                            <button type="button" name="reset" class="btn btn-md btn-success"
                                    onclick="location.href = '<?php echo base_url('lead/'); ?>'">
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
