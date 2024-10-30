
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<?php include "custom_class/MTJ_speciali.class.php";
$special = new MTJ_speciali();

?>

<div style="padding-right:10px;">

    <?php
    $specialLinks = array();
    $specialLinks = json_decode($special->getAllSpecialsLinks(),true);
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1>Gestione Speciali</h1>
                <div><hr /></div>
                <table id="tableMenu" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID speciale</th>
                        <th>Descrizione</th>
                        <th>Azioni</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($specialLinks != NULL){foreach ($specialLinks as $row){ ?>
                        <tr>
                            <td><?php echo $row["value"] ?></td>
                            <td><?php echo $row["descrizione"] ?></td>
                            <td><span class="glyphicon glyphicon-remove-sign delete_special_post" data-ids="<?php echo $row["id"] ?>"></span><span class="glyphicon glyphicon-pencil rename_special_post" data-ids="<?php echo $row["id"] ?>"></span></td>
                        </tr>
                    <?php } }?>
                    </tbody>
                </table>
                <!-- Modal per inserimento row -->
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Aggiungi post speciale</h4>
                            </div>
                            <div class="modal-body">
                                <label for="menu_item_name">Nome post speciale</label>
                                <input type="text" class="form-control" id="special_post_name"  placeholder="Menu Name">
                                <br>
                                <div class="form-group">
                                    <label for="comment">Descrizione</label>
                                    <textarea class="form-control" rows="5" id="descrizione_post_speciale"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Chiudi</button>
                                <button id="add_post_special_name" type="button" class="btn btn-primary" data-dismiss="modal">Salva</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- Fine Modal Insermento Row -->
                <!-- Conferma delete Row -->
                <div class="modal fade" id="confirm">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Conferma cancellazione</h4>
                            </div>
                            <div class="modal-body">
                                Vuoi veramente cancellare questa riga ? Questo processo non è reversibile
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Chiudi</button>
                                <button type="button" class="btn btn-primary del_special_post" data-dismiss="modal">Salva</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- Fine delete Row -->
                <!-- Conferma update state Row -->
                <div class="modal fade" id="confirm_update">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Aggiorna Nome o descrizione</h4>
                        </div>
                        <div class="modal-body">
                            <label for="menu_item_name">Nome</label>
                            <input type="text" class="form-control update_menu_item_name" id="update_menu_item_name" >
                            <br>
                            <div class="form-group">
                                <label for="comment">Descrizione</label>
                                <textarea class="form-control" rows="5" id="descr_post_speciale"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left closeModal" data-dismiss="modal">Chiudi</button>
                            <button type="button" class="btn btn-primary delete" data-dismiss="modal">Salva</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
                <!-- Fine Conferma change state Row -->
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>


</div>


<div style="margin-top:30px;">

<script>
        jQuery('#tableMenu').DataTable({
            "searching": false,
            "bInfo" : false,
            "lengthChange": false,
            "pageLength": 15,
            dom: 'l<"toolbar">frtip',
            initComplete: function(){
                jQuery("div.dataTables_paginate")
                    .append('<div class="toolbar"><button type="button" class="btn btn-block btn-primary" id="add_menu_item" ' +
                        '  data-toggle="modal" data-target="#modal-default">Aggiungi</button></div>');
            }
        });

        jQuery('#modal-default').on('hidden.bs.modal', function (e) {
            jQuery('#special_post_name').val("");
            jQuery('#descrizione_post_speciale').val("");
        });
        jQuery('#confirm_update').on('hidden.bs.modal', function (e) {
            jQuery('#update_menu_item_name').val("");
            jQuery('#descr_post_speciale').val("");
        });
        jQuery('.select2').select2();
</script>
</html>