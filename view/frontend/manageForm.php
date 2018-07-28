<?php
ob_start();
?>
<script type="text/javascript">
    var idDelete;
    var idEdit;
    function ctrlAddForm() {
        var msg = "";
        if ($("#addName").val() == '')
            msg += 'Le nom est obligatoire.';
        if ($("#addDesignation").val() == '')
            msg += 'La désignation est obligatoire.';

        // Monitoring des erreurs
        $("#message").html(msg);
        $result = (msg != "" ? false : true);
        return $result;
    }
    function refresh() {
        $.ajax({
            type: 'POST',
            url: '/routes.php?action=listForm',
            success: function (data) {
                $("#requete").html(data);
                $('[data-toggle="tooltip"]').tooltip();
                $('a[class="delete"]').click(function () {
                    idDelete = this.getAttribute('idtag');
                    console.log(idDelete);
                });
                $('a[class="edit"]').click(function () {
                    //MISE A JOUR DES CHAMPS POUR L'UPDATE 
                    //value a qualifier
                    idEdit = this.getAttribute('idtag');
                    console.log(idEdit);
                    $('#editName').val(this.getAttribute('tagname'));
                    designationEdit = this.getAttribute('designation');
                    $('#editDesignation').val(designationEdit);
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
            $("#addName").val('');
            $("#addDesignation").val('');
            $("#addMessage").html('');
            $("#addTagModal").modal('show');
        });
        // Requête AJAX pour validation
        $("#addTag").on('click', (function () {
            if (ctrlAddForm()) {
                // alert();
                $.ajax({
                    type: 'POST',
                    url: '/routes.php?action=addTag&name=' + $("#addName").val() + '&designation=' + $("#addDesignation").val(),
                    success: function (data) {
                        console.log('retour success' + data + $("#addName").val() + '&designation=' + $("#addDesignation").val());
                        if (data != 1) {
                            $("#addMessage").html("Erreur d\'ajout" + data);
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
            // alert();
            console.log(idDelete);
            $.ajax({
                type: 'POST',
                url: '/routes.php?action=deleteForm&id=' + idDelete,
                success: function (data) {
                    console.log(data);
                    if (data != 1) {
                        $("#messageDelete").html("Erreur de suppression".data);
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

            $.ajax({
                type: 'POST',
                url: '/routes.php?action=updateForm&id=' + idEdit + '&designation=' + $("#editDesignation").val(),
                success: function (data) {
                    console.log('retour update' + data + '/routes.php?action=updateTag&id=' + idEdit + '&editdesignation=' + $("#editDesignation").val());
                    if (data != 1) {
                        $("#messageEdit").html("Erreur de update".data);
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
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-8 form-group">
                    <h4>Gestion des Formulaires</h4>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-9 form-group">
                <h5>VOUS ÊTES DANS LA BUSINESS UNIT :  <?= $bu->getBu_name() ?></h5>  

            </div>

            <div class="col-md-3 ">
                <button id="addbutton" class="btn btn-success btn-sm" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Création d'un formulaire</span></button>
              <!--  <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>test</span></a>		-->				
            </div>
        </div>
        <div class="row" id="requete">
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
                    <h4 class="modal-title">Edit formulaire</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <div class="form-group">
                        <label>Nom du Formulaire</label>
                        <input type="text" class="form-control" readonly="readonly" id ="editName" >
                    </div>
                    <div class="form-group">
                        <label>Désignation</label>
                        <input type="text" class="form-control"  id ="editDesignation" >
                    </div>  
                    <div class="form-group">
                        <label>Catégorie</label>
                        <select class="form-control" name="idCategory" id="addCategory">
                            <?php for ($i = 0; $i < count($categories); $i++) { ?>
                                <option value="<?= $categories[$i]->getCategory_id() ?>"><?= $categories[$i]->getCategory_name() ?></option>
                            <?php } ?>
                        </select>
                    </div>                    
                </div>
                <div id="messageEdit" class="text-warning align-center"></div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" id="editCancel">
                    <input type="button" class="btn btn-success" value="edit" id="editTag">
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
                    <h4 class="modal-title">Création d'un Formulaire</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nom du Tag</label>
                        <input type="text" class="form-control"  id ="addName" >
                    </div>
                    <div class="form-group">
                        <label>Désignation</label>
                        <input type="text" class="form-control"  id ="addDesignation" >
                    </div>
                    <div class="form-group">
                        <label>Catégorie</label>
                        <select class="form-control" name="idCategory" id="addCategory">
                            <?php for ($i = 0; $i < count($categories); $i++) { ?>
                                <option value="<?= $categories[$i]->getCategory_id() ?>"><?= $categories[$i]->getCategory_name() ?></option>
                            <?php } ?>
                        </select>
                    </div> 
                     <div class="form-group">
                        <label>Type de recherche</label>
                        <select class="form-control" name="idSearchType" id="addSearchType">
                            <?php for ($i = 0; $i < count($searchtypes); $i++) { ?>
                                <option value="<?= $searchtypes[$i]->getSearchType_id() ?>"><?= $searchtypes[$i]->getSearchType_name() ?></option>
                            <?php } ?>
                        </select>
                    </div> 
                </div>
                <div id="addMessage" class="text-warning align-center"></div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" id="addCancel">
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
                    <h6 class="text-warning">ATTENTION, la suppression du formulaire entraine la supression de tous les éléments le composant.</br>Principe du ON DELETE CASCADE</h6>
                </div>
                <div id="messageDelete" class="text-warning align-center"></div>
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