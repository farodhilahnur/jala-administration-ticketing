<?=$this->session->flashdata('pesan');?>
<style>
.fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-question-circle"></i> Support Issue Form </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                
                <form enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('faq/tambah_proses'); ?>" role="form" method="post">
                    <!-- <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Email</label>
                                    <div class="col-md-9">                       
                                            <input type="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                            </div>   
                        </div> -->
                        <!--/row-->
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Category</label>
                                    <div class="col-md-9">             
                                            <select class="form-control" name="category">
                                                <option value="Jala Dashboard">Jala Dashboard</option>
                                                <option value="Jala Assistant">Jala Assistant</option>

                                            </select>            
                                    </div>
                                </div>
                            </div>                           
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Title</label>
                                    <div class="col-md-9">                       
                                            <input type="text" name="title" class="form-control" required>
                                    </div>
                                </div>
                            </div>                           
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Problem</label>
                                    <div class="col-md-9">
                                            <textarea name="detail" 
                                                      class="form-control"
                                                      required cols="50" rows="5"
                                                      ></textarea> 
                                        
                                    </div>
                                </div>
                            </div>                           
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Images</label>
                                    <div class="col-md-9">
                                        <div id="content">        
                                            <div class="card">
                                                <div class="imgWrap">
                                                    <div id="dvPreview"></div> 
                                                </div>
                                                <div class="card-body">
                                                    <!-- <div class="custom-file">
                                                        <input type="file" id="fileupload" class="imgFile custom-file-input" onchange="preview_image();" aria-describedby="inputGroupFileAddon01" name="userfile[]" required multiple>
                                                    </div> -->
                                                    <div class="fileUpload btn btn-default">
                                                        <span>Choose image</span>
                                                        <input type="file" id="fileupload" class="imgFile custom-file-input upload" onchange="preview_image();" aria-describedby="inputGroupFileAddon01" name="userfile[]" required multiple>
                                                    </div><br><br><br>
                                                </div>
                                            </div>                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                       
                                            <!-- <button type="submit" class="btn green">Submit</button> -->
                                            <!-- <a href="after">SUBMIT</a> -->
                                            <!-- <button onclick="location.href = '<?php echo base_url('after'); ?>'" type="button" class="btn green">Submit</button> -->
                                            <button type="submit" class="btn green">Submit</button>

                                        <button id="btn-save-multi" style="display: none;" type="button" class="btn blue">Save</button>
                                        <button onclick="location.href = '<?php echo base_url('faq'); ?>'" type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"> </div>
                        </div>
                    </div>
                    
                </form>
                
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>

<script language="javascript" type="text/javascript">
window.onload = function () {
    var fileUpload = document.getElementById("fileupload");
    fileUpload.onchange = function () {
        if (typeof (FileReader) != "undefined") {
            var dvPreview = document.getElementById("dvPreview");
            dvPreview.innerHTML = "";
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
            for (var i = 0; i < fileUpload.files.length; i++) {
                var file = fileUpload.files[i];
                if (regex.test) { 
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = document.createElement("IMG");
                        img.height = "200";
                        img.width = "300";
                        img.style.padding ="10px";
                        img.src = e.target.result; 
                        dvPreview.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                } 
                // else {
                //     alert(file.name + " is not a valid image file."); 
                //     dvPreview.innerHTML = "";
                //     return false;
                //

            } 
        } else {
            alert("This browser does not support HTML5 FileReader.");
        }
    }
};
</script>