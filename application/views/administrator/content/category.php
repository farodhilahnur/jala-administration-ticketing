<?=$this->session->flashdata('pesan');?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> <?php echo $title; ?>CATEGORY </span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                        <!-- <button onclick="location.href = '<?php echo base_url('category/add_category'); ?>'" id="sample_editable_1_new"
                                class="btn sbold red"> Add New
                            <i class="fa fa-plus"></i>
                        </button> -->
                        <a href="#add" data-toggle="modal" class="btn btn-danger">Add New
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
                            <th> Icon </th>
                            <th> Color </th>
                            <th> Mobile Icon </th>
                            <th> Background </th>
                            <th> Urutan </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=0;foreach ($tampil_category as $kat): $no++;?>
                        <tr>
                            <td><?=$kat->lead_category_id?></td>
                            <td><?=$kat->category_name?></td>
                            <td><?=$kat->icon?></td>
                            <td><button class="btn btn-xs" style="color:white;background-color: <?php echo $kat->color; ?>"><?php echo $kat->color; ?></td>
                            <td><img style="max-width:70px;width:100%;" class="img-responsive" src="<?php echo base_url('assets/picture/mobile/' . $kat->mobile_icon); ?>"></td>
                            <td><button class="btn btn-xs" style="color:white;background-color: <?php echo $kat->background_color; ?>"><?php echo $kat->background_color; ?></td>
                            <td><?=$kat->urutan?></td>
                            <td>
                                        <!-- <button>
                                            <a href="#edit" data-toggle="modal" onclick="edit('<?=$kat->a?>')">
                                                <i class="fa fa-pencil"></i>
                                            </a>    
                                        </button>     -->
                                        <a href="#update_category" class="btn btn-info" style="padding:5px;" data-toggle="modal" onclick="tm_detail('<?=$kat->lead_category_id?>')"><i class="fa fa-pencil"></i></a>
                                        <!-- <a href="<?php echo base_url('index.php/category/hapus_category/'.$kat->lead_category_id)?>"  onclick="return confirm('Are you sure to delete ?')" class="btn btn-danger" style="padding:6px;"><span class="fa fa-trash"></span></a> -->

                                        
                            </td>
                        </tr>
		                <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

<!-- form add  -->
<div class="modal fade" id="add" tabindex="-1" role="add" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Form Category</h4>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">
                    <form enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('category/add_category'); ?>" role="form" method="post">
                        <div class="form-body">
                            
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-9">
                                    <input type="text" name="category_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Background</label>
                                <div class="col-md-9">
                                <input type="text" name="background_color" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Icon</label>
                                <div class="col-md-9">
                                <input type="text" name="icon" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Color</label>
                                <div class="col-md-9">
                                <input type="text" name="color" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Urutan</label>
                                <div class="col-md-9">
                                <input type="number" name="urutan" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Mobile Icon</label>
                                <div class="col-md-9">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <img id="box" style="width: 50%;height: 50%;"/>
                                       <div>
                                            
                                                <span class="fileinput-new"></span>
                                                <input type="file" name="category_picture" id="input">                                      
                                        </div>
                                    </div>
                                </div>
                            </div>                        
                        </div>
                      
                        <div style="background-color: white ; " class="form-actions right">
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- form edit -->
<div class="modal fade" id="update_category">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Form Edit</h4>
      </div>
      <div class="modal-body">
        <div class="portlet-body form">
        <form action="<?=base_url('index.php/category/update_category')?>" method="post" enctype="multipart/form-data">
          <input type="hidden" name="lead_category_id" id="lead_category_id">
          
          <div class="form-group">
            <label class="col-md-3 control-label" for="nama" style="padding-top:20px; text-align:right;">Nama</label>
            <div class="col-md-9" style="padding-top:20px">
            <input id="update__name" type="text" name="category_name" class="form-control"></div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label" for="nama" style="padding-top:20px; text-align:right;">Icon</label>
            <div class="col-md-9" style="padding-top:20px">
            <input id="icon" type="text" name="icon" class="form-control"></div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label" for="nama" style="padding-top:20px; text-align:right;">Color</label>
            <div class="col-md-9" style="padding-top:20px">
            <input id="color" type="text" name="color" class="form-control"></div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label" for="nama" style="padding-top:20px; text-align:right;">Background</label>
            <div class="col-md-9" style="padding-top:20px">
            <input id="background_color" type="text" name="background_color" class="form-control">
            </div>
          </div>
           <div class="form-group">
            <label class="col-md-3 control-label" for="nama" style="padding-top:20px; text-align:right;">Urutan</label>
            <div class="col-md-9" style="padding-top:20px">
            <input id="urutan" type="text" name="urutan" class="form-control">
            </div>
          </div>
          <div class="form-group">
          <label class="col-md-3 control-label" for="gambar" style="padding-top:80px; text-align:right;">Mobile Icon</label>
          <div class="col-md-9" style="padding:40px">
            <img id="update__img" style="width: 50%;height: 50%;" class="img-responsive">
            <input type="file" name="update_img" id="update__image"> </div>
          </div>
          
          <input type="submit" name="simpan" value="Submit" class="btn btn-success" style="float:right; margin:20px;">
        </form>
      </div>
    
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
      </div></div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script>
  
  function tm_detail(lead_category_id) {
    $.getJSON("<?=base_url()?>index.php/category/get_detail_category/"+lead_category_id,function(data){
        $("#lead_category_id").val(data['lead_category_id'])
        // console.log(data['mobile_icon'])
        $("#update__name").val(data['category_name'])
        $("#icon").val(data['icon'])
        $("#color").val(data['color'])
        $("#urutan").val(data['urutan'])
        $("#background_color").val(data['background_color'])
        $("#update__img").attr('src',`assets/picture/mobile/${data['mobile_icon']}`)
    });
  }

</script>

<script type="text/javascript">
inputBox = document.getElementById("input"); // Mengambil elemen tempat Input gambar

 inputBox.addEventListener('change',function(input){ // Jika tempat Input Gambar berubah

  var box = document.getElementById("box"); // mengambil elemen box
  var img = input.target.files; // mengambil gambar

  var reader = new FileReader(); // memanggil pembaca file/gambar
  reader.onload = function(e){ // ketika sudah ada
   box.setAttribute('src',e.target.result); // membuat alamat gambar
  }
  reader.readAsDataURL(img[0]); // menampilkan gambar
 }
);

updateBox = document.getElementById("update__image"); // Mengambil elemen tempat Input gambar
updateBox.addEventListener('change',function(input){ // Jika tempat Input Gambar berubah
  var box = document.getElementById("update__img"); // mengambil elemen box
  var img = input.target.files; // mengambil gambar

  var reader = new FileReader(); // memanggil pembaca file/gambar
  reader.onload = function(e){ // ketika sudah ada
   box.setAttribute('src',e.target.result); // membuat alamat gambar
  }
  reader.readAsDataURL(img[0]); // menampilkan gambar
 }
);
</script>
