<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_6">
            <thead>
                <tr>
                    <th> # </th>
                    <th> Picture </th>
                    <th> Name </th>
                    <th> Participated Team </th>
                    <th> Leads </th>
                    <th> Click </th>
                    <th> Tracking Url </th>    
                    <th> Status </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $role_id = $this->MainModels->UserSession('role_id');
                if (!empty($data_channel)) {
                    $this->load->model('LeadModels');
                    $no = 1;
                    foreach ($data_channel as $dc) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><img style="max-width:100px;width:100%;" class="img-responsive" src="<?php echo $dc->channel_picture; ?>"></td>
                            <td><?php echo $dc->channel_name; ?></td>
                            <td>
                                <div class="panel-group accordion" id="accordion3">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled collapsed" 
                                                   data-toggle="collapse" 
                                                   data-parent="#accordion3" 
                                                   href="#collapse_<?php echo $dc->id; ?>" 
                                                   aria-expanded="false"> Sales Team </a>
                                            </h4>
                                        </div>
                                        <div id="collapse_<?php echo $dc->id; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body">
                                                <ul class="list-group">
                                                    <?php
                                                    $this->load->model('ChannelModels');
                                                    $data_sales_team_channel = $this->ChannelModels->getParticipateDealerbyChannelId($dc->id);
                                                    foreach ($data_sales_team_channel as $dstc) {
                                                        ?>
                                                        <li class='list-group-item'><?php echo $dstc->sales_team_name; ?></li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align:center;">   
                                <?php if ($this->MainModels->UserSession('role_id') == 2) {
                                    ?>
                                    <a class="badge badge-primary" href="<?php echo base_url('lead/?channel_id=' . $dc->id); ?>">
                                        <?php echo count($this->LeadModels->getLeadByChannelId($dc->id)); ?>
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <a class="badge badge-primary">
                                        <?php echo count($this->LeadModels->getLeadByChannelId($dc->id)); ?>
                                    </a>
                                    <?php
                                }
                                ?>
                            </td>
                            <td style="text-align:center;"><a class="badge badge-primary"><?php echo $dc->channel_click; ?></a></td>
                            <td>
                                <a style="width: 100%; max-width: 350px;" href="<?php echo $dc->channel_url . "/?q=" . $dc->unique_code; ?>" target='_blank' type="button" class="btn btn-xs btn-default">
                                    <?php echo $dc->channel_url . '/?q=' . $dc->unique_code; ?>
                                </a>
                            </td>
                            <td>
                                <?php
                                if ($role_id == 1 || $role_id == 2) {
                                    $onclick_inactive = base_url('main_function/set_status/?id=' . $dc->id . '&tbl_name=tbl_channel&status=0&param1=' . $project_id);
                                    $onclick_active = base_url('main_function/set_status/?id=' . $dc->id . '&tbl_name=tbl_channel&status=1&param1=' . $project_id);
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
                                    <!--                                    <button class="btn btn-info btn-xs btnEditChannel"
                                                                                data-toggle="modal" href="#edit"
                                                                                id="editChannel-<?php echo $dc->id; ?>"
                                                                                data-id="<?php echo $dc->id; ?>"
                                                                                >
                                                                            <i class="fa fa-pencil"></i>
                                                                        </button>        -->
                                    <button class="btn btn-info btn-xs" onclick="location.href = '<?php echo base_url('project_new/edit_channel_new/?id=' . $dc->id); ?>'">
                                        <i class="fa fa-pencil"></i>
                                    </button>
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