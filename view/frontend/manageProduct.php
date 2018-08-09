<?php
ob_start();
?>
<script type="text/javascript">
    function refresh() {
        $.ajax({
            type: 'POST',
            url: '/routes.php?action=listProductByCat',
             data:
                            {
                                "category" : 0,
                            },
            success: function (data) {
                $("#requete").html(data);
                $('[data-toggle="tooltip"]').tooltip();
                $("#okbutton").click(function () {
                    var s = $('table tbody input:checked');
                    if (s.length !== 0) {
                        console.log(checkbox);
                        $("#message").html('');
                        $("#addResponseModal").modal('show');
                    } else {
                        $("#messageModal").modal('show');
                    }
                });
                var checkbox = $('table tbody input[type="checkbox"]');

                checkbox.click(function () {
                    var s = this.checked;
                    console.log(s)
                    checkbox.each(function () {
                        this.checked = false;
                    });
                    this.checked = s;
                });


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
         $("#back").click(function () {
            window.history.back();
        });
        // Activate tooltip
        // $('[data-toggle="tooltip"]').tooltip();
        // Validation de la modal AJOUTER UNE REPONSE
        $("#okbutton").click(function () {
            var s = $('table tbody input:checked');
            if (s.length !== 0) {
                console.log(checkbox);
                $("#message").html('');
                $("#addResponseModal").modal('show');
            } else {
                $("#messageModal").modal('show');
            }
        });
        // Validation de la modal SUPPRIMER UNE QUESTION
        $("#deletebutton").click(function () {
            var s = $('table tbody input:checked');
            if (s.length !== 0) {
               /// console.log(s[0]);
               // console.log(s[0].value);
                var deleteHeader= s[0].value;
                $("#message").html('');
                $("#deleteQuestionModal").modal('show');
            } else {
                $("#messageModal").modal('show');
            }
        });
                // AJAX 
        $("#deleteHeader").on('click', (function () {
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
        // Select/Deselect checkboxes
        var checkbox = $('table tbody input[type="checkbox"]');

        checkbox.click(function () {
            var s = this.checked;
            checkbox.each(function () {
                this.checked = false;
            });
            this.checked = s;
        });
        $("#addResponse").click(function () {
            // alert();
            var checkbox = $('table tbody input[type="checkbox"]');
            //alert(checkbox);
            console.log(checkbox);
        });
    });

</script>

<div class="container-fluid">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-4">
                    <h5>LISTE DES PRODUITS</h5><input type="hidden" value="" id="idForm">
                </div>
                <div class="col-sm-4">		
                    <button id="back" class="btn btn-default" data-toggle="modal"><i class="material-icons">&#xE314;</i> <span class="black-write">Retour</span></button>
                    <button id="addbutton" class="btn btn-info" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Ajouter un produit</span></button>

                </div>
                  <div class="col-sm-4">
                        
                    <input class=" pull-right" type="submit" value="Rechercher" onclick="searchString()" />
                    <input class="pull-right" id="search" name="search" type="text" value="" onfocus="clearSearch()" />
                </div>
            </div>
        </div>
        <!-- RAFRAICHISSEMENT DU DETAIL VIA AJAX -->
        <div id='requete' class="scrollDiv2">
            
        </div>
    </div>
    <!-- MODAL ADD RESPONSE -->
    <div id="addResponseModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">						
                        <h4 class="modal-title">Ajouter une réponse</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" required>
                        </div>					
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-success" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL EDIT QUESTION -->
    <div id="editProductModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">						
                        <h4 class="modal-title">Edit Employee</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" required>
                        </div>					
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-info" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL DELETE QUESTION -->
    <div id="deleteQuestionModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">						
                        <h4 class="modal-title">Supprimer une question</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <p>Are you sure you want to delete these Records?</p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="button" id="deleteHeader" class="btn btn-danger" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL MESSAGE SELECTION QUESTION-->
    <div id="messageModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">						
                        <h4 class="modal-title">Attention</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body align-center">					
                        <p class="text-warning align-center"><h6>Vous devez sélectionner une question</h6></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">

                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $content = ob_get_clean(); ?>
    <?php require('template.php'); ?>
