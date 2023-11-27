$(document).ready(function () {

    $('#btnDay').click(function () {
        $(this).addClass('active');
        $('#btnMonth').removeClass('active');
        $('#btnYear').removeClass('active');
            
        var urlGetDataTotalLead = 'lead/getDataTotalLead/?period=' + 'DAY';

        $.ajax({url: urlGetDataTotalLead, success: function (dataChart) {

                $('#pTotal1').html(dataChart.total[0].status);

                if (typeof dataChart.total[1] !== 'undefined') {
                    $('#pTotal2').show();
                    $('#pTotal2').html(dataChart.total[1].status);
                } else {
                    $('#pTotal2').hide();
                    $('#pTotal2').html('');
                }

                $('#numTotal1').html(dataChart.total[0].jumlah);

                if (typeof dataChart.total[1] !== 'undefined') {
                    $('#numTotal2').html(dataChart.total[1].jumlah);
                } else {
                    $('#numTotal2').html('');
                }

                $('#chartLeadTotal').highcharts({
                    title: {
                        text: 'Total',
                        x: -20 //center
                    },
                    xAxis: {
                        categories: dataChart.categories
                    },
                    series: dataChart.series
                });


            }});

    });

    $('#btnMonth').click(function () {
        $(this).addClass('active');
        $('#btnDay').removeClass('active');
        $('#btnYear').removeClass('active');
        
        var urlGetDataTotalLead = 'lead/getDataTotalLead/?period=' + 'MONTH';
        $.ajax({url: urlGetDataTotalLead, success: function (dataChart) {

                $('#pTotal1').html(dataChart.total[0].status);

                if (typeof dataChart.total[1] !== 'undefined') {
                    $('#pTotal2').html(dataChart.total[1].status);
                } else {
                    $('#pTotal2').html('');
                }

                $('#numTotal1').html(dataChart.total[0].jumlah);

                if (typeof dataChart.total[1] !== 'undefined') {
                    $('#numTotal2').html(dataChart.total[1].jumlah);
                } else {
                    $('#numTotal2').html('');
                }

                $('#chartLeadTotal').highcharts({
                    title: {
                        text: 'Total',
                        x: -20 //center
                    },
                    xAxis: {
                        categories: dataChart.categories
                    },
                    series: dataChart.series
                });


            }});
    });

    $('#btnYear').click(function () {
        $(this).addClass('active');
        $('#btnDay').removeClass('active');
        $('#btnMonth').removeClass('active');
        
        var urlGetDataTotalLead = 'lead/getDataTotalLead/?period=' + 'YEAR';
        $.ajax({url: urlGetDataTotalLead, success: function (dataChart) {

                $('#pTotal1').html(dataChart.total[0].status);

                if (typeof dataChart.total[1] !== 'undefined') {
                    $('#pTotal2').html(dataChart.total[1].status);
                } else {
                    $('#pTotal2').html('');
                }

                $('#numTotal1').html(dataChart.total[0].jumlah);

                if (typeof dataChart.total[1] !== 'undefined') {
                    $('#numTotal2').html(dataChart.total[1].jumlah);
                } else {
                    $('#numTotal2').html('');
                }

                $('#chartLeadTotal').highcharts({
                    title: {
                        text: 'Total',
                        x: -20 //center
                    },
                    xAxis: {
                        categories: dataChart.categories
                    },
                    series: dataChart.series
                });
   

            }});
    });

    var time = $('.btn-time.active').val();
    var urlGetDataTotalLead = 'lead/getDataTotalLead/?period=' + time;
    $.ajax({url: urlGetDataTotalLead, success: function (dataChart) {

            $('#pTotal1').html(dataChart.total[0].status);

            if (typeof dataChart.total[1] !== 'undefined') {
                $('#pTotal2').html(dataChart.total[1].status);
            } else {
                $('#pTotal2').html('');
            }
            
            console.log(dataChart.total[1].status);
            
            if(dataChart.total[1].status !== ' All :') {
                $('#pTotal2').html(dataChart.total[1].status);
            } else {
                $('#pTotal2').html('');
            }
            

            $('#numTotal1').html(dataChart.total[0].jumlah);

            if (typeof dataChart.total[1] !== 'undefined') {
                $('#numTotal2').html(dataChart.total[1].jumlah);
            } else {
                $('#numTotal2').html('');
            }
            
            if (dataChart.total[1].status !== ' All :') {
                $('#numTotal2').html(dataChart.total[1].jumlah);
            } else {
                $('#numTotal2').html('');
            }

            $('#chartLeadTotal').highcharts({
                title: {
                    text: '',
                    x: -20 //center
                },
                xAxis: {
                    categories: dataChart.categories
                },
                series: dataChart.series
            });


        }});

});