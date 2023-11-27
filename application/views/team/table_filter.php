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
                        <input id="salesTeamNameFilter" data-id="1" type="checkbox" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="1" checked>Sales Team Name</label>
                    <label>
                        <input id="salesTeamCoverageAreaFilter" data-id="1" type="checkbox" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="2" checked>Coverage Area</label>
                    <label>
                        <input id="salesTeamAddressFilter" type="checkbox" data-id="0" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="3" >Address</label>
                    <label>
                        <input id="salesTeamPICFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="4" checked>PIC & Email</label>
                    <label>
                        <input id="salesTeamSalesOfficerFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="5" checked>Sales Officer</label>
                    <label>
                        <input id="salesTeamChannelFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="6" checked>Chanel</label>
                    <label>
                        <input id="salesTeamLeadsFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="7" checked>Leads</label>
                    <label>
                        <input id="salesTeamStatusFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="8" checked>Status</label>
                    <label>
                        <input id="salesTeamDateFilter" type="checkbox" data-id="0" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="9" >Create At</label>
                    <!--<div class="">
                        <button class="btn btn-info">Save</button></div>-->
                </div>
            </div>
            <!-- /btn-group -->
        </div>
        <div class="col-md-6">
            <button style="float: right;" onclick="location.href = '<?php echo base_url('team/add_sales_team'); ?>'"
                    id="sample_editable_1_new"
                    class="btn sbold red"> Add New
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
</div>
<script>
    function switchIt(id) {
        var box = document.getElementById(id);

        if (box.getAttribute("checked") == "true") {
            box.checked = false;
            box.removeAttribute("checked");
            box.setAttribute("checked", "false");
            console.log('a');
        } else if (box.getAttribute("checked") == "") {
            box.removeAttribute("checked");
            box.setAttribute("checked", "false");
            console.log('b');
        } else {
            box.checked = true;
            box.removeAttribute("checked");
            box.setAttribute("checked", "true");
            console.log('c');
        }
    }
</script>