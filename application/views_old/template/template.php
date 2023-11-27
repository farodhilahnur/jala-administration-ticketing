<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.5.3
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>
            <?php
            if ($this->uri->segment(1) == '') {
                echo "Jala | Dashboard";
            } else {
                echo 'Jala | ' . ucfirst($this->uri->segment(1));
            }
            ?>
        </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <?php
        if (!empty($css)) {
            foreach ($css as $value) {
                ?>
                <link href="<?php echo base_url() . $value; ?>" rel="stylesheet" type="text/css" />
                <?php
            }
        }
        ?>
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo base_url(); ?>assets/global/css/components-md.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/css/plugins-md.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?php echo base_url(); ?>assets/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/layouts/layout4/css/themes/light.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?php echo base_url(); ?>assets/layouts/layout4/css/custom.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    </head>
    <!-- END HEAD -->

    <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
        <!-- BEGIN HEADER -->
        <?php $this->load->view('template/header'); ?>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <?php $this->load->view('template/sidebar'); ?>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE BREADCRUMB -->
                    <ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="<?php echo base_url($this->uri->segment(1)); ?>"><?php
                                if ($this->uri->segment(1) == '') {
                                    echo "Dashboard";
                                } else {
                                    echo ucfirst($this->uri->segment(1));
                                }
                                ?></a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active"><?php echo str_replace("_", " ", ucfirst($this->uri->segment(2))); ?></span>
                        </li>
                    </ul>
                    <!-- END PAGE BREADCRUMB -->
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <?php echo $this->session->flashdata('message'); ?>
                    <?php echo $body; ?>
                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> 2018 © Jala.ai Lead Management Software. 
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->
        <!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url(); ?>assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                $("#addProduct").click(function () {
                    var id = $(".product-div").attr("data-id");
                    var newId = parseInt(id) + 1;
                    var htmlTwitter = "<div data-id=" + newId + " class='product-div-' " + id + " >" +
                            "<div class='form-group'>" +
                            "<label class='control-label col-md-2'>Product" +
                            "<span class='required'> * </span>" +
                            "</label>" +
                            "<div class='col-md-4'>" +
                            "<input type='text' placeholder='Name' class='form-control' name='product_name' />" +
                            "</div>" +
                            "<div class='col-md-2'>" +
                            "<input type='number' placeholder='Price' class='form-control' name='product-price' />" +
                            "</div>"
                    "<div class='col-md-4'>" +
                            "<input type='text' placeholder='Detail' class='form-control' name='product_detail' />" +
                            "</div>" +
                            "</div>" +
                            "</div>";
                    $(".product-div-wrapper").append(htmlTwitter);
                    $(".product-div").attr("data-id", newId);
                    $("#removeProduct").attr("data-id", newId);
                });
                $("#removeProduct").click(function () {
                    var id = $(this).attr("data-id");
                    $(".product-div-" + id).remove();
                    $("#removeProduct").attr("data-id", id - 1);
                });
            });
            $(document).ready(function () {
                $("#addTwitter").click(function () {
                    var id = $("#kontol").attr("data-id");
                    var newId = parseInt(id) + 1;
                    var htmlTwitter = "<div data-id=" + newId + " id='kontol-" + newId + "' class='form-group'>" +
                            "<div class='form-group'>" +
                            "<label class='control-label col-md-2'>Product" +
                            "<span class='required'> * </span>" +
                            "</label>" +
                            "<div class='col-md-2'>" +
                            "<input type='text' placeholder='Name' class='form-control' name='product_name' required/>" +
                            "</div>" +
                            "<div class='col-md-2'>" +
                            "<input type='number' placeholder='Price' class='form-control' name='product_price' required/>" +
                            "</div>" +
                            "<div class='col-md-4'>" +
                            "<input type='text' placeholder='Detail' class='form-control' name='product_detail' required/>" +
                            "</div>" +
                            "</div>" +
                            "</div>";
                    $("#twitterDiv").append(htmlTwitter);
                    $("#kontol").attr("data-id", newId);
                    $("#removeTwitter").attr("data-id", newId);
                });
                $("#removeTwitter").click(function () {
                    var id = $(this).attr("data-id");
                    $("#kontol-" + id).remove();
                    $("#removeTwitter").attr("data-id", id - 1);
                });
                $("#addStatus").click(function () {
                    var id = $("#list-status").attr("data-id");
                    var newId = parseInt(id) + 1;
                    var htmlStatus = "<li data-id=" + newId + " id='list-status-" + newId + "' class='list-group-item'>" +
                            "<div class='form-group'>" +
                            "<div class='col-md-5'>" +
                            "<input type='text' class='form-control' placeholder='status name' name='status_name[]' required/>" +
                            "</div>" +
                            "<div class='col-md-3'>" +
                            "<input type='number' class='form-control' name='point[]' required/>" +
                            "</div>" +
                            "</div>" +
                            "</li>";
                    $("#list-custom-status").append(htmlStatus);
                    $("#list-status").attr("data-id", newId);
                    $("#removeStatus").attr("data-id", newId);
                });
                $("#removeStatus").click(function () {
                    var id = $(this).attr("data-id");
                    $("#list-status-" + id).remove();
                    $("#removeStatus").attr("data-id", id - 1);
                });
            });
        </script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <?php
        if (!empty($js)) {
            foreach ($js as $value) {
                ?>
                <script src="<?php echo base_url() . $value; ?>" type="text/javascript"></script>
                <?php
            }
        }
        ?>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url(); ?>assets/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/layouts/layout4/scripts/demo.min.js" type="text/javascript"></script>
        <script type="text/javascript">

            var rupiah = document.getElementById('rupiah');
            rupiah.addEventListener('keyup', function (e) {
                // tambahkan 'Rp.' pada saat form di ketik
                // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                rupiah.value = formatRupiah(this.value, 'Rp. ');
            });

            /* Fungsi formatRupiah */
            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                        split = number_string.split(','),
                        sisa = split[0].length % 3,
                        rupiah = split[0].substr(0, sisa),
                        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
            }
        </script>
        <script type="text/javascript">
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#previewPic').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>