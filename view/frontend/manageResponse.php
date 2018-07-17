<?php
ob_start();
?>
<script type="text/javascript">
    var idDelete;
    var idEdit;
    function ctrlAddForm(form) {
        var msg = "";
        if ($("#idOperator").val() == 'EST' && $("#alphanumericValue").val() == "")
            msg += 'L\'opérateur EST nécessite une valeur alphanumérique';
        if ($("#idOperator").val() != 'EST' && $("#numericValue").val() == "")
            msg += 'Les opérateurs =>< nécessite une valeur numérique';

        // Monitoring des erreurs
        $("#message").html(msg);
        $result = (msg != "" ? false : true);
        return $result;
    }
    function refresh() {
        $.ajax({
            type: 'POST',
            url: '/routes.php?action=listTagsRequest&id=' + $("#idRequest").val(),
            success: function (data) {
                $("#requete").html(data);
                $('[data-toggle="tooltip"]').tooltip();
                $('a[class="delete"]').click(function () {
                    idDelete = this.getAttribute('value');
                    console.log(idDelete);
                });
                $('a[class="edit"]').click(function () {
                    //MISE A JOUR DES CHAMPS POUR L'UPDATE 
                    //value a qualifier
                    idEdit = this.getAttribute('value');
                    $('#editName').val(this.getAttribute('tagname'));
                    signEdit = this.getAttribute('sign');
                    $('#editSign').val(signEdit);
                    alphaEdit = this.getAttribute('alpha');
                    $('#editAlpha').val(alphaEdit);
                    numericEdit = this.getAttribute('numeric');
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
        // Activation du tooltip
        $('[data-toggle="tooltip"]').tooltip();
        // Activation de la fenêtre modale AJOUTER UN TAG
        $("#addbutton").click(function () {
            // Reset de la fenetre modale 
            $("#alphanumericValue").val('');
            $("#numericValue").val('');
            $("#message").html('');
            $("#addTagModal").modal('show');
        });
        // Requête AJAX pour validation
        $("#addTag").on('click', (function () {
            if (ctrlAddForm()) {
                $.ajax({
                    type: 'POST',
                    url: '/routes.php?action=addTagOnRequest' + '&idRequest=' + $("#idRequest").val() + '&idTag=' + $("#idTag").val() + '&selectOperator=' + $("#idOperator").val() + '&alphanumericValue=' + $("#alphanumericValue").val() + '&numericValue=' + $("#numericValue").val(),
                    success: function (result) {
                        console.log('retour success' + result);
                        if (result != 1) {
                            $("#message").html("Erreur d\'insertion");
                        } else {
                            $('#cancel').trigger('click');
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
                url: '/routes.php?action=deleteTagOnRequest&idRequest=' + $("#idRequest").val() + '&idTag=' + idDelete,
                success: function (data) {
                    console.log('retour delete' + data + $("#idRequest").val() + idDelete);
                    if (data != 1) {
                        $("#messageDelete").html("Erreur de suppression");
                    } else {
                        $('#cancelDelete').trigger('click');
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

            $.ajax({
                type: 'POST',
                url: '/routes.php?action=updateTagOnRequest' + '&idRequest=' + $("#idRequest").val() + '&idTag=' + idEdit + '&editSign=' + $("#editSign").val() + '&editAlpha=' + $("#editAlpha").val() + '&editNumeric=' + $("#editNumeric").val(),
                success: function (data) {
                    console.log('retour update' + data + $("#idRequest").val() + idEdit + '&editSign=' + $("#editSign").val() + '&editAlpha=' + $("#editAlpha").val() + '&editNumeric=' + $("#editNumeric").val());
                    if (data != 1) {
                        $("#messageEdit").html("Erreur de update");
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
            return false;
        }));
        // AJAX
    });
</script>

<div class="container">
    <?php echo $id ?>
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-8 form-group">
                    <h4>Réponses</b></h4>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-2 form-group">

                <input class="form-control input-sm" type="text" name="nameRequest" value="<?= $request[0]['request_name'] ?>" readonly="readonly" />
            </div>
            <div class="col-sm-5 form-group">
                <input class="form-control input-sm" type="text" name="libelleRequest" value="<?= $request[0]['request_libelle'] ?>" />
            </div>
            <div class="col-sm-2 form-group">
                <input class="form-control input-sm" type="text" name="orderRequest" value="<?= $request[0]['request_order'] ?>" readonly="readonly" />
            </div>        <div class="col-sm-3 ">
                <button id="addbutton" class="btn btn-success btn-sm" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Ajouter un tag</span></button>
              <!--  <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>test</span></a>		-->				
            </div>
        </div>
        <div id="requete">

        </div>
    </div>
</div>
</div>
<!-- Edit Modal HTML -->
<div id="editTagModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">						
                    <h4 class="modal-title">Edit Tag</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <div class="form-group">
                        <label>Nom du Tag</label>
                        <input type="text" class="form-control" readonly="readonly" id ="editName" >
                    </div>
                    <div class="form-group">
                        <label>Opérateur</label>
                        <select class="form-control" name="editSign" id="editSign">
                            <option value="=">=</option> 
                            <option value=">">></option>
                            <option value="<"><</option>
                            <option value="EST">EST</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Valeur Alphanumérique</label>
                        <input type="text" class="form-control" id ="editAlpha">
                    </div>
                    <div class="form-group">
                        <label>Valeur numérique</label>
                        <input type="text" class="form-control" id ="editNumeric">
                    </div>					
                </div>
                <div id="messageEdit" class="text-warning align-center"></div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" id="editCancel">
                    <input type="submit" class="btn btn-success" value="edit" id="editTag">
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
                    <h4 class="modal-title">Ajout d'un Tag</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div>
                        <input type="hidden" value="<?= $id ?>" name="idRequest" id="idRequest">
                        <input type="hidden" value="<?= $bu ?>" name="idBu" id="idBu">
                    </div>
                    <div class="form-group">
                        <label>Nom du Tag</label>
                        <select class="form-control" name="idTag" id="idTag">
                            <?php for ($i = 0; $i < count($tags); $i++) { ?>
                                <option value="<?= $tags[$i]->getTag_id() ?>"><?= $tags[$i]->getTag_name() ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Opérateur</label>
                        <select class="form-control" name="selectOperator" id="idOperator">
                            <option value="=">=</option>
                            <option value=">">></option>
                            <option value="<"><</option>
                            <option value="EST">EST</option>
                            
                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Valeur Alphanumérique</label>
                        <input type="text" class="form-control" name="alphanumericValue" id="alphanumericValue">
                    </div>	
                    <div class="form-group">
                        <label>Valeur numérique</label>
                        <input type="number" class="form-control" name="numericValue" id="numericValue">
                    </div>
                </div>
                <div id="message" class="text-warning align-center"></div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" id="cancel">
                    <input type="button" class="btn btn-info" value="add" id="addTag" >
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
                    <h4 class="modal-title">Supprimer un Tag</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <p class="text-warning">Etes vous sûr?</p>

                </div>
                <div id="messageDelete" class="text-warning align-center"></div>
                <div class="modal-footer">
                    <input type="button" id="cancelDelete" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="button" id="deleteTag" class="btn btn-danger" value="Delete">
                </div>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>