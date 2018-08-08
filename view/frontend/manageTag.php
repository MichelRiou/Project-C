<?php
ob_start();
?>
<script type="text/javascript">
    var idDelete;
    var idEdit;
    function ctrlAddForm(form) {
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
            url: '/routes.php?action=listTag',
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
        $("#back").click(function () {
            window.history.back();
        });
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
                url: '/routes.php?action=deleteTag&id=' + idDelete,
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
                url: '/routes.php?action=updateTag&id=' + idEdit + '&designation=' + $("#editDesignation").val(),
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
                <div class="col-sm-4 form-group">
                    <h5>GESTION DES MOTS-CLES</h5>
                </div>
                <div class="col-sm-4 ">
                     <button id="back" class="btn btn-default btn-sm" data-toggle="modal"><i class="material-icons">&#xE314;</i> <span class="black-write">Retour</span></button>
                     <button id="addbutton" class="btn btn-success btn-sm" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Ajouter un tag</span></button>
                   
                </div>
                    <div class="col-sm-4 ">
                         
                    <input class=" pull-right btn-sm" type="submit" value="Rechercher" onclick="searchString()" />
                    <input class="pull-right " id="search" name="search" type="text" value="" onfocus="clearSearch()" />
                  
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-10 form-group">
                <h5>VOUS ÊTES DANS LA BUSINESS UNIT :  <?= $bu->getBu_name() ?></h5>  

            </div>


        </div>
        <div class ="scrollDiv2" id="requete">

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
                    <h4 class="modal-title">Modifier un mot-clé</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <div class="form-group">
                        <label>Nom du Tag</label>
                        <input type="text" class="form-control" readonly="readonly" id ="editName" >
                    </div>
                    <div class="form-group">
                        <label>Désignation</label>
                        <input type="text" class="form-control"  id ="editDesignation" >
                    </div>           					
                </div>
                <div id="messageEdit" class="text-warning align-center"></div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Abandon" id="editCancel">
                    <input type="button" class="btn btn-success" value="Modifier" id="editTag">
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
                    <h4 class="modal-title">Ajout d'un Mot-clé</h4>
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
                    <h4 class="modal-title">Supprimer un Mot-clé</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <h5 class="text-warning">ATTENTION, la suppression d'un mot-clé entraine la supression des mots-clés correspondant sur les produits et les réponses.</h5>
                </div>
                <div id="messageDelete" class="text-warning align-center"></div>
                <div class="modal-footer">
                    <input type="button" id="deleteCancel" class="btn btn-default" data-dismiss="modal" value="Abandon">
                    <input type="button" id="deleteTag" class="btn btn-danger" value="Supprimer">
                </div>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>