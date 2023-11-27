<div class="portlet">
    <div class="portlet-body">
        <form class="form-inline" role="form">
            <input type="hidden" name="id" value="<?php echo $project_id; ?>">
            <div class="form-group">
                <select id="campaignSelect" name="campaign_id" class="form-control">
                    <option value="">--select campaign--</option>
                    <option value="0" <?php
                    if ($session['filter']['campaign_id'] == 0) {
                        echo 'selected';
                    }
                    ?> >All
                    </option>
                    <?php
                    foreach ($data_campaign as $dc) {
                        ?>      
                        <option value="<?php echo $dc->id; ?>"
                        <?php
                        if ($session['filter']['campaign_id'] == $dc->id) {
                            echo 'selected';
                        }
                        ?>
                                >
                                    <?php echo $dc->campaign_name; ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>    
            </div>
            <div class="form-group">
                <div class="input-group" id="defaultrange">
                    <input name="date_range" type="text" id="date-range-filter" class="form-control input-large" value="<?php echo $session['filter']['date_range']; ?>">
                    <span class="input-group-btn">
                        <button class="btn default date-range-toggle" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </span>
                </div>   
            </div>
            <button class="btn btn-md btn-default"><i class="fa fa-search"></i></button>
        </form>
    </div>
</div>