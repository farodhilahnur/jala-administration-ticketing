<!-- BEGIN SAMPLE FORM PORTLET-->
<?php 
//echo "<pre>" ;
//print_r($this->session->userdata('dashboard'));
//echo "</pre>" ;

$session_dashboard = $this->session->userdata('dashboard');
$from = $session_dashboard['from'];
$to = $session_dashboard['to'];

?>
<div class="portlet">
    <div class="portlet-body">
        <form class="form-inline" role="form">
            <div class="form-group">
                <div class="col-md-4">
                    <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control" value="<?php echo $from ; ?>" name="from">
                        <span class="input-group-addon"> to </span>
                        <input type="text" class="form-control" value="<?php echo $to ; ?>" name="to"> </div>
                </div>   
            </div>   
            <div class="form-group">   
                <button type="submit" class="btn btn-md btn-default"><span class="fa fa-search"></span></button>
                <button type="button" name="reset" class="btn btn-md btn-success" onclick="location.href = '<?php echo base_url('project/resetFilterCampaign/'); ?>'">
                    <span class="fa fa-repeat"></span>
                </button>
            </div>
        </form>
    </div>   
</div>
<!-- END SAMPLE FORM PORTLET-->