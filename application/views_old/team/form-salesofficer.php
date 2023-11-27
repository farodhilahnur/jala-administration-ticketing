<style>.select2-search__field{ width: 100% !important }</style>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-user-plus"></i> Sales Officer Form </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="" method="post" class="form-horizontal">
                    <div class="form-body">
                        <div class="row">
                            <?php
                            if ($function == 'edit') {
                                ?>
                                <input name="sales_officer_id" type="hidden" value="<?php echo $data_sales_officer->sales_officer_id; ?>">
                                <input name="user_id" type="hidden" value="<?php echo $data_sales_officer->user_id; ?>">
                                <?php
                            }
                            ?>
                            <div  class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Sales Team</label>
                                    <div class="col-md-9">
                                        <select name="salesTeam[]" id="multiple" class="form-control select2-multiple select2-multiple-st" multiple>
                                            <?php
                                            foreach ($data_sales_team as $value) {
                                                ?>      
                                                <option value="<?php echo $value->sales_team_id; ?>"
                                                <?php
                                                if ($function == 'edit') {
                                                    if (in_array($value->sales_team_id, $list_sales_team)) {
                                                        echo "selected";
                                                    }
                                                }
                                                ?>
                                                        >
                                                            <?php echo $value->sales_team_name; ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Name</label>
                                    <div class="col-md-9">
                                        <input name="salesOfficerName" 
                                               type="text" 
                                               class="form-control"
                                               value="<?php
                                               if ($function == 'edit') {
                                                   echo $data_sales_officer->sales_officer_name;
                                               }
                                               ?>"
                                               required
                                               > 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Gender</label>
                                    <div class="radio-list">
                                        <label class="radio-inline">
                                            <div class="radio" id="uniform-optionsRadios4">
                                                <span class="checked">
                                                    <input name="gender" 
                                                           type="radio" 
                                                           id="optionsRadios4" 
                                                           value="male"
                                                           <?php
                                                           if ($function == 'edit') {
                                                               if ($data_sales_officer->sales_officer_gender == 1) {
                                                                   echo "checked";
                                                               }
                                                           }
                                                           ?>
                                                           >
                                                </span>
                                            </div> <i class="fa fa-male"></i> 
                                        </label>
                                        <label class="radio-inline">
                                            <div class="radio" id="uniform-optionsRadios5">
                                                <span class="">
                                                    <input name="gender" 
                                                           type="radio" 
                                                           id="optionsRadios5" 
                                                           value="female"
                                                           <?php
                                                           if ($function == 'edit') {
                                                               if ($data_sales_officer->sales_officer_gender == 2) {
                                                                   echo "checked";
                                                               }
                                                           }
                                                           ?>
                                                           >
                                                </span>
                                            </div> <i class="fa fa-female"></i> 
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Phone</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </span>
                                            <input name="phone" 
                                                   type="text" 
                                                   class="form-control" 
                                                   value="<?php
                                                   if ($function == 'edit') {
                                                       echo $data_sales_officer->sales_officer_phone;
                                                   }
                                                   ?>"
                                                   placeholder="Phone"
                                                   required
                                                   > 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($this->MainModels->UserSession('role_id') == 1) {
                                ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Client</label>
                                        <div class="col-md-9">
                                            <select name="client_id" class="form-control">
                                                <option value="">--SELECT CLIENT--</option>
                                                <?php
                                                if ($data_client) {
                                                    foreach ($data_client as $dc) {
                                                        ?>
                                                        <option value="<?php echo $dc->client_id; ?>"
                                                        <?php
                                                        if ($function == 'edit') {
                                                            if ($dc->client_id == $data_sales_officer->client_id) {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?>        
                                                                >
                                                                    <?php echo $dc->client_name; ?>
                                                        </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>   
                                <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Email</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                            </span>
                                            <input name="email" 
                                                   id="userEmail"
                                                   type="email" 
                                                   class="form-control" 
                                                   value="<?php
                                                   if ($function == 'edit') {
                                                       echo $data_sales_officer->sales_officer_email;
                                                   }
                                                   ?>"
                                                   placeholder="Email"
                                                   required
                                                   > 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3"><?php
                                        if ($function == 'edit') {
                                            echo "Change ";
                                        }
                                        ?>Password</label>
                                    <div class="col-md-9">
                                        <input name="password" type="password" placeholder="Password" class="form-control" <?php
                                        if ($function == 'add') {
                                            echo "required";
                                        }
                                        ?>> </div>
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Address</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-map-pin"></i>
                                            </span>
                                            <textarea name="address" 
                                                      class="form-control"
                                                      required
                                                      ><?php
                                                          if ($function == 'edit') {
                                                              echo $data_sales_officer->sales_officer_address;
                                                          }
                                                          ?></textarea> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <?php
                                        if ($function == 'edit') {
                                            ?>
                                            <button type="submit" class="btn green">Save</button>
                                            <?php
                                        } else {
                                            ?>
                                            <button type="submit" class="btn green">Add</button>
                                            <?php
                                        }
                                        ?>
                                        <button id="btn-save-multi" style="display: none;" type="button" class="btn blue">Save</button>
                                        <button onclick="location.href = '<?php echo base_url('team/sales_team'); ?>'" type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"> </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>