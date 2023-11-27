<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> # </th>
                    <th> Cover </th>
                    <th> Name </th>
                    <th> Price </th>
                    <th> Detail </th>
                    <th> Status </th>
                    <th> Action </th>
                </tr>    
            </thead>
            <tbody>
                <?php
                $role_id = $this->MainModels->UserSession('role_id');
                if (!empty($data_product)) {
                    $no = 1;
                    foreach ($data_product as $dp) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><img style="max-width: 100px;" class="img-responsive" src="<?php echo $dp->cover; ?>"></td>
                            <td><?php echo $dp->product_name; ?></td>
                            <td><?php echo $dp->product_price; ?></td>
                            <td><?php echo $dp->product_detail; ?></td>
                            <td>
                                <?php
                                if ($role_id == 1 || $role_id == 2) {
                                    $onclick_inactive = base_url('main_function/set_status/?id=' . $dp->id . '&tbl_name=tbl_product&status=0&param1=' . $dp->project_id);
                                    $onclick_active = base_url('main_function/set_status/?id=' . $dp->id . '&tbl_name=tbl_product&status=1&param1=' . $dp->project_id);
                                } else {
                                    $onclick_inactive = "";
                                    $onclick_active = "";
                                }

                                if ($dp->status == 1) {
                                    ?><button onclick="location.href = '<?php echo $onclick_inactive; ?>'"  class="btn btn-xs btn-success">Active</button><?php
                                } else {
                                    ?><button onclick="location.href = '<?php echo $onclick_active; ?>'" class="btn btn-xs btn-danger">Inactive</button><?php
                                }
                                ?>
                            </td>
                            <td>
                                <!--                                <button class="btn btn-info btn-xs btnEditProduct"
                                                                        data-toggle="modal" href="#edit"
                                                                        id="editProduct-<?php echo $dp->id; ?>"
                                                                        data-id="<?php echo $dp->id; ?>"
                                                                        >
                                                                    <i class="fa fa-pencil"></i>
                                                                </button>-->
                                <button class="btn btn-warning btn-xs"
                                        onclick="location.href = '<?php echo base_url('product/detail/?id=' . $dp->id); ?>'"
                                        >
                                    <i class="fa fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<?php
$data = array('project_id' => $project_id);
$this->load->view('project/setting/form-edit-product');
$this->load->view('project/setting/form-add-product');
?>