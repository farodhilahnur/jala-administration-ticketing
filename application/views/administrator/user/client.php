<?=$this->session->flashdata('pesan');?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> <?php echo $title; ?> </span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                        <button onclick="location.href = '<?php echo base_url('user_management/add_client'); ?>'" id="sample_editable_1_new"
                                class="btn sbold red"> Add New
                            <i class="fa fa-plus"></i>
                        </button>
                        <!--<button onclick="location.href = '<?php echo base_url('master_data/export_excel/?d=' . strtolower($this->uri->segment(2))); ?>'" class="btn sbold green"> Export Excel
                          <i class="fa fa-file-excel-o"></i>
                      </button>-->
                    </div>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Name </th>
                            <th> Industry Type </th>
                            <th> Contact </th>
                            <th> Sales Officer </th>
                            <th> Project </th>
                            <th> Status </th>
                            <th> Created At </th>
                            <th> Duration </th>
                            <!--<th> Updated At </th>-->
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $role_id = $this->MainModels->UserSession('role_id');
                        if (!empty($data_client)) {
                            $no = 1;
                            foreach ($data_client as $dc) {
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $dc->client_name; ?></td>
                                    <td>
                                        <?php
                                        switch ($dc->industry_type) {
                                            case 1:
                                                $indutry = '<button class="btn btn-xs btn-success">Property</button>';
                                                break;
                                            case 2 :
                                                $indutry = '<button class="btn btn-xs btn-danger">Education</button>';
                                                break;
                                            case 3 :
                                                $indutry = '<button class="btn btn-xs btn-warning">Automotive</button>';
                                                break;
                                            default:
                                                break;
                                        }
                                        echo $indutry;
                                        ?>
                                    </td>
                                    <td><?php echo $dc->client_email . "<br>" . $dc->client_phone; ?></td>
                                    <td>
                                        <?php $data_so = $this->db->get_where('tbl_sales_officer', array('client_id' => $dc->client_id))->result(); ?>
                                        <a href="" class="btn btn-xs btn-success"><?php echo count($data_so); ?></a>
                                    </td>
                                    <td>
                                        <?php $data_project = $this->db->get_where('tbl_project', array('client_id' => $dc->client_id))->result(); ?>
                                        <a href="" class="btn btn-xs btn-success"><?php echo count($data_project); ?></a>
                                    </td>
                                    <td>
                                        <?php
                                        if ($role_id == 1 || $role_id == 2) {
                                            $onclick_inactive = base_url('main_function/set_status/?id=' . $dc->client_id . '&tbl_name=tbl_client&status=0');
                                            $onclick_active = base_url('main_function/set_status/?id=' . $dc->client_id . '&tbl_name=tbl_client&status=1');
                                        } else {
                                            $onclick_inactive = "";
                                            $onclick_active = "";
                                        }

                                        if ($dc->status == 1) {
                                            ?><button onclick="location.href = '<?php echo $onclick_inactive; ?>'"  class="btn btn-xs btn-success">Active</button><?php
                                        } else {
                                            ?><button onclick="location.href = '<?php echo $onclick_active; ?>'" class="btn btn-xs btn-danger">Inactive</button><?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo substr($dc->create_date, 0, 10); ?>
                                        
                                    </td>
                                    <td>
                                        <!-- <?php echo $dc->duration; ?> -->
                                        <?php echo time_ago($dc->create_date); ?>
                                    </td>
                                    <td>
                                        <!-- <button class="btn btn-info btn-xs"
                                                onclick="location.href = '<?php echo base_url('user_management/edit_client/?id=' . $dc->client_id); ?>'"
                                                >
                                            <i class="fa fa-pencil"></i>
                                        </button> -->
                                        <a href="#update_client" class="btn btn-info" data-toggle="modal" onclick="tm_detail('<?=$dc->client_id?>')" style="padding:5px;"><i class="fa fa-pencil"></i></a>
                                        <?php
                                        if ($role_id == 1 || $role_id == 2) {
                                            ?>
                                            <a href="<?php echo base_url('main_function/delete_data?id=' . $dc->client_id . '&tbl_name=tbl_client'); ?>"
                                               style="text-decoration: none ;"
                                               class="btn btn-danger btn-xs"
                                               onclick="return confirm('Are you sure to delete this Client ?')"
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


<div class="modal fade" id="update_client" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Form Client</h4>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">
                    <form enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('user_management/update_client'); ?>" role="form" method="post">
                    <input type="hidden" name="client_id" id="client_id">
                        <div class="form-body">     
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-9">
                                <input id="client__name" type="text" name="client_name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Address</label>
                                <div class="col-md-9">
                                  <input id="address_update" type="text" name="client_address" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email</label>
                                <div class="col-md-9">
                                  <input id="email_update" type="email" name="client_email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Password</label>
                                <div class="col-md-9">
                                  <input id="password" type="password" name="password" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Phone</label>
                                <div class="col-md-9">
                                  <input id="phone_update" type="text" name="client_phone" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">PIC</label>
                                <div class="col-md-9">
                                  <input id="pic_update" type="text" name="pic" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Industry Type</label>
                                <div class="col-md-9">                             
                                        <select class="form-control" name="industry_type" id="industry_update">
                                            <option value="0" selected>-- SELECT TYPE --</option>
                                            <option value="1">Property</option>
                                            <option value="2">Automotive</option>
                                            <option value="3">Assurance</option>
                                            <option value="4">Other</option>
                                        </select>                                     
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Duration</label>
                                <div class="col-md-9">
                                  <input id="duration_update" type="text" name="duration" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Quota</label>
                                <div class="col-md-9">
                                  <input id="quota_update" type="text" name="quota" class="form-control">
                                </div>
                            </div>
                           
                        </div>
                        <div style="background-color: white ; " class="form-actions right">
                        <input type="submit" name="simpan" value="Submit" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<script>
  
  function tm_detail(client_id) {
    $.getJSON("<?=base_url()?>index.php/user_management/get_detail_client/"+client_id,function(data){
        $("#client_id").val(data['client_id'])
        $("#client__name").val(data['client_name'])
        $("#address_update").val(data['client_address'])
        $("#email_update").val(data['client_email'])
        $("#phone_update").val(data['client_phone'])
        $("#pic_update").val(data['pic'])
        $("#industry_update").val(data['industry_type'])
        $("#duration_update").val(data['duration'])
        $("#quota_update").val(data['quota'])
    });
  }

</script>