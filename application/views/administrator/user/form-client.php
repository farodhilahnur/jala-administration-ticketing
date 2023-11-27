<style>.select2-search__field{ width: 100% !important }</style>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-user-plus"></i> Client Form </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="" method="post" class="form-horizontal">
                    <div class="form-body">
                        <div class="row">
                            <?php
                            if ($function == 'edit') {
                                ?>
                                <input name="client_id" type="hidden" value="<?php echo $data_client->client_id; ?>">
                                <input name="user_id" type="hidden" value="<?php echo $data_sales_team->user_id; ?>">
                                <?php
                            }
                            ?>
                        </div>
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Name</label>
                                    <div class="col-md-9">
                                        <input name="name" 
                                               type="text" 
                                               class="form-control"
                                               value="<?php
                                               if ($function == 'edit') {
                                                   echo $data_client->client_name;
                                               }
                                               ?>"
                                               required
                                               > 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">PIC Name</label>
                                    <div class="col-md-9">
                                        <input name="picname" 
                                               type="text" 
                                               placeholder="PIC Name" 
                                               value="<?php
                                               if ($function == 'edit') {
                                                   echo $data_client->client_email;
                                               }
                                               ?>"
                                               class="form-control"
                                               required
                                               > 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                                                       echo $data_sales_team->sales_team_phone;
                                                   }
                                                   ?>"
                                                   placeholder="Phone"
                                                   required
                                                   > 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Industry Type</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="industry_type">
                                            <option value="0" selected>-- SELECT TYPE --</option>
                                            <option value="1">Property</option>
                                            <option value="2">Automotive</option>
                                            <option value="3">Assurance</option>
                                            <option value="4">Other</option>
                                        </select>
                                    </div>       
                                </div>
                            </div>
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
                                                   type="email" 
                                                   class="form-control" 
                                                   value="<?php
                                                   if ($function == 'edit') {
                                                       echo $data_sales_team->sales_team_email;
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
                                                              echo $data_sales_team->sales_team_address;
                                                          }
                                                          ?></textarea> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Duration</label>
                                    <div class="col-md-9">
                                        <input name="duration" 
                                               type="text" 
                                               placeholder="Duration/Month" 
                                               value="<?php
                                               if ($function == 'edit') {
                                                   echo $data_sales_team->sales_team_pic;
                                               }
                                               ?>"
                                               class="form-control"
                                               required
                                               > 
                                    </div>
                                </div>
                            </div>  -->
                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Quota</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            
                                            <input name="quota" 
                                                   type="text" 
                                                   class="form-control" 
                                                   value="<?php
                                                   if ($function == 'edit') {
                                                       echo $data_sales_team->sales_team_phone;
                                                   }
                                                   ?>"
                                                   placeholder="Quota"
                                                   required
                                                   > 
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