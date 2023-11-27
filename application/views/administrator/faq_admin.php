<?=$this->session->flashdata('pesan');?>
<style>
.button1 {background-color: #0079BF; color:white;}
.button2 {background-color: #FF78CB; color:white;}
.button3 {background-color: #4CAF50; color:white;} 

</style>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> <?php echo $title; ?>FAQ </span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                    </div>
                </div>
            </div>
            
            <div class="portlet-body">
                <!-- <form action="<?php echo base_url(). 'faq_admin/tambah_data'; ?>" method="post"> -->
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Title </th>
                            <th> Client </th>
                            <th> Category </th>
                            <th> Problem </th>
                            <th> Status </th>
                            <th> Due Date </th>
                            <th> Image </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1;foreach ($tampil_category as $kat): ?>
                        <tr>
                            <td><?=$no++?></td>
                            <td><?=$kat->title?></td>
                            <td><?=$kat->email?><br><b><i><?=$kat->client_name?></td>
                            <td>
                                <?php
                                    if ($kat->category == 'Jala Dashboard') {
                                        echo '<button class="btn btn-xs button1">Jala Dashboard</button>';
                                    } else if ($kat->category == 'Jala Assistant') {
                                        echo '<button class="btn btn-xs button2">Jala Assistant</button>';
                                    } else if ($kat->category == 'Billing') {
                                        echo '<button class="btn btn-xs button3">Billing</button>';
                                    } else {
                                        echo '';
                                    }
                                    
                                ?>    
                            </td>
                            <td>
                            <!-- <?=$kat->detail?> -->
                            <div id=”kotak”>
                             
                              <?php  
                              $artikel=$kat->detail;
                              $cut=substr($artikel,0,80);
                              echo $cut;
                              ?>
                                <a href="#modaltext" data-toggle="modal" onclick="tm_detail('<?=$kat->id?>')" style="padding:5px;">ReadMore</a>  
                              </div>
                            </td>
                           
                            <td>
                              <?php 
                                if ($kat->status == '1') {
                                    echo '<button class="btn btn-xs btn-danger">Pending</button>';
                                } else if ($kat->status == '2') {
                                    echo '<button class="btn btn-xs btn-warning">On Progress</button>';
                                } else if ($kat->status == '3') {
                                    echo '<button class="btn btn-xs btn-success">Done</button>';
                                } else {
                                    echo '';
                                }
                                ?>       
                            </td> 
                            <td> 
                            <?=$kat->due_date?>
                            
                            </td>
                            <td>
                            <?php
                            if($kat->image3 == NULL && $kat->image2 == NULL){
                              echo '
                              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal" onclick="tm_detail('.$kat->id.')">
                              <img style="max-width:100px;width:100%;" src="'.base_url('assets/picture/faq/' . $kat->image).'" alt="" class="img-responsive">
                              </button><br><br>
                              ';
                            } elseif($kat->image3 == NULL){
                              echo '
                              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal" onclick="tm_detail('.$kat->id.')">
                              <img style="max-width:100px;width:100%;" src="'.base_url('assets/picture/faq/' . $kat->image).'" alt="" class="img-responsive">
                              </button><br><br>

                              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal2" onclick="tm_detail('.$kat->id.')">
                              <img style="max-width:100px;width:100%;" src="'.base_url('assets/picture/faq/' . $kat->image2).'" alt="" class="img-responsive">
                              </button><br><br>
                              ';                      
                            } else {
                              echo '
                              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal" onclick="tm_detail('.$kat->id.')">
                              <img style="max-width:100px;width:100%;" src="'.base_url('assets/picture/faq/' . $kat->image).'" alt="" class="img-responsive">
                              </button><br><br>

                              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal2" onclick="tm_detail('.$kat->id.')">
                              <img style="max-width:100px;width:100%;" src="'.base_url('assets/picture/faq/' . $kat->image2).'" alt="" class="img-responsive">
                              </button><br><br>

                              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal3" onclick="tm_detail('.$kat->id.')">
                              <img style="max-width:100px;width:100%;" src="'.base_url('assets/picture/faq/' . $kat->image3).'" alt="" class="img-responsive">
                              </button><br><br>
                              ';
                            }
                                    
                                  ?>      
                            </td>        
                                
                            <td>
                                <a href="#update_admin" class="btn btn-info" data-toggle="modal" onclick="tm_detail('<?=$kat->id?>')" style="padding:5px;"><i class="fa fa-pencil"></i></a>
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

<!-- Modal -->
<div class="modal fade" id="update_admin">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Update</h4>
      </div>
      <div class="modal-body">
        <form action="<?=base_url('index.php/Faq_admin/update_admin')?>" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id">
          <input id="email"  name="email" class="form-control" type="hidden"><br>
          <br>
         
          <!-- <input id="status" type="text" name="status" class="form-control"> -->
          <select name="status"  id="status" class="form-control">

            <option value="1">Pending</option>

            <option value="2">On Progress</option>

            <option value="3">Done</option>

            </select>

          <br>
          <input id="due_date" type="date" name="due_date" class="form-control" hidden="hidden" pk="1"><br>
          <button type="button" class="btn btn-default" data-dismiss="modal" style="float:right; margin:5px">Close</button>
          <input type="submit" name="simpan" value="Submit" class="btn btn-success" style="float:right; margin:5px">
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
               
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"></h4>
	      </div>
	      <div class="modal-body">
          <form action="<?=base_url('index.php/')?>" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id"> 
          <img id="image" name="image" style="width: 100%;height: 100%;" class="img-responsive">
        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>	
	      </div>
	    </div>
	  </div>
	</div>
  <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"></h4>
	      </div>
	      <div class="modal-body">
          <form action="<?=base_url('index.php/Faq_admin/update_admin')?>" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id"> 
          <img id="image2" name="image2" style="width: 100%;height: 100%;" class="img-responsive">
        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>	
	      </div>
	    </div>
	  </div>
	</div>
  <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"></h4>
	      </div>
	      <div class="modal-body">
          <form action="<?=base_url('index.php/Faq_admin/update_admin')?>" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id"> 
          <img id="image3" name="image3" style="width: 100%;height: 100%;" class="img-responsive">
        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>	
	      </div>
	    </div>
	  </div>
	</div>

  <div class="modal fade" id="modaltext" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"></h4>
	      </div>
	      <div class="modal-body">
          <form action="<?=base_url('index.php')?>" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id"> 
          <textarea rows="20" id="detail" type="text"  name="detail" class="form-control" ></textarea><br>
        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>	
	      </div>
	    </div>
	  </div>
	</div>

<script>
  
  function tm_detail(id) {
    $.getJSON("<?=base_url()?>index.php/Faq_admin/get_detail_admin/"+id,function(data){
        $("#id").val(data['id']);
        $("#email").val(data['email']);
        $("#detail").val(data['detail']);
        $("#status").val(data['status']);
        $("#due_date").val(data['due_date']);
        $("#image").attr('src',`assets/picture/faq/${data['image']}`)
        $("#image2").attr('src',`assets/picture/faq/${data['image2']}`)
        $("#image3").attr('src',`assets/picture/faq/${data['image3']}`)
    });
  }

</script>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
   $("#status").change(function () {
    var selected_option = $('#status').val();

    if (selected_option === '2') {
      $('#due_date').attr('pk','1').show();
    }
    if (selected_option != '2') {
      $("#due_date").removeAttr('pk').hide();
    }
  })
</script>
<!-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal2" onclick="tm_detail('<?=$kat->id?>')">
                                    <img style="max-width:100px;width:100%;" src="<?php echo base_url('assets/picture/faq/' . $kat->image2); ?>" alt="" class="img-responsive">
                                </button> -->
