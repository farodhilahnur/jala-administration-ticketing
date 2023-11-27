$(document).ready(function () {
    $(".btnEditCampaign").click(function () {
        var btnId = $(this).attr("id");
        var id = $("#" + btnId).attr("data-id");

        var urlGetDataCampaign = '../getDataCampaignEdit/?id=' + id;
        $.ajax({
            url: urlGetDataCampaign, success: function (data) {
                var src1 = "assets/picture/campaign/" + data.data.campaign_picture;
                $('#campaignName').val(data.data.campaign_name);
                $('#campaignId').val(data.data.id);
                $('#campaignDetail').val(data.data.campaign_detail);
                $("#campaignPicture").attr("src", src1);
            }
        });

    });
});

var myChartCampaign;

var projectId = $('#projectIdCampaign').val();
var urlGetPerformance = '../../lead/getLeadPerformanceCampaignIn/?id=' + projectId + '&page=' + 1;
$.ajax({
    url: urlGetPerformance, success: function (dataChart) {

        if (dataChart[1].length < 5) {
            $('#btn-show-more-campaign').hide();
        }

        var ctx = document.getElementById("performancesCampaignIn");
        myChartCampaign = new Chart(ctx, {
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
            $("#wait-lead-CampaignIn").css("display", "none");
            console.log('lead total loader close');
        });
    }
});

$('#btn-show-more-campaign').click(function () {

    myChartCampaign.destroy();

    var projectId = $('#projectIdCampaign').val();
    var page = $('#pageCampaign').val();
    var page_new = parseInt(page) + 1;
    var newHight = 200 * page_new;

    $('#pageCampaign').val(page_new);
    $('#btn-show-less-campaign').show();

    var urlGetPerformance = '../../lead/getLeadPerformanceCampaignIn/?id=' + projectId + '&page=' + page_new;

    $.ajax({
        url: urlGetPerformance, success: function (dataChart) {

            $('.chart-performances-campaign-in').css('height', newHight);
            var ctx = document.getElementById("performancesCampaignIn");
            myChartCampaign = new Chart(ctx, {
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

$('#btn-show-less-campaign').click(function () {

    myChartCampaign.destroy();

    var projectId = $('#projectIdCampaign').val();
    var page = $('#pageCampaign').val();
    var page_new = parseInt(page) - 1;
    var newHight = 200 * page_new;

    $('#pageCampaign').val(page_new);

    if (page_new == 1) {
        $('#btn-show-less-campaign').hide();
    }

    var urlGetPerformance = '../../lead/getLeadPerformanceCampaignIn/?id=' + projectId + '&page=' + page_new;

    $.ajax({
        url: urlGetPerformance, success: function (dataChart) {

            $('.chart-performances-campaign-in').css('height', newHight);
            var ctx = document.getElementById("performancesCampaignIn");
            myChartCampaign = new Chart(ctx, {
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