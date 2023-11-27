<div class="modal fade" id="follow-up" tabindex="-1" role="follow-up" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Form Follow Up </h4>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">
                    <form class="form-horizontal form-follow-up" action="" role="form" method="post">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-9">
                                    <input id="leadName" type="text" name="lead_name" class="form-control" readonly>
                                </div>    
                            </div>
                            <div class="form-group">    
                                <label class="col-md-3 control-label">Phone</label>
                                <div class="col-md-9">
                                    <input id="leadPhone" type="text" name="lead_phone" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Category</label>     
                                <div class="col-md-9">
                                    <select id="lead-category-id" name="lead_category_id" class="form-control">
                                        <option value="">--SELECT LEAD CATEGORY--</option>
                                        <?php
                                        if ($data_lead_category) {
                                            foreach ($data_lead_category as $dlc) {
                                                ?>
                                                <option value="<?php echo $dlc->lead_category_id; ?>"

                                                        >
                                                            <?php echo $dlc->category_name; ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Status</label>
                                <div class="col-md-9">
                                    <select id="status-id" name="status_id" class="form-control">
                                        <option value="">--SELECT LEAD STATUS--</option>
                                        <?php
                                        if ($data_lead_status) {
                                            foreach ($data_lead_status as $dls) {
                                                ?>
                                                <option value="<?php echo $dls->id; ?>"

                                                        >
                                                            <?php echo $dls->status_name; ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Product</label>
                                <div class="col-md-9">
                                    <select name="product_id" class="form-control">
                                        <option value="">--SELECT PRODUCT--</option>
                                        <?php
                                        if ($data_product) {
                                            foreach ($data_product as $dlp) {
                                                ?>
                                                <option value="<?php echo $dlp->id; ?>"

                                                        >
                                                            <?php echo $dlp->product_name; ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Notes</label>
                                <div class="col-md-9">
                                    <textarea name="lead_notes" class="form-control" ></textarea>
                                </div>
                            </div>
                        </div>
                        <input id="leadId" type="hidden" name="lead_id" value="">
                        <input id="salesOfficerIdLead" type="hidden" name="sales_officer_id" value="">
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
