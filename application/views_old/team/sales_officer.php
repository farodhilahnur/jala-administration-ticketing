<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-graph font-grey-gallery"></i>
                    <span class="caption-subject bold font-grey-gallery uppercase"> Summary </span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"> </a>
                    <a href="" class="fullscreen"> </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="dashboard-stat2 bordered">
                            <div class="display">
                                <div class="number">
                                    <h3 class="font-red-haze">
                                        <span data-counter="counterup" data-value="<?php echo count($data_sales_officer); ?>"><?php echo count($data_sales_officer); ?></span>
                                        <small class="font-red-haze"><?php echo $this->MainModels->getCaption(count($data_sales_officer), 'Sales Officer'); ?></small>
                                    </h3>
                                    <small>TOTAL </small>
                                </div>
                                <div class="icon">
                                    <i class="icon-pie-chart"></i>
                                </div>
                            </div>
                            <div class="progress-info">   
                                <div class="status">
                                    <div class="status-title"> 
                                        <?php
                                        //$date = explode(' to ', $session['filter']['date_range']);
                                        //$new_project_date = date("M d, Y", strtotime($date[0]));
                                        //$new_now_date = date("M d, Y", strtotime($date[1]));
                                        //echo $new_project_date . ' - ' . $new_now_date;
                                        ?> 
                                    </div>
                                </div>      
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="font-red-sunglo"></i>
                                    <span class="caption-subject font-red-sunglo bold uppercase">Top 5 Sales Officers</span>
                                </div>
                            </div>   
                            <div class="portlet-body">
                                <?php
                                if (!empty($data_chart_sales_officer)) {
                                    foreach ($data_chart_sales_officer as $key => $dcso) {
                                        ?>
                                        <div class="panel-group accordion" id="accordion-<?php echo $key; ?>">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion<?php echo $key; ?>" href="#collapse_<?php echo $key; ?>" aria-expanded="false"> 
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <?php echo $dcso['sales_officer_name']; ?>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div style="margin-bottom:0px !important;" class="progress">
                                                                        <div class="progress-bar progress-bar-success" 
                                                                             role="progressbar" 
                                                                             aria-valuenow="<?php echo $dcso['percent']; ?>" 
                                                                             aria-valuemin="0" 
                                                                             aria-valuemax="100" 
                                                                             style="width: <?php echo $dcso['percent'] . '%'; ?>"
                                                                             >
                                                                            <span class=""><?php echo $dcso['total']; ?></span>
                                                                        </div>    
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1"> <?php echo $dcso['percent']; ?>% </div>
                                                            </div>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_<?php echo $key; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                    <div class="panel-body">
                                                        <?php
                                                        $sales_officer_id = $dcso['sales_officer_id'];

                                                        $data_chart_sales_officer_category = $this->LeadModels->getDataLeadBySalesOfficerIdCategory($sales_officer_id);

                                                        if (!empty($data_chart_sales_officer_category)) {
                                                            foreach ($data_chart_sales_officer_category as $dcsc) {
                                                                ?>
                                                                <li style="border: 0px !important;" class="list-group-item">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="row"></div>
                                                                            <div class="col-md-4">
                                                                                <?php echo $dcsc['category_name']; ?>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div style="margin-bottom:0px !important;" class="progress">
                                                                                    <div class="progress-bar progress-bar-<?php echo $dcsc['color']; ?>" 
                                                                                         role="progressbar" 
                                                                                         aria-valuenow="<?php echo $dcsc['percent']; ?>" 
                                                                                         aria-valuemin="0" 
                                                                                         aria-valuemax="100" 
                                                                                         style="width: <?php echo $dcsc['percent'] . '%'; ?>"
                                                                                         >
                                                                                        <span class=""><?php echo $dcsc['total']; ?></span>
                                                                                    </div>    
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-1"> <?php echo $dcsc['percent']; ?>% </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--                                        <li style="border: 0px !important;" class="list-group-item">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="row"></div>
                                                                                            <div class="col-md-4">
                                        <?php echo $dcso['sales_officer_name']; ?>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <div style="margin-bottom:0px !important;" class="progress">
                                                                                                    <div class="progress-bar progress-bar-success" 
                                                                                                         role="progressbar" 
                                                                                                         aria-valuenow="<?php echo $dcso['percent']; ?>" 
                                                                                                         aria-valuemin="0" 
                                                                                                         aria-valuemax="100" 
                                                                                                         style="width: <?php echo $dcso['percent'] . '%'; ?>"
                                                                                                         >
                                                                                                        <span class=""><?php echo $dcso['total']; ?></span>
                                                                                                    </div>    
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-1"> <?php echo $dcso['percent']; ?>% </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>-->
                                        <?php
                                    }
                                }
                                ?>
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
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Sales Officers </span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                        <button onclick="location.href = '<?php echo base_url('team/add_sales_officer'); ?>'" id="sample_editable_1_new"
                                class="btn sbold red"> Add New
                            <i class="fa fa-plus"></i>
                        </button>
<!--                        <button onclick="location.href = '<?php echo base_url('master_data/export_excel/?d=' . strtolower($this->uri->segment(2))); ?>'" class="btn sbold green"> Export Excel
                            <i class="fa fa-file-excel-o"></i>
                        </button>-->
                    </div>
                </div>
            </div>

            <div class="portlet-body">
                <?php
                $data = array('total' => $total);
                $this->load->view('team/table_filter_sales_officer', $data);
                ?>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th id="salesOfficerNameHeader"> Name <br> Joined </th>
                            <?php
                            if ($this->MainModels->UserSession('role_id') == 1) {
                                ?>
                                <th> Client </th>
                                <?php
                            }
                            ?>
                            <th style="display : none ;" id="salesOfficerContactHeader" > Contact</th>    
                            <th id="salesOfficerLeadsHeader" style="text-align:center;"> Leads </th>
                            <th id="salesOfficerPointsHeader" style="text-align:center;"> Points </th>
                            <th id="salesOfficerSalesTeamHeader"> Sales Team </th>
                            <th id="salesOfficerStatusHeader"> Status </th>
                            <th> Action </th>
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
                                    <td style="display : none ;" id="salesOfficerContactField-<?php echo $key; ?>">
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
                                    <td id="salesOfficerPointsField-<?php echo $key; ?>" style="text-align:center;"><span class="badge badge-primary"><?php echo $dso->point; ?></span></td>
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
                                                <div id="collapse_<?php echo $dso->sales_officer_id; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
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
                                            ?><button onclick="location.href = '<?php echo $onclick_inactive; ?>'"  class="btn btn-xs btn-success">Active</button><?php
                                        } else {
                                            ?><button onclick="location.href = '<?php echo $onclick_active; ?>'" class="btn btn-xs btn-danger">Inactive</button><?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-xs"
                                                onclick="location.href = '<?php echo base_url('team/edit_sales_officer/?id=' . $dso->sales_officer_id); ?>'"
                                                >
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <a href="<?php echo base_url('main_function/delete_data?id=' . $dso->sales_officer_id . '&tbl_name=tbl_sales_officer'); ?>"
                                           style="text-decoration: none ;"
                                           class="btn btn-danger btn-xs"
                                           onclick="return confirm('Are you sure to delete this Sales Officer ?')"
                                           >
                                            <span class="fa fa-trash"></span>
                                        </a>
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