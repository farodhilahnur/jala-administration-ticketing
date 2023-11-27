<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> Form User </span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                        <?php
                        if ($this->MainModels->userSession('role_id') == 1 || $this->MainModels->userSession('role_id') == 2 ) {
                            ?>
                            <button id="sample_editable_1_new"
                                    data-toggle="modal" href="#add"
                                    class="btn sbold red"> Add New
                                <i class="fa fa-plus"></i>
                            </button>
                            <?php
                        }
                        ?>
                      <!--<button onclick="location.href = '<?php echo base_url('master_data/export_excel/?d=' . strtolower($this->uri->segment(2))); ?>'" class="btn sbold green"> Export Excel
                          <i class="fa fa-file-excel-o"></i>
                      </button>-->
                    </div>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Email </th>
                            <th> Role </th>
                            <th> Status </th>
                            <th> Create At </th>
                            <th> Update At </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $session = $this->session->userdata('user');
                        if (!empty($data_user)) {
                            $no = 1;
                            foreach ($data_user as $du) {
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $du->email; ?></td>
                                    <td>
                                        <?php
                                        switch ($du->role_id) {
                                            case 1:
                                                ?><label class="label label-xs label-default">Neo</label><?php
                                                break;
                                            case 2:
                                                ?><label class="label label-xs label-default">Client</label><?php
                                                break;
                                            case 3:
                                                ?><label class="label label-xs label-default">Sales Team</label><?php
                                                break;
                                            case 4:
                                                ?><label class="label label-xs label-default">Sales Officer</label><?php
                                                break;
                                            case 5:
                                                ?><label class="label label-xs label-default">Admin</label><?php
                                                break;
                                            default:
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($session['role_id'] == 1) {
                                            $onclick_inactive = base_url('main_function/set_status/?id=' . $du->user_id . '&tbl_name=tbl_user&status=0');
                                            $onclick_active = base_url('main_function/set_status/?id=' . $du->user_id . '&tbl_name=tbl_user&status=1');
                                        } else {
                                            $onclick_inactive = "";
                                            $onclick_active = "";
                                        }

                                        if ($du->status == 1) {
                                            ?><button onclick="location.href = '<?php echo $onclick_inactive; ?>'"  class="btn btn-xs btn-success">Active</button><?php
                                        } else {
                                            ?><button onclick="location.href = '<?php echo $onclick_active; ?>'" class="btn btn-xs btn-danger">Inactive</button><?php
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $du->create_at; ?></td>
                                    <td><?php echo $du->update_at; ?></td>
                                    <td>
                                        <button class="btn btn-info btn-xs btnEditUser"
                                                data-toggle="modal" href="#edit"
                                                id="editUser-<?php echo $du->user_id; ?>"
                                                data-id="<?php echo $du->user_id; ?>"
                                                >
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <?php
                                        if ($session['role_id'] == 1) {
                                            ?>
                                            <a href="<?php echo base_url('main_function/delete_data?id=' . $du->user_id . '&tbl_name=tbl_user'); ?>"
                                               style="text-decoration: none ;"
                                               class="btn btn-danger btn-xs"
                                               onclick="return confirm('Are you sure to delete this user ?')"
                                               >
                                                <span class="fa fa-trash"></span>
                                            </a>
                                            <?php
                                        }
                                        ?>
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
$this->load->view('user/form-add');
$this->load->view('user/form-edit');
