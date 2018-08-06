<?php
ob_start();
?>
<script type="text/javascript">
    var idDelete;
    var idEdit;
    var idQuestion;
    var IdForm;
    function ctrlAddResponse() {
        var msg = "";
        if ($("#addName").val() == '')
            msg += 'Le nom est obligatoire.';
        if ($("#addLibelle").val() == '')
            msg += 'Le libellé est obligatoire.';
        if ($("#addOrder").val() == '')
            msg += 'Le numéro d\'ordre est obligatoire.';
        if ($("#addOrder").val() > 217 || $("#addOrder").val() < 1)
            msg += 'Le numéro d\'ordre doit être compris entre 1 et 127.';

        // Monitoring des erreurs
        $("#addMessage").html(msg);
        $result = (msg != "" ? false : true);
        return $result;
    }
    function ctrlAddQuestion() {
        var msg = "";
        if ($("#addQuestionName").val() == '')
            msg += 'Le nom est obligatoire.';
        if ($("#addQuestionLibelle").val() == '')
            msg += 'Le libellé est obligatoire.';
        if ($("#addQuestionOrder").val() == '')
            msg += 'Le numéro d\'ordre est obligatoire.';
        if ($("#addQuestionOrder").val() > 217 || $("#addQuestionOrder").val() < 1)
            msg += 'Le numéro d\'ordre doit être compris entre 1 et 127.';

        // Monitoring des erreurs
        $("#addQuestionMessage").html(msg);
        $result = (msg != "" ? false : true);
        return $result;
    }
    function refresh() {
        $.ajax({
            type: 'POST',
            url: '/routes.php?action=listQuestion&form=' + $("#idForm").val(),
            success: function (data) {
                $("#requete").html(data);
                /*  $('[data-toggle="tooltip"]').tooltip();*/
                /* $("#okbutton").click(function () {
                 var s = $('table tbody input:checked');
                 if (s.length !== 0) {
                 console.log(checkbox);
                 $("#message").html('');
                 $("#addResponseModal").modal('show');
                 } else {
                 $("#messageModal").modal('show');
                 }
                 });*/
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
                $("#errorMessage").html("Erreur d\'envoi de la requête");
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
        $("#addResponseButton").click(function () {
            // Reset de la fenetre modale 
            $("#addName").val('');
            $("#addLibelle").val('');
            $("#addOrder").val('');
            var s = $('table tbody input:checked');
            if (s.length !== 0) {
                console.log(checkbox);
                idQuestion = s[0].value;
                console.log(idQuestion);
                $("#addMessage").html('');
                $("#addResponseModal").modal('show');
            } else {
                $("#messageModal").modal('show');
            }
        });
        $("#addQuestionButton").click(function () {
            // Reset de la fenetre modale 
            $("#addQuestionName").val('');
            $("#addQuestionLibelle").val('');
            $("#addQuestionOrder").val('');
            idForm = $("#idForm").val();
            console.log(idForm);
            $("#addQuestionMessage").html('');
            $("#addQuestionModal").modal('show');
        });
        // Validation de la modal SUPPRIMER UNE QUESTION
        $("#deleteQuestionButton").click(function () {
            var s = $('table tbody input:checked');
            if (s.length !== 0) {
                idQuestion = s[0].value;
                console.log(idQuestion);
                $("#message").html('');
                $("#deleteQuestionModal").modal('show');
            } else {
                $("#messageModal").modal('show');
            }
        });
        // AJAX 
        $("#deleteQuestion").on('click', (function () {
            //alert();
            // console.log(obj);
            $.ajax({
                type: 'POST',
                url: '/routes.php?action=deleteQuestion&idQuestion=' + idQuestion,
                /*   data:
                 {
                 "idQuestion" : idQuestion,
                 "addName" : $("#addName").val(),
                 "addLibelle" : $("#addLibelle").val(),
                 "addOrder" : $("#addOrder").val(),
                 },*/
                success: function (data) {
                    console.log('retour delete' + data + idQuestion);
                    if (data != 1) {
                        $("#deleteMessage").html("Erreur de suppression");
                    } else {
                        $('#deleteCancel').trigger('click');
                        refresh();
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $("#errorMessage").html("Erreur d\'envoi de la requête");
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
            //     console.log(checkbox);
            if (ctrlAddResponse()) {
                $.ajax({
                    type: 'POST',
                    url: '/routes.php?action=addResponse&idQuestion=' + idQuestion + '&addName=' + $("#addName").val()
                            + '&addLibelle=' + $("#addLibelle").val() + '&addOrder=' + $("#addOrder").val(),
                    /*   data:
                     {
                     "idQuestion" : idQuestion,
                     "addName" : $("#addName").val(),
                     "addLibelle" : $("#addLibelle").val(),
                     "addOrder" : $("#addOrder").val(),
                     },*/
                    success: function (data) {
                        console.log('add' + data + '/routes.php?action=addResponse&idQuestion=' + idQuestion
                                + '&addName=' + $("#addName").val() + '&addLibelle=' + $("#addLibelle").val()
                                + '&addOrder=' + $("#addOrder").val());
                        if (data != 1) {
                            $("#addMessage").html("Erreur d\'ajout");
                        } else {
                            $('#addCancel').trigger('click');
                            refresh();
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $("#errorMessage").html("Erreur d\'envoi de la requête");
                    }
                });
            }
        });
        $("#addQuestion").click(function () {
            // alert();
         var checkbox = $('table tbody input[type="checkbox"]');
            //alert(checkbox);
            //   console.log(checkbox);
            if (ctrlAddQuestion()) {
                $.ajax({
                    type: 'POST',
                    url: '/routes.php?action=addQuestion',
                    data:
                            {
                                "idForm": idForm,
                                "addName": $("#addQuestionName").val(),
                                "addLibelle": $("#addQuestionLibelle").val(),
                                "addOrder": $("#addQuestionOrder").val()
                            },
                    success: function (data) {
                        if (data != 1) {
                            $("#addQuestionMessage").html("Erreur d\'Ajout");
                        } else {
                            $('#addQuestionCancel').trigger('click');
                            refresh();
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $("#errorMessage").html("Erreur d\'envoi de la requête");
                    }
                });
            }
        });
    });

</script>

<div class="container_fluid">
    <div class="table-wrapper">
        <div class="table-title ">
            <div class="row">
                <div class="col-sm-4">
                    <h5><?= $form->getForm_name() ?></h5><input type="hidden" value="<?= $form->getForm_id() ?>" id="idForm">
                </div>
                <div class="col-sm-8">
                    <button id="back" class="btn btn-default btn-sm" data-toggle="modal">
                        <i class="material-icons">&#xE314;</i> <span class="black-write">Retour</span></button>
                    <button id="addResponseButton" class="btn btn-success btn-sm" data-toggle="modal">
                        <i class="material-icons">&#xE147;</i> <span>Ajouter une réponse</span></button>
                    <button id="deleteQuestionButton" class="btn btn-danger btn-sm" data-toggle="modal">
                        <i class="material-icons">&#xE15C;</i> <span>Supprimer une question</span></button>						
                    <button id="addQuestionButton" class="btn btn-info btn-sm" data-toggle="modal">
                        <i class="material-icons">&#xE147;</i> <span>Ajouter une question</span></button>


                </div>
            </div>
            <div id='errorMessage'></div>
        </div>
        <!-- RAFRAICHISSEMENT DU DETAIL VIA AJAX -->
        <div id='requete' class="scrollDiv2"></div>
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
                            <label>Nom</label>
                            <input type="text" class="form-control" required id="addName">
                        </div>
                        <div class="form-group">
                            <label>Libellé</label>
                            <input type="text" class="form-control" required id="addLibelle">
                        </div>
                        <div class="form-group">
                            <label>N° d'ordre</label>
                            <input type="number" class="form-control" required id="addOrder">
                        </div>	
                        <div id="addMessage" class="text-warning align-items-center"></div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" id="addCancel">
                        <input type="button" class="btn btn-success" value="Ajouter" id="addResponse">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL ADD RESPONSE -->
    <div id="addQuestionModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">						
                        <h4 class="modal-title">Ajouter une question</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" class="form-control" required id="addQuestionName">
                        </div>
                        <div class="form-group">
                            <label>Libellé</label>
                            <input type="text" class="form-control" required id="addQuestionLibelle">
                        </div>
                        <div class="form-group">
                            <label>N° d'ordre</label>
                            <input type="number" class="form-control" required id="addQuestionOrder">
                        </div>	
                        <div id="addQuestionMessage" class="text-warning align-items-center"></div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Abandon" id="addQuestionCancel">
                        <input type="button" class="btn btn-success" value="Ajouter" id="addQuestion">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL EDIT QUESTION -->
    <div id="editEmployeeModal" class="modal fade">
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
                        <p>Etes vous sûr de vouloir supprimer la question?</p>
                        <p class="text-warning">Sa suppression entrainera la suppression des réponses attachées.</p>
                    </div>
                    <div id="deleteMessage" class="text-warning align-items-center"></div>
                    <div class="modal-footer">
                        <input type="button" id="deleteCancel" class="btn btn-default" data-dismiss="modal" value="Abandon">
                        <input type="button" id="deleteQuestion" class="btn btn-danger" value="Suppr.">
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
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Abandon">

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
