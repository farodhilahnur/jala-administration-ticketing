<div class="col-md-12 col-xs-12 col-sm-12">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">Online vs Offline</span>
            </div>
            <div class="tools">
                <a href="javascript:;" class="collapse"> </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12">
                    <div style="height: 40px;" class="progress">
                        <?php
                        $online_percent = $data_online_offline['online_percent'] . '%';
                        $offline_percent = $data_online_offline['offline_percent'] . '%';
                        ?>
                        <div class="progress-bar"
                             style="background:#EDF8F3;text-align:center;width: <?php echo $online_percent; ?>;">
                            <p style="margin: 10px;font-size: 20px;color: gray;">
                                <?php echo $data_online_offline['online_total']; ?>
                            </p>
                        </div>
                        <div class="progress-bar progress-bar-warning"
                             style="background:#CFECFC;text-align:center;width: <?php echo $offline_percent; ?>;">
                            <p style="margin: 10px;font-size: 20px;color: gray;">
                                <?php echo $data_online_offline['offline_total']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div style="text-align: center;margin-top: 20px;">
                    <button style="width: 30px;height: 15px;background: #EDF8F3;border-radius: 10px;box-shadow: none;"
                            class="btn btn-xs btn-rounded"></button>
                    <span style="padding-right: 20px;">Online</span>
                    <button style="width: 30px;height: 15px;background: #CFECFC;border-radius: 10px;box-shadow: none;"
                            class="btn btn-xs btn-rounded"></button>
                    <span>Offline</span>
                </div>
            </div>
        </div>
    </div>
</div>