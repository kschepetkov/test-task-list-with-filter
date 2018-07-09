$(document).ready(function () {
    $('.getAllData').on('click',function (e) {
        var id = $(this).data('id');
        if(id != '' && id != undefined){
            var content = '';
            $('.order_nomer').text(id);
            $(".detail_element").detach();
            $.ajax({
                type: "POST",
                url: "/api/detailOrder/",
                data: "id="+id,
                dataType : "json",
                success: function(data){
                    if(data){
                        $.each(data,function(index,value){
                            content += '<tr class="detail_element">' +
                                        '<td>'+value.prod_id+'</td>' +
                                        '<td>'+value.prod_name+'</td>' +
                                        '<td>'+value.item_price+'</td>' +
                                        '<td>'+value.quantity+'</td>' +
                                        '<td>'+value.summ+'</td>' +
                                       '</tr>';
                        });
                        $(".content_table").append(content);
                        $("#detailOrder").modal('show');
                    }
                }
            });
        }
    });


});
