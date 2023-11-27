$(document).ready(function () {
    $('#newLeads').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='new-leads-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='New Leads' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='0' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#new-leads-list').remove();
        }
    });
    $('#interested').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='interest-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='Interested' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='5' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#interest-list').remove();
        }
    });
    $('#reservation').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='reservation-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='Reservation' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='15' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#reservation-list').remove();
        }
    });
    $('#booking').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='booking-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='Booking' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='20' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#booking-list').remove();
        }
    });
    $('#kPRProcess').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='kprkpa-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='KPR Process' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='0' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#kprkpa-list').remove();
        }
    });
    $('#closing').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='closing-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='Closing' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='100' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#closing-list').remove();
        }
    });
    $('#interestedbutNotNow').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='interest-but-not-now-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='Interested but Not Now' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='1' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#interest-but-not-now-list').remove();
        }
    });
    $('#noResponse').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='no-response-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='No Response' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='0' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#no-response-list').remove();
        }
    });
    $('#notInterested').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='not-interest-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='Not Interested' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='1' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#not-interest-list').remove();
        }
    });
    $('#inactive').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='inactive-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='Inactive' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='0' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#inactive-list').remove();
        }
    });
    $('#callback').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='callback-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='Callback' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='0' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#callback-list').remove();
        }
    });
    $('#invalid').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='invalid-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='Invalid' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='0' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#invalid-list').remove();
        }
    });
    $('#visitStore').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='visit-store-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='Visit Store' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='0' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#visit-store-list').remove();
        }
    });
    $('#walkIn').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='walk-in-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='Walk In' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='10' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#walk-in-list').remove();
        }
    });
    $('#veryInterested').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='very-interested-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='Very Interested' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='10' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#very-interested-list').remove();
        }
    });
    $('#visit').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='visit-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='Visit' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='15' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#visit-list').remove();
        }
    });
    $('#deliveryOrder').click(function () {
        if ($(this).is(':checked')) {
            var htmlStatusList = "<li id='delivery-order-list' class='list-group-item'>" +
                "<div class='form-group'>" +
                "<div class='col-md-5'>" +
                "<input type='text' class='form-control' value='Delivery Order' name='status_name[]' readonly/>" +
                "</div>" +
                "<div class='col-md-3'>" +
                "<input type='number' class='form-control' name='point[]' value='100' required/>" +
                "</div>" +
                "</div>" +
                "</li>";
            $("#list-custom-status").append(htmlStatusList);
        } else {
            $('#delivery-order-list').remove();
        }
    });

    $('#btn-grid').click(function () {
        $(this).addClass('active');
        $('#btn-list').removeClass('active');
        $('#grid-view').fadeIn();
        $('#list-view').fadeOut();
    })

    $('#btn-list').click(function () {
        $(this).addClass('active');
        $('#btn-grid').removeClass('active');
        $('#grid-view').fadeOut();
        $('#list-view').fadeIn();
    })

});

function channelDetail(id) {
    document.location.href = "project_new/channel/?id=" + id;
}

function campaignDetail(id) {
    document.location.href = "project_new/campaign/?id=" + id;
}

function leadDetail(id) {
    document.location.href = "project_new/leads/?id=" + id;
}

function productDetail(id) {
    document.location.href = "project_new/product/?id=" + id;
}