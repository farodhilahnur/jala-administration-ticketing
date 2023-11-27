function $_GET(param) {
    var vars = {};
    window.location.href.replace(
        /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
        function (m, key, value) { // callback
            vars[key] = value !== undefined ? value : '';
        }
    );

    if (param) {
        return vars[param] ? vars[param] : null;
    }
    return vars;
}

if ($_GET('from')) {
    var from = $_GET('from')
} else {
    var from = ''
}
if ($_GET('to')) {
    var to = $_GET('to')
} else {
    var to = ''
}
if ($_GET('campaign_id')) {
    var campaign_id = $_GET('campaign_id')
} else {
    var campaign_id = ''
}
if ($_GET('sales_team_id')) {
    var sales_team_id = $_GET('sales_team_id')
} else {
    var sales_team_id = ''
}
if ($_GET('lead_category_id')) {
    var lead_category_id = $_GET('lead_category_id')
} else {
    var lead_category_id = ''
}
if ($_GET('type_id')) {
    var type_id = $_GET('type_id')
} else {
    var type_id = ''
}
if ($_GET('status_id')) {
    var status_id = $_GET('status_id')
} else {
    var status_id = ''
}
if ($_GET('channel_id')) {
    var channel_id = $_GET('channel_id')
} else {
    var channel_id = ''
}
if ($_GET('sales_officer_id')) {
    var sales_officer_id = $_GET('sales_officer_id')
} else {
    var sales_officer_id = ''
}

if ($_GET('campaign_id')) {
    var urlGetTopCategory = '../getCategories/?project_id=' + projectId + '&campaign_id=' + campaign_id + '&from=' + from + '&to=' + to + '&sales_team_id=' + sales_team_id + '&lead_category_id=' + lead_category_id + '&type_id=' + type_id + '&status_id=' + status_id + '&channel_id=' + channel_id + '&sales_officer_id=' + sales_officer_id + '&search=1';
} else {
    var urlGetTopCategory = '../getCategories/?project_id=' + projectId;
}
$.ajax({
    url: urlGetTopCategory, success: function (dataChart) {
        var ctx = document.getElementById("chartCategory");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dataChart.label,
                datasets: [{
                    label: 'Total',
                    data: dataChart.total,
                    backgroundColor: dataChart.background,
                }]
            },
            options: {
                responsive: true,
                legend: {
                    display: false
                },
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        gridLines: {
                            color: "#F5F5F5",
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            color: "#F5F5F5",
                        }
                    }]
                }
            }
        });

        $(document).ajaxComplete(function () {
            $("#wait-lead-CategoriesLeadIn").css("display", "none");
            console.log('lead total loader close');
        });

        // console.log(myChart);
    }
});


