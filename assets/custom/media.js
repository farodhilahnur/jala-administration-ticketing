$(document).ready(function () {
    $(".btnEditMedia").click(function () {
        var btnId = $(this).attr("id");
        var id = $("#" + btnId).attr("data-id");

        var urlGetDataMedia = 'media/getDataMediaEdit/?id=' + id;
        $.ajax({url: urlGetDataMedia, success: function (data) {
                var src1 = "assets/picture/media/" + data.data.media_pic;
                $('#mediaName').val(data.data.media_name);
                $('#mediaId').val(data.data.id);
                $('#mediaCategory').val(data.data.media_category);
                $("#mediaPicture").attr("src", src1);
            }});

    });
});     