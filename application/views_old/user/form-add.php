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
                                <label class="col-md-3 control-label">Email</label>
                                <div class="col-md-9">
                                    <input id="userEmail" type="text" name="username" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Password</label>
                                <div class="col-md-9">
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>
<!--                            <div class="form-group">
                                <label class="col-md-3 control-label">Role</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="role_id">
                                        <option>-- SELECT ROLE --</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Client</option>
                                    </select>
                                </div>
                            </div>-->
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
