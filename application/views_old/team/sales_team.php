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
                                        <span data-counter="counterup" data-value="<?php echo count($data_team); ?>"><?php echo count($data_team); ?></span>
                                        <small class="font-red-haze"><?php echo $this->MainModels->getCaption(count($data_team), 'Team'); ?></small>
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
                                        //]$date = explode(' to ', $session['filter']['date_range']);
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
                                    <span class="caption-subject font-red-sunglo bold uppercase">Top 5 Sales Teams</span>
                                </div>
                            </div>   
                            <div class="portlet-body">
                                <?php
                                if (!empty($data_chart_team)) {
                                    foreach ($data_chart_team as $key => $dct) {
                                        ?>
                                        <div class="panel-group accordion" id="accordion-<?php echo $key; ?>">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion<?php echo $key; ?>" href="#collapse_<?php echo $key; ?>" aria-expanded="false"> 
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <?php echo $dct['sales_team_name']; ?>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div style="margin-bottom:0px !important;" class="progress">
                                                                        <div class="progress-bar progress-bar-success" 
                                                                             role="progressbar" 
                                                                             aria-valuenow="<?php echo $dct['percent']; ?>" 
                                                                             aria-valuemin="0" 
                                                                             aria-valuemax="100" 
                                                                             style="width: <?php echo $dct['percent'] . '%'; ?>"
                                                                             >
                                                                            <span class=""><?php echo $dct['total']; ?></span>
                                                                        </div>    
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1"> <?php echo $dct['percent']; ?>% </div>
                                                            </div>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse_<?php echo $key; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                    <div class="panel-body">
                                                        <?php
                                                        $sales_team_id = $dct['sales_team_id'];

                                                        $data_chart_team_category = $this->LeadModels->getDataLeadBySalesTeamIdCategory($sales_team_id);

                                                        if (!empty($data_chart_team_category)) {
                                                            foreach ($data_chart_team_category as $dctc) {
                                                                ?>
                                                                <li style="border: 0px !important;" class="list-group-item">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="row"></div>
                                                                            <div class="col-md-4">
                                                                                <?php echo $dctc['category_name']; ?>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div style="margin-bottom:0px !important;" class="progress">
                                                                                    <div class="progress-bar progress-bar-<?php echo $dctc['color']; ?>" 
                                                                                         role="progressbar" 
                                                                                         aria-valuenow="<?php echo $dctc['percent']; ?>" 
                                                                                         aria-valuemin="0" 
                                                                                         aria-valuemax="100" 
                                                                                         style="width: <?php echo $dctc['percent'] . '%'; ?>"
                                                                                         >
                                                                                        <span class=""><?php echo $dctc['total']; ?></span>
                                                                                    </div>    
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-1"> <?php echo $dctc['percent']; ?>% </div>
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
                    <span class="caption-subject bold uppercase"> Sales Teams </span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                        <button onclick="location.href = '<?php echo base_url('team/add_sales_team'); ?>'" id="sample_editable_1_new"
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
                $this->load->view('team/table_filter', $data);
                ?>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> # </th>    
                            <th id="salesTeamNameHeader"> Name </th>
                            <?php
                            if ($this->MainModels->UserSession('role_id') == 1) {
                                ?><th> Client </th><?php
                                }
                                ?>
                            <th id="salesTeamCoverageAreaHeader" >Coverage Area</th>
                            <th style="display:none;" id="salesTeamAddressHeader"> Address </th>
                            <th id="salesTeamPICHeader"> PIC <br> Contact </th>
                            <th id="salesTeamSalesOfficerHeader"> Sales <br> Officers </th>
                            <th id="salesTeamLeadsHeader"> Leads </th>
                            <th id="salesTeamChannelHeader"> Channels </th>
                            <th id="salesTeamStatusHeader"> Status </th>
                            <th style="display:none;" id="salesTeamDateHeader"> Created </th>
                            <!--<th> Updated At </th>-->
                            <th> Action </th>
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
                                        ?><td><?php echo $dt->client_name; ?></td><?php
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
                                                <div id="collapse_<?php echo $dt->sales_team_id; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
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
                                    <td id="salesTeamAddressField-<?php echo $key; ?>" style="display:none;"><?php echo $dt->sales_team_address; ?></td>
                                    <td id="salesTeamPICField-<?php echo $key; ?>" ><?php echo '<b>' . $dt->sales_team_pic . "</b><br>" . $dt->sales_team_email . "<br>" . $dt->sales_team_phone; ?></td>
                                    <td id="salesTeamSalesOfficerField-<?php echo $key; ?>" style="text-align:center;">
                                        <a class="badge badge-primary" href="<?php echo base_url('team/sales_officer/?sales_team_id=' . $dt->sales_team_id); ?>">
                                            <?php
                                            echo $this->TeamModels->getCountSalesOfficerbySalesTeamId($dt->sales_team_id);
                                            ?>
                                        </a>
                                    </td>
                                    <td id="salesTeamLeadsField-<?php echo $key; ?>" style="text-align:center;">
                                        <a href="<?php echo base_url('lead/?sales_team_id=' . $dt->sales_team_id); ?>" class="badge badge-primary">
                                            <?php
                                            $list_sales_officer_id = array();

                                            $data_sales_offcier_group = $this->db->get_where('tbl_sales_officer_group', array('sales_team_id' => $dt->sales_team_id))->result();

                                            foreach ($data_sales_offcier_group as $dsog) {
                                                array_push($list_sales_officer_id, $dsog->sales_officer_id);
                                            }

                                            if (!empty($list_sales_officer_id)) {
                                                $this->db->where_in('sales_officer_id', $list_sales_officer_id);
                                                $this->db->select('count(lead_id) as total');
                                                $count_lead = $this->db->get('tbl_lead')->row('total');
                                            } else {
                                                $count_lead = 0;
                                            }

                                            echo $count_lead;
                                            ?>
                                        </a>
                                    </td>
                                    <td id="salesTeamChannelField-<?php echo $key; ?>" style="text-align:center;">
                                        <a class="badge badge-primary" href="<?php echo base_url('channel/?sales_team_id=' . $dt->sales_team_id); ?>">
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
                                            ?><button onclick="location.href = '<?php echo $onclick_inactive; ?>'"  class="btn btn-xs btn-success">Active</button><?php
                                        } else {
                                            ?><button onclick="location.href = '<?php echo $onclick_active; ?>'" class="btn btn-xs btn-danger">Inactive</button><?php
                                        }
                                        ?>
                                    </td>
                                    <td id="salesTeamDateField-<?php echo $key; ?>" style="display: none;">
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
                                            <a href="<?php echo base_url('main_function/delete_data?id=' . $dt->sales_team_id . '&tbl_name=tbl_sales_team'); ?>"
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



