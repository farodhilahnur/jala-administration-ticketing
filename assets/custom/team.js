$(document).ready(function () {

    $(".btnMigration").click(function () {

        // console.log(getAbsolutePath());

        var btnId = $(this).attr("id");
        var id = $("#" + btnId).attr("data-id");

        $('#salesOfficerIdMigrate').val(id);

        var base_url = 'https://jala.ai/dashboard/';
//        var urlGetDataLead = '../team/getSalesOfficerbySalesOfficerId/?id=' + id;
        var urlGetSalesOfficer = base_url + 'team/getSalesOfficerAll/?id=' + id;
        $.ajax({
            url: urlGetSalesOfficer, success: function (data) {
                $('#optionSelectSalesOfficer').html(data);
            }
        });


    });

    $('#salesTeamNameFilter').click(function () {
        var id = $(this).attr("data-id");
        var source = $(this).attr("data-source");
        if (id == 1) {
            $('#salesTeamNameHeader').hide();

            for (var a = 0; a < source; a++) {
                $('#salesTeamNameField-' + a).hide();
            }
            $(this).attr("data-id", 0);
        } else {
            $('#salesTeamNameHeader').show();

            for (var a = 0; a < source; a++) {
                $('#salesTeamNameField-' + a).show();
            }

            $(this).attr("data-id", 1);
        }

    });

    $('#salesTeamAddressFilter').click(function () {
        var id = $(this).attr("data-id");
        var source = $(this).attr("data-source");
        if (id == 1) {
            $('#salesTeamAddressHeader').hide();

            for (var a = 0; a < source; a++) {
                $('#salesTeamAddressField-' + a).hide();
            }
            $(this).attr("data-id", 0);
        } else {
            $('#salesTeamAddressHeader').show();

            for (var a = 0; a < source; a++) {
                $('#salesTeamAddressField-' + a).show();
            }

            $(this).attr("data-id", 1);
        }

    });

    $('#salesTeamCoverageAreaFilter').click(function () {
        var id = $(this).attr("data-id");
        var source = $(this).attr("data-source");
        if (id == 1) {
            $('#salesTeamCoverageAreaHeader').hide();

            for (var a = 0; a < source; a++) {
                $('#salesTeamCoverageAreaField-' + a).hide();
            }
            $(this).attr("data-id", 0);
        } else {
            $('#salesTeamCoverageAreaHeader').show();

            for (var a = 0; a < source; a++) {
                $('#salesTeamCoverageAreaField-' + a).show();
            }

            $(this).attr("data-id", 1);
        }

    });

    $('#salesTeamStatusFilter').click(function () {
        var id = $(this).attr("data-id");
        var source = $(this).attr("data-source");
        if (id == 1) {
            $('#salesTeamStatusHeader').hide();

            for (var a = 0; a < source; a++) {
                $('#salesTeamStatusField-' + a).hide();
            }
            $(this).attr("data-id", 0);
        } else {
            $('#salesTeamStatusHeader').show();

            for (var a = 0; a < source; a++) {
                $('#salesTeamStatusField-' + a).show();
            }

            $(this).attr("data-id", 1);
        }

    });

    $('#salesTeamPICFilter').click(function () {
        var id = $(this).attr("data-id");
        var source = $(this).attr("data-source");
        if (id == 1) {
            $('#salesTeamPICHeader').hide();

            for (var a = 0; a < source; a++) {
                $('#salesTeamPICField-' + a).hide();
            }
            $(this).attr("data-id", 0);
        } else {
            $('#salesTeamPICHeader').show();

            for (var a = 0; a < source; a++) {
                $('#salesTeamPICField-' + a).show();
            }

            $(this).attr("data-id", 1);
        }

    });

    $('#salesTeamSalesOfficerFilter').click(function () {
        var id = $(this).attr("data-id");
        var source = $(this).attr("data-source");
        if (id == 1) {
            $('#salesTeamSalesOfficerHeader').hide();

            for (var a = 0; a < source; a++) {
                $('#salesTeamSalesOfficerField-' + a).hide();
            }
            $(this).attr("data-id", 0);
        } else {
            $('#salesTeamSalesOfficerHeader').show();

            for (var a = 0; a < source; a++) {
                $('#salesTeamSalesOfficerField-' + a).show();
            }

            $(this).attr("data-id", 1);
        }

    });

    $('#salesTeamChannelFilter').click(function () {
        var id = $(this).attr("data-id");
        var source = $(this).attr("data-source");
        if (id == 1) {
            $('#salesTeamChannelHeader').hide();

            for (var a = 0; a < source; a++) {
                $('#salesTeamChannelField-' + a).hide();
            }
            $(this).attr("data-id", 0);
        } else {
            $('#salesTeamChannelHeader').show();

            for (var a = 0; a < source; a++) {
                $('#salesTeamChannelField-' + a).show();
            }

            $(this).attr("data-id", 1);
        }

    });

    $('#salesTeamLeadsFilter').click(function () {
        var id = $(this).attr("data-id");
        var source = $(this).attr("data-source");
        if (id == 1) {
            $('#salesTeamLeadsHeader').hide();

            for (var a = 0; a < source; a++) {
                $('#salesTeamLeadsField-' + a).hide();
            }
            $(this).attr("data-id", 0);
        } else {
            $('#salesTeamLeadsHeader').show();

            for (var a = 0; a < source; a++) {
                $('#salesTeamLeadsField-' + a).show();
            }

            $(this).attr("data-id", 1);
        }

    });

    $('#salesTeamDateFilter').click(function () {
        var id = $(this).attr("data-id");
        var source = $(this).attr("data-source");
        if (id == 1) {
            $('#salesTeamDateHeader').hide();

            for (var a = 0; a < source; a++) {
                $('#salesTeamDateField-' + a).hide();
            }
            $(this).attr("data-id", 0);
        } else {
            $('#salesTeamDateHeader').show();

            for (var a = 0; a < source; a++) {
                $('#salesTeamDateField-' + a).show();
            }

            $(this).attr("data-id", 1);
        }

    });

    $('#salesOfficerNameFilter').click(function () {

        var id = $(this).attr("data-id");
        var source = $(this).attr("data-source");
        if (id == 1) {
            $('#salesOfficerNameHeader').hide();

            for (var a = 0; a < source; a++) {
                $('#salesOfficerNameField-' + a).hide();
            }
            $(this).attr("data-id", 0);
        } else {
            $('#salesOfficerNameHeader').show();

            for (var a = 0; a < source; a++) {
                $('#salesOfficerNameField-' + a).show();
            }

            $(this).attr("data-id", 1);
        }

    });

    $('#salesOfficerContactFilter').click(function () {

        var id = $(this).attr("data-id");
        var source = $(this).attr("data-source");
        if (id == 1) {
            $('#salesOfficerContactHeader').hide();

            for (var a = 0; a < source; a++) {
                $('#salesOfficerContactField-' + a).hide();
            }
            $(this).attr("data-id", 0);
        } else {
            $('#salesOfficerContactHeader').show();

            for (var a = 0; a < source; a++) {
                $('#salesOfficerContactField-' + a).show();
            }

            $(this).attr("data-id", 1);
        }

    });

    $('#salesOfficerLeadsFilter').click(function () {

        var id = $(this).attr("data-id");
        var source = $(this).attr("data-source");
        if (id == 1) {
            $('#salesOfficerLeadsHeader').hide();

            for (var a = 0; a < source; a++) {
                $('#salesOfficerLeadsField-' + a).hide();
            }
            $(this).attr("data-id", 0);
        } else {
            $('#salesOfficerLeadsHeader').show();

            for (var a = 0; a < source; a++) {
                $('#salesOfficerLeadsField-' + a).show();
            }

            $(this).attr("data-id", 1);
        }

    });

    $('#salesOfficerPointsFilter').click(function () {

        var id = $(this).attr("data-id");
        var source = $(this).attr("data-source");
        if (id == 1) {
            $('#salesOfficerPointsHeader').hide();

            for (var a = 0; a < source; a++) {
                $('#salesOfficerPointsField-' + a).hide();
            }
            $(this).attr("data-id", 0);
        } else {
            $('#salesOfficerPointsHeader').show();

            for (var a = 0; a < source; a++) {
                $('#salesOfficerPointsField-' + a).show();
            }

            $(this).attr("data-id", 1);
        }

    });

    $('#salesOfficerSalesTeamFilter').click(function () {

        var id = $(this).attr("data-id");
        var source = $(this).attr("data-source");
        if (id == 1) {
            $('#salesOfficerSalesTeamHeader').hide();

            for (var a = 0; a < source; a++) {
                $('#salesOfficerSalesTeamField-' + a).hide();
            }
            $(this).attr("data-id", 0);
        } else {
            $('#salesOfficerSalesTeamHeader').show();

            for (var a = 0; a < source; a++) {
                $('#salesOfficerSalesTeamField-' + a).show();
            }

            $(this).attr("data-id", 1);
        }

    });

    $('#salesOfficerStatusFilter').click(function () {

        var id = $(this).attr("data-id");
        var source = $(this).attr("data-source");
        if (id == 1) {
            $('#salesOfficerStatusHeader').hide();

            for (var a = 0; a < source; a++) {
                $('#salesOfficerStatusField-' + a).hide();
            }
            $(this).attr("data-id", 0);
        } else {
            $('#salesOfficerStatusHeader').show();

            for (var a = 0; a < source; a++) {
                $('#salesOfficerStatusField-' + a).show();
            }

            $(this).attr("data-id", 1);
        }

    });

    $('#salesOfficerDateFilter').click(function () {

        var id = $(this).attr("data-id");
        var source = $(this).attr("data-source");
        if (id == 1) {
            $('#salesOfficerDateHeader').hide();

            for (var a = 0; a < source; a++) {
                $('#salesOfficerDateField-' + a).hide();
            }
            $(this).attr("data-id", 0);
        } else {
            $('#salesOfficerDateHeader').show();

            for (var a = 0; a < source; a++) {
                $('#salesOfficerDateField-' + a).show();
            }

            $(this).attr("data-id", 1);
        }

    });

    $('#selectSalesOfficer').click(function () {
        $('#divSelectSalesOfficer').toggle();
    });

    $('#selectAllSalesOfficer').click(function () {
        $('#divSelectSalesOfficer').toggle();
    });

    $('#leadByCategory').click(function () {
        $('#divCategory').show();
        $('#divStatus').hide();
    });

    $('#leadByStatus').click(function () {
        $('#divStatus').show();
        $('#divCategory').hide();

    });

});

