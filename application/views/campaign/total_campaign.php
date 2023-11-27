<div class="dashboard-stat2 bordered">
    <div class="display">
        <div class="number">
            <h3 class="font-red-haze">
                <span data-counter="counterup" data-value="<?php echo count($data_campaign); ?>"><?php echo count($data_campaign); ?></span>
                <small class="font-red-haze">Campaign</small>
            </h3>
            <small>TOTAL </small>
        </div>
        <div class="icon">
            <!--<i class="icon-pie-chart"></i>-->
        </div>
    </div>
    <div class="progress-info">   
        <div class="status">
            <div class="status-title"> 
                <?php
                $date = explode(' to ', $session['filter']['date_range']);
                $new_project_date = date("M d, Y", strtotime($date[0]));
                $new_now_date = date("M d, Y", strtotime($date[1]));
                echo $new_project_date . ' - ' . $new_now_date;
                ?> 
            </div>
        </div>      
    </div>
</div>