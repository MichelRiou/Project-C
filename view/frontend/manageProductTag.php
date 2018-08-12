<?php
ob_start();
?>
<script type="text/javascript">
    var idDelete;
    var idEdit;
    function ctrlAddTag() {
        var msg = "";
        if ($("#addAlpha").val() == "" && $("#addNumeric").val() == 0)
            msg += 'La saisie d\'une valeur est obligatoire.';

        // Monitoring des erreurs
        $("#addMessage").html(msg);
        $result = (msg != "" ? false : true);
        return $result;
    }
    function ctrlEditTagProduct() {
        var msg = "";
 
        if ($("#editAlpha").val() == "" &&  $("#editNumeric").val() == 0)
            msg += 'Une valeur doit être saisie';
        // Monitoring des erreurs
        $("#editMessage").html(msg);
        $result = (msg != "" ? false : true);
        return $result;

    }
    function ctrlMajTagProduct() {

        return true;

    }
    function refresh() {
        $.ajax({
            type: 'POST',
            url: '/routes.php?action=listProductTag',
            data:
                    {
                        "id": $("#idProduct").val(),
                    },
            success: function (data) {
                $("#requete").html(data);
                $('[data-toggle="tooltip"]').tooltip();
                $('a[class="delete"]').click(function () {
                    idDelete = this.getAttribute('producttagid');
                    console.log(idDelete);
                });
                $('a[class="edit"]').click(function () {
                    //MISE A JOUR DES CHAMPS POUR L'UPDATE 
                    //value a qualifier
                    idEdit = this.getAttribute('producttagid');
                    $('#editName').val(this.getAttribute('producttagname'));
                    designationEdit = this.getAttribute('producttagdesignation');
                    $('#editDesignation').val(designationEdit);
                    alphaEdit = this.getAttribute('producttagvalue');
                    $('#editAlpha').val(alphaEdit);
                    numericEdit = this.getAttribute('producttagnumeric');
                    $('#editNumeric').val(numericEdit);

                    console.log(idEdit);
                });

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(textStatus);
                $("#retour").html("Erreur d\'envoi de la requête");
            }
        });
    }
    $(document).ready(function () {
        refresh();
        $("#back").click(function () {
            window.history.back();
        });
        // Activation du tooltip
        $('[data-toggle="tooltip"]').tooltip();
        // Activation de la fenêtre modale AJOUTER UN TAG
        $("#addbutton").click(function () {
            // Reset de la fenetre modale 
            $("#addAlpha").val('');
            $("#addNumeric").val('');
            $("#addMessage").html('');
            $("#addTagModal").modal('show');
        });
        $("#manageTag").click(function () {
            // Reset de la fenetre modale 
            window.location = "routes.php?action=manageTag";
        });
        // Requête AJAX pour maj
        $("#majTag").on('click', (function () {

            if (ctrlMajForm()) {
                //  alert();
                $.ajax({
                    type: 'POST',
                    url: '/routes.php?action=addTagRequest' + '&idRequest=' + $("#idRequest").val() + '&idTag=' + $("#addName").val() + '&addSign=' + $("#addSign").val() + '&addAlpha=' + $("#addAlpha").val() + '&addNumeric=' + $("#addNumeric").val(),
                    success: function (data) {
                        console.log(data);
                        if (data != 1) {
                            $("#addMessage").html("Erreur d\'insertion");
                        } else {
                            $('#addCancel').trigger('click');
                            refresh();
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(textStatus);
                        $("#retour").html("Erreur d\'envoi de la requête");
                    }
                });
                return false;
            }
        }));
        // Requête AJAX pour validation
        $("#addTag").on('click', (function () {

            if (ctrlAddTag()) {
                //  alert();
                $.ajax({
                    type: 'POST',
                    url: '/routes.php?action=addProductTag' + '&idProduct=' + $("#idProduct").val() + '&idTag=' + $("#addName").val() + '&addAlpha=' + $("#addAlpha").val() + '&addNumeric=' + $("#addNumeric").val(),
                    success: function (data) {
                        console.log(data + '/routes.php?action=addProductTag' + '&idProduct=' + $("#idProduct").val() + '&idTag=' + $("#addName").val() + '&addAlpha=' + $("#addAlpha").val() + '&addNumeric=' + $("#addNumeric").val());
                        if (data != 1) {
                            $("#addMessage").html("Erreur d\'insertion");
                        } else {
                            $('#addCancel').trigger('click');
                            refresh();
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(textStatus);
                        $("#retour").html("Erreur d\'envoi de la requête");
                    }
                });
                return false;
            }
        }));
        // AJAX 
        $("#deleteTag").on('click', (function () {
            //alert();
            // console.log(obj);
            $.ajax({
                type: 'POST',
                url: '/routes.php?action=deleteTagRequest&id=' + idDelete,
                success: function (data) {
                    console.log(idDelete),
                    console.log(data);
                    if (data != 1) {
                        $("#deleteMessage").html("Erreur de suppression");
                    } else {
                        $('#deleteCancel').trigger('click');
                        refresh();
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(textStatus);
                    $("#retour").html("Erreur d\'envoi de la requête");
                }
            });
            return false;
        }));
        // AJAX
        $("#editTag").on('click', (function () {
            if (ctrlEditTagProduct()) {
                $.ajax({
                    type: 'POST',
                    url: '/routes.php?action=updateTagProduct&id=' + idEdit + '&editAlpha=' + $("#editAlpha").val() + '&editNumeric=' + $("#editNumeric").val(),
                    success: function (data) {
                  
                       console.log('retour update' + data + '/routes.php?action=updateTagProduct&id=' + idEdit + '&editAlpha=' + $("#editAlpha").val() + '&editNumeric=' + $("#editNumeric").val());
                        if (data != 1) {
                            $("#editMessage").html("Erreur de update");
                        } else {
                            $('#editCancel').trigger('click');
                            refresh();
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(textStatus);
                        $("#retour").html("Erreur d\'envoi de la requête");
                    }
                });
                // return false;
            }
            return false;
        }));
        // AJAX
    });
</script>

<div class="container-fluid">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-4 ">
                    <h5>LISTE DES MOT-CLES D'UN PRODUIT</h5>
                </div>
                <div class="col-sm-8 ">                 
                    <button id="back" class="btn btn-default" data-toggle="modal"><i class="material-icons">&#xE314;</i> <span class="black-write">Retour</span></button>
                  <!--  <button id="majbutton" class="btn btn-info btn-sm" data-toggle="modal"><i class="material-icons">&#xE254;</i> <span>Màj réponse</span></button> -->
                    <button id="addbutton" class="btn btn-success btn-sm" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Ajouter un tag</span></button>
                    <button id="manageTag" class="btn btn-info btn-sm" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Créé un mot-clé</span></button>		
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 form-group row">
                <div class="col-sm-2 form-group">

                    <input class="form-control input-sm" type="text" name="refProduct" value="<?= $product->getProduct_builder_ref() ?>" readonly="readonly" />
                </div>
                <div class="col-sm-2 form-group">
                    <input class="form-control input-sm" type="text" name="libelleRequest" value="<?= $product->getProduct_ref() ?>" readonly="readonly" />
                </div>
                <div class="col-sm-8 form-group">
                     <input class="form-control input-sm" type="text" name="orderRequest" value="<?= $product->getProduct_designation() ?>" readonly="readonly"  />
                </div>  
            </div>   

        </div>

        <div class ="scrollDiv2" id="requete"></div>
    </div>
</div>
</div>
<!-- Edit Modal HTML -->
<div id="editTagModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">						
                    <h4 class="modal-title">Modifier un mot-clé</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <div class="form-group">
                        <label>Nom du Tag</label>
                        <input type="text" class="form-control" readonly="readonly" id ="editName" >
                    </div>
                    <div class="form-group">
                        <label>Valeur Alphanumérique</label>
                        <input type="text" class="form-control" id ="editAlpha">
                    </div>
                    <div class="form-group">
                        <label>Valeur numérique</label>
                        <input type="numeric" class="form-control" id ="editNumeric">
                    </div>					
                </div>
                <div id="editMessage" class="text-warning align-center"></div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Abandon" id="editCancel">
                    <input type="submit" class="btn btn-success" value="Modifier" id="editTag">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Modal HTML -->
<div id="addTagModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form >
                <div class="modal-header">						
                    <h4 class="modal-title">Ajout d'un mot-clé</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div>
                        <input type="hidden" value="<?= $product->getProduct_id() ?>" name="idProduct" id="idProduct">
                        <input type="hidden" value="<?= $bu ?>" name="idBu" id="idBu">
                    </div>
                    <div class="form-group">
                        <label>Nom du mot-clé</label>
                        <select class="form-control" name="idTag" id="addName">
                            <?php for ($i = 0; $i < count($tags); $i++) { ?>
                                <option value="<?= $tags[$i]->getTag_id() ?>"><?= $tags[$i]->getTag_name() ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Valeur Alphanumérique</label>
                        <input type="text" class="form-control" name="alphanumericValue" id="addAlpha">
                    </div>	
                    <div class="form-group">
                        <label>Valeur numérique</label>
                        <input type="number" class="form-control" name="numericValue" id="addNumeric">
                    </div>
                </div>
                <div id="addMessage" class="text-warning align-center"></div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Abandon" id="addCancel">
                    <input type="button" class="btn btn-info" value="Ajouter" id="addTag" >
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Modal HTML -->
<div id="deleteTagModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">						
                    <h4 class="modal-title">Supprimer un mot-clé</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <p class="text-warning">Etes vous sûr?</p>

                </div>
                <div id="deleteMessage" class="text-warning align-center"></div>
                <div class="modal-footer">
                    <input type="button" id="deleteCancel" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="button" id="deleteTag" class="btn btn-danger" value="Delete">
                </div>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>