<div class="table-toolbar">
    <div class="row">
        <div class="col-md-6">
            <button onclick="goBack()" style="float: left;" class="btn btn-danger btn-md">back</button>
        </div>
        <div class="col-md-6">
            <!-- /btn-group -->
            <div style="float: right;" class="btn-group">
                <button type="button" class="btn btn-info btn-outline">Filter</button>
                <button type="button" class="btn btn-info btn-outline dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-angle-down"></i>
                </button>
                <div class="dropdown-menu dropdown-checkboxes" role="menu">
                    <p> COLUMN TO BE DISPLAYED </p>
                    <label>
                        <input id="leadNameFilter" data-id="1" type="checkbox" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="1" checked>Name</label>
                    <label>
                        <input id="leadPhoneFilter" data-id="1" type="checkbox" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="2" checked>Phone</label>
                    <label>
                        <input id="leadEmailFilter" data-id="0" type="checkbox" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="3" >Email</label>
                    <label>
                        <input id="leadAddressFilter" data-id="0" type="checkbox" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="4" >Address</label>
                    <label>
                        <input id="leadCategoryFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="5" checked>Category</label>
                    <label>
                        <input id="leadStatusFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="6" checked>Status</label>
                    <label>
                        <input id="leadSalesTeamFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="7" checked>Sales Team</label>
                    <label>
                        <input id="leadSalesOfficerFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="8" checked>Sales Officer</label>
                    <label>
                        <input id="leadCampaignFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="9" checked>Campaign</label>
                    <label>
                        <input id="leadChannelFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="10" checked>Channel</label>
                    <label>
                        <input id="leadProductFilter" type="checkbox" data-id="0" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="11" >Product</label>
                    <label>
                        <input id="leadDateFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="12" checked>Lead Date</label>
                    <label>
                        <input id="leadLastUpdateFilter" type="checkbox" data-id="1" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="13" checked>Last Update</label>
                    <label>
                        <input id="leadNoteFilter" type="checkbox" data-id="0" data-source="<?php echo $total; ?>"
                               onclick="switchIt(this.id)" class="toggle-vis" data-column="14" >Note</label>
                    <!--<div class="">
                        <button class="btn btn-info">Save</button></div>-->
                </div>
            </div>
            <!-- /btn-group -->
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