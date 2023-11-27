<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject bold uppercase"> Campaign List </span>
                </div>
                <ul class="nav nav-tabs">
                    <li>
                        <a href="#portlet_tab2" data-toggle="tab"><i class="fa fa-list"></i></a>
                    </li>
                    <li class="active">
                        <a href="#portlet_tab1" data-toggle="tab"><i class="fa fa-clone"></i></a>
                    </li>
                </ul>
            </div>
            <div class="portlet-body">
                <?php $data = array('data_campaign' => $data_campaign); ?>
                <div class="tab-content">
                    <div class="tab-pane active" id="portlet_tab1">
                        <?php
                        $this->load->view('campaign/grid-view', $data);
                        ?>
                    </div>
                    <div class="tab-pane" id="portlet_tab2">
                        <?php
                        $this->load->view('campaign/table-view', $data);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>