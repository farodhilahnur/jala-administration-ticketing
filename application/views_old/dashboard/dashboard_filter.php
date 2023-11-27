<!-- BEGIN SAMPLE FORM PORTLET-->
<?php $session_dashboard = $this->session->userdata('dashboard'); ?>
<div class="portlet">
    <div class="portlet-body">
        <form class="form-inline" role="form">
            <div class="form-group">
                <select id="projectSelect" name="project_id" class="form-control">
                    <option value="">--select project--</option>
                    <option value="0" 
                    <?php
                    if ($session_dashboard['project_id'] == 0) {
                        echo "selected";
                    }
                    ?> > All </option>
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
                <div class="input-group" id="defaultrange">
                    <input name="date_range" type="text" id="date-range-filter" class="form-control input-large" value="<?php echo $session_dashboard['date_range']; ?>">
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
<!-- END SAMPLE FORM PORTLET-->