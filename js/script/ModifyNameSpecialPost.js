jQuery(document).ready( function($) {
    $('body').on('click', '.rename_special_post', function (e) {
        e.preventDefault();
        var obj = new Object();
        obj.id = $(this).attr("data-ids");
        var column = $(this).parent().parent()[0];
        $(".update_menu_item_name").val(column.cells[0].childNodes[0].nodeValue);
        $("#descr_post_speciale").val(column.cells[1].childNodes[0].nodeValue);
        $('#confirm_update').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '.delete', function (e) {
            e.preventDefault();
            obj.col = $(".update_menu_item_name").val();
            obj.descr =  $("#descr_post_speciale").val();
            jsonString = JSON.stringify(obj);
            var data = {
                action: 'MTJ_update_special_post',
                data: jsonString
            };
            $.post(ajaxurl, data, function (dataR, textStatus, jqXHR) {
                var returnedData = JSON.parse(dataR);
                if (returnedData.status == -1) {
                    jQuery.notify({
                        message: returnedData.message
                    }, {
                        // settings
                        type: 'danger',
                        offset: {
                            x: 10,
                            y: 40
                        }
                    });
                }
                else {
                    jQuery.notify({
                        // options
                        message: returnedData.message
                    }, {
                        // settings
                        type: 'success',
                        offset: {
                            x: 10,
                            y: 40
                        }
                    });
                    column.cells[0].childNodes[0].nodeValue = returnedData.value;
                    column.cells[1].childNodes[0].nodeValue = returnedData.descr;
                }
            });
        });
    });
});