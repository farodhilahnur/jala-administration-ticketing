<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> # </th>
                    <th> Name </th>
                    <th> Point </th>
                    <th> Status </th>
                    <th> Action </th>  
                </tr>
            </thead>
            <tbody>
                <?php
                $role_id = $this->MainModels->UserSession('role_id');
                if (!empty($data_status)) {
                    $no = 1;
                    foreach ($data_status as $ds) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $ds->status_name; ?></td>
                            <td><?php echo $ds->point; ?></td>
                            <td>
                                <?php
                                if ($role_id == 1 || $role_id == 2) {
                                    $onclick_inactive = base_url('main_function/set_status/?id=' . $ds->id . '&tbl_name=tbl_status&status=0&param1=' . $ds->project_id);
                                    $onclick_active = base_url('main_function/set_status/?id=' . $ds->id . '&tbl_name=tbl_status&status=1&param1=' . $ds->project_id);
                                } else {
                                    $onclick_inactive = "";
                                    $onclick_active = "";
                                }

                                if ($ds->status == 1) {
                                    ?><button onclick="location.href = '<?php echo $onclick_inactive; ?>'"  class="btn btn-xs btn-success">Active</button><?php
                                } else {
                                    ?><button onclick="location.href = '<?php echo $onclick_active; ?>'" class="btn btn-xs btn-danger">Inactive</button><?php
                                }
                                ?>
                            </td>
                            <td>
                                <button class="btn btn-info btn-xs btnEditStatus"
                                        data-toggle="modal" href="#edit-status"
                                        id="editStatus-<?php echo $ds->id; ?>"
                                        data-id="<?php echo $ds->id; ?>"
                                        >
                                    <i class="fa fa-pencil"></i>
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
$this->load->view('project/setting/form-edit-status');