jQuery(document).ready( function($) {
    $( "#add_post_item_name" ).click(function() {
        var obj = new Object();
        obj.link_name = $('#post_item_name').val();
        obj.link =$('#post_item_list').val();
        jsonString = JSON.stringify(obj);
        var data = {
            action : 'MTJ_add_post_menu',
            data : jsonString
        };
            $.post(ajaxurl,
                data,
                function (dataR, textStatus, jqXHR) {
                    var returnedData = JSON.parse(dataR);
                    if(returnedData.status == -1 ) {
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
                    else{
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
                        var date = JSON.parse(returnedData.data);
                        var rowCount = $('#tableMenuVoices tr').length;
                        if(rowCount == 2){
                            var trovato = false;
                            $('#tableMenuVoices tr').each(function () {
                                var row = $(this)[0].cells[0].childNodes[0].nodeValue;
                                if(row == "No data available in table"){
                                    trovato = true;
                                }
                            });
                            if(trovato)
                                $('#tableMenuVoices').find('tbody').empty();
                        }

                        $('#tableMenuVoices').append('<tr><td>'+date.link+'</td><td>'+date.name_link+'</td><td><span class="glyphicon glyphicon-remove-sign delete_post" data-ids="'+date.id_link+'"></span><span class="glyphicon glyphicon-pencil rename_post" data-ids="'+date.id_link+'"></span></td></tr>');
                    }
                });

    });
});