<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> Payment </span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                        <button id="sample_editable_1_new"
                                data-toggle="modal" href="#add-payment"
                                class="btn sbold red"> Add New
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Type </th>
                            <th> Qr Code </th>
                            <th> Create At </th>
                            <th> Update At </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($data_payment)) {
                            $no = 1;
                            foreach ($data_payment as $dp) {
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <?php
                                        switch ($dp->type) {
                                            case 1:
                                                echo "Ovo";
                                                break;
                                            case 2:
                                                echo "GoPay";
                                                break;
                                            case 3:
                                                echo "DANA";
                                                break;
                                            default:
                                                break;
                                        }  
                                        ?>
                                    </td>
                                    <td><img style="max-width:200px;" class="img-responsive" src="<?php echo $dp->image_link; ?>"></td>
                                    <td><?php echo $dp->create_date; ?></td>
                                    <td><?php echo $dp->update_date; ?></td>
                                    <td>
<!--                                        <button class="btn btn-info btn-xs btnEditUser"
                                                data-toggle="modal" href="#edit"
                                                id="editPayment-<?php echo $dp->id; ?>"
                                                data-id="<?php echo $dp->id; ?>"
                                                >
                                            <i class="fa fa-pencil"></i>-->
                                        </button>
                                        <a href="<?php echo base_url('main_function/delete_data?id=' . $dp->id . '&tbl_name=tbl_payment'); ?>"
                                           style="text-decoration: none ;"
                                           class="btn btn-danger btn-xs"
                                           onclick="return confirm('Are you sure to delete this payment ?')"
                                           >
                                            <span class="fa fa-trash"></span>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<?php
$this->load->view('user/add_payment');
$this->load->view('user/form-edit');
