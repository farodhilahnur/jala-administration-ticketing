<div class="row">
    <?php
    $role_id = $this->MainModels->UserSession('role_id');
    if (!empty($data_campaign)) {
        foreach ($data_campaign as $dc_g) {
            ?>
            <div style="height: 570px;" class="col-md-4 ">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=""></i> <?php echo $dc_g->campaign_name; ?></div>
                        <div class="actions">
                            <div class="btn-group">
                                <?php if ($role_id == 1) {
                                    ?>
                                    <a class="btn btn-danger btn-sm" href="javascript:;">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                <?php }
                                ?>
                                <button class="btn btn-info btn-sm btnEditCampaign"
                                        data-toggle="modal" href="#edit"
                                        id="editCampaign-<?php echo $dc_g->id; ?>"
                                        data-id="<?php echo $dc_g->id; ?>"
                                        >
                                    <i class="fa fa-pencil"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div style="width:100%;height:200px;background:url('<?php echo $dc_g->campaign_picture; ?>'); no-repeat center contain " class="thumbnail">  
                                    <!--<img src="<?php echo base_url('assets/picture/campaign/' . $dc_g->campaign_picture); ?>" alt="100%x200" style="width: 100%; height: 200px; display: block;" data-src="../assets/global/plugins/holder.js/100%x200">-->

                                </div>
                                <div class="caption">
                                    <p> <?php echo $dc_g->campaign_detail; ?> </p>
                                    <p>
                                        <?php
                                        if ($role_id == 1 || $role_id == 2) {
                                            $onclick_inactive = base_url('main_function/set_status/?id=' . $dc_g->id . '&tbl_name=tbl_campaign');
                                            $onclick_active = base_url('main_function/set_status/?id=' . $dc_g->id . '&tbl_name=tbl_campaign');
                                        } else {
                                            $onclick_inactive = "";
                                            $onclick_active = "";
                                        }

                                        if ($dc_g->status == 1) {
                                            ?><button onclick="location.href = '<?php echo $onclick_inactive; ?>'"  class="btn btn-success">Active</button><?php
                                        } else {
                                            ?><button onclick="location.href = '<?php echo $onclick_active; ?>'" class="btn btn-danger">Inactive</button><?php
                                        }
                                        ?>

                                    </p>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th> Channel </th>          
                                                <th> Total Leads </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $this->load->model('ChannelModels');
                                            $data_channel = $this->ChannelModels->getDataChannelLeadbyCampaignIdDash($dc_g->id);

                                            if ($data_channel) {
                                                foreach ($data_channel as $channel) {
                                                    ?>
                                                    <tr>
                                                        <td> <?php echo $channel['channel_name']; ?> </td>
                                                        <td>
                                                            <span class="badge badge-primary badge-roundless"> <?php echo $channel['total']; ?> </span>
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
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>