$(document).ready(function () {
    $(".btnEditUser").click(function () {
        var btnId = $(this).attr("id");
        var id = $("#" + btnId).attr("data-id");

        var urlGetDataUser = 'user/getDataUserEdit/?id=' + id;
        $.ajax({url: urlGetDataUser, success: function (data) {
                $('#editUserEmail').val(data.data.email);
                $('#editUserPhone').val(data.data.phone);
//                $('#editUserPassword').val(data.data.password);
                $('#editUserAddress').val(data.data.address);
                $('#editUserId').val(data.data.user_id);
            }});

    });
    $("#userEmail").change(function () {
        var email = $(this).val();

        var urlValidateEmail = '../user/validate_email/?email=' + email;
        $.ajax({url: urlValidateEmail, success: function (data) {

                if (data.res == 200) {
                    $('#userEmail').val("");
                    alert('email address already used');
                }
            }});

    });

    $("#userRoleSelect").change(function () {
        var id = $(this).val();
        if (id === "5") {
            $("#projectSelect").show();
        } else {
            $("#projectSelect").hide();
        }
    });

});     