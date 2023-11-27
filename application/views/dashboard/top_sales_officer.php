<div class="tab-pane active" id="tab_5_1">
    <!-- BEGIN ACCORDION PORTLET-->
    <div class="portlet-body">
        <div class="panel-group accordion" id="accordion1">
            <?php
            if (!empty($data_sales_officer)) {
                $jumlah_point = array();

                foreach ($data_sales_officer as $value_total) {
                    $point = $value_total->point;
                    array_push($jumlah_point, $point);
                }

                $jum_point = array_sum($jumlah_point);

                foreach ($data_sales_officer as $key => $value) {

                    $int_point = intval($value->point);

                    if ($int_point != 0) {
                        $percent = ceil(intval($int_point) / $jum_point * 100);
                    } else {
                        $percent = 0;
                    }
                    ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $value->sales_officer_id; ?>" href="#collapse_<?php echo $value->sales_officer_id; ?>">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <?php
                                            echo "<b>" . $value->sales_officer_name . "</b>";
                                            ?>
                                        </div>
                                        <div class="col-md-9">   
                                            <div class="row"></div>
                                            <div class="col-md-3">
                                                <p style="font-size:15px;">Total Points : <?php echo intval($value->point); ?> </p> 
                                            </div>
                                            <div class="col-md-9">
                                                <div style="margin-bottom:0px !important;" class="progress-point">
                                                    <div class="progress-bar progress-bar-danger" 
                                                         role="progressbar" 
                                                         aria-valuenow="40" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100" 
                                                         style="width: <?php echo $percent . "%"; ?>"
                                                         >
                                                        <span class=""> <?php echo intval($value->point); ?> </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse_<?php echo $value->sales_officer_id; ?>" class="panel-collapse 
                        <?php
                        if ($key == 0) {
                            echo "in";
                        } else {
                            echo "collapse";
                        }
                        ?>
                             ">
                            <div class="panel-body">
                                <ul class="list-group">

                                    <?php
                                    $jumlead = array();

                                    $this->db->select('count(a.lead_id) as lead_total, b.status_name');
                                    $this->db->join('tbl_status b', 'a.status_id = b.id');
                                    $this->db->group_by('a.status_id');
                                    $data_lead_agent = $this->db->get_where('tbl_lead a', array('a.sales_officer_id' => $value->sales_officer_id))->result();

                                    foreach ($data_lead_agent as $value_jum) {
                                        array_push($jumlead, $value_jum->lead_total);
                                    }

                                    $jumleadtotal = array_sum($jumlead);

                                    foreach ($data_lead_agent as $value_lead) {

                                        $jumlah_lead = intval($value_lead->lead_total);
                                        $color = $this->db->get_where('tbl_master_status', array('status_name' => $value_lead->status_name))->row('color');
                                        $percent = $jumlah_lead / intval($jumleadtotal) * 100;
                                        ?>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-3">

                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row"></div>
                                                    <div class="col-md-3">
                                                        <?php echo $value_lead->status_name; ?>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div style="margin-bottom:0px !important;" class="progress">
                                                            <div class="progress-bar progress-bar-info" 
                                                                 role="progressbar" 
                                                                 aria-valuenow="40" 
                                                                 aria-valuemin="0" 
                                                                 aria-valuemax="100" 
                                                                 style="background-color: <?php echo $color; ?> ;
                                                                 width: <?php echo $percent . "%"; ?>">
                                                                <span class=""><?php echo intval($value_lead->lead_total); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <!-- END ACCORDION PORTLET-->
</div>