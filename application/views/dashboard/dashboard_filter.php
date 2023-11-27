<!-- BEGIN SAMPLE FORM PORTLET-->
<?php

$user_session = $this->session->userdata('user');


$session_dashboard = $this->session->userdata('dashboard');
$project_id = $session_dashboard['project_id'];
$from = $session_dashboard['from'];
$to = $session_dashboard['to'];
?>
<div class="portlet">
    <div class="portlet-body">
        <form class="form-inline" role="form">
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
                        ?> > All </option>
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
            <div class="form-group">
                <div class="col-md-4">
                    <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control" value="<?php echo $from; ?>" name="from">
                        <span class="input-group-addon"> to </span>
                        <input type="text" class="form-control" value="<?php echo $to; ?>" name="to"> </div>
                </div>   
            </div>   
            <div class="form-group">   
                <button type="submit" class="btn btn-md btn-default"><span class="fa fa-search"></span></button>
                <button type="button" name="reset" class="btn btn-md btn-success" onclick="location.href = '<?php echo base_url('dashboard/resetFilter/'); ?>'">
                    <span class="fa fa-repeat"></span>
                </button>
            </div>
        </form>
    </div>   
</div>
<!-- END SAMPLE FORM PORTLET-->