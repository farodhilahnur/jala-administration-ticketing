$(document).ready(function () {
    $(".btnFollowUp").click(function () {

        var btnId = $(this).attr("id");
        var id = $("#" + btnId).attr("data-id");

        var urlGetDataLead = 'lead/getDataFollowUpLead/?id=' + id;
        $.ajax({
            url: urlGetDataLead, success: function (data) {
                $('#leadName').val(data.data.lead_name);
                $('#leadPhone').val(data.data.lead_phone);
                $('#leadId').val(data.data.lead_id);
                $('#salesOfficerIdLead').val(data.data.sales_officer_id);
            }
        });

    });

    // $(".btnShowHistoryLead").click(function () {
    //
    //     var btnId = $(this).attr("id");
    //     var id = $("#" + btnId).attr("data-id");
    //
    //     var urlGetDataLead = '../../lead/getDataHistoryLead/?id=' + id;
    //     $.ajax({url: urlGetDataLead, success: function (data) {
    //             $('#timeLine').html(data.data);
    //         }});
    //
    // });

    // process the form
    $('.form-follow-up').submit(function (event) {

        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
        var formData = {
            'lead_id': $('input[name=lead_id]').val(),
            'sales_officer_id': $('input[name=sales_officer_id]').val(),
            'lead_category_id': $('#lead-category-id').val(),
            'status_id': $('#status-id').val(),
            'product_id': $('select[name=product_id]').val(),
            'lead_notes': $('textarea[name=lead_notes]').val()
        };

        console.log(formData);

        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: 'lead/follow_up/', // the url where we want to POST
            data: formData, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
            // using the done promise callback
            .done(function (data) {

                // log data to the console so we can see
                //console.log(data);
                if (data.res) {
                    alert('thanks for your follow up');
                } else {
                    alert('sorry the system has been error');
                }
                window.location.href = data.redirect;
                // here we will handle errors and validation messages
            });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    });
});

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

var projectId = $_GET('id');
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

var myChartChannelLead;

if ($_GET('campaign_id')) {
    var urlGetTopChannel = '../getChannels/?page=1&project_id=' + projectId + '&campaign_id=' + campaign_id + '&from=' + from + '&to=' + to + '&sales_team_id=' + sales_team_id + '&lead_category_id=' + lead_category_id + '&type_id=' + type_id + '&status_id=' + status_id + '&channel_id=' + channel_id + '&sales_officer_id=' + sales_officer_id + '&search=1';
} else {
    var urlGetTopChannel = '../getChannels/?page=1&project_id=' + projectId;
}
$.ajax({
    url: urlGetTopChannel, success: function (dataChart) {

        var length_ = dataChart.label.length;
        if (length_ < 5) {
            $('#btn-show-more-channel-lead').hide();
        }

        var ctx = document.getElementById("chartChannel");
        myChartChannelLead = new Chart(ctx, {
            type: 'horizontalBar',
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
            $("#wait-lead-ChannelLeadIn").css("display", "none");
            console.log('lead total loader close');
        });

        // console.log(myChart);
    }
});

$('#btn-show-more-channel-lead').click(function () {

    myChartChannelLead.destroy();

    var page = $('#pageChannelLead').val();
    var page_new = parseInt(page) + 1;
    var newHight = 300 * page_new;

    $('#pageChannelLead').val(page_new);

    $('#btn-show-less-channel-lead').show();

    if ($_GET('campaign_id')) {
        var urlGetTopChannel = '../getChannels/?page=' + page_new + '&project_id=' + projectId + '&campaign_id=' + campaign_id + '&from=' + from + '&to=' + to + '&sales_team_id=' + sales_team_id + '&lead_category_id=' + lead_category_id + '&type_id=' + type_id + '&status_id=' + status_id + '&channel_id=' + channel_id + '&sales_officer_id=' + sales_officer_id + '&search=1';
    } else {
        var urlGetTopChannel = '../getChannels/?page=' + page_new + '&project_id=' + projectId;
    }
    $.ajax({
        url: urlGetTopChannel, success: function (dataChart) {

            $('.chart-lead-channel-lead').css('height', newHight);
            var ctx = document.getElementById("chartChannel");
            myChartChannelLead = new Chart(ctx, {
                type: 'horizontalBar',
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
                $("#wait-lead-ChannelLeadIn").css("display", "none");
                console.log('lead total loader close');
            });

            // console.log(myChart);
        }
    });

});

$('#btn-show-less-channel-lead').click(function () {

    myChartChannelLead.destroy();

    var page = $('#pageChannelLead').val();
    var page_new = parseInt(page) - 1;
    var newHight = 300 * page_new;

    $('#pageChannelLead').val(page_new);

    if (page_new == 1) {
        $('#btn-show-less-channel-lead').hide();
    }

    if ($_GET('campaign_id')) {
        var urlGetTopChannel = '../getChannels/?page=' + page_new + '&project_id=' + projectId + '&campaign_id=' + campaign_id + '&from=' + from + '&to=' + to + '&sales_team_id=' + sales_team_id + '&lead_category_id=' + lead_category_id + '&type_id=' + type_id + '&status_id=' + status_id + '&channel_id=' + channel_id + '&sales_officer_id=' + sales_officer_id + '&search=1';
    } else {
        var urlGetTopChannel = '../getChannels/?page=' + page_new + '&project_id=' + projectId;
    }
    $.ajax({
        url: urlGetTopChannel, success: function (dataChart) {

            $('.chart-lead-channel-lead').css('height', newHight);
            var ctx = document.getElementById("chartChannel");
            myChartChannelLead = new Chart(ctx, {
                type: 'horizontalBar',
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
                $("#wait-lead-ChannelLeadIn").css("display", "none");
                console.log('lead total loader close');
            });

            // console.log(myChart);
        }
    });

});