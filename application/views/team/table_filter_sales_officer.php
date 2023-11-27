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
                        <input id="salesOfficerNameFilter" data-id="1" type="checkbox" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="1" checked>Name</label>
                    <label>
                        <input id="salesOfficerContactFilter" type="checkbox" data-id="0" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="2">Contact</label>
                    <label>
                        <input id="salesOfficerLeadsFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="3" checked>Leads</label>
                    <label>
                        <input id="salesOfficerPointsFilter" data-id="1" type="checkbox" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="4" checked>Points</label>
                    <label>
                        <input id="salesOfficerSalesTeamFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="5" checked>Sales Team</label>
                    <label>
                        <input id="salesOfficerStatusFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="6"checked>Status</label>
                    <!--<label>
                        <input id="salesOfficerDateFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>" >Create At</label>-->
                    <!--<div class="">
                        <button class="btn btn-info">Save</button></div>-->
                </div>
            </div>
            <!-- /btn-group -->
        </div>
        <div class="col-md-6">
            <button style="float: right;" onclick="location.href = '<?php echo base_url('team/add_sales_officer'); ?>'"
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