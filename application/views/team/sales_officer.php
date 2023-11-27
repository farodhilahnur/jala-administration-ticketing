<?php
$count = count($data_sales_officer);
$caption = $this->MainModels->getCaption(count($data_sales_officer), 'Sales Officer');
$icon = 'fa fa-user';
$card = $this->ComponentModels->statiscticsCard($count, $caption, $icon, 'big');
?>

<div class="row">
    <div class="col-md-12">
        <div style="background: none;" class="portlet light">
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
                                    <div style="height:200px;display: block;transition: all 0.5s ease 0s;"
                                         class="chart-performances-sales-officer-in col-md-12">
                                        <div id="wait-lead-salesOfficer" style="display: block;">
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
                                        <canvas id="performancesSalesOfficerIn"></canvas>
                                    </div>
                                    <div class="col-md-12">
                                        <form>
                                            <input type="hidden" value="1" id="page" name="page">
                                        </form>
                                        <button id="btn-show-more" style="background: #FF6E66;float: right;"
                                                class="btn btn-md">Show More
                                        </button>
                                        <button id="btn-show-less"
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
                $this->load->view('team/table_filter_sales_officer', $data);
                ?>
                <table class="table table-striped table-bordered table-hover table-checkable order-column"
                       id="sample_1">
                    <thead>
                    <tr>
                        <th> #</th>
                        <th id="salesOfficerNameHeader"> Name <br> Joined</th>
                        <?php
                        if ($this->MainModels->UserSession('role_id') == 1) {
                            ?>
                            <th> Client</th>
                            <?php
                        }
                        ?>
                        <th id="salesOfficerContactHeader"> Contact</th>
                        <th id="salesOfficerLeadsHeader"> Leads</th>
                        <th id="salesOfficerPointsHeader"> Points</th>
                        <th id="salesOfficerSalesTeamHeader"> Sales Team</th>
                        <th id="salesOfficerStatusHeader"> Status</th>
                        <th> Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($data_sales_officer)) {
                        $no = 1;
                        $this->load->model('LeadModels');
                        foreach ($data_sales_officer as $key => $dso) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td id="salesOfficerNameField-<?php echo $key; ?>"><?php echo $dso->sales_officer_name . "<br>" . substr($dso->create_at, 0, 10); ?></td>
                                <td id="salesOfficerContactField-<?php echo $key; ?>">
                                    <?php echo $dso->sales_officer_address . '<br><b>' . $dso->sales_officer_phone . '<br>' . $dso->sales_officer_email . '</b>'; ?>
                                </td>
                                <?php
                                if ($this->MainModels->UserSession('role_id') == 1) {
                                    ?>
                                    <td><?php echo $dso->client_name; ?></td>
                                    <?php
                                }
                                ?>
                                <td id="salesOfficerLeadsField-<?php echo $key; ?>" style="text-align:center;">
                                    <a href="<?php echo base_url('lead/?sales_officer_id=' . $dso->sales_officer_id); ?>">
                                            <span class="badge badge-primary">
                                                <?php
                                                $this->db->select('count(lead_id) as total');
                                                $count_lead = $this->db->get_where('tbl_lead', array('sales_officer_id' => $dso->sales_officer_id))->row('total');
                                                echo $count_lead;
                                                ?>
                                            </span>
                                    </a>
                                </td>
                                <td id="salesOfficerPointsField-<?php echo $key; ?>"
                                    style="text-align:center;"><span
                                            class="badge badge-primary"><?php echo $dso->point; ?></span></td>
                                <td id="salesOfficerSalesTeamField-<?php echo $key; ?>">
                                    <div class="panel-group accordion" id="accordion3">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle accordion-toggle-styled collapsed"
                                                       data-toggle="collapse"
                                                       data-parent="#accordion3"
                                                       href="#collapse_<?php echo $dso->sales_officer_id; ?>"
                                                       aria-expanded="false"> Sales Team </a>
                                                </h4>
                                            </div>
                                            <div id="collapse_<?php echo $dso->sales_officer_id; ?>"
                                                 class="panel-collapse collapse" aria-expanded="false"
                                                 style="height: 0px;">
                                                <div class="panel-body">
                                                    <ul class="list-group">
                                                        <?php
                                                        $data_sales_team = $this->MainModels->getSalesTeamBySalesOfficerId($dso->sales_officer_id);
                                                        foreach ($data_sales_team as $dst) {
                                                            ?>
                                                            <li class='list-group-item'><?php echo $dst->sales_team_name; ?></li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td id="salesOfficerStatusField-<?php echo $key; ?>">
                                    <?php
                                    $onclick_inactive = base_url('main_function/set_status/?id=' . $dso->sales_officer_id . '&tbl_name=tbl_sales_officer&status=0');
                                    $onclick_active = base_url('main_function/set_status/?id=' . $dso->sales_officer_id . '&tbl_name=tbl_sales_officer&status=1');

                                    if ($dso->status == 1) {
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
                                <td>
                                    <button class="btn btn-info btn-xs"
                                            onclick="location.href = '<?php echo base_url('team/edit_sales_officer/?id=' . $dso->sales_officer_id); ?>'"
                                    >
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <?php
                                    if ($count_lead == 0) {
                                        ?>
                                        <a href="<?php echo base_url('team/delete_sales_officer?id=' . $dso->sales_officer_id); ?>"
                                           style="text-decoration: none ;"
                                           class="btn btn-danger btn-xs"
                                           onclick="return confirm('Are you sure to delete this Sales Officer ?')"
                                        >
                                            <span class="fa fa-trash"></span>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                    <button class="btn btn-success btn-xs btnMigration"
                                            data-toggle="modal" href="#add"
                                            id="leadMigration-<?php echo $dso->sales_officer_id; ?>"
                                            data-id="<?php echo $dso->sales_officer_id; ?>"
                                    >
                                        <i class="fa fa-recycle"></i>
                                    </button>
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
<?php $this->load->view('team/lead_migration'); ?>

<!---->
