<div class="modal fade" id="add" tabindex="-1" role="add" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Form Add</h4>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">
                    <form class="form-horizontal" action="<?php echo $action_add; ?>" role="form" method="post">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-9">
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email</label>
                                <div class="col-md-9">
                                    <input id="userEmail" type="text" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Phone</label>
                                <div class="col-md-9">
                                    <input type="text" name="phone" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Address</label>
                                <div class="col-md-9">
                                    <textarea name="address" class="form-control" ></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Password</label>
                                <div class="col-md-9">
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Role</label>
                                <div class="col-md-9">
                                    <select id="userRoleSelect" class="form-control" name="role_id">
                                        <option value="0">-- SELECT ROLE --</option>
                                        <?php
                                        if (!empty($data_role)) {
                                            foreach ($data_role as $role) {
                                                ?>
                                                <option value="<?php echo $role->role_id; ?>">
                                                    <?php echo $role->role_name; ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>   
                            </div>
                            <div id="industryType" style="display:block;" class="form-group">
                                <label class="col-md-3 control-label">Industry Type</label>
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
                            <div id="projectSelect" style="display:none;" class="form-group">
                                <label class="col-md-3 control-label">Project</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="project_id">
                                        <option value="0" selected>All</option>
                                        <?php
                                        if (!empty($data_project)) {
                                            foreach ($data_project as $project) {
                                                ?>
                                                <option value="<?php echo $project->id; ?>">
                                                    <?php echo $project->project_name; ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div style="background-color: white ; " class="form-actions right">
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>   
    <!-- /.modal-dialog -->
</div>
