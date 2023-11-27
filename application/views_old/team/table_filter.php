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
                        <input id="salesTeamNameFilter" data-id="1" type="checkbox" data-source="<?php echo $total; ?>" checked>Sales Team Name</label>
                    <label>
                        <input id="salesTeamCoverageAreaFilter" data-id="1" type="checkbox" data-source="<?php echo $total; ?>" checked>Coverage Area</label>
                    <label>
                        <input id="salesTeamAddressFilter" type="checkbox" data-id="0" data-source="<?php echo $total; ?>" >Address</label>
                    <label>
                        <input id="salesTeamPICFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>PIC & Email</label>
                    <label>
                        <input id="salesTeamSalesOfficerFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Sales Officer</label>
                    <label>
                        <input id="salesTeamChannelFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Chanel</label>
                    <label>
                        <input id="salesTeamLeadsFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Leads</label>
                    <label>
                        <input id="salesTeamStatusFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Status</label>
                    <label>
                        <input id="salesTeamDateFilter" type="checkbox" data-id="0" data-source="<?php echo $total; ?>" >Create At</label>
                    <!--<div class="">
                        <button class="btn btn-info">Save</button></div>-->
                </div>
            </div>
            <!-- /btn-group -->     
        </div>
    </div>
</div>