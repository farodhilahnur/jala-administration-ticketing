$(document).ready(function () {

    $('#filter-btn').click(function () {
        console.log('asu');
    });

    $('.inactive-filter').click(function () {
        var data_id = $(this).attr('data-id');

        console.log(data_id);

        if (data_id == 0) {
            $(this).addClass("filter-active");
            $(this).removeClass("inactive-filter");
            $('.filter-form').show();
            $(this).attr('data-id', 1);
        } else {
            $(this).addClass("inactive-filter");
            $(this).removeClass("filter-active");
            $('.filter-form').hide();
            $(this).attr('data-id', 0);
        }

    });
});

var projectId = $('#projectSelect').val();
var from = $('#fromDateFilter').val();
var end = $('#endDateFilter').val();
var urlGetTopCategory = 'lead/getTopCategory/?project_id=' + projectId + '&from=' + from + '&to=' + end;

$.ajax({
    url: urlGetTopCategory, success: function (dataChart) {

        var ctx = document.getElementById("topCategory");
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
            $("#wait-lead-category").css("display", "none");
            console.log('lead total loader close');
        });

    }
});

var period = $('.btn-time.active').val();
var urlGetDataTotalLead = 'lead/getTotalLead/?project_id=' + projectId + '&from=' + from + '&to=' + end + '&period=' + period;

// $(document).ajaxStart(function () {
//     $("#wait-lead-total").css("display", "block");
//     console.log('lead total loader startssss');
// });

$.ajax({
    url: urlGetDataTotalLead, success: function (dataChart) {


        var ctx = document.getElementById("leadTotal");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dataChart.label,
                datasets: [{
                    label: 'Total',
                    data: dataChart.total,
                    backgroundColor: [
                        '#FFCFCC'
                    ]
                }]
            },
            options: {
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "#F5F5F5",
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "#F5F5F5",
                        }
                    }]
                }
            }
        });

        $(document).ajaxComplete(function () {
            $("#wait-lead-total").css("display", "none");
            console.log('lead total loader close');
        });

    }
});

$('#btnDay').click(function () {
    $(this).addClass('active');
    $('#btnMonth').removeClass('active');
    $('#btnYear').removeClass('active');

    $(document).ajaxStart(function () {
        $("#wait-lead-total").css("display", "block");
        console.log('lead total loader start');
    });

    var urlGetDataTotalLead = 'lead/getTotalLead/?project_id=' + projectId + '&from=' + from + '&to=' + end + '&period=DAY';
    $.ajax({
        url: urlGetDataTotalLead, success: function (dataChart) {


            var ctx = document.getElementById("leadTotal");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dataChart.label,
                    datasets: [{
                        label: 'Total',
                        data: dataChart.total,
                        backgroundColor: [
                            '#FFCFCC'
                        ]
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        xAxes: [{
                            stacked: true,
                            gridLines: {
                                color: "#F5F5F5",
                            }
                        }],
                        yAxes: [{
                            stacked: true,
                            gridLines: {
                                color: "#F5F5F5",
                            }
                        }]
                    }
                }
            });

            $(document).ajaxComplete(function () {
                $("#wait-lead-total").css("display", "none");
                console.log('lead total loader close');
            });

        }
    });

});

$('#btnMonth').click(function () {
    $(this).addClass('active');
    $('#btnDay').removeClass('active');
    $('#btnYear').removeClass('active');

    var urlGetDataTotalLead = 'lead/getTotalLead/?project_id=' + projectId + '&from=' + from + '&to=' + end + '&period=MONTH';

    $(document).ajaxStart(function () {
        $("#wait-lead-total").css("display", "block");
        console.log('lead total loader start');
    });

    $.ajax({
        url: urlGetDataTotalLead, success: function (dataChart) {


            var ctx = document.getElementById("leadTotal");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dataChart.label,
                    datasets: [{
                        label: 'Total',
                        data: dataChart.total,
                        backgroundColor: [
                            '#FFCFCC'
                        ]
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        xAxes: [{
                            stacked: true,
                            gridLines: {
                                color: "#F5F5F5",
                            }
                        }],
                        yAxes: [{
                            stacked: true,
                            gridLines: {
                                color: "#F5F5F5",
                            }
                        }]
                    }
                }
            });

            $(document).ajaxComplete(function () {
                $("#wait-lead-total").css("display", "none");
                console.log('lead total loader close');
            });

        }
    });
});

