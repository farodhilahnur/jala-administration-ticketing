$(document).ready(function () {
    $(".btnEditProduct").click(function () {

        var btnId = $(this).attr("id");
        var id = $("#" + btnId).attr("data-id");

        var urlGetDataProduct = '../../project/getDataProductEdit/?id=' + id;
        $.ajax({url: urlGetDataProduct, success: function (data) {
                $('#productName').val(data.data.product_name);
                $('#productId').val(data.data.id);
                $('#projectId').val(data.data.project_id);
                $('#productPrice').val(data.data.product_price);
                $('#productDetail').val(data.data.product_detail);
            }});

    });
    $(".btnEditStatus").click(function () {

        var btnId = $(this).attr("id");
        var id = $("#" + btnId).attr("data-id");

        var urlGetDataStatus = '../../project/getDataStatusEdit/?id=' + id;
        $.ajax({url: urlGetDataStatus, success: function (data) {
                $('#statusName').val(data.data.status_name);
                $('#statusId').val(data.data.id);
                $('#projectIdStatus').val(data.data.project_id);
                $('#statusPoint').val(data.data.point);
            }});

    });
});     