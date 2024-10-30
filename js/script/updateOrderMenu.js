jQuery(document).ready( function($) {
   $( "#aggiorna_ordine" ).click(function(e) {
       e.preventDefault();
       var replicate_ordered = false;
       var jsonString = "";
       var array_order = [];
       var array_object = [];
       var table = $('#tableMenu').dataTable().fnGetNodes();
       table.forEach(function (element) {
           if (array_order.indexOf(element.cells[2].childNodes[1].value) == -1) {
               var obj = new Object();
               obj.id = element.cells[2].childNodes[1].getAttribute("data-ids");
               obj.order = element.cells[2].childNodes[1].value;
               array_object.push(obj);
               array_order.push(element.cells[2].childNodes[1].value);
           }
           else {
               replicate_ordered = true;
           }
       });
       if (!replicate_ordered) {
           jsonString = JSON.stringify(array_object);
           var data = {
               action : 'MTJ_reload_menu',
               data : jsonString
           };
           $('#confirm').modal({
               backdrop: 'static',
               keyboard: false
           })
               .one('click', '.delete', function (e) {
                   e.preventDefault();
                   $.post(ajaxurl,
                       data,
                       function (dataR, textStatus, jqXHR) {
                           var returnedData = JSON.parse(dataR);
                           if (returnedData.status == -1) {

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
                           }
                       });
               });
       }
       else {
           jQuery.notify({
               // options
               message: 'Ci sono due elementi con lo stesso ordine'
           }, {
               // settings
               type: 'danger',
               offset: {
                   x: 10,
                   y: 40
               }
           });
       }
   });
});