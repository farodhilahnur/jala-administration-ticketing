<div class="row">
    <div class="col-md-12">
        <div class="row">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="col-md-4">
                <!-- PORTLET MAIN -->
                <div class="portlet light profile-sidebar-portlet ">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
                        <img id="previewPic" src="<?php echo $data_profile->picture_link; ?>" class="img-responsive" alt="">

                    </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name"> <?php echo $data_profile->client_name; ?> </div>
                        <div class="profile-usertitle-job"> Company </div>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR BUTTONS -->
                    <!--<div class="profile-userbuttons">
                        <button type="button" class="btn btn-circle green btn-sm">Change Picture</button>
                    </div>-->
                    <!-- END SIDEBAR BUTTONS -->
                    <!-- SIDEBAR MENU -->
                    <div class="profile-usermenu">
                        <!--<ul class="nav">
                            <li>
                                <a href="page_user_profile_1.html">
                                    <i class="icon-home"></i> Overview </a>
                            </li>
                            <li class="active">
                                <a href="page_user_profile_1_account.html">
                                    <i class="icon-settings"></i> Account Settings </a>
                            </li>
                            <li>
                                <a href="page_user_profile_1_help.html">
                                    <i class="icon-info"></i> Help </a>
                            </li>
                        </ul>-->
                    </div>
                    <!-- END MENU -->
                </div>
                <!-- END PORTLET MAIN -->
                <!-- PORTLET MAIN -->
                <div class="portlet light ">
                    <!-- STAT -->
                    <div class="row list-separated profile-stat">
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="uppercase profile-stat-title"> <?php echo $total_project; ?> </div>
                            <div class="uppercase profile-stat-text"> <?php if($total_project > 1){ echo "Projects" ; } else { echo "Project" ; }  ?> </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="uppercase profile-stat-title"> <?php echo $total_sales_team; ?> </div>
                            <div class="uppercase profile-stat-text"> <?php if($total_sales_team > 1){ echo "Sales Teams" ; } else { echo "Sales Team" ; }  ?> </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="uppercase profile-stat-title"> <?php echo $total_sales_officer; ?> </div>
                            <div class="uppercase profile-stat-text"> <?php if($total_sales_officer > 1){ echo "Sales Officers" ; } else { echo "Sales Officer" ; }  ?> </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="uppercase profile-stat-title"> <?php echo $total_lead; ?> </div>
                            <div class="uppercase profile-stat-text"> <?php if($total_lead > 1){ echo "Leads" ; } else { echo "Lead" ; }  ?> </div>
                        </div>
                    </div>
                    <!-- END STAT -->
                    <div>
                        <div class="margin-top-20 profile-desc-link">
                            <i class="fa fa-envelope"></i>
                            <a href=""><?php echo $data_profile->client_email; ?></a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                            <i class="fa fa-map-pin"></i>
                            <a href=""><?php echo $data_profile->client_address; ?></a>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET MAIN -->
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->


            <!-- BEGIN PROFILE CONTENT -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">Info</span>
                                </div>
                                <ul class="nav nav-tabs">
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                    <div class="tab-pane active" id="tab_1_1">
                                        <form role="form" action="<?php echo base_url('user/change_profile'); ?>" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="control-label">Picture</label>
                                                <input onchange="readURL(this);" type="file" name="picture_link" value="" class="form-control" /> </div>
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                <input type="text" name="name" value="<?php echo $data_profile->client_name; ?>" class="form-control" /> </div>
                                            <div class="form-group">
                                                <label class="control-label">Address</label>
                                                <textarea class="form-control" name="address" rows="3"><?php echo $data_profile->client_address; ?></textarea></div>
                                            <div class="form-group">
                                                <label class="control-label">Phone Number</label>
                                                <input type="text" name="phone" value="<?php echo $data_profile->client_phone; ?>" class="form-control" /> </div>
                                            <div class="form-group">
                                                <label class="control-label">PIC</label>
                                                <input type="text" name="pic" value="<?php echo $data_profile->pic; ?>" class="form-control" /> </div>
                                            <div class="form-group">
                                                <label class="control-label">Email</label>
                                                <input type="text" name="email" value="<?php echo $data_profile->client_email; ?>" class="form-control" readonly /> </div>
                                            <div class="form-group">
                                                <label class="control-label">Password</label>
                                                <input type="password" name="password" value="" class="form-control" /> </div>
                                            <div class="margiv-top-10">
                                                <button type="submit" class="btn green"> Save Changes </button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- END PERSONAL INFO TAB -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>