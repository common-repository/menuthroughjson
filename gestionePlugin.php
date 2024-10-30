<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<?php include "custom_class/MTJ_gestionePlugin.class.php";
include "custom_class/MTJ_dashboard.class.php";
include "custom_class/MTJ_speciali.class.php";
$plugin = new MTJ_gestionePlugin;
$dashBoard = new MTJ_dashboardMenu;
$special = new MTJ_speciali();
?>

<div style="padding-right:10px;">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1>Gestione Menu'</h1>
                <div><hr /></div>
                <?php
                $resultMenu = array();
                $resultMenu = json_decode($plugin->getAllMenu(),true);
                $resultMenuVoices = array();
                $resultMenuVoices = json_decode($plugin->getAllMenuVoices($dashBoard),true);
                $links = array();
                $links = json_decode($plugin->getAllLinks(),true);
                $specialLinks = array();
                $specialLinks = json_decode($special->getAllSpecialsLinks(),true);
                ?>
                <table id="tableMenu" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nome menu'</th>
                        <th>Stato</th>
                        <th>Azioni</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($resultMenu != NULL){foreach ($resultMenu as $row){ ?>
                        <tr>
                            <td><?php echo $row["menu_name"] ?></td>
                            <td><input class="change_state" name="change_state" type="checkbox" data-toggle="toggle" data-ids="<?php echo $row["id_menu"] ?>" data-size="small" <?php if($row["active"]== 1 ){ ?> checked="checked" <?php } ?>></td>
                            <td><span class="glyphicon glyphicon-remove-sign delete_item" data-ids="<?php echo $row["id_menu"] ?>"></span><span class="glyphicon glyphicon-pencil rename_item" data-ids="<?php echo $row["id_menu"] ?>"></span></td>
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
                                <h4 class="modal-title">Aggiungi item al menu'</h4>
                            </div>
                            <div class="modal-body">
                                <label for="menu_item_name">Nome</label>
                                <input type="text" class="form-control" id="menu_item_name"  placeholder="Menu Name">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Chiudi</button>
                                <button id="add_menu_item_name" type="button" class="btn btn-primary" data-dismiss="modal">Salva</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- Fine Modal Insermento Row -->
                <!-- Modal per inserimento POST -->
                <div class="modal fade" id="modal-default_post">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Aggiungi voce menu'</h4>
                            </div>
                            <div class="modal-body">
                                <label for="menu_item_name">Nome</label>
                                <input type="text" class="form-control" id="post_item_name"  placeholder="Post Name">
                                <br>
                                <label for="post_item_list">Riferimento</label>
                                <select class="form-control select2" id="post_item_list" style="width: 100%;" ">
                                    <?php
                                    $optgroup= "";
                                    foreach ($links as $row){
                                        if($optgroup == ""){ ?>
                                    <optgroup label="<?php echo $row["post_type"] ?>">
                                    <?php $optgroup = $row["post_type"]; }
                                        else if($optgroup != $row["post_type"] && $optgroup != ""){
                                            ?>
                                    </optgroup>
                                    <optgroup label="<?php echo $row["post_type"] ?>">
                                    <?php $optgroup =$row["post_type"]; } ?>
                                    <option value="<?= $row["id"]  ?>">
                                            <?= $row["name"]."(".$row["id"].")" ?>
                                    </option>
                                    <?php } ?>
                                 </optgroup>
                                <optgroup label="Speciali">
                                    <?php foreach ($specialLinks as $row){ ?>
                                        <option value="<?= $row["value"]  ?>">
                                            <?= $row["label"] ?>
                                        </option>
                                    <?php }?>
                                </optgroup>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Chiudi</button>
                                <button id="add_post_item_name" type="button" class="btn btn-primary" data-dismiss="modal">Salva</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- Fine Modal Inserimento POST -->
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
                                <button type="button" class="btn btn-primary delete_item_confirm" data-dismiss="modal">Salva</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- Fine delete Row -->
                <!-- Conferma delete Post -->
                <div class="modal fade" id="modal_delete_post">
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
                                <button type="button" class="btn btn-primary delete_post_confirm" data-dismiss="modal">Salva</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- Fine delete Post -->
                <!-- Conferma update state Row -->
                <div class="modal fade" id="confirm_update">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Aggiorna nome</h4>
                        </div>
                        <div class="modal-body">
                            <label for="menu_item_name">Nome</label>
                            <input type="text" class="form-control update_menu_item_name" id="update_menu_item_name" >
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
                <!-- Conferma update state post -->
                <div class="modal fade" id="rename_post_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Aggiorna Nome</h4>
                            </div>
                            <div class="modal-body">
                                <label for="menu_item_name">Nome</label>
                                <input type="text" class="form-control update_post_item_name" id="update_menu_item_name" >
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left closeModal" data-dismiss="modal">Chiudi</button>
                                <button type="button" class="btn btn-primary rename_post_confirm" data-dismiss="modal">Salva</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- Fine Conferma change state post -->
            </div>
            <div class="col-md-2"></div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-10">
                <h1>Gestione Voci Menu'</h1>
                <div><hr /></div>
                <table id="tableMenuVoices" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Link e ID pagina</th>
                        <th>Opzioni Menu'</th>
                        <th>Azioni</th>
                    </tr>
                    </thead>
                    <tbody class="tbody_post_voices">
                    <?php if($resultMenuVoices != NULL && $resultMenu != NULL){ foreach ($resultMenuVoices as $row){ ?>
                        <tr>
                            <td><?php if($row["post_name"]!=null){ echo $row["post_name"].'('.$row["id"].')';} else { echo '('.$row["id"].')';}  ?></td>
                            <td><?php echo $row["name"] ?></td>
                            <td><span class="glyphicon glyphicon-remove-sign delete_post" data-ids="<?php echo $row["id_rel"] ?>"></span><span class="glyphicon glyphicon-pencil rename_post" data-ids="<?php echo $row["id_rel"] ?>"></span></td>
                        </tr>
                    <?php }} ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>


</div>


<div style="margin-top:30px;">

<script>
        jQuery('#tableMenu').DataTable({
            "order": [[1, "asc"]],
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
        jQuery('#tableMenuVoices').DataTable({
            "order": [],
            "searching": false,
            "bInfo" : false,
            "lengthChange": false,
            "pageLength": 15,
            dom: 'l<"toolbar">frtip',
            initComplete: function(){
                jQuery("#tableMenuVoices_paginate")
                    .append('<div class="toolbar"><button type="button" class="btn btn-block btn-primary" id="add_post_item" ' +
                        '  data-toggle="modal" data-target="#modal-default_post">Aggiungi</button></div>');
            }
        });
        jQuery('.select2').select2();

        jQuery('.tbody_post_voices').sortable({
            stop: function (event, ui) {
                var array_object = [];
                jQuery(this).find('tr').each(function (i) {
                    var element = jQuery(this).find('td:last')[0].childNodes[0];
                    var obj = new Object();
                    obj.id = jQuery(element).attr("data-ids");
                    obj.order = i+1;
                    array_object.push(obj);
                });
                jsonString = JSON.stringify(array_object);
                    var data = {
                        action: 'MTJ_reload_menu',
                        data: jsonString
                    };
                    jQuery.post(ajaxurl, data, function (dataR, textStatus, jqXHR) {
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
                        else if (returnedData.status == 1) {
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


            }
        });

        jQuery('#modal-default').on('hidden.bs.modal', function (e) {
            jQuery('#menu_item_name').val("");
        });
        jQuery('#modal-default_post').on('hidden.bs.modal', function (e) {
            jQuery('#post_item_name').val("");
        });
        jQuery('#confirm_update').on('hidden.bs.modal', function (e) {
            jQuery('#update_menu_item_name').val("");
        });
        jQuery('#rename_post_modal').on('hidden.bs.modal', function (e) {
            jQuery('#update_menu_item_name').val("");
        });



</script>
</html>