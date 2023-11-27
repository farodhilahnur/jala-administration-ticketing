<?php
$session = $this->session->userdata('user');
$role_id = $session['role_id'];


// echo "<pre>" ;
// print_r($role_id);
// echo "</pre>" ;
?>


<div style="margin-bottom: 30px;" class="row">
    <div class="col-md-6">
        <button id="btn-grid" class="btn btn-default btn-md active"><i class="fa fa-clone"></i></button>
        <button id="btn-list" class="btn btn-default btn-md"><i class="fa fa-list"></i>
        </button>
    </div>
    <?php
    if($role_id != 3){
        if($role_id != 5) {
            ?>
            <div class="col-md-6">
                <button onclick="location.href='<?php echo base_url('project_new/add_project'); ?>'"
                        style="float: right;"
                        class="btn btn-danger btn-md"><i class="fa fa-plus"></i> Add
                </button>
            </div>
            <?php
        }
    }
    ?>
    

</div>
<div id="grid-view" style="display: block;" class="row">
    <?php
    if (!empty($data_project)) {
        foreach ($data_project as $dp) {
            ?>
            <div class="col-md-6 col-sm-6">
                <div class="portlet mt-element-ribbon light portlet-fit ">
                    <div style="box-shadow: none;background-color: #EDF8F3;color: #46B989;margin-top: 45px;margin-right: 10px;"
                         class="ribbon ribbon-right ribbon-clip ribbon-shadow ribbon-border-dash-hor ribbon-color-success uppercase">
                        <div style="background-color: #EDF8F3;" class="ribbon-sub ribbon-clip ribbon-right"></div>
                        <?php if ($dp->status == 1) {
                            echo "Running";
                        } else {
                            echo "Stop";
                        } ?>
                    </div>
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-red bold uppercase"><?php echo $dp->project_name; ?></span>
                            <p style="margin: 5px 0px;font-size: 12px;"><i><?php echo $dp->project_detail; ?></i></p>
                        </div>
                    </div>
                    <div style="padding: 20px 0px 0px 20px;" class="portlet-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <p>Start Date</p>
                                <h4><label style="box-shadow: none;"
                                           class="label label-danger label-md"><?php echo $dp->date; ?></label>
                                </h4>
                            </div>
                            <!--                        <div class="col-md-6">-->
                            <!--                            <p>End Date</p>-->
                            <!--                            <h4><label style="box-shadow: none;" class="label label-danger label-md"></label>-->
                            <!--                            </h4>-->
                            <!--                        </div>-->
                        </div>
                        <div style="margin-top: 15px;" class="row">
                            <div class="col-md-12 col-sm-12">
                                Summary
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                $count = count($this->CampaignModels->getDataCampaignbyProjectId($dp->id));
                                $caption = $this->MainModels->getCaption($count, 'Campaign');
                                $icon = 'fa fa-bullhorn';
                                $link = 'campaignDetail(' . $dp->id . ')';
                                $card_campaign = $this->ComponentModels->statiscticsCardSummary($count, $caption, $icon, $link, 'big');


                                echo $card_campaign;
                                ?>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                $count_chanel = count($this->ChannelModels->getChannelbyProjectId($dp->id));
                                $caption_channel = $this->MainModels->getCaption($count_chanel, 'Channel');
                                $icon_channel = 'fa fa-bullseye';
                                $link_channel = 'channelDetail(' . $dp->id . ')';
                                $card_channel = $this->ComponentModels->statiscticsCardSummary($count_chanel, $caption_channel, $icon_channel, $link_channel, 'big');


                                echo $card_channel;
                                ?>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                $count_lead = count($this->LeadModels->getDataLeadbyProjectId($dp->id));
                                $caption_lead = $this->MainModels->getCaption($count_lead, 'Lead');
                                $icon_lead = 'fa fa-book';
                                $link_lead = 'leadDetail(' . $dp->id . ')';
                                $card_channel = $this->ComponentModels->statiscticsCardSummary($count_lead, $caption_lead, $icon_lead, $link_lead, 'big');


                                echo $card_channel;
                                ?>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                $count_product = count($this->ProductModels->getDataProductByProjectId($dp->id));
                                $caption_product = $this->MainModels->getCaption($count_lead, 'Product');
                                $icon_product = 'fa fa-archive';
                                $link_product = 'productDetail(' . $dp->id . ')';
                                $card_product = $this->ComponentModels->statiscticsCardSummary($count_product, $caption_product, $icon_product, $link_product, 'big');


                                echo $card_product;
                                ?>
                            </div>
                        </div>
                        <div style="margin-top: 20px;" class="row">
                            <div class="col-md-12">
                                <div style="border-radius: 10px;float: right;" class="btn-group">
                                    <button onclick="location.href='<?php echo base_url('project_new/setting/?id=' . $dp->id); ?>'"
                                            class="btn btn-md btn-success">Setting
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>

<div id="list-view" style="display: none;" class="row">
    <div class="row">
        <div class="col-md-12 ">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet light">
                <div class="portlet-body">
                    <?php
                    $data = array('data_project' => $data_project);
                    $this->load->view('project/table-view', $data);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

