$(document).ready(function () {
    $('.getAllData').on('click',function (e) {
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
            type: "POST",
            url: "/api/detailOrder/",
            data: "id="+id,
            success: function(msg){

            }
        });
    });
});

