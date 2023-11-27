(function ($) {
    $(document).ready(function () {
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

        var q = getUrlParameter('q');
        var url = "https://jala.ai/dashboard/tracking/";

      	console.log('test');
      
        if (typeof q != 'undefined') {
            var data = {
                'query': q
            }

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: url,
                data: data,
                success: function (data) {
                    $('#form-field-source').val(data.unique_code);
                }
            });

        }
    });
	
  	$('form').submit(function (event) {

        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
        var formData = {
            'name': $('#form-field-name').val(),
            'email': $('#form-field-email').val(),
            'phone': $('#form-field-phone').val(),
            'source': $('#form-field-source').val(),

        };

        console.log(formData);

        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: 'https://jala.ai/dashboard/lead/post_lead_martadinata/', // the url where we want to POST
            data: formData, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
                // using the done promise callback
                .done(function (data) {

                    // log data to the console so we can see
                    //console.log(data);
                    if (data.res) {
                        alert('thanks for your interest');
                    } else {
                        alert('sorry the system has been error');
                    }
                    window.location.href = data.redirect;
                    // here we will handle errors and validation messages
                });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    });
  
})(jQuery);
