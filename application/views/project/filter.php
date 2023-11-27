<?php 
$session = $this->session->userdata();
?>
<div class="portlet" style="box-shadow: none; margin-bottom: 0">
    <div class="portlet-body row">
        <!--        <form class="form-inline" role="form">-->
        <input type="hidden" name="id" value="<?php echo $project_id; ?>">
        <div class="form-group col-md-4">
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
            <div class="col-md-4">
                <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd">
                    <input type="text" class="form-control" value="<?php echo $session['filter']['from'] ; ?>" name="from">
                    <span class="input-group-addon"> to </span>
                    <input type="text" class="form-control" value="<?php echo $session['filter']['to'] ; ?>" name="to"> </div>
            </div>   
        </div>
    </div>
</div>