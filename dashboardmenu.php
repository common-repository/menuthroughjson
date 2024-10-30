<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<?php include "custom_class/MTJ_dashboard.class.php";
$dashboard = new MTJ_dashboardMenu;
?>

<div style="padding-right:10px;">
	<h1>Dashboard</h1>
	<div><hr /></div>
    <?php
    $resultMenuActive= array();
    $resultMenuActive = json_decode($dashboard->getMenuActive(),true);
    if($resultMenuActive != NULL){
    $resultMenuVoice = json_decode($dashboard->getRelationWithName($resultMenuActive[0]["id_menu"]),true);}
    ?>
        <div class="container">
            <div class="row">
                <div class="container">
                    <h3>Menu' Attivo : <?php echo $resultMenuActive[0]["menu_name"] ?> </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                        <table id="tableMenu" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Titolo</th>
                                <th>Riferimento</th>
                                <th>Ordine </th>
                            </tr>
                            </thead>
                            <tbody>
                        <?php if($resultMenuVoice != NULL){ foreach ($resultMenuVoice as $row){ ?>
                            <tr>
                                <td><?php if($row["post_title"] != null) {echo $row["post_title"];} else {echo $row["id_post"]; } ?></td>
                                <td><?php if($row["ID"] != null) {echo $row["ID"];} else {echo $row["id_post"]; } ?></td>
                                <td>
                                    <select class="form-control select2" data-ids="<?php echo $row["id_relation"] ?>"  style="width: 100%;">
                                        <?php for($i=1;$i<=$dashboard->getCountRelation($resultMenuActive[0]["id_menu"]);$i++){ ?>
                                        <option value="<?php echo $i ?>"  <?php if($i == $row["order_menu"]){ ?> selected="selected" <?php } ?> >
                                            <?php echo $i ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <?php }} ?>
                            </tbody>
                        </table>
                    <div class="modal fade" id="confirm">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Aggiorna menu'</h4>
                                </div>
                                <div class="modal-body">
                                    Vuoi veramente aggiornare l'ordine del menu' ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Chiudi</button>
                                    <button type="button" class="btn btn-primary delete" data-dismiss="modal">Salva</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- Fine delete Row -->
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
<div style="margin-top:30px;">
</div>
</div>

<script>
        jQuery('#tableMenu').DataTable({
            "order": [[2, "asc"]],
            "searching": false,
            "bInfo" : false,
            "lengthChange": false,
            "pageLength": 15,
            dom: 'l<"toolbar">frtip',
            initComplete: function(){
                jQuery("div.dataTables_paginate")
                    .append('<div class="toolbar"><button type="button" class="btn btn-block btn-primary" id="aggiorna_ordine">Refresh_Order</button></div>');
            }

        });
        jQuery('.select2').select2();


</script>
</html>