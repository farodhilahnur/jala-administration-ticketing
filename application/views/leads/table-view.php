<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <?php
        $data = array('total' => $total);
        $this->load->view('project/leads/table_filter', $data);
        ?>
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
            <thead>
                <tr>
                    <th> # </th>
                    <th id="leadNameHeader"> Name </th>
                    <th id="leadAddressHeader"> Address </th>
                    <th id="leadCategoryHeader"> Category </th>
                    <th id="leadStatusHeader"> Status </th>
                    <th id="leadSalesTeamHeader"> Sales Team </th>
                    <th id="leadSalesOfficerHeader"> Sales Officer </th>
                    <th id="leadCampaignHeader"> Campaign </th>
                    <th id="leadChannelHeader"> Channel </th>
                    <th id="leadProductHeader"> Product </th>
                    <th id="leadDateHeader"> Created </th>
                    <th id="leadLastUpdateHeader"> Updated </th>
                    <th id="leadNoteHeader"> Note </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $role_id = $this->MainModels->UserSession('role_id');
                if (!empty($data_lead)) {
                    $no = 1;
                    foreach ($data_lead as $key => $dl) {
                        ?>
                        <tr>    
                            <td><?php echo $no++; ?></td>
                            <td id="leadNameField-<?php echo $key; ?>"><?php echo $dl->lead_name . "<br><b><i>" . $dl->lead_phone . "</b</i>" . "<br><b><i>" . $dl->lead_email . "</b</i>"; ?></td>
                            <td id="leadAddressField-<?php echo $key; ?>"><?php echo $dl->lead_address . "<br><b><i>" . $dl->kota_name . "</b></i>"; ?></td>
                            <td id="leadCategoryField-<?php echo $key; ?>"><?php echo '<label class="label label-md label-' . $dl->color . '"> <span class="icon ' . $dl->icon . '"></span>&nbsp;' . $dl->category_name . '</label>'; ?></td>
                            <td id="leadStatusField-<?php echo $key; ?>">
                                <button class="btn btn-default btn-xs btnShowHistoryLead"
                                        data-toggle="modal" href="#history"
                                        id="showHistory-<?php echo $dl->lead_id; ?>"
                                        data-id="<?php echo $dl->lead_id; ?>"
                                        >
                                            <?php echo $dl->status_name; ?>
                                </button>
                            </td>
                            <td id="leadSalesTeamField-<?php echo $key; ?>"><?php echo $dl->sales_team_name; ?></td>
                            <td id="leadSalesOfficerField-<?php echo $key; ?>"><?php echo $dl->sales_officer_name; ?></td>
                            <td id="leadCampaignField-<?php echo $key; ?>"><?php echo $dl->campaign_name; ?></td>
                            <td id="leadChannelField-<?php echo $key; ?>"><?php echo $dl->channel_name; ?></td>
                            <td id="leadProductField-<?php echo $key; ?>"><?php echo $dl->product_name; ?></td>
                            <td id="leadDateField-<?php echo $key; ?>"><?php echo $dl->create_date; ?></td>
                            <td id="leadLastUpdateField-<?php echo $key; ?>"><?php echo $dl->update_date; ?></td>
                            <td id="leadNoteField-<?php echo $key; ?>"><?php echo $dl->note; ?></td>
                            <td>
                                <button class="btn btn-warning btn-xs btnFollowUp"
                                        data-toggle="modal" href="#follow-up"
                                        id="followUpLead-<?php echo $dl->lead_id; ?>"
                                        data-id="<?php echo $dl->lead_id; ?>"
                                        >
                                    <i class="fa fa-bars"></i>
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
$this->load->view('project/leads/follow-up');
$this->load->view('project/leads/history');
