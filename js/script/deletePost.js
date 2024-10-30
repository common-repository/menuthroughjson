jQuery(document).ready( function($) {
    $('body').on('click', '.delete_post', function (e) {
        e.preventDefault();
        var id = $(this).attr("data-ids");
        var row = $(this).parent().parent();
        $('#modal_delete_post').modal({
            backdrop: 'static',
            keyboard: false
        })
            .one('click', '.delete_post_confirm', function (e) {
                e.preventDefault();
                var data = {
                    action: 'MTJ_delete_post',
                    data: id
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
                        row.remove();
                        var rowCount = $('#tableMenuVoices tr').length;
                        if(rowCount == 1){
                            $('#tableMenuVoices').append('<tr><td valign="top" colspan="3" class="dataTables_empty">No data available in table</td></tr>');
                        }
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
                    }
                });
            });
    });
});