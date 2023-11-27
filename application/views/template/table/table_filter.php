<?php $total = 0; ?>
<div class="table-toolbar">
    <div class="row">

        <div class="col-md-6">
            <!-- /btn-group -->
            <div class="btn-group">
                <button type="button" class="btn btn-info btn-outline">Filter</button>
                <button type="button" class="btn btn-info btn-outline dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-angle-down"></i>
                </button>
                <div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
                    <p> COLUMN TO BE DISPLAYED </p>
                    <label>
                        <input id="dealerSalesTeamName" data-id="1" type="checkbox" data-source="<?php echo $total; ?>" checked>Sales Team Name</label>
                    <label>
                        <input id="dealerCoverageArea" data-id="1" type="checkbox" data-source="<?php echo $total; ?>" checked>Coverage Area</label>
                    <label>
                        <input id="dealerAddress" type="checkbox" data-id="0" data-source="<?php echo $total; ?>" >Address & Phone</label>
                    <label>
                        <input id="dealerPIC" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>PIC & Email</label>
                    <label>
                        <input id="dealerAgent" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Agent</label>
                    <label>
                        <input id="dealerCampaign" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Campaign</label>
                    <label>
                        <input id="dealerLeads" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Leads</label>
                    <!--<div class="">
                        <button class="btn btn-info">Save</button></div>-->
                </div>
            </div>
            <!-- /btn-group -->
        </div>
    </div>
</div>