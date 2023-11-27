$(document).ready(function () {
    $(".btnEditChannel").click(function () {

        var btnId = $(this).attr("id");
        var id = $("#" + btnId).attr("data-id");

        var urlGetDataChannel = '../getDataChannelEdit/?id=' + id;
        $.ajax({
            url: urlGetDataChannel, success: function (data) {
                var src1 = "assets/picture/channel/" + data.data.channel_picture;
                $('#channelName').val(data.data.channel_name);
                $('#channelId').val(data.data.id);
                $('#channelDetail').val(data.data.channel_detail);
                $("#channelPic").attr("src", src1);
                $("#landingPageUrl").val(data.data.channel_url);
                $("#redirectUrl").val(data.data.channel_redirect_url);
                $('#uniqueCode').val(data.data.unique_code);
                $("#mediaIdEdit").val(data.data.channel_media);
            }
        });

    });

    $('.mediaSelect').change(function () {
        var id = $(this).val();
        var urlCheckMedia = '../getCheckMedia/?id=' + id;
        $.ajax({
            url: urlCheckMedia, success: function (data) {
                if (data.data.media_category == 2) {
                    $('#landingPageUrlField').hide();
                    $('#redirectPageUrlField').hide();
                    $('#landingPageUrlInput').removeAttr('required');
                    $('#redirectPageUrlInput').removeAttr('required');
                } else if (data.data.media_category == 3) {
                    $('#landingPageUrlField').hide();
                    $('#redirectPageUrlField').hide();
                    $('#landingPageUrlInput').removeAttr('required');
                    $('#redirectPageUrlInput').removeAttr('required');
                } else {
                    $('#landingPageUrlField').show();
                    $('#redirectPageUrlField').show();
                    $('#landingPageUrlInput').prop('required', true);
                    $('#redirectPageUrlInput').prop('required', true);
                    ;
                }
            }
        });
    });


});

var myChartChannel;

var projectId = $('#projectIdChannel').val();
var urlGetPerformance = '../../lead/getLeadPerformanceChannelIn/?id=' + projectId + '&page=1';
$.ajax({
    url: urlGetPerformance, success: function (dataChart) {

        if (dataChart[1].length < 5) {
            $('#btn-show-more-channel').hide();
        }

        var ctx = document.getElementById("performancesChannelIn");
        myChartChannel = new Chart(ctx, {
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
            $("#wait-lead-channelIn").css("display", "none");
            console.log('lead total loader close');
        });

    }
});

$('#btn-show-more-channel').click(function () {

    myChartChannel.destroy();
    var page = $('#pageChannel').val();
    var page_new = parseInt(page) + 1;
    var newHight = 200 * page_new;

    $('#pageChannel').val(page_new);
    $('#btn-show-less-channel').show();

    var projectId = $('#projectIdChannel').val();
    var urlGetPerformance = '../../lead/getLeadPerformanceChannelIn/?id=' + projectId + '&page=' + page_new;
    $.ajax({
        url: urlGetPerformance, success: function (dataChart) {

            if (dataChart[1].length < 5) {
                $('#btn-show-more-channel').hide();
            }

            $('.chart-performances-channel-in').css('height', newHight);
            var ctx = document.getElementById("performancesChannelIn");
            myChartChannel = new Chart(ctx, {
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

})

$('#btn-show-less-channel').click(function () {

    myChartChannel.destroy();

    var projectId = $('#projectIdChannel').val();
    var page = $('#pageChannel').val();
    var page_new = parseInt(page) - 1;
    var newHight = 200 * page_new;

    $('#pageChannel').val(page_new);

    if (page_new == 1) {
        $('#btn-show-less-channel').hide();
    }

    var urlGetPerformance = '../../lead/getLeadPerformanceChannelIn/?id=' + projectId + '&page=' + page_new;

    $.ajax({
        url: urlGetPerformance, success: function (dataChart) {

            $('.chart-performances-channel-in').css('height', newHight);
            var ctx = document.getElementById("performancesChannelIn");
            myChartChannel = new Chart(ctx, {
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