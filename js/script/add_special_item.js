jQuery(document).ready( function($) {
    $( "#add_post_special_name" ).click(function() {
        var obj = new Object();
        obj.name = $('#special_post_name').val();
        obj.descrizione =$('#descrizione_post_speciale').val();
        jsonString = JSON.stringify(obj);
        var data = {
            action : 'MTJ_add_post_special',
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

                    $('#tableMenu').append('<tr><td>'+date.name+'</td><td>'+date.descrizione+'</td><td><span class="glyphicon glyphicon-remove-sign delete_special_post" data-ids="'+date.id_link+'"></span><span class="glyphicon glyphicon-pencil rename_special_post" data-ids="'+date.id_link+'"></span></td></tr>');
                }
            });

    });
});