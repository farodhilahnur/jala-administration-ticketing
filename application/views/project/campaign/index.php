<?php
$session = $this->session->userdata();
if ($this->session->userdata('search') !== NULL) {
    $session_search = $session['search'];
} else {
    $session_search = array();
}

$data_filter = array(
    'session_search' => $session_search,
    'session' => $session
);

$count = count($data_campaign);
$icon = 'fa fa-bullhorn';
$caption = $this->MainModels->getCaption(count($data_campaign), 'Campaign');

$card = $this->ComponentModels->statiscticsCard($count, $caption, $icon, 'big');

?>
<?php //$this->load->view('project/campaign/campaign_filter'); ?>
    <form>
        <input type="hidden" value="<?php echo $project_id; ?>" name="project_id" id="projectIdCampaign">
    </form>

    <div style="margin-bottom: 20px;" class="row">
        <div class="col-md-12">

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light" style="background: none;">
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <?php echo $card; ?>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="font-red-sunglo"></i>
                                        <span class="caption-subject font-red-sunglo bold uppercase">Top Campaign Performance</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <div style="height:200px;display: block;" class="chart-performances-campaign-in col-md-12">
                                            <div id="wait-lead-CampaignIn" style="display: block;">
                                                <svg stroke="#FFB7B3" ; width="50%" height="50%" viewBox="0 0 38 38"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     style="position:absolute;top: 50%;left: 50%; transform: translate(-50%, -50%)">
                                                    <g fill="none" fill-rule="evenodd">
                                                        <g transform="translate(1 1)" stroke-width="2">
                                                            <circle stroke-opacity=".5" cx="18" cy="18" r="18"/>
                                                            <path d="M36 18c0-9.94-8.06-18-18-18">
                                                                <animateTransform
                                                                        attributeName="transform"
                                                                        type="rotate"
                                                                        from="0 18 18"
                                                                        to="360 18 18"
                                                                        dur="1s"
                                                                        repeatCount="indefinite"></animateTransform>
                                                            </path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <canvas id="performancesCampaignIn"></canvas>
                                        </div>
                                        <div class="col-md-12">
                                            <form>
                                                <input type="hidden" value="1" id="pageCampaign" name="page">
                                            </form>
                                            <button id="btn-show-more-campaign" style="background: #FF6E66;float: right;"
                                                    class="btn btn-md">Show More
                                            </button>
                                            <button id="btn-show-less-campaign"
                                                    style="background: #9B9B9B;float: right;display: none;"
                                                    class="btn btn-md">Show Less
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 ">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet light">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <span class="caption-subject bold uppercase"> Campaign List </span>
                    </div>
                    <?php if ($this->MainModels->UserSession('role_id') == 2 || $this->MainModels->UserSession('role_id') == 5) {
                        ?>
                        <button style="float: right;margin-left: 100px;" id="sample_editable_1_new" data-toggle="modal"
                                href="#add"
                                type="button"
                                class="btn red btn-md"><i class="fa fa-plus"></i> Add
                        </button>
                    <?php }
                    ?>
                    <!--                    <ul class="nav nav-tabs">-->
                    <!--                        <li>-->
                    <!--                            <a href="#portlet_tab2" data-toggle="tab"><i class="fa fa-list"></i></a>-->
                    <!--                        </li>-->
                    <!--                        <li class="active">-->
                    <!--                            <a href="#portlet_tab1" data-toggle="tab"><i class="fa fa-clone"></i></a>-->
                    <!--                        </li>-->
                    <!--                        <li>-->
                    <!--                            -->
                    <!--                        </li>-->
                    <!--                    </ul>-->
                </div>
                <div class="portlet-body">
                    <?php $data = array('data_campaign' => $data_campaign); ?>
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">
                            <?php
                            $this->load->view('project/campaign/table-view', $data);
                            ?>
                        </div>
                        <div class="tab-pane" id="portlet_tab2">
                            <?php
                            $this->load->view('project/campaign/grid-view', $data);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$data = array('project_id', $project_id);
$this->load->view('project/campaign/form-add-campaign', $data);
$this->load->view('project/campaign/form-edit-campaign', $data);
