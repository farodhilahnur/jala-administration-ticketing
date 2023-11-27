<div class="row">
    <?php
    $role_id = $this->MainModels->UserSession('role_id');
    if (!empty($data_channel)) {
        $this->load->model('ChannelModels');
        foreach ($data_channel as $dc_g) {
            $data_lead = $this->db->get_where('tbl_lead', array('channel_id' => $dc_g->id))->result();
            $count_lead = count($data_lead);
            ?>
            <div class="col-md-4 ">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=""></i> <?php echo $dc_g->channel_name; ?></div>
                        <div class="actions">
                            <div class="btn-group">
                                <?php if ($role_id == 1) {
                                    ?>
                                    <a class="btn btn-danger btn-sm" href="javascript:;">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                <?php }
                                ?>
                                <?php if ($role_id == 2) {
                                    ?>
                                    <button class="btn btn-info btn-sm btnEditChannel"
                                            data-toggle="modal" href="#edit"
                                            id="editChannel-<?php echo $dc_g->id; ?>"
                                            data-id="<?php echo $dc_g->id; ?>"
                                            >
                                        <i class="fa fa-pencil"></i>
                                    </button>    
                                    <?php }
                                ?>           
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div style="width:100%;height:200px;background:url('<?php echo $dc_g->channel_picture; ?>') no-repeat center / contain ; " class="thumbnail">
                                    <!--<img src="<?php echo base_url('assets/picture/channel/' . $dc_g->channel_picture); ?>" alt="100%x200" style="width: 100%; height: 200px; display: block;" data-src="../assets/global/plugins/holder.js/100%x200">-->
                                </div>
                                <div class="caption">
                                    <p> <?php echo $dc_g->channel_detail; ?> </p>
                                    <p style="text-align:center;">
                                        <?php
                                        if ($role_id == 1 || $role_id == 2) {
                                            $onclick_inactive = base_url('main_function/set_status/?id=' . $dc_g->id . '&tbl_name=tbl_channel&status=0');
                                            $onclick_active = base_url('main_function/set_status/?id=' . $dc_g->id . '&tbl_name=tbl_channel&status=1');
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
                                        <button class="btn btn-danger">Total Leads <i><?php echo " " . $count_lead; ?></i> </button>
                                        <button class="btn btn-warning">Total Clicks <i><?php echo " " . $dc_g->channel_click; ?></i></button>
                                    </p>
                                    <?php
                                    if ($dc_g->channel_media != 3) {
                                        ?>
                                        <table style="border:0;" class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td> Tracking Url </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a style="width: 100%; max-width: 350px;" href="<?php echo $dc_g->channel_url . "/?q=" . $dc_g->unique_code; ?>" target='_blank' type="button" class="btn btn-xs btn-default">
                                                            <?php echo $dc_g->channel_url . '/?q=' . $dc_g->unique_code; ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> Redirect Url </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <button type="button" class="btn btn-xs btn-default"><?php echo $dc_g->channel_redirect_url; ?></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>      
                                        <?php
                                    }
                                    ?>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>   
                                                <th> Participate Dealer </th>
                                            </tr>      
                                        </thead>
                                        <tbody>
                                            <?php
                                            $data_sales_team_channel = $this->ChannelModels->getParticipateDealerbyChannelId($dc_g->id);

                                            if ($data_sales_team_channel) {
                                                foreach ($data_sales_team_channel as $dstc) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $dstc->sales_team_name; ?></td>
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