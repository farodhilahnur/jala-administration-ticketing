<?php
$unique_code = $this->session->userdata('unique_code');
$session_step_1 = $this->session->userdata('step_1');
$session_step_2 = $this->session->userdata('step_2');
$session_step_3 = $this->session->userdata('step_3');
$session_step_4 = $this->session->userdata('step_4');
$category = $session_step_1['category'];
$field = $session_step_3['field'];


$script = "$(document).ready(function () {

    $('form').submit(function (event) {
        var formData = {
    ";

foreach ($field as $key => $f) {

    $name = $this->MainModels->getNameField($f);

    if ($key + 1 > 1) {
        if ($f == 1) {
            $script .= "\t \t '$name': $('input[name=$name]').val(), \n";
        }
        if ($f == 2) {
            $script .= "\t \t '$name': $('input[name=$name]').val(), \n";
        }
        if ($f == 3) {
            $script .= "\t \t '$name': $('input[name=$name]').val(), \n";
        }
        if ($f == 4) {
            $script .= "\t \t '$name': $('input[name=$name]').val(), \n";
        }
        if ($f == 5) {
            $script .= "\t \t '$name': $('input[name=$name]').val(), \n";
        }
        if ($f == 6) {
            $script .= "\t \t '$name': $('select[name=$name]').val(), \n";
        }
        if ($f == 7) {
            $script .= "\t \t '$name': $('select[name=$name]').val(), \n";
        }
        if ($f == 8) {
            $script .= "\t \t '$name': $('input[name=$name]').val(), \n";
        }
    } else {
        $script .= "\t '$name': $('input[name=$name]').val(), \n";
    }
}

$script .= "\t \t 'source': $('input[name=source]').val(),
        };       
    
        $.ajax({
            type: 'POST', 
            url: 'https://jala.ai/dashboard/lead/post_lead/', 
            data: formData, 
            dataType: 'json', 
            encode: true
        })
                   
                .done(function (data) {
     
                    if (data.res) {
                        alert('thanks for your interest');
                    } else {
                        alert('sorry the system has been error');
                    }
                    window.location.href = data.redirect;
                });

        event.preventDefault();
    });


});";

$unset_step1 = $this->session->unset_userdata('step_1');
$unset_step2 = $this->session->unset_userdata('step_2');
$unset_step3 = $this->session->unset_userdata('step_3');
$unset_step4 = $this->session->unset_userdata('step_4');
?>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE BASE CONTENT -->
        <div class="row">
            <!--            <div class="col-md-12">-->
            <!--                <div class="note note-success">-->
            <!--                    <h4 class="block">CodeMirror</h4>-->
            <!--                    <p> CodeMirror is a versatile text editor implemented in JavaScript for the browser. It is-->
            <!--                        specialized for editing code, and comes with a number of language modes and addons that-->
            <!--                        implement more advanced editing functionality.-->
            <!--                        For more info please check out-->
            <!--                        <a href="http://codemirror.net/" target="_blank"> the official documentation</a>-->
            <!--                    </p>-->
            <!--                </div>-->
            <!--            </div>-->
        </div>
        <div class="row">
            <?php
            if ($category == 'Online') {
                ?>
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="font-green"></i>
                                <span class="caption-subject font-green bold uppercase">Guide</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <p style="font-size: 18px;font-weight: 600;">1. Add one input type hidden with value
                                        code
                                        besides and name source </p>
                                    <i>this step only use for your first channel or organic websites</i>
                                </div>
                                <div class="col-md-3">
                                    <p style="font-size: 24px;text-align: center;background-color: #ec211e;color: white;border-radius: 10px;">
                                        <?php echo $unique_code; ?>
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <p style="margin-top: 20px;"><i>example :</i></p>
                                    <textarea class="form-control" readonly><input type="hidden" name="source"
                                                                                   value="<?php echo $unique_code; ?>"></textarea>
                                </div>
                            </div>
                            <div style="margin-top: 20px;" class="row">
                                <div class="col-md-12">
                                    <p style="font-size: 18px;font-weight: 600;">2. Add code above to your head tags of
                                        your web
                                </div>
                                <div class="col-md-12">
                                    <p><i>code :</i></p>
                                    <textarea class="form-control" readonly><script
                                                src="https://jala.ai/dashboard/script/tracking-new.js"
                                                type="text/javascript"></script></textarea>
                                </div>
                            </div>
                            <div style="margin-top: 20px;" class="row">
                                <div class="col-md-12">
                                    <p style="font-size: 18px;font-weight: 600;">3. Create new file .js with the code
                                        besides and include to your website </p>
                                    <i>make sure your web use the latest jquery plugins</i>
                                </div>
                            </div>
                            <div style="text-align: center;margin-top: 95px;" class="row">
                                <button onclick="location.href='<?php echo base_url('project_new/channel/?id=' . $project_id); ?>'"
                                        class="btn btn-lg btn-success"<?php echo $unset_step1 ?><?php echo $unset_step2 ?><?php echo $unset_step3 ?><?php echo $unset_step4 ?>>
                                    Go to Channel Page
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-body">
                                    <textarea id="code_editor_demo_3"><?php echo $script; ?>
                                    </textarea>
                        </div>
                    </div>
                </div>

                <?php
            } else {
                ?>
                <div style="text-align: center;font-size: 27px;margin-bottom: 40px;" class="col-md-12">
                    <label style="font-size: 24px;" class="label label-default">Success create Offline Channel</label>

                </div>
                <div style="text-align: center;" class="col-md-12">
                    <button onclick="location.href='<?php echo base_url('project_new/channel/?id=' . $project_id); ?>'"
                            class="btn btn-lg btn-success"<?php echo $unset_step1 ?><?php echo $unset_step2 ?><?php echo $unset_step3 ?><?php echo $unset_step4 ?>>
                        Go to Channel Page
                    </button>
                </div>

                <?php
            }
            ?>

        </div>
    </div>
    <!-- END PAGE BASE CONTENT -->
</div>

