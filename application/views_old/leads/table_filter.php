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
                        <input id="leadNameFilter" data-id="1" type="checkbox" data-source="<?php echo $total; ?>" checked>Name</label>
                    <label>
                        <input id="leadAddressFilter" data-id="1" type="checkbox" data-source="<?php echo $total; ?>" checked>Address</label>
                    <label>
                        <input id="leadCategoryFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Category</label>
                    <label>
                        <input id="leadStatusFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Status</label>
                    <label>
                        <input id="leadSalesTeamFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Sales Team</label>
                    <label>
                        <input id="leadSalesOfficerFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Sales Officer</label>
                    <label>
                        <input id="leadCampaignFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Campaign</label>
                    <label>
                        <input id="leadChannelFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Channel</label>
                    <label>
                        <input id="leadProductFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Product</label>
                    <label>
                        <input id="leadDateFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Lead Date</label>
                    <label>
                        <input id="leadLastUpdateFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Last Update</label>
                    <label>
                        <input id="leadNoteFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Note</label>
                    <!--<div class="">
                        <button class="btn btn-info">Save</button></div>-->
                </div>
            </div>
            <!-- /btn-group -->     
        </div>
    </div>
</div>