$('#btnYear').click(function () {
    $(this).addClass('active');
    $('#btnDay').removeClass('active');
    $('#btnMonth').removeClass('active');

    var urlGetDataTotalLead = 'lead/getTotalLead/?project_id=' + projectId + '&from=' + from + '&to=' + end + '&period=YEAR';

    $(document).ajaxStart(function () {
        $("#wait-lead-total").css("display", "block");
        console.log('lead total loader start');
    });

    $.ajax({
        url: urlGetDataTotalLead, success: function (dataChart) {


            var ctx = document.getElementById("leadTotal");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dataChart.label,
                    datasets: [{
                        label: 'Total',
                        data: dataChart.total,
                        backgroundColor: [
                            '#FFCFCC'
                        ]
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        xAxes: [{
                            stacked: true,
                            gridLines: {
                                color: "#F5F5F5",
                            }
                        }],
                        yAxes: [{
                            stacked: true,
                            gridLines: {
                                color: "#F5F5F5",
                            }
                        }]
                    }
                }
            });

            $(document).ajaxComplete(function () {
                $("#wait-lead-total").css("display", "none");
                console.log('lead total loader close');
            });

        }
    });

});


$('#btnCampaign').click(function () {
    $(this).addClass('active');
    $('#btnChannel').removeClass('active');
    $('#btnSalesTeam').removeClass('active');
    $('#btnSalesOfficer').removeClass('active');

    $('.chart-performances-campaign').fadeIn();
    $('.chart-performances-channel').fadeOut();
    $('.chart-performances-sales-team').fadeOut();
    $('.chart-performances-sales-officer').fadeOut();

});

$('#btnChannel').click(function () {
    $(this).addClass('active');
    $('#btnCampaign').removeClass('active');
    $('#btnSalesTeam').removeClass('active');
    $('#btnSalesOfficer').removeClass('active');

    $('.chart-performances-campaign').fadeOut();
    $('.chart-performances-channel').fadeIn();
    $('.chart-performances-sales-team').fadeOut();
    $('.chart-performances-sales-officer').fadeOut();

});

$('#btnSalesTeam').click(function () {
    $(this).addClass('active');
    $('#btnChannel').removeClass('active');
    $('#btnCampaign').removeClass('active');
    $('#btnSalesOfficer').removeClass('active');

    $('.chart-performances-campaign').fadeOut();
    $('.chart-performances-channel').fadeOut();
    $('.chart-performances-sales-team').fadeIn();
    $('.chart-performances-sales-officer').fadeOut();

});

$('#btnSalesOfficer').click(function () {
    $(this).addClass('active');
    $('#btnChannel').removeClass('active');
    $('#btnSalesTeam').removeClass('active');
    $('#btnCampaign').removeClass('active');

    $('.chart-performances-campaign').fadeOut();
    $('.chart-performances-channel').fadeOut();
    $('.chart-performances-sales-team').fadeOut();
    $('.chart-performances-sales-officer').fadeIn();
});

var urlGetPerformance = 'lead/getLeadPerformance/?project_id=' + projectId + '&from=' + from + '&to=' + end + '&type=1';

$.ajax({
    url: urlGetPerformance, success: function (dataChart) {

        var ctx = document.getElementById("performancesCampaign");
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: dataChart[1],
                datasets: dataChart[0]
            },
            options: {
                responsive: true,
                legend: {
                    display: true
                },
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "#F5F5F5",
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "#F5F5F5",
                        }
                    }]
                }
            }
        });

        $(document).ajaxComplete(function () {
            $("#wait-lead-campaign").css("display", "none");
            console.log('lead total loader close');
        });

    }
});

var urlGetPerformance = 'lead/getLeadPerformance/?project_id=' + projectId + '&from=' + from + '&to=' + end + '&type=2';
$.ajax({
    url: urlGetPerformance, success: function (dataChart) {

        var ctx = document.getElementById("performancesChannel");
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: dataChart[1],
                datasets: dataChart[0]
            },
            options: {
                responsive: true,
                legend: {
                    display: true
                },
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "#F5F5F5",
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "#F5F5F5",
                        }
                    }]
                }
            }
        });
    }
});

var urlGetPerformance = 'lead/getLeadPerformance/?project_id=' + projectId + '&from=' + from + '&to=' + end + '&type=3';
$.ajax({
    url: urlGetPerformance, success: function (dataChart) {

        var ctx = document.getElementById("performancesSalesTeam");
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: dataChart[1],
                datasets: dataChart[0]
            },
            options: {
                responsive: true,
                legend: {
                    display: true
                },
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "#F5F5F5",
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "#F5F5F5",
                        }
                    }]
                }
            }
        });
    }
});

var urlGetPerformance = 'lead/getLeadPerformance/?project_id=' + projectId + '&from=' + from + '&to=' + end + '&type=4';
$.ajax({
    url: urlGetPerformance, success: function (dataChart) {

        var ctx = document.getElementById("performancesSalesOfficer");
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: dataChart[1],
                datasets: dataChart[0]
            },
            options: {
                responsive: true,
                legend: {
                    display: true
                },
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "#F5F5F5",
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            color: "#F5F5F5",
                        }
                    }]
                }
            }
        });
    }
});









