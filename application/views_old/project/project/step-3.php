<div class="tab-pane" id="tab3">
    <h3 class="block">Provide what you want to tracking</h3>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-success">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <h3 class="panel-title">Available Status</h3>
                    </div>
                    <div class="panel-body">
                        <p> Check the status list if you want to use and uncheck if you don't use</p>
                    </div>
                    <ul class="list-group">
                        <?php
                        $status_default = array(1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 12, 14);
                        if ($data_master_status) {
                            foreach ($data_master_status as $dms) {
                                $js_id = lcfirst(str_replace(" ", "", $dms->status_name));
                                $name = strtolower(str_replace(" ", "", $dms->status_name));
                                ?>
                                <li class="list-group-item"> 
                                    <label>
                                        <input id="<?php echo $js_id; ?>" type="checkbox" name="<?php echo $name ?>" value="1" <?php if (in_array($dms->id, $status_default)){ echo "checked" ; } ?> /> <?php echo $dms->status_name; ?>
                                    </label>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-warning">
                    <!-- Default panel contents -->
                    <div class="panel-heading">
                        <h3 class="panel-title">Your Status</h3>
                    </div>
                    <div class="panel-body">
                        <p> You also create your own status and set the point </p>
                    </div>
                    <ul id="list-custom-status" class="list-group">
                        <li id='new-leads-list' class='list-group-item'>
                            <div class='form-group'>
                                <div class='col-md-5'>
                                    <input type='text' class='form-control' value='New Leads' name='status_name[]' readonly/>
                                </div>
                                <div class='col-md-3'>
                                    <input type='number' class='form-control' name='point[]' value="0" required/>
                                </div>
                            </div>
                        </li>
                        <li id='interest-list' class='list-group-item'>
                            <div class='form-group'>
                                <div class='col-md-5'>
                                    <input type='text' class='form-control' value='Interest' name='status_name[]' readonly/>
                                </div>
                                <div class='col-md-3'>
                                    <input type='number' class='form-control' name='point[]' value="5" required/>
                                </div>
                            </div>
                        </li>
                        <li id='walk-in-list' class='list-group-item'>
                            <div class='form-group'>
                                <div class='col-md-5'>
                                    <input type='text' class='form-control' value='Walk In' name='status_name[]' readonly/>
                                </div>
                                <div class='col-md-3'>
                                    <input type='number' class='form-control' name='point[]' value="10" required/>
                                </div>
                            </div>
                        </li>
                        <li id='reservation-list' class='list-group-item'>
                            <div class='form-group'>
                                <div class='col-md-5'>
                                    <input type='text' class='form-control' value='Reservation' name='status_name[]' readonly/>
                                </div>
                                <div class='col-md-3'>
                                    <input type='number' class='form-control' name='point[]' value="15" required/>
                                </div>
                            </div>
                        </li>
                        <li id='booking-list' class='list-group-item'>
                            <div class='form-group'>
                                <div class='col-md-5'>
                                    <input type='text' class='form-control' value='Booking' name='status_name[]' readonly/>
                                </div>
                                <div class='col-md-3'>
                                    <input type='number' class='form-control' name='point[]' value="20" required/>
                                </div>
                            </div>
                        </li>
                        <li id='closing-list' class='list-group-item'>
                            <div class='form-group'>
                                <div class='col-md-5'>
                                    <input type='text' class='form-control' value='Closing' name='status_name[]' readonly/>
                                </div>
                                <div class='col-md-3'>
                                    <input type='number' class='form-control' name='point[]' value="100" required/>
                                </div>
                            </div>
                        </li>
                        <li id='interest-but-not-now-list' class='list-group-item'>
                            <div class='form-group'>
                                <div class='col-md-5'>
                                    <input type='text' class='form-control' value='Interest but Not Now' name='status_name[]' readonly/>
                                </div>
                                <div class='col-md-3'>
                                    <input type='number' class='form-control' name='point[]' value="1" required/>
                                </div>
                            </div>
                        </li>
                        <li id='not-interest-list' class='list-group-item'>
                            <div class='form-group'>
                                <div class='col-md-5'>
                                    <input type='text' class='form-control' value='Not Interest' name='status_name[]' readonly/>
                                </div>
                                <div class='col-md-3'>
                                    <input type='number' class='form-control' name='point[]' value="1" required/>
                                </div>
                            </div>
                        </li>
                        <li id='callback-list' class='list-group-item'>
                            <div class='form-group'>
                                <div class='col-md-5'>
                                    <input type='text' class='form-control' value='Callback' name='status_name[]' readonly/>
                                </div>
                                <div class='col-md-3'>
                                    <input type='number' class='form-control' name='point[]' value="0" required/>
                                </div>
                            </div>
                        </li>
                        <li id='no-response-list' class='list-group-item'>
                            <div class='form-group'>
                                <div class='col-md-5'>
                                    <input type='text' class='form-control' value='No Response' name='status_name[]' readonly/>
                                </div>
                                <div class='col-md-3'>
                                    <input type='number' class='form-control' name='point[]' value="0" required/>
                                </div>
                            </div>
                        </li>
                        <li id='inactive-list' class='list-group-item'>
                            <div class='form-group'>
                                <div class='col-md-5'>
                                    <input type='text' class='form-control' value='Inactive' name='status_name[]' readonly/>
                                </div>
                                <div class='col-md-3'>
                                    <input type='number' class='form-control' name='point[]' value="0" required/>
                                </div>
                            </div>
                        </li>
                        <li id='invalid-list' class='list-group-item'>
                            <div class='form-group'>
                                <div class='col-md-5'>
                                    <input type='text' class='form-control' value='Invalid' name='status_name[]' readonly/>
                                </div>
                                <div class='col-md-3'>
                                    <input type='number' class='form-control' name='point[]' value="0" required/>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>