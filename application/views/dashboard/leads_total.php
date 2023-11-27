<?php
$session_dashboard = $this->session->userdata('dashboard');
?>
<!-- BEGIN Portlet PORTLET-->
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Total Leads</span>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
            <a href="" class="fullscreen"> </a>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="btn-toolbar margin-bottom-10">
                    <div class="btn-group btn-group-sm btn-group-solid">
                        <button id="btnDay" type="button" value="DAY" class="btn btn-sm btn-time btn-danger active">
                            Day
                        </button>
                        <button id="btnMonth" type="button" value="MONTH" class="btn btn-sm btn-time btn-danger">Month
                        </button>
                        <button id="btnYear" type="button" value="YEAR" class="btn btn-sm btn-time btn-danger">Year
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <div class="row">
                        <form action="" method="get">
                            <div class="col-md-6">
                                <select id="selectStatus1" name="category_id_1" style="margin-left: 40px;"
                                        class="form-control">
                                    <option>--Select Category--</option>
                                    <option value="0" <?php if ($category->lead_category_id == 0) {
                                        echo "selected";
                                    } ?>>All
                                    </option>
                                    <?php
                                    if (!empty($data_category)) {
                                        foreach ($data_category as $category) {
                                            ?>
                                            <option value="<?php echo $category->lead_category_id; ?>"
                                                <?php
                                                if ($session_dashboard['category_id_1'] == $category->lead_category_id) {
                                                    echo "selected";
                                                }
                                                ?>
                                            >
                                                <?php echo $category->category_name; ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        VS
                                    </span>
                                    <select id="selectStatus2" name="category_id_2" class="form-control">
                                        <option value="">--Select Category--</option>
                                        <?php
                                        if (!empty($data_category)) {
                                            foreach ($data_category as $category) {
                                                ?>
                                                <option value="<?php echo $category->lead_category_id; ?>"
                                                    <?php
                                                    if ($session_dashboard['category_id_2'] == $category->lead_category_id) {
                                                        echo "selected";
                                                    }
                                                    ?>
                                                >
                                                    <?php echo $category->category_name; ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" name="versus" value="1" class="btn btn-md btn-default"><span
                                            class="fa fa-search"></span></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /input-group -->
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <span id="pTotal1" style="font-size: 18px;color:red;font-weight: bold;"></span>
                        <span id="numTotal1" style="color:black;font-size: 16px;font-weight: bold;">0</span>
                    </div>
                    <div class="col-md-6">
                        <span id="pTotal2" style="font-size: 18px;color:red;font-weight: bold;"></span>
                        <span id="numTotal2" style="color:black;font-size: 16px;font-weight: bold;">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <canvas height="500" id="myChart"></canvas>
    </div>
</div>
<!-- END Portlet PORTLET-->