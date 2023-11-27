<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> <?php echo $title; ?> </span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                        <button onclick="location.href = '<?php echo base_url('team/add_client'); ?>'" id="sample_editable_1_new"
                                class="btn sbold red"> Add New
                            <i class="fa fa-plus"></i>
                        </button>
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
                            <th> Name </th>
                            <th> Address </th>
                            <th> PIC <br> Contact </th>
                            <th> Status </th>
                            <!--<th> Created At </th>
                            <th> Updated At </th>-->
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $role_id = $this->MainModels->UserSession('role_id');
                        if (!empty($data_client)) {
                            $no = 1;
                            foreach ($data_client as $dc) {
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $dc->client_name; ?></td>
                                    <td><?php echo $dc->client_address; ?></td>
                                    <td><?php echo '<b>' . $dc->pic . "</b><br>" . $dc->client_email . "<br>" . $dc->client_phone; ?></td>
                                    <td>
                                        <?php
                                        if ($role_id == 1 || $role_id == 2) {
                                            $onclick_inactive = base_url('main_function/set_status/?id=' . $dc->client_id . '&tbl_name=tbl_client&status=0');
                                            $onclick_active = base_url('main_function/set_status/?id=' . $dc->client_id . '&tbl_name=tbl_client&status=1');
                                        } else {
                                            $onclick_inactive = "";
                                            $onclick_active = "";
                                        }

                                        if ($dc->status == 1) {
                                            ?><button onclick="location.href = '<?php echo $onclick_inactive; ?>'"  class="btn btn-xs btn-success">Active</button><?php
                                        } else {
                                            ?><button onclick="location.href = '<?php echo $onclick_active; ?>'" class="btn btn-xs btn-danger">Inactive</button><?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-xs"
                                                onclick="location.href = '<?php echo base_url('team/edit_client/?id=' . $dc->client_id); ?>'"
                                                >
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <?php
                                        if ($role_id == 1 || $role_id == 2) {
                                            ?>
                                            <a href="<?php echo base_url('main_function/delete_data?id=' . $dc->client_id . '&tbl_name=tbl_client'); ?>"
                                               style="text-decoration: none ;"
                                               class="btn btn-danger btn-xs"
                                               onclick="return confirm('Are you sure to delete this Client ?')"
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