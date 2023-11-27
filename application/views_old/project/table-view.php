<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
            <thead>
                <tr>
                    <th> # </th>
                    <th id="leadNameHeader"> Name </th>
                    <th id="leadAddressHeader"> Detail </th>
                    <th id="leadCategoryHeader"> Created </th>
                    <th id="leadStatusHeader"> Status </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $role_id = $this->MainModels->UserSession('role_id');
                if (!empty($data_project)) {
                    $no = 1;
                    foreach ($data_project as $key => $dl) {
                        ?>
                        <tr>    
                            <td><?php echo $no++; ?></td>
                            <td id="leadNameField-<?php echo $key; ?>">
                                <?php echo $dl->project_name ; ?>
                            </td>
                            <td id="leadAddressField-<?php echo $key; ?>">
                                <?php echo $dl->project_detail ; ?>
                            </td>     
                            <td id="leadCategoryField-<?php echo $key; ?>"><?php echo $dl->create_at ; ?></td>
                            <td id="leadStatusField-<?php echo $key; ?>">
                                <?php
                                if ($role_id == 1 || $role_id == 2) {
                                    $onclick_inactive = base_url('main_function/set_status/?id=' . $dl->id . '&tbl_name=tbl_project&status=0');
                                    $onclick_active = base_url('main_function/set_status/?id=' . $dl->id . '&tbl_name=tbl_project&status=1');
                                } else {
                                    $onclick_inactive = "";
                                    $onclick_active = "";
                                }

                                if ($dl->status == 1) {
                                    ?><button onclick="location.href = '<?php echo $onclick_inactive; ?>'"  class="btn btn-xs btn-success">Active</button><?php
                                } else {
                                    ?><button onclick="location.href = '<?php echo $onclick_active; ?>'" class="btn btn-xs btn-danger">Inactive</button><?php
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
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<?php
$this->load->view('project/leads/follow-up');
$this->load->view('project/leads/history');
