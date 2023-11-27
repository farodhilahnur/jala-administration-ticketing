<div class="modal fade" id="edit" tabindex="-1" role="add" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Form Edit</h4>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">
                    <form class="form-horizontal" action="<?php echo $action_edit; ?>" role="form" method="post">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email</label>
                                <div class="col-md-9">
                                    <input id="editUserEmail" type="text" name="username" class="form-control userEmail" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Password</label>
                                <div class="col-md-9">
                                    <input id="editUserPassword" type="password" name="password" class="form-control" required>
                                </div>
                            </div>
                            <input type="hidden" name="user_id" id="editUserId" value="">
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
