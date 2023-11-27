<div class="modal fade" id="add-payment" tabindex="-1" role="add-product" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Form Product Picture</h4>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">
                    <form enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('user/add_payment'); ?>" role="form" method="post">
                        <div class="form-body">
                            <div style="display:block;" class="form-group">
                                <label class="col-md-3 control-label">Payment Type</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="type">
                                        <option value="0" selected>-- SELECT TYPE --</option>
                                        <option value="1">OVO</option>
                                        <option value="2">GoPay</option>
                                        <option value="3">DANA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">   
                                <label class="col-md-3 control-label">QR Code</label>
                                <div class="col-md-9">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="" alt="" /> </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"> Select image </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="qr_code"> </span>
                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <input type="hidden"name="client_id" value="<?php echo $client_id; ?>">
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
