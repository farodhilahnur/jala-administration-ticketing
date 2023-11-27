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
                        <input id="salesOfficerNameFilter" data-id="1" type="checkbox" data-source="<?php echo $total; ?>" checked>Name</label>
                    <label>
                        <input id="salesOfficerContactFilter" type="checkbox" data-id="0" data-source="<?php echo $total; ?>" >Contact</label>
                    <label>
                        <input id="salesOfficerLeadsFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Leads</label>
                    <label>
                        <input id="salesOfficerPointsFilter" data-id="1" type="checkbox" data-source="<?php echo $total; ?>" checked>Points</label>
                    <label>
                        <input id="salesOfficerSalesTeamFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Sales Team</label>
                    <label>
                        <input id="salesOfficerStatusFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" checked>Status</label>
                    <!--<label>
                        <input id="salesOfficerDateFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" >Create At</label>-->
                    <!--<div class="">
                        <button class="btn btn-info">Save</button></div>-->  
                </div>
            </div>
            <!-- /btn-group -->     
        </div>
    </div>
</div>