<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-social-dribbble font-purple-soft"></i>
            <span class="caption-subject font-purple-soft bold uppercase"><?php echo $data_product->product_name; ?></span>
        </div>
    </div>
    <div class="portlet-body">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_1_1" data-toggle="tab" aria-expanded="true"> Detail </a>
            </li>
            <li class="">
                <a href="#tab_1_2" data-toggle="tab" aria-expanded="false"> Picture </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="tab_1_1">
                <div class="portlet light bordered">
                    <div class="portlet-body form">
                        <form class="form-horizontal" enctype="multipart/form-data" method="post" role="form">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" name="product_name" class="form-control" value="<?php echo $data_product->product_name; ?>" placeholder="Product Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Price</label>
                                    <div class="col-md-3">
                                        <input type="number" name="product_price" class="form-control" value="<?php echo $data_product->product_price; ?>" placeholder="Product Price">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Detail Indonesia</label>
                                    <div class="col-md-9">
                                        <textarea name="product_detail_id" class="form-control"><?php echo $data_product->product_detail; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Detail Inggris</label>
                                    <div class="col-md-9">
                                        <textarea name="product_detail_en" class="form-control"><?php echo $data_product->product_detail_en; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Location</label>
                                    <div class="col-md-9">
                                        <input type="text" name="location" class="form-control" value="<?php echo $data_product->location; ?>" placeholder="Location">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Kamar Tidur</label>
                                    <div class="col-md-2">
                                        <input type="number" name="kamar_tidur" class="form-control" value="<?php echo $data_product->kamar_tidur; ?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Kamar Mandi</label>
                                    <div class="col-md-2">
                                        <input type="number" name="kamar_mandi" class="form-control" value="<?php echo $data_product->kamar_mandi; ?>" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Cover</label>
                                    <div class="col-md-9">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <img src="<?php echo $data_product->cover; ?>" alt="" /> </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                            <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" name="cover"> </span>
                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden"name="project_id" value="<?php echo $data_product->project_id; ?>">
                                <input type="hidden"name="product_id" value="<?php echo $data_product->id; ?>">
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Submit</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab_1_2">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption col-md-6">
                            <span class="caption-subject bold uppercase"></span>
                        </div>
                        <div style="text-align: right;" class="col-md-6">
                            <div class="btn-group">
                                <button id="sample_editable_1_new" data-toggle="modal" href="#add-product-pic" type="button" class="btn red btn-md"><i class="fa fa-plus"></i> Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <?php
                            if (!empty($data_product_image)) {
                                foreach ($data_product_image as $dpi) {
                                    ?>
                                    <div class="col-md-4 ">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                                                <div class="actions">
                                                    <a href="javascript:;" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i></a>
                                                    <button data-toggle="modal" href="#detail-product-pic" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-eye"></i></button>
                                                </div>
                                            </div>
                                            <div style="background-image: url('<?php echo $dpi->image_link; ?>');height: 200px;
                                                 background-size: cover;
                                                 background-repeat: no-repeat;
                                                 background-position: center top;" 
                                                 class="portlet-body"
                                                 >

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
<?php $this->load->view('project/add_product_pic'); ?>
<?php $this->load->view('project/detail_product_pic'); ?>