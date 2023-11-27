<?php
//echo "<pre>";
//print_r($this->session->userdata());
//echo "</pre>";
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

$count = count($data_channel);
$icon = 'fa fa-bullseye';
$caption = $this->MainModels->getCaption(count($data_channel), 'Channel');

$card = $this->ComponentModels->statiscticsCard($count, $caption, $icon, 'big');

?>

<form>
    <input type="hidden" value="<?php echo $project_id; ?>" name="project_id" id="projectIdChannel">
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
                    <div class="col-md-8 col-sm-8">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="font-red-sunglo"></i>
                                    <span class="caption-subject font-red-sunglo bold uppercase">Top Channel Performance</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div style="height:200px;display: block;" class="chart-performances-channel-in col-md-12">
                                        <div id="wait-lead-channelIn" style="display: block;">
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
                                        <canvas id="performancesChannelIn"></canvas>
                                    </div>
                                    <div class="col-md-12">
                                        <form>
                                            <input type="hidden" value="1" id="pageChannel" name="page">
                                        </form>
                                        <button id="btn-show-more-channel" style="background: #FF6E66;float: right;"
                                                class="btn btn-md">Show More
                                        </button>
                                        <button id="btn-show-less-channel"
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
                    <span class="caption-subject bold uppercase"> Channel List </span>
                </div>
                <?php if ($this->MainModels->UserSession('role_id') == 2 || $this->MainModels->UserSession('role_id') == 5) {
                    ?>
                    <button style="float: right;"
                            onclick="location.href = '<?php echo base_url('project_new/form_add_channel/?id=' . $project_id . '&step=1'); ?>'"
                            type="button" class="btn red btn-md"><i class="fa fa-plus"></i> Add
                    </button>
                <?php }
                ?>
            </div>
            <div class="portlet-body">
                <?php $data = array('data_channel' => $data_channel); ?>
                <div class="tab-content">
                    <div class="tab-pane active" id="portlet_tab1">
                        <?php
                        $this->load->view('project/channel/table-view', $data);
                        ?>
                    </div>
                    <div class="tab-pane" id="portlet_tab2">
                        <?php
                        $this->load->view('project/channel/grid-view', $data);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
