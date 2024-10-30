jQuery(document).ready( function($) {
    $('body').on('change', '.change_state', function (e) {
        e.preventDefault();
        var obj = new Object();
        var value = $(this).is(':checked');
        obj.id = $(this).attr("data-ids");
        if (value) {
            $(".change_state").not(this).each(function () {
                $(this).prop('checked', false).bootstrapToggle('destroy').bootstrapToggle();
            });
        }
        if (value == true)
            obj.value = 1;
        else
            obj.value = 0;
        jsonString = JSON.stringify(obj);
        var data = {
            action: 'MTJ_change_state_item',
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
                var data = {
                    action: 'MTJ_update_post_table',
                };
                $.post(ajaxurl, data, function (dataR, textStatus, jqXHR) {
                    var returnedData = JSON.parse(dataR);
                    var json = JSON.parse(returnedData.results);
                    $('#tableMenuVoices').find('tbody').empty();
                    if(json == null){
                        $('#tableMenuVoices').append('<tr><td valign="top" colspan="3" class="dataTables_empty">No data available in table</td></tr>');
                    }
                    else {
                        json.forEach(function (element) {
                            if(element["status"] ==1) {
                                var state = '<span class="glyphicon glyphicon-remove-sign add_post" data-ids="'+element["id"]+'"></span><span class="glyphicon glyphicon-pencil remove_post" data-ids="'+element["id"]+'"></span>';
                            }
                            else{
                                var state = '<span class="glyphicon glyphicon-remove-sign add_post" data-ids="'+element["id"]+'"></span><span class="glyphicon glyphicon-pencil remove_post" data-ids="'+element["id"]+'"></span>';

                            }
                            $('#tableMenuVoices').append('<tr><td>' + element["post_name"]+"("+element["id"]+")" + '</td><td>' + element["name"] + '</td><td>' + state + '</td></tr>');
                        });
                    }
                });
            }
        });

    });
});