<div class="tab-pane" id="tab_5_2">
    <!-- BEGIN ACCORDION PORTLET-->
    <div class="portlet-body">
        <div class="panel-group accordion" id="accordion1">
            <?php
            if (!empty($data_top_sales_team)) {

                $jumlah_point = array();

                foreach ($data_top_sales_team as $value_total) {
                    $point = $value_total['points'];
                    array_push($jumlah_point, $point);
                }

                $jum_point = array_sum($jumlah_point);

                foreach ($data_top_sales_team as $key => $value) {

                    $int_point = intval($value['points']);

                    if ($int_point != 0) {
                        $percent = ceil(intval($int_point) / $jum_point * 100);
                    } else {
                        $percent = 0;
                    }
                    ?>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $value['group_id']; ?>" href="#collapse_<?php echo $value['group_id']; ?>">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <?php
                                            echo "<b>" . ucfirst($value['group_name']) . "</b>";
                                            ?>
                                        </div>
                                        <div class="col-md-9">   
                                            <div class="row"></div>
                                            <div class="col-md-3">
                                                <p style="font-size:15px;">Total Points : <?php echo intval($value['points']); ?> </p> 
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
                                                        <span class=""> <?php echo intval($value['points']); ?> </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </h4>
                        </div>
                        <div id="collapse_<?php echo $value['group_id']; ?>" class="panel-collapse <?php
                        if ($key == 0) {
                            echo "in";
                        } else {
                            echo "collapse";
                        }
                        ?>"
                             >
                            <!--<div class="panel-body">
                                <?php
                                /*$jumlead = array();
                                $agentId = array();

                                $get_date_agent = $this->db->get_where('tbl_sales_', array('group_id' => $value['group_id']))->result();

                                foreach ($get_date_agent as $value_agent) {
                                    array_push($agentId, $value_agent->agent_id);
                                }

                                $this->db->select('count(a.lead_id) as lead_total, b.status_name, b.color');
                                $this->db->join('tbl_status b', 'a.current_status = b.status_id');
                                $this->db->group_by('a.current_status');
                                $this->db->where_in('a.agent_id', $agentId);
                                $data_lead_agent = $this->db->get('tbl_lead a')->result();
                                
                                foreach ($data_lead_agent as $value_jum) {
                                    array_push($jumlead, $value_jum->lead_total);
                                }

                                $jumleadtotal = array_sum($jumlead);

                                foreach ($data_lead_agent as $value_lead) {

                                    $jumlah_lead = intval($value_lead->lead_total);
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
                                                             style="background-color:<?php echo $value_lead->color; ?>;
                                                             width: <?php echo $percent . "%"; ?>">
                                                            <span class=""><?php echo intval($value_lead->lead_total); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }*/
                                ?>
                            </div>-->
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