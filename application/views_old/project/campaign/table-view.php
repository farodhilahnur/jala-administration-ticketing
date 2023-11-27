<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
            <thead>
                <tr>
                    <th> # </th>
                    <th> Picture </th>
                    <th> Name </th>
                    <th> Channels </th>
                    <th> Leads </th>
                    <th> Detail </th>
                    <th> Status </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $role_id = $this->MainModels->UserSession('role_id');
                if (!empty($data_campaign_filter)) {
                    $no = 1;
                    $this->load->model('ChannelModels');
                    $this->load->model('LeadModels');
                    foreach ($data_campaign_filter as $dc) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><img style="max-width:150px;" class="img-responsive" src="<?php echo $dc->campaign_picture; ?>"></td>
                            <td><?php echo $dc->campaign_name; ?></td>
                            <td style="text-align:center;"><a class="badge badge-primary" href="<?php echo base_url('channel/?campaign_id=' . $dc->id); ?>"><?php echo count($this->ChannelModels->getDataChannelLeadbyCampaignIdDash($dc->id)); ?></a></td>
                            <td style="text-align:center;"><a class="badge badge-primary" href="<?php echo base_url('lead/?campaign_id=' . $dc->id); ?>"><?php echo count($this->LeadModels->getDataLeadbyCampaignId($dc->id)); ?></a></td>
                            <td><?php echo $dc->campaign_detail; ?></td>
                            <td>
                                <?php
                                if ($role_id == 1 || $role_id == 2) {
                                    $onclick_inactive = base_url('main_function/set_status/?id=' . $dc->id . '&tbl_name=tbl_campaign&status=0&param1=' . $project_id);
                                    $onclick_active = base_url('main_function/set_status/?id=' . $dc->id . '&tbl_name=tbl_campaign&status=1&param1=' . $project_id);
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
                                <?php
                                if ($role_id == 2) {
                                    ?>
                                    <button class="btn btn-info btn-xs btnEditCampaign"
                                            data-toggle="modal" href="#edit"
                                            id="editCampaign-<?php echo $dc->id; ?>"
                                            data-id="<?php echo $dc->id; ?>"
                                            >
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <?php
                                }
                                ?>
                                <?php
                                if ($role_id == 1) {
                                    ?>
                                    <a href="<?php echo base_url('main_function/delete_data?id=' . $dc->id . '&tbl_name=tbl_campaign'); ?>"
                                       style="text-decoration: none ;"
                                       class="btn btn-danger btn-xs"
                                       onclick="return confirm('Are you sure to delete this Campaign ?')"
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
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>