<?php
ob_start();
?>
<script type="text/javascript">
    var idDelete;
    var idEdit;
    function ctrlEditProduct() {
        var msg = "";
        if ($("#editCategory").val() == '0')
            msg += 'La catégorie est obligatoire.';
        // Monitoring des erreurs
        $("#editMessage").html(msg);
        $result = (msg != "" ? false : true);
        return $result;
    }
    function refresh() {

        $.ajax({
            type: 'POST',
            url: '/routes.php?action=listProductImport',
            success: function (data) {
                $("#requete").html(data);
                $('[data-toggle="tooltip"]').tooltip();
                $('a[class="delete"]').click(function () {
                    idDelete = this.getAttribute('idProduct');
                    console.log(idDelete);
                });
                $('a[class="edit"]').click(function () {
                    //MISE A JOUR DES CHAMPS POUR L'UPDATE 
                    //value a qualifier
                    idEdit = this.getAttribute('idProduct');
                    console.log(idEdit);
                    $('#editBuilderRef').val(this.getAttribute('builder_ref'));
                    $('#editRef').val(this.getAttribute('ref'));
                    $('#editModel').val(this.getAttribute('model'));
                    $('#editBuilder').val(this.getAttribute('builder'));
                    $('#editEan').val(this.getAttribute('ean'));
                    $('#editDesignation').val(this.getAttribute('designation'));
                    $('#editCategory').val("0");
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
        // Activation de la fenêtre modale AJOUTER UN FORMULAIRE
        $("#addbutton").click(function () {
            // Reset de la fenetre modale 
            $("#addName").val('');
            $("#addDesignation").val('');
            $("#addMessage").html('');
            $("#addFormModal").modal('show');
        });
        // Requête AJAX pour validation
        $("#addForm").on('click', (function () {
            if (ctrlAddForm()) {
                $.ajax({
                    type: 'POST',
                    url: '/routes.php?action=addForm&name=' + $("#addName").val() + '&designation=' + $("#addDesignation").val() + '&category=' + $("#addCategory").val() + '&searchtype=' + $("#addSearchType").val(),
                    success: function (data) {
                        console.log('retour success' + data + 'routes.php?action=addForm&name=' + $("#addName").val() + '&designation=' + $("#addDesignation").val() + '&category=' + $("#addCategory").val() + '&searchtype=' + $("#addSearchType").val());
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
        $("#deleteForm").on('click', (function () {
            // alert();
            console.log(idDelete);
            $.ajax({
                type: 'POST',
                url: '/routes.php?action=deleteForm&id=' + idDelete,
                success: function (data) {
                    console.log(data + '/routes.php?action=deleteForm&id=' + idDelete);
                    if (data != 1) {
                        $("#deleteMessage").html("Erreur de suppression".data);
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
        $("#editForm").on('click', (function () {
            if (ctrlEditProduct()) {
                $.ajax({
                    type: 'POST',
                    url: '/routes.php?action=createProduct&id=' + idEdit + '&builderref=' + $("#editBuilderRef").val()+ '&ref=' + $("#editRef").val() + '&model=' + $("#editModel").val() + '&builder=' + $("#editBuilder").val() + '&designation=' + $("#editDesignation").val() + '&ean=' + $("#editEan").val()+ '&category=' + $("#editCategory").val()+ '&tag=""',
                    success: function (data) {
                        console.log(data);
                        if (data != 1) {
                            $("#editMessage").html("Erreur d'insert".data);
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
            }
        }));
                // AJAX
        $("#editFormSuite").on('click', (function () {
            if (ctrlEditProduct()) {
                $.ajax({
                    type: 'POST',
                    url: '/routes.php?action=updateForm&id=' + idEdit + '&name=' + $("#editName").val() + '&designation=' + $("#editDesignation").val() + '&category=' + $("#editCategory").val() + '&searchtype=' + $("#editSearchType").val() + '&validated=' + $("#editValidated").val(),
                    success: function (data) {
                        console.log('retour update' + data + '/routes.php?action=updateForm&id=' + idEdit + '&name=' + $("#editName").val() + '&designation=' + $("#editDesignation").val() + '&category=' + $("#editCategory").val() + '&searchtype=' + $("#editSearchType").val() + '&validated=' + $("#editValidated").val());
                        if (data != 1) {
                            $("#editMessage").html("Erreur de update".data);
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
            }
        }));
        // AJAX
    });
</script>

<div class="container-fluid">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="form-group row">
                <div class="col-md-7">
                    <h5>VALIDATION DES PRODUITS</h5>
                </div >
                <div class="col-md-5">
                    <input class=" pull-right" type="submit" value="Rechercher" onclick="searchString()" />
                    <input class="pull-right" id="search" name="search" type="text" value="" onfocus="clearSearch()" />
                </div>
            </div>
        </div>
        <div class="row scrollDiv2" id="requete">
        </div>



    </div>
</div>
</div>

<!-- Edit Modal HTML -->
<div id="editProduct" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">						
                    <h4 class="modal-title">Validation Produit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <div class="form-group">
                        <label>Ref. constructeur</label>
                        <input type="text" class="form-control"  id ="editBuilderRef" >
                    </div>
                      <div class="form-group">
                        <label>Ref. grossiste</label>
                        <input type="text" class="form-control"  id ="editRef" >
                    </div>
                    <div class="form-group">
                        <label>Modèle</label>
                        <input type="text" class="form-control"  id ="editModel" >
                    </div>  


                    <div class="form-group">
                        <label>Constructeur</label>
                        <input type="text" class="form-control"  id ="editBuilder" >
                    </div>  
                    <div class="form-group">
                        <label>Désignation</label>
                        <textarea class="form-control"  id ="editDesignation" rows="3"></textarea>
                    </div>  
                    <div class="form-group">
                        <label>EAN</label>
                        <input type="text" class="form-control"  id ="editEan" >
                    </div> 
                    <div class="form-group">
                        <label>Catégorie</label>
                        <select class="form-control" name="editCategory" id="editCategory">
                            <option value="0">--</option>
                            <?php for ($i = 0; $i < count($categories); $i++) { ?>
                                <option value="<?= $categories[$i]->getCategory_id() ?>"><?= $categories[$i]->getCategory_name() ?></option>
                            <?php } ?>
                        </select>
                    </div> 
                </div>
                <div id="editMessage" class="text-warning align-items-center"></div>
                <div class="modal-footer">
                     <input type="button" class="btn btn-success" value="Valid + Tag" id="editFormSuite">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" id="editCancel">
                    <input type="button" class="btn btn-success" value="Validation" id="editForm">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Modal HTML -->
<div id="addFormModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form >
                <div class="modal-header">						
                    <h4 class="modal-title">Création d'un Formulaire</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nom du Formulaire</label>
                        <input type="text" class="form-control"  id ="addName" >
                    </div>
                    <div class="form-group">
                        <label>Désignation</label>
                        <input type="text" class="form-control"  id ="addDesignation" >
                    </div>


                </div>
                <div id="addMessage" class="text-warning align-center"></div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" id="addCancel">
                    <input type="button" class="btn btn-info" value="add" id="addForm" >
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Modal HTML -->
<div id="deleteFormModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">						
                    <h4 class="modal-title">Supprimer un Formulaire</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <h6 class="text-warning">ATTENTION, la suppression du formulaire entraine la supression de tous les éléments le composant.</br>Principe du ON DELETE CASCADE</h6>
                </div>
                <div id="deleteMessage" class="text-warning align-center"></div>
                <div class="modal-footer">
                    <input type="button" id="deleteCancel" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="button"  class="btn btn-danger" value="delete" id="deleteForm">
                </div>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>