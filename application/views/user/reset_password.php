<form class="" action="" method="post">
    <p style="color:black;"> Enter your password to change reset your password. </p>
    <div class="form-group">
        <div class="input-icon">
            <i class="fa fa-key"></i>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> </div>
    </div>
    <input type="hidden" name="user_id" class="userId">
    <div class="form-actions">
        <button onclick="location.href = '<?php echo base_url('login'); ?>'" type="button" id="back-btn" class="btn red btn-outline">Back </button>
        <button type="submit" class="btn green pull-right"> Submit </button>
    </div>   
</form>