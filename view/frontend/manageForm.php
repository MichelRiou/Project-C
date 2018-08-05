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
        $("#addMessage").html(msg);
        $result = (msg != "" ? false : true);
        return $result;
    }
    /*function searchString() {
        var search = $('#search').val();
        $("td:contains('" + search + "')").css("background", "lightgrey");
        var n = $("td:contains('" + search + "')").length;
        //alert(n + " occurence(s) trouvée(s)");
        $("td:contains('" + search + "')")[0].scrollIntoView(true);
    }
    function clearSearch() {
        var search = $('#search').val();
        if (search != '') {
            $("td:contains('" + search + "')").css("background", "none");
            $('#search').val('');
        }
    }*/
    function refresh() {

        $.ajax({
            type: 'POST',
            url: '/routes.php?action=listForm',
            success: function (data) {
                $("#requete").html(data);
                $('[data-toggle="tooltip"]').tooltip();
                $('a[class="delete"]').click(function () {
                    idDelete = this.getAttribute('idForm');
                    console.log(idDelete);
                });
                $('a[class="edit"]').click(function () {
                    //MISE A JOUR DES CHAMPS POUR L'UPDATE 
                    //value a qualifier
                    idEdit = this.getAttribute('idForm');
                    console.log(idEdit);
                    $('#editName').val(this.getAttribute('formname'));
                    //designationEdit = this.getAttribute('designation');
                    $('#editDesignation').val(this.getAttribute('designation'));
                    //validatedEdit = this.getAttribute('validated');
                    $('#editCategory').val(this.getAttribute('category')).prop('selected', true);
                    //validatedEdit = this.getAttribute('validated');
                    $('#editSearchType').val(this.getAttribute('searchtype')).prop('selected', true);
                    $('#editValidated').val(this.getAttribute('validated')).prop('selected', true);

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
        }));
        // AJAX
    });
</script>

<div class="container-fluid">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="form-group row">
                <div class="col-md-7">
                    <h4>Gestion des Formulaires</h4>
                </div >
                <div class="col-md-5">
                    <input class=" pull-right" type="submit" value="Rechercher" onclick="searchString()" />
                    <input class="pull-right" id="search" name="search" type="text" value="" onfocus="clearSearch()" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 form-group">
                <h5>BU :  <?= $bu->getBu_name() ?></h5>  

            </div>

            <div class="col-md-3 ">
                <button id="addbutton" class="btn btn-success btn-sm pull-right" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Création d'un formulaire</span></button>
              <!--  <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>test</span></a>		-->				
            </div>
        </div>
        <div class="scrollDiv2" id="requete">
        </div>
    </div>
</div>
<!-- Edit Modal HTML -->
<div id="editFormModal" class="modal fade">
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
                        <input type="text" class="form-control"  id ="editName" >
                    </div>
                    <div class="form-group">
                        <label>Désignation</label>
                        <input type="text" class="form-control"  id ="editDesignation" >
                    </div>  
                    <div class="form-group">
                        <label>Catégorie</label>
                        <select class="form-control" name="idCategory" id="editCategory">
                            <?php for ($i = 0; $i < count($categories); $i++) { ?>
                                <option value="<?= $categories[$i]->getCategory_id() ?>"><?= $categories[$i]->getCategory_name() ?></option>
                            <?php } ?>
                        </select>
                    </div>  
                    <div class="form-group">
                        <label>Type de recherche</label>
                        <select class="form-control" name="idSearchType" id="editSearchType">
                            <?php for ($i = 0; $i < count($searchtypes); $i++) { ?>
                                <option value="<?= $searchtypes[$i]->getSearchType_id() ?>"><?= $searchtypes[$i]->getSearchType_name() ?></option>
                            <?php } ?>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label>Validation</label>
                        <select class="form-control" name="editValidated" id="editValidated">                   
                            <option value="0" >NON</option>
                            <option value="1" >OUI</option>
                        </select>
                    </div>  
                </div>
                <div id="editMessage" class="text-warning align-center"></div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" id="editCancel">
                    <input type="button" class="btn btn-success" value="edit" id="editForm">
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
                    <input type="button" id="deleteCancel" class="btn btn-default rounded-0" data-dismiss="modal" value="Cancel">
                    <input type="button"  class="btn btn-danger" value="delete" id="deleteForm">
                </div>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>