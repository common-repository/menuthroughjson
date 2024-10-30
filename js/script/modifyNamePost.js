jQuery(document).ready( function($) {
    $('body').on('click', '.rename_post', function (e) {
        e.preventDefault();
        var obj = new Object();
        obj.id = $(this).attr("data-ids");
        var column = $(this).parent().parent()[0];
        $(".update_post_item_name").val(column.cells[1].childNodes[0].nodeValue);
        $('#rename_post_modal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '.rename_post_confirm', function (e) {
            e.preventDefault();
            obj.col = $(".update_post_item_name").val();
            jsonString = JSON.stringify(obj);
            var data = {
                action: 'MTJ_update_post_name',
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
                    column.cells[1].childNodes[0].nodeValue = returnedData.data;
                }
            });
        });
    });
});