var myChartTeam;

var baseUrl = 'https://jala.ai/dashboard/'

var urlGetPerformance = baseUrl + 'lead/getSalesTeamLeadPerformance?page=1';
$.ajax({
    url: urlGetPerformance, success: function (dataChart) {

        var length_ = dataChart[1].length;

        if (length_ < 5) {
            $('#btn-show-more-team').hide();
        }

        var ctx = document.getElementById("performancesSalesTeamIn");
        myChartTeam = new Chart(ctx, {
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
            $("#wait-lead-salesTeam").css("display", "none");
            console.log('lead total loader close');
        });

    }
});

$('#btn-show-more-team').click(function () {

    myChartTeam.destroy();

    var page = $('#pageTeam').val();
    var page_new = parseInt(page) + 1;
    var newHight = 200 * page_new;

    $('#pageTeam').val(page_new);

    $('#btn-show-less-team').show();

    var urlGetPerformance = baseUrl + 'lead/getSalesTeamLeadPerformance/?page=' + page_new;
    $.ajax({
        url: urlGetPerformance, success: function (dataChart) {

            $('.chart-performances-sales-team-in').css('height', newHight);
            var ctx = document.getElementById("performancesSalesTeamIn");
            myChartTeam = new Chart(ctx, {
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

});

$('#btn-show-less-team').click(function () {

    myChartTeam.destroy();

    var page = $('#pageTeam').val();
    var page_new = parseInt(page) - 1;
    var newHight = 200 * page_new;

    $('#pageTeam').val(page_new);

    if (page_new == 1) {
        $('#btn-show-less-team').hide();
    }

    var urlGetPerformance = baseUrl + 'lead/getSalesTeamLeadPerformance?page=' + page_new;

    $.ajax({
        url: urlGetPerformance, success: function (dataChart) {

            $('.chart-performances-sales-team-in').css('height', newHight);
            var ctx = document.getElementById("performancesSalesTeamIn");
            myChartTeam = new Chart(ctx, {
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

});

var myChart;

var urlGetPerformance = baseUrl + 'lead/getSalesOfficerLeadPerformance/?page=1';
$.ajax({
    url: urlGetPerformance, success: function (dataChart) {

        var length_ = dataChart[1].length;

        console.log(length_);

        if (length_ < 5) {
            $('#btn-show-more').hide();
        }
        var ctx = document.getElementById("performancesSalesOfficerIn");
        myChart = new Chart(ctx, {
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
            $("#wait-lead-salesOfficer").css("display", "none");
            console.log('lead total loader close');
        });

    }
});

$('#btn-show-more').click(function () {

    myChart.destroy();

    var page = $('#page').val();
    var page_new = parseInt(page) + 1;
    var newHight = 200 * page_new;

    $('#page').val(page_new);
    $('#btn-show-less').show();

    var urlGetPerformance = baseUrl + 'lead/getSalesOfficerLeadPerformance?page=' + page_new;

    $.ajax({
        url: urlGetPerformance, success: function (dataChart) {

            $('.chart-performances-sales-officer-in').css('height', newHight);
            var ctx = document.getElementById("performancesSalesOfficerIn");
            myChart = new Chart(ctx, {
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

});

$('#btn-show-less').click(function () {

    myChart.destroy();

    var page = $('#page').val();
    var page_new = parseInt(page) - 1;
    var newHight = 200 * page_new;

    $('#page').val(page_new);

    if (page_new == 1) {
        $('#btn-show-less').hide();
    }

    var urlGetPerformance = baseUrl + 'lead/getSalesOfficerLeadPerformance?page=' + page_new;

    $.ajax({
        url: urlGetPerformance, success: function (dataChart) {

            $('.chart-performances-sales-officer-in').css('height', newHight);
            var ctx = document.getElementById("performancesSalesOfficerIn");
            myChart = new Chart(ctx, {
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

});



