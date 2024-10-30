jQuery(document).ready( function($) {
    $( "#add_menu_item_name" ).click(function() {
        var menu_name = $('#menu_item_name').val();
        var data = {
            action : 'MTJ_add_item_menu',
            data : menu_name
        };
        var row =
        $.post(ajaxurl,
            data,
            function (dataR, textStatus, jqXHR) {
                var returnedData = JSON.parse(dataR);
                if(returnedData.status == -1 ) {

                    jQuery.notify({
                        // options
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
                else{
                    var date = JSON.parse(returnedData.data);
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
                    var rowCount = $('#tableMenu tr').length;
                    if(rowCount == 2){
                        var trovato = false;
                        $('#tableMenu tr').each(function () {
                            var row = $(this)[0].cells[0].childNodes[0].nodeValue;
                            if(row == "No data available in table"){
                                trovato = true;
                            }
                        });
                        if(trovato)
                        $('#tableMenu').find('tbody').empty();
                    }

                    var state ='<input class="change_state" type="checkbox" data-ids="'+date[0].id_menu+'" data-toggle="toggle" data-size="small">';
                    $('#tableMenu').append('<tr><td>'+date[0].menu_name+'</td><td>'+state+'</td><td><span class="glyphicon glyphicon-remove-sign delete_item" data-ids="'+date[0].id_menu+'"></span><span class="glyphicon glyphicon-pencil rename_item" data-ids="'+date[0].id_menu+'"></span></td></tr>');
                    $(".change_state").each(function() {
                        $(this).bootstrapToggle('destroy').bootstrapToggle();
                    });
                }
            });

    });
});