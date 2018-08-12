<script type="text/javascript">
    var idDelete;
    var idEdit;
    function ctrlEditProduct() {
        var msg = "";
        if ($("#editCategory").val() == '0')
            msg += 'La catégorie est obligatoire.<br>';
        // Monitoring des erreurs
        $("#editMessage").html(msg);
        $result = (msg != "" ? false : true);
        return $result;
    }
    function ctrlAddProduct() {
        var msg = "";
        if ($("#addRefBuilder").val() == '')
            msg += 'La référence constructeur est obligatoire.<br>';
        if ($("#addCategory").val() == '0')
            msg += 'La catégorie est obligatoire.';
        // Monitoring des erreurs
        $("#addMessage").html(msg);
        $result = (msg != "" ? false : true);
        return $result;
    }

    function refresh() {
        $.ajax({
            type: 'POST',
            url: '/routes.php?action=listProductByCat',
            data:
                    {
                        "category": 0,
                    },
           /* beforeSend: function(){
              $("#loader").show();  
            },*/
            success: function (data) {
                /* $("#loader").hide(); */
                $("#requete").html(data);
                $('[data-toggle="tooltip"]').tooltip();
                $("#addButton").click(function () {
                    //       var s = $('table tbody input:checked');
                    //     if (s.length !== 0) {
                   // console.log(checkbox);
                    $("#message").html('');
                    $("#addProductModal").modal('show');
                    //   } else {
                    //     $("#messageModal").modal('show');
                    // }
                });
                /*   var checkbox = $('table tbody input[type="checkbox"]');
                 
                 checkbox.click(function () {
                 var s = this.checked;
                 console.log(s)
                 checkbox.each(function () {
                 this.checked = false;
                 });
                 this.checked = s;
                 });*/


                $('a[class="delete"]').click(function () {
                    idDelete = this.getAttribute('value');
                    console.log(idDelete);
                });
                $('a[class="edit"]').click(function () {
                   idEdit = this.getAttribute('value');
                    console.log(idEdit);
                    $('#editBuilderRef').val(this.getAttribute('builder_ref'));

                    //$('#editRef').val(this.getAttribute('ref'));
                    $('#editModel').val(this.getAttribute('model'));
                    $('#editRef').val(this.getAttribute('ref'));
                    $('#editBuilder').val(this.getAttribute('builder'));
                    $('#editEan').val(this.getAttribute('ean'));
                     $('#editCategory').val(this.getAttribute('cat'));
                    $('#editDesignation').val(this.getAttribute('designation'));
                    /* console.log('cat' + this.getAttribute('category'));
                     var cat =this.getAttribute('category');
                     console.log('cat' + cat);
                       console.log( cat);
                    $('#editCategory').val(this.getAttribute('category')).prop('selected', true);*/
                   //  $('#editCategory').val('1').prop('selected', true);

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
        $("#addButton").click(function () {
            // var s = $('table tbody input:checked');
            //  if (s.length !== 0) {
            console.log(checkbox);
            $("#message").html('');
            $("#addProductModal").modal('show');
            // } else {
            //   $("#messageModal").modal('show');
            // }
        });
        // Validation de la modal SUPPRIMER UNE QUESTION
        $("#deletebutton").click(function () {
           /* var s = $('table tbody input:checked');
            if (s.length !== 0) {
                /// console.log(s[0]);
                // console.log(s[0].value);
                var deleteHeader = s[0].value;*/
                $("#message").html('');
                $("#deleteQuestionModal").modal('show');
           /* } else {
                $("#messageModal").modal('show');
            }*/
        });
        // Requête AJAX pour validation
        $("#addProduct").on('click', (function () {
            if (ctrlAddProduct()) {
                $.ajax({
                    type: 'POST',
                    url: '/routes.php?action=addProduct&builderref=' + $("#addRefBuilder").val() + '&ref=' + $("#addRef").val() + '&model=' + $("#addModel").val() + '&builder=' + $("#addBuilder").val() + '&designation=' + $("#addDesignation").val() + '&ean=' + $("#addEan").val() + '&category=' + $("#addCategory").val(),
                   // url: '/routes.php?action=addForm&name=' + $("#addName").val() + '&designation=' + $("#addDesignation").val() + '&category=' + $("#addCategory").val() + '&searchtype=' + $("#addSearchType").val(),
                    success: function (data) {
                        console.log(data + '/routes.php?action=addProduct&builderref=' + $("#addBuilderRef").val() + '&ref=' + $("#addRef").val() + '&model=' + $("#addModel").val() + '&builder=' + $("#addBuilder").val() + '&designation=' + $("#addDesignation").val() + '&ean=' + $("#addEan").val() + '&category=' + $("#addCategory").val());
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
         // Requête AJAX pour validation
        $("#deleteProduct").on('click', (function () {
            if (ctrlAddProduct()) {
                $.ajax({
                    type: 'POST',
                    url: '/routes.php?action=deleteProduct&builderref=' + $("#addRefBuilder").val() + '&ref=' + $("#addRef").val() + '&model=' + $("#addModel").val() + '&builder=' + $("#addBuilder").val() + '&designation=' + $("#addDesignation").val() + '&ean=' + $("#addEan").val() + '&category=' + $("#addCategory").val(),
                   // url: '/routes.php?action=addForm&name=' + $("#addName").val() + '&designation=' + $("#addDesignation").val() + '&category=' + $("#addCategory").val() + '&searchtype=' + $("#addSearchType").val(),
                    success: function (data) {
                        console.log(data + '/routes.php?action=addProduct&builderref=' + $("#addBuilderRef").val() + '&ref=' + $("#addRef").val() + '&model=' + $("#addModel").val() + '&builder=' + $("#addBuilder").val() + '&designation=' + $("#addDesignation").val() + '&ean=' + $("#addEan").val() + '&category=' + $("#addCategory").val());
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
        $("#editProduct").on('click', (function () {
       // var next = this.getAttribute('id');
       // console.log(next);
        if (ctrlEditProduct()) {
            $.ajax({
                type: 'POST',
                url: '/routes.php?action=updateProduct&id=' + idEdit + '&builderref=' + $("#editBuilderRef").val() + '&ref=' + $("#editRef").val() + '&model=' + $("#editModel").val() + '&builder=' + $("#editBuilder").val() + '&designation=' + $("#editDesignation").val() + '&ean=' + $("#editEan").val() + '&category=' + $("#editCategory").val(),
                success: function (data) {
                    console.log(data);
                    if (data == 0) {
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
        }
        ));
                // AJAX
        // Select/Deselect checkboxes
        var checkbox = $('table tbody input[type="checkbox"]');

        checkbox.click(function () {
            var s = this.checked;
            checkbox.each(function () {
                this.checked = false;
            });
            this.checked = s;
        });
        /* $("#addResponse").click(function () {
         // alert();
         var checkbox = $('table tbody input[type="checkbox"]');
         //alert(checkbox);
         console.log(checkbox);
         });*/
    });

</script>

<div class="container-fluid">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-4">
                    <h5>LISTE DES PRODUITS</h5><input type="hidden" value="" id="idForm">
                </div>
                <div class="col-sm-3">		
                    <button id="back" class="btn btn-default" data-toggle="modal"><i class="material-icons">&#xE314;</i> <span class="black-write">Retour</span></button>
                    <button id="addButton" class="btn btn-info" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Ajouter un produit</span></button>

                </div>
                <div class="col-sm-5">

                    <input class=" pull-right" type="submit" value="Rechercher" onclick="searchString()" />
                    <input class="pull-right" id="search" name="search" type="text" value="" onfocus="clearSearch()" />
                </div>
            </div>
        </div>
        <!-- RAFRAICHISSEMENT DU DETAIL VIA AJAX -->
       <!-- <div id="loader" class="offset-md-5 col-md-1 mx-auto"><img src="public/images/ajax-loader.gif"/></div> -->
        <div id="requete" class="scrollDiv2">

        </div>
    </div>
    <!-- MODAL ADD RESPONSE -->
    <div id="editProductModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">						
                        <h4 class="modal-title">Modification Produit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div class="form-group">
                            <label>Ref. constructeur</label>
                            <input type="text" class="form-control" readonly="readonly" id ="editBuilderRef" >
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
                            <?php for ($i = 0; $i < count($categories); $i++) { ?>
                                <option value="<?= $categories[$i]->getCategory_id() ?>">
                                    <?= $categories[$i]->getCategory_name() ?></option>
                            <?php } ?>
                        </select>
                    </div>  
                    </div>
                    <div id="editMessage" class="text-warning align-items-center"></div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" id="editCancel">
                        <input type="button" class="btn btn-success edit" value="Validation" id="editProduct">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- MODAL EDIT RESPONSE -->
    <div id="addProductModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">						
                        <h4 class="modal-title">Ajouter Produit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div class="form-group">
                            <label>Ref. constructeur</label>
                            <input type="text" class="form-control"  id ="addRefBuilder" >
                        </div>
                        <div class="form-group">
                            <label>Ref. grossiste</label>
                            <input type="text" class="form-control"  id ="addRef" >
                        </div>
                        <div class="form-group">
                            <label>Modèle</label>
                            <input type="text" class="form-control"  id ="addModel" >
                        </div>  


                        <div class="form-group">
                            <label>Constructeur</label>
                            <input type="text" class="form-control"  id ="addBuilder" >
                        </div>  
                        <div class="form-group">
                            <label>Désignation</label>
                            <textarea class="form-control"  id ="addDesignation" rows="3"></textarea>
                        </div>  
                        <div class="form-group">
                            <label>EAN</label>
                            <input type="text" class="form-control"  id ="addEan" >
                        </div> 
                        <div class="form-group">
                            <label>Catégorie</label>
                            <select class="form-control" name="addCategory" id="addCategory">
                                <option value="0">--</option>
                                <?php for ($i = 0; $i < count($categories); $i++) { ?>
                                    <option value="<?= $categories[$i]->getCategory_id() ?>"><?= $categories[$i]->getCategory_name() ?></option>
                                <?php } ?>
                            </select>
                        </div> 
                    </div>
                    <div id="addMessage" class="text-warning align-items-center"></div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Abandon" id="addCancel">
                        <input type="button" class="btn btn-success edit" value="Ajouter" id="addProduct">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal HTML -->
    <div id="deleteProductModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">						
                        <h4 class="modal-title">Supprimer un produit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <h6 class="text-warning">Etes-vous sur ?</h6>
                    </div>
                    <div id="deleteMessage" class="text-warning align-center"></div>
                    <div class="modal-footer">
                        <input type="button" id="deleteCancel" class="btn btn-default" data-dismiss="modal" value="Abandon">
                        <input type="button"  class="btn btn-danger" value="Suppr." id="deleteProduct">
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

