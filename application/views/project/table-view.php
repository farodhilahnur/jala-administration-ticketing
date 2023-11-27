<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_4">
            <thead>
            <tr>
                <th> #</th>
                <th id="leadNameHeader"> Name</th>
                <th id="leadAddressHeader"> Detail</th>
                <th> Campaign</th>
                <th> Channel</th>
                <th> Leads</th>
                <th> Product</th>
                <th id="leadCategoryHeader"> Start Date</th>
                <th id="leadStatusHeader"> Status</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $role_id = $this->MainModels->UserSession('role_id');
            if (!empty($data_project)) {
                $no = 1;
                foreach ($data_project as $key => $dp) {
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td id="leadNameField-<?php echo $key; ?>">
                            <?php echo $dp->project_name; ?>
                        </td>
                        <td id="leadAddressField-<?php echo $key; ?>">
                            <?php echo $dp->project_detail; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php
                            $count_campaign = count($this->CampaignModels->getDataCampaignbyProjectId($dp->id));
                            ?>
                            <button onclick="campaignDetail(<?php echo $dp->id; ?>)"
                                    class="btn btn-info btn-xs"><?php echo $count_campaign; ?></button>
                        </td>
                        <td style="text-align: center;">
                            <?php
                            $count_channel = count($this->ChannelModels->getChannelbyProjectId($dp->id));
                            ?>
                            <button onclick="channelDetail(<?php echo $dp->id; ?>)"
                                    class="btn btn-info btn-xs"><?php echo $count_channel; ?></button>
                        </td>
                        <td style="text-align: center;">
                            <?php
                            $count_lead = count($this->LeadModels->getDataLeadbyProjectId($dp->id));
                            ?>
                            <button onclick="leadDetail(<?php echo $dp->id; ?>)"
                                    class="btn btn-info btn-xs"><?php echo $count_lead; ?></button>
                        </td>
                        <td style="text-align: center;">
                            <?php
                            $count_product = count($this->ProductModels->getDataProductByProjectId($dp->id));
                            ?>
                            <button onclick="productDetail(<?php echo $dp->id; ?>)"
                                    class="btn btn-info btn-xs"><?php echo $count_product; ?></button>
                        </td>
                        <td id="leadCategoryField-<?php echo $key; ?>"><?php echo $dp->date; ?></td>
                        <td id="leadStatusField-<?php echo $key; ?>">
                            <?php
                            if ($role_id == 1 || $role_id == 2) {
                                $onclick_inactive = base_url('main_function/set_status/?id=' . $dp->id . '&tbl_name=tbl_project&status=0');
                                $onclick_active = base_url('main_function/set_status/?id=' . $dp->id . '&tbl_name=tbl_project&status=1');
                            } else {
                                $onclick_inactive = "";
                                $onclick_active = "";
                            }

                            if ($dp->status == 1) {
                                ?>
                            <button onclick="location.href = '<?php echo $onclick_inactive; ?>'"
                                    class="btn btn-xs btn-success">Running</button><?php
                            } else {
                                ?>
                            <button onclick="location.href = '<?php echo $onclick_active; ?>'"
                                    class="btn btn-xs btn-danger">Stop</button><?php
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
