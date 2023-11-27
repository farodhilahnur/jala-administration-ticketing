$(document).ready(function () {
    $(".btnEditClub").click(function () {
        var btnId = $(this).attr("id");
        var id = $("#" + btnId).attr("data-id");

        var urlGetDataGenset = 'http://localhost/daihatsu-club-cms/club/getDataClubEdit/?id=' + id;
        $.ajax({url: urlGetDataGenset, success: function (data) {
                $('#clubName').val(data.data.club_name);
                $('#clubSince').val(data.data.club_since);
                $('#clubMember').val(data.data.member);
                $('#clubKetua').val(data.data.ketua);
                $('#clubHumas').val(data.data.humas);
                $('#clubPhone').val(data.data.phone);
                $('#clubMail').val(data.data.mail);
                $('#clubAddress').val(data.data.address);
                $('#clubFb').val(data.data.facebook);
                $('#clubIg').val(data.data.instagram);
                $('#clubTw').val(data.data.twitter);
                $('#clubYt').val(data.data.youtube);
                $('#clubWebsite').val(data.data.website);
                $('#clubDetail').val(data.data.detail);
                $('#clubId').val(data.data.club_id);
                $("#clubLogo").attr("src", 'http://localhost/daihatsu-club-cms/assets/club/logo/' + data.data.club_logo);
            }});

    });
    $(".btnGalleryClub").click(function () {
        var btnId = $(this).attr("id");
        var id = $("#" + btnId).attr("data-id");

        var urlGetDataGenset = 'http://localhost/daihatsu-club-cms/club/getDataClubEdit/?id=' + id;
        $.ajax({url: urlGetDataGenset, success: function (data) {
                $('#clubIdGallery').val(data.data.club_id);
            }});

    });
    $(".btnGalleryView").click(function () {
        var btnId = $(this).attr("id");
        var id = $("#" + btnId).attr("data-id");

        var urlGetDataGenset = 'http://localhost/daihatsu-club-cms/club/getDataClubGallery/?id=' + id;
        $.ajax({url: urlGetDataGenset, success: function (data) {
                //$('#div-gallery').html(data.data.club_id);

                var elemen = '' ;

                for(var i = 0 ; i < data.data.length ; i++){

                  var link = data.data[i].link;

                  elemen += "<div class='col-sm-12 col-md-4'>"+
                      "<div class='thumbnail'>"+
                          "<div style='width:100%;height:200px;background:url(http://localhost/daihatsu-club-cms/assets/club/gallery/" + link + " ) no-repeat center / contain'></div>" +
                          "<div class='caption'>" +
                              "<p style='text-align:center;'>" +
                                  "<a href='javascript:;' class='btn blue'> Delete </a>"+
                              "</p>"+
                          "</div>"+
                      "</div>"+
                  "</div>" ;
                }

                //console.log(elemen);

                $('#div-gallery').html(elemen);


            }});

    });
});
