<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
            <thead>
                <tr>
                    <th> # </th>
                    <th> Picture </th>
                    <th> Name </th>
                    <th> Category </th>
                    <th> Status </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($data_media)) {
                    $no = 1;
                    foreach ($data_media as $dm) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><img style="max-width:70px;width:100%;" class="img-responsive" src="<?php echo base_url('assets/picture/media/' . $dm->media_pic); ?>"></td>
                            <td><?php echo $dm->media_name; ?></td>
                            <td>
                                <?php
                                if ($dm->media_category == 1) {
                                    echo "online";
                                } else {
                                    echo "offline";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $onclick_inactive = base_url('main_function/set_status/?id=' . $dm->id . '&tbl_name=tbl_media&status=0');
                                $onclick_active = base_url('main_function/set_status/?id=' . $dm->id . '&tbl_name=tbl_media&status=1');

                                if ($dm->status == 1) {
                                    ?><button onclick="location.href = '<?php echo $onclick_inactive; ?>'"  class="btn btn-xs btn-success">Active</button><?php
                                } else {
                                    ?><button onclick="location.href = '<?php echo $onclick_active; ?>'" class="btn btn-xs btn-danger">Inactive</button><?php
                                }
                                ?>
                            </td>
                            <td>
                                <button class="btn btn-info btn-xs btnEditMedia"
                                        data-toggle="modal" href="#edit"
                                        id="editMedia-<?php echo $dm->id; ?>"
                                        data-id="<?php echo $dm->id; ?>"
                                        >
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <a href="<?php echo base_url('main_function/delete_data?id=' . $dm->id . '&tbl_name=tbl_media'); ?>"
                                   style="text-decoration: none ;"
                                   class="btn btn-danger btn-xs"
                                   onclick="return confirm('Are you sure to delete this Campaign ?')"
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
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>