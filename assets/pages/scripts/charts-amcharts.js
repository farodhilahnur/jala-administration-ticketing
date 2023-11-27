var ChartsAmcharts = function () {

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

    var id = getUrlParameter('id');

    var dataxx = [];

    var urlGetDataLeadProduct = 'https://jala.ai/jala-new/product/getDataChartProduct/?id=' + id;
    $.ajax({url: urlGetDataLeadProduct, success: function (data) {
            
            for(var a = 0 ; a < data.count ; a++){
                var datax = data.data[a];
                
                dataxx.push(datax);
            }
            
            /*var datax = {
                "country": "Lithuania",
                "value": 260
            };*/

            

        }});


    var initChartSample7 = function () {
        var chart = AmCharts.makeChart("chart_7", {
            "type": "pie",
            "theme": "dark",

            "fontFamily": 'Open Sans',

            "color": '#888',

            "dataProvider": dataxx,
            "valueField": "value",
            "titleField": "country",
            "outlineAlpha": 0.4,
            "depth3D": 15,
            "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
            "angle": 30,
            "exportConfig": {
                menuItems: [{
                        icon: '/lib/3/images/export.png',
                        format: 'png'
                    }]
            }
        });

        jQuery('.chart_7_chart_input').off().on('input change', function () {
            var property = jQuery(this).data('property');
            var target = chart;
            var value = Number(this.value);
            chart.startDuration = 0;

            if (property == 'innerRadius') {
                value += "%";
            }

            target[property] = value;
            chart.validateNow();
        });

        $('#chart_7').closest('.portlet').find('.fullscreen').click(function () {
            chart.invalidateSize();
        });
    }

    return {
        //main function to initiate the module

        init: function () {

            initChartSample7();
        }

    };

}();

jQuery(document).ready(function () {
    ChartsAmcharts.init();
});     