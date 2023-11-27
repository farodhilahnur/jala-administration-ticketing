<style>
    td {text-align: center}
</style>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="row">
            <div class="col-md-12">
                <?php
                $data = array('total' => $total);
                $this->load->view('project/leads/table_filter', $data);
                ?>
            </div>
            <div class="col-md-12" style="overflow-x:auto;">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_4">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th id="leadNameHeader"> Name </th>
                            <th id="leadPhoneHeader"> Phone </th>
                            <th id="leadEmailHeader"> Email </th>
                            <th id="leadAddressHeader"> Address </th>
                            <th id="leadCategoryHeader"> Category </th>
                            <th id="leadStatusHeader"> Status </th>
                            <th id="leadSalesTeamHeader"> Sales Team </th>
                            <th id="leadSalesOfficerHeader"> Sales Officer </th>
                            <th id="leadCampaignHeader"> Campaign </th>
                            <th id="leadChannelHeader"> Channel </th>
                            <th style="display:none;" id="leadProductHeader"> Product </th>
                            <th id="leadDateHeader"> Created </th>
                            <th id="leadLastUpdateHeader"> Updated </th>
                            <th style="display:none;" id="leadNoteHeader"> Note </th>
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
                                    <td id="leadNameField-<?php echo $key; ?>"><?php echo $dl['lead_name']; ?></td>
                                    <td id="leadPhoneField-<?php echo $key; ?>"><?php echo $dl['lead_phone']; ?></td>
                                    <td id="leadEmailField-<?php echo $key; ?>"><?php echo $dl['lead_email']; ?></td>
                                    <td id="leadAddressField-<?php echo $key; ?>"><?php echo $dl['lead_address'] . "<br><b><i>" . $dl['kota_name'] . "</b></i>"; ?></td>
                                    <td id="leadCategoryField-<?php echo $key; ?>"><?php echo '<label class="label label-md label-' . $dl['color'] . '"> <span class="icon ' . $dl['icon'] . '"></span>&nbsp;' . $dl['category_name'] . '</label>'; ?></td>
                                    <td id="leadStatusField-<?php echo $key; ?>">
                                        <a class="btn btn-default btn-xs btnShowHistoryLead"
                                                href="<?= base_url() ?>lead/leadHistory/?id=<?= $dl['lead_id'] ?>"
                                                id="showHistory-<?php echo $dl['lead_id']; ?>"
                                                data-id="<?php echo $dl['lead_id']; ?>"
                                                >
                                                    <?php echo $dl['status_name']; ?>
                                        </a>
                                        <p><i class=""><?php echo $dl['last_history']; ?></i></p>
                                        <?php
//                                        $leads = $this->LeadModels->getHistoryLead($dl->lead_id);
//                                        if (!empty($leads)) {
//                                            echo '<i class="">' . $leads . '</i>';
//                                        }
                                        ?>
                                    </td>
                                    <td id="leadSalesTeamField-<?php echo $key; ?>"><?php echo $dl['sales_team_name']; ?></td>
                                    <td id="leadSalesOfficerField-<?php echo $key; ?>"><?php echo $dl['sales_officer_name']; ?></td>
                                    <td id="leadCampaignField-<?php echo $key; ?>"><?php echo $dl['campaign_name']; ?></td>
                                    <td id="leadChannelField-<?php echo $key; ?>"><?php echo $dl['channel_name']; ?></td>
                                    <td style="display:none;" id="leadProductField-<?php echo $key; ?>"><?php echo $dl['product_name']; ?></td>
                                    <td id="leadDateField-<?php echo $key; ?>"><?php echo $dl['create_date']; ?></td>
                                    <td id="leadLastUpdateField-<?php echo $key; ?>"><?php echo $dl['update_date']; ?></td>
                                    <td style="display:none;" id="leadNoteField-<?php echo $key; ?>"><?php echo $dl['note']; ?></td>
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
$this->load->view('project/leads/follow-up');
$this->load->view('project/leads/history');
