<?php
$count = count($data_team);
$caption = $this->MainModels->getCaption(count($data_team), 'Team');
$icon = 'fa fa-users';
$card = $this->ComponentModels->statiscticsCard($count, $caption, $icon, 'big');
?>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light" style="background: none;">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <?php echo $card; ?>
                    </div>

                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="font-red-sunglo"></i>
                                    <span class="caption-subject font-red-sunglo bold uppercase">Top Performance</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div style="height:200px;display: block;"
                                         class="chart-performances-sales-team-in col-md-12">
                                        <div id="wait-lead-salesTeam" style="display: block;">
                                            <svg stroke="#FFB7B3" ; width="50%" height="50%" viewBox="0 0 38 38"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 style="position:absolute;top: 50%;left: 50%; transform: translate(-50%, -50%)">
                                                <g fill="none" fill-rule="evenodd">
                                                    <g transform="translate(1 1)" stroke-width="2">
                                                        <circle stroke-opacity=".5" cx="18" cy="18" r="18"/>
                                                        <path d="M36 18c0-9.94-8.06-18-18-18">
                                                            <animateTransform
                                                                    attributeName="transform"
                                                                    type="rotate"
                                                                    from="0 18 18"
                                                                    to="360 18 18"
                                                                    dur="1s"
                                                                    repeatCount="indefinite"></animateTransform>
                                                        </path>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <canvas id="performancesSalesTeamIn"></canvas>
                                    </div>
                                    <div class="col-md-12">
                                        <form>
                                            <input type="hidden" value="1" id="pageTeam" name="page">
                                        </form>
                                        <button id="btn-show-more-team" style="background: #FF6E66;float: right;"
                                                class="btn btn-md">Show More
                                        </button>
                                        <button id="btn-show-less-team"
                                                style="background: #9B9B9B;float: right;display: none;"
                                                class="btn btn-md">Show Less
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-body">
                <?php
                $data = array('total' => $total);
                $this->load->view('team/table_filter', $data);
                ?>
                <table class="table table-striped table-bordered table-hover table-checkable order-column"
                       id="sample_5">
                    <thead>
                    <tr>
                        <th> #</th>
                        <th id="salesTeamNameHeader"> Name</th>
                        <?php
                        if ($this->MainModels->UserSession('role_id') == 1) {
                            ?>
                            <th> Client</th><?php
                        }
                        ?>
                        <th id="salesTeamCoverageAreaHeader">Coverage Area</th>
                        <th id="salesTeamAddressHeader"> Address</th>
                        <th id="salesTeamPICHeader"> PIC <br> Contact</th>
                        <th id="salesTeamSalesOfficerHeader"> Sales <br> Officers</th>
                        <th id="salesTeamLeadsHeader"> Leads</th>
                        <th id="salesTeamChannelHeader"> Channels</th>
                        <th id="salesTeamStatusHeader"> Status</th>
                        <th id="salesTeamDateHeader"> Created</th>
                        <!--<th> Updated At </th>-->
                        <th> Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $role_id = $this->MainModels->UserSession('role_id');
                    $this->load->model('TeamModels');
                    if (!empty($data_team)) {
                        $no = 1;
                        foreach ($data_team as $key => $dt) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td id="salesTeamNameField-<?php echo $key; ?>"><?php echo $dt->sales_team_name; ?></td>
                                <?php
                                if ($this->MainModels->UserSession('role_id') == 1) {
                                    ?>
                                    <td><?php echo $dt->client_name; ?></td><?php
                                }
                                ?>
                                <td id="salesTeamCoverageAreaField-<?php echo $key; ?>">
                                    <div class="panel-group accordion" id="accordion3">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle accordion-toggle-styled collapsed"
                                                       data-toggle="collapse"
                                                       data-parent="#accordion3"
                                                       href="#collapse_<?php echo $dt->sales_team_id; ?>"
                                                       aria-expanded="false"> Coverage Area </a>
                                                </h4>
                                            </div>
                                            <div id="collapse_<?php echo $dt->sales_team_id; ?>"
                                                 class="panel-collapse collapse" aria-expanded="false"
                                                 style="height: 0px;">
                                                <div class="panel-body">
                                                    <ul class="list-group">
                                                        <?php
                                                        $data_coverage_area = $this->MainModels->getCoverageAreaBySalesTeamId($dt->sales_team_id);
                                                        foreach ($data_coverage_area as $ca) {
                                                            ?>
                                                            <li class='list-group-item'><?php echo $ca->kota_name; ?></li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td id="salesTeamAddressField-<?php echo $key; ?>"
                                    ><?php echo $dt->sales_team_address; ?></td>
                                <td id="salesTeamPICField-<?php echo $key; ?>"><?php echo '<b>' . $dt->sales_team_pic . "</b><br>" . $dt->sales_team_email . "<br>" . $dt->sales_team_phone; ?></td>
                                <td id="salesTeamSalesOfficerField-<?php echo $key; ?>" style="text-align:center;">
                                    <a class="badge badge-primary"
                                       href="<?php echo base_url('team/sales_officer/?sales_team_id=' . $dt->sales_team_id); ?>">
                                        <?php
                                        echo $this->TeamModels->getCountSalesOfficerbySalesTeamId($dt->sales_team_id);
                                        ?>
                                    </a>
                                </td>
                                <td id="salesTeamLeadsField-<?php echo $key; ?>" style="text-align:center;">
                                    <a href="<?php echo base_url('lead/?sales_team_id=' . $dt->sales_team_id); ?>"
                                       class="badge badge-primary">
                                        <?php
                                        $list_sales_officer_id = array();

                                        $data_sales_offcier_group = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $dt->sales_team_id))->result();

                                        foreach ($data_sales_offcier_group as $dsog) {
                                            array_push($list_sales_officer_id, $dsog->sales_officer_id);
                                        }

                                        if (!empty($list_sales_officer_id)) {
                                            $this->db->where_in('a.sales_officer_id', $list_sales_officer_id);
                                            $this->db->select('count(a.lead_id) as total');
                                            $this->db->join('tbl_channel c', 'c.id = a.channel_id');
                                            $this->db->join('tbl_campaign b', 'b.id = c.campaign_id');
                                            $this->db->join('tbl_lead_category e', 'a.lead_category_id = e.lead_category_id');
                                            $this->db->join('tbl_kota h', 'h.kota_id = a.lead_city');
                                            $this->db->join('tbl_sales_officer d', 'a.sales_officer_id = d.sales_officer_id');
                                            $count_lead = $this->db->get('tbl_lead a')->row('total');
                                        } else {
                                            $count_lead = 0;
                                        }

                                        echo $count_lead;
                                        ?>
                                    </a>
                                </td>
                                <td id="salesTeamChannelField-<?php echo $key; ?>" style="text-align:center;">
                                    <a class="badge badge-primary"
                                       href="<?php echo base_url('channel/?sales_team_id=' . $dt->sales_team_id); ?>">
                                        <?php
                                        echo $this->TeamModels->getCountChannelbySalesTeamId($dt->sales_team_id);
                                        ?>
                                    </a>
                                </td>
                                <td id="salesTeamStatusField-<?php echo $key; ?>">
                                    <?php
                                    if ($role_id == 1 || $role_id == 2) {
                                        $onclick_inactive = base_url('main_function/set_status/?id=' . $dt->sales_team_id . '&tbl_name=tbl_sales_team&status=0');
                                        $onclick_active = base_url('main_function/set_status/?id=' . $dt->sales_team_id . '&tbl_name=tbl_sales_team&status=1');
                                    } else {
                                        $onclick_inactive = "";
                                        $onclick_active = "";
                                    }

                                    if ($dt->status == 1) {
                                        ?>
                                    <button onclick="location.href = '<?php echo $onclick_inactive; ?>'"
                                            class="btn btn-xs btn-success">Active</button><?php
                                    } else {
                                        ?>
                                    <button onclick="location.href = '<?php echo $onclick_active; ?>'"
                                            class="btn btn-xs btn-danger">Inactive</button><?php
                                    }
                                    ?>
                                </td>
                                <td id="salesTeamDateField-<?php echo $key; ?>">
                                    <?php echo substr($dt->create_at, 0, 10) ?>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-xs"
                                            onclick="location.href = '<?php echo base_url('team/edit_sales_team/?id=' . $dt->sales_team_id); ?>'"
                                    >
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <?php
                                    if ($role_id == 1 || $role_id == 2) {
                                        ?>
                                        <a href="<?php echo base_url('team/delete_sales_team?id=' . $dt->sales_team_id); ?>"
                                           style="text-decoration: none ;"
                                           class="btn btn-danger btn-xs"
                                           onclick="return confirm('Are you sure to delete this Sales Team ?')"
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



