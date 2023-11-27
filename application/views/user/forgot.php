<form class="" action="" method="post">
    <p style="color:black;"> Enter your e-mail address below to reset your password. </p>
    <div class="form-group">
        <div class="input-icon">
            <i class="fa fa-envelope"></i>
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="mail" /> </div>
    </div>
    <div class="form-actions">
        <button onclick="location.href = '<?php echo base_url('login'); ?>'" type="button" id="back-btn" class="btn red btn-outline">Back </button>
        <button type="submit" class="btn green pull-right"> Submit </button>
    </div>   
</form>