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
                       
                        <a href="#tambah" data-toggle="modal" class="btn btn-danger">Add New
                            <i class="fa fa-plus"></i>
                        </a>
                        
                    </div>
                </div>
            </div>

            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Name </th>
                            <th> Detail </th>
                            <th> Detail English </th>
                            <th> Color </th>
                            <th> Status </th>
                            <th> Created At </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($data_status)) {
                            $no = 1;
                            foreach ($data_status as $ds) {
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $ds->status_name; ?></td>
                                    <td><?php echo $ds->detail; ?></td>
                                    <td><?php echo $ds->detail_en; ?></td>
                                    <td>
                                        <button class="btn btn-xs" style="color:white;background-color: <?php echo $ds->color; ?>"><?php echo $ds->color; ?></button>
                                    </td>
                                    <td>
                                        <?php
                                        $onclick_inactive = base_url('main_function/set_status/?id=' . $ds->id . '&tbl_name=tbl_client&status=0');
                                        $onclick_active = base_url('main_function/set_status/?id=' . $ds->id . '&tbl_name=tbl_client&status=1');

                                        if ($ds->status == 1) {
                                            ?><button onclick="location.href = '<?php echo $onclick_inactive; ?>'"  class="btn btn-xs btn-success">Active</button><?php
                                        } else {
                                            ?><button onclick="location.href = '<?php echo $onclick_active; ?>'" class="btn btn-xs btn-danger">Inactive</button><?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo substr($ds->create_at, 0, 10); ?>
                                    </td>
                                    <td>
                                        
                                        <a href="#update_status" class="btn btn-info" data-toggle="modal" onclick="tm_detail('<?=$ds->id?>')" style="padding:5px;"><i class="fa fa-pencil"></i></a>
                                        <!-- <a href="<?php echo base_url('index.php/content_management/hapus_status/'.$ds->id)?>"  onclick="return confirm('Are you sure to delete ?')" class="btn btn-danger" style="padding:6px;"><span class="fa fa-trash"></span></a> -->

                                        
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

<!-- form add -->
<div class="modal fade" id="tambah" tabindex="-1" role="add" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Form Edit</h4>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">
                    <form enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('content_management/tambah'); ?>" role="form" method="post">
                        <div class="form-body">
                            
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-9">
                                    <input type="text" name="status_name" id="status_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Detail</label>
                                <div class="col-md-9">
                                    <input type="text" name="detail" id="detail" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Detail En</label>
                                <div class="col-md-9">
                                    <input type="text" name="detail_en" id="detail_en" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Color</label>
                                <div class="col-md-9">
                                <input type="text" name="color" id="color" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Urutan</label>
                                <div class="col-md-9">
                                <input type="number" name="urutan" id="urutan" class="form-control" required>
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


<div class="modal fade" id="update_status" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Form Category</h4>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">
                    <form enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('content_management/update_status'); ?>" role="form" method="post">
                    <input type="hidden" name="id" id="id">
                        <div class="form-body">     
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-9">
                                <input id="status__name" type="text" name="status_name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Detail</label>
                                <div class="col-md-9">
                                  <input id="detail_update" type="text" name="detail" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Detail En</label>
                                <div class="col-md-9">
                                  <input id="detail_en_update" type="text" name="detail_en" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Color</label>
                                <div class="col-md-9">
                                  <input id="color_update" type="text" name="color" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Urutan</label>
                                <div class="col-md-9">
                                  <input id="urutan_update" type="number" name="urutan" class="form-control">
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
  
  function tm_detail(id) {
    $.getJSON("<?=base_url()?>index.php/content_management/get_detail_status/"+id,function(data){
        $("#id").val(data['id'])
        $("#status__name").val(data['status_name'])
        $("#detail_update").val(data['detail'])
        $("#detail_en_update").val(data['detail_en'])
        $("#color_update").val(data['color'])
        $("#urutan_update").val(data['urutan'])
    });
  }

</script>

