<?php //$session = $this->session->userdata('user'); ?>
<div class="portlet-title">
    <div class="caption font-dark">
        <i class="icon-settings font-dark"></i>
        <span class="caption-subject bold uppercase"> <?php echo $title; ?> </span>
    </div>
    <div class="actions">
        <div class="btn-group btn-group-devided" data-toggle="buttons">
            <?php
            //if($session['role_id'] == 1){
              ?>
              <button id="sample_editable_1_new"
                      data-toggle="modal" href="#add"
                      class="btn sbold red"> Add New
                  <i class="fa fa-plus"></i>
              </button>
              <?php
            //}
            ?>
            <!--<button onclick="location.href = '<?php echo base_url('master_data/export_excel/?d='. strtolower($this->uri->segment(2))); ?>'" class="btn sbold green"> Export Excel
                <i class="fa fa-file-excel-o"></i>
            </button>-->
        </div>
    </div>
</div>
