<div class="modal fade" id="add" tabindex="-1" role="add" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Lead Migration Form</h4>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">
                    <form enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('team/migrate'); ?>" role="form" method="post">
                        <div class="form-body">
                            <div class="form-group">
                                <label style="text-align: left;" class="col-md-12 control-label">Who do you want to migrate lead ?</label>
                                <br>
                            </div>
                            <div class="form-group">
                                <div class="col-md-9">
                                    <div class="radio-list">
<!--                                        <label class="radio-inline">
                                            <div class="radio" id="uniform-optionsRadios25">
                                                <span class="checked"><input type="radio" name="migrateWho" id="selectAllSalesOfficer" value="all-sales-officer" checked=""></span>
                                            </div> All Sales Officer 
                                        </label>-->
                                        <label class="radio-inline">
                                            <div class="radio" id="uniform-optionsRadios26">
                                                <span class=""><input type="radio" name="migrateWho" id="selectSalesOfficer" value="custom-sales-officer" checked=""></span>
                                            </div> Select Sales Officer 
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="divSelectSalesOfficer" class="form-group">
<!--                                <div class="col-md-12" id="optionSelectSalesOfficer">-->
<!--                                    <div class="row" id="">-->
                                        <div class="col-md-12">
                                            <select name="list_sales_officer_id[]" id="optionSelectSalesOfficer" class="form-control">
                                                <option value="0">--select sales officer--</option>
        
                                            </select>
                                        </div>
<!--                                    </div>-->
<!--                                </div>-->
                            </div>
                            <div class="form-group">
                                <label style="text-align: left;" class="col-md-12 control-label">What kind of lead do you want to migrate ?</label>
                                <br>
                            </div>
                            <div class="form-group">
                                <div class="col-md-9">
                                    <div class="radio-list">
                                        <label class="radio-inline">
                                            <div class="radio" id="uniform-optionsRadios1">
                                                <span class="checked"><input type="radio" name="migrateHow" id="leadByCategory" value="by-category" checked="" ></span>
                                            </div> Per Category 
                                        </label>
<!--                                        <label class="radio-inline">
                                            <div class="radio" id="uniform-optionsRadios2">
                                                <span class=""><input type="radio" name="migrateHow" id="leadByStatus" value="by-status" ></span>
                                            </div> Per Status 
                                        </label>-->
                                    </div>
                                </div>
                            </div>
                            <div id="divCategory" class="form-group">
                                <div class="row">
                                    <?php
                                    if (!empty($data_category)) {
                                        foreach ($data_category as $dc) {
                                            ?>
                                            <div class="col-md-4">
                                                <div class="checkbox">
                                                    <label><input name="category[]" type="checkbox" value="<?php echo $dc->lead_category_id; ?>"><?php echo $dc->category_name; ?></label>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="col-md-4">
                                        <div class="checkbox">
                                            <label><input name="category[]" type="checkbox" value="0">All</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="display: none;" id="divStatus" class="form-group">
                                <div class="row">
                                    <?php
                                    if (!empty($data_status)) {
                                        foreach ($data_status as $ds) {
                                            ?>
                                            <div class="col-md-4">
                                                <div class="checkbox">
                                                    <label><input name="status[]" type="checkbox" value="<?php echo $ds->status_name; ?>"><?php echo $ds->status_name; ?></label>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <input type="text" id="salesOfficerIdMigrate" name="sales_officer_id" value="">
                        <div style="background-color: white ; " class="form-actions right">
                            <button type="submit" class="btn green">Migrate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




