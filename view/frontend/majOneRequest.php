<?php
ob_start();
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
    body {
        color: #566787;
        background: #f5f5f5;
        font-family: 'Varela Round', sans-serif;
        font-size: 13px;
    }
    .table-wrapper {
        background: #fff;
        padding: 20px 25px;
        margin: 30px 0;
        border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .table-title {        
        padding-bottom: 15px;
        background: #435d7d;
        color: #fff;
        padding: 16px 30px;
        margin: -20px -25px 10px;
        border-radius: 3px 3px 0 0;
    }
    .table-title h2 {
        margin: 5px 0 0;
        font-size: 24px;
    }
    .table-title .btn-group {
        float: right;
    }
    .table-title .btn {
        color: #fff;
        float: right;
        font-size: 13px;
        border: none;
        min-width: 50px;
        border-radius: 2px;
        border: none;
        outline: none !important;
        margin-left: 10px;
    }
    .table-title .btn i {
        float: left;
        font-size: 21px;
        margin-right: 5px;
    }
    .table-title .btn span {
        float: left;
        margin-top: 2px;
    }
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
        padding: 12px 15px;
        vertical-align: middle;
    }
    table.table tr th:first-child {
        width: 60px;
    }
    table.table tr th:last-child {
        width: 100px;
    }
    table.table-striped tbody tr:nth-of-type(odd) {
        background-color: #fcfcfc;
    }
    table.table-striped.table-hover tbody tr:hover {
        background: #f5f5f5;
    }
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }	
    table.table td:last-child i {
        opacity: 0.9;
        font-size: 22px;
        margin: 0 5px;
    }
    table.table td a {
        font-weight: bold;
        color: #566787;
        display: inline-block;
        text-decoration: none;
        outline: none !important;
    }
    table.table td a:hover {
        color: #2196F3;
    }
    table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #F44336;
    }
    table.table td i {
        font-size: 19px;
    }
    table.table .avatar {
        border-radius: 50%;
        vertical-align: middle;
        margin-right: 10px;
    }
    .pagination {
        float: right;
        margin: 0 0 5px;
    }
    .pagination li a {
        border: none;
        font-size: 13px;
        min-width: 30px;
        min-height: 30px;
        color: #999;
        margin: 0 2px;
        line-height: 30px;
        border-radius: 2px !important;
        text-align: center;
        padding: 0 6px;
    }
    .pagination li a:hover {
        color: #666;
    }	
    .pagination li.active a, .pagination li.active a.page-link {
        background: #03A9F4;
    }
    .pagination li.active a:hover {        
        background: #0397d6;
    }
    .pagination li.disabled i {
        color: #ccc;
    }
    .pagination li i {
        font-size: 16px;
        padding-top: 6px
    }
    .hint-text {
        float: left;
        margin-top: 10px;
        font-size: 13px;
    }    
    /* Custom checkbox */
    .custom-checkbox {
        position: relative;
    }
    .custom-checkbox input[type="checkbox"] {    
        opacity: 0;
        position: absolute;
        margin: 5px 0 0 3px;
        z-index: 9;
    }
    .custom-checkbox label:before{
        width: 18px;
        height: 18px;
    }
    .custom-checkbox label:before {
        content: '';
        margin-right: 10px;
        display: inline-block;
        vertical-align: text-top;
        background: white;
        border: 1px solid #bbb;
        border-radius: 2px;
        box-sizing: border-box;
        z-index: 2;
    }
    .custom-checkbox input[type="checkbox"]:checked + label:after {
        content: '';
        position: absolute;
        left: 6px;
        top: 3px;
        width: 6px;
        height: 11px;
        border: solid #000;
        border-width: 0 3px 3px 0;
        transform: inherit;
        z-index: 3;
        transform: rotateZ(45deg);
    }
    .custom-checkbox input[type="checkbox"]:checked + label:before {
        border-color: #03A9F4;
        background: #03A9F4;
    }
    .custom-checkbox input[type="checkbox"]:checked + label:after {
        border-color: #fff;
    }
    .custom-checkbox input[type="checkbox"]:disabled + label:before {
        color: #b8b8b8;
        cursor: auto;
        box-shadow: none;
        background: #ddd;
    }
    /* Modal styles */
    .modal .modal-dialog {
        max-width: 400px;
    }
    .modal .modal-header, .modal .modal-body, .modal .modal-footer {
        padding: 20px 30px;
    }
    .modal .modal-content {
        border-radius: 3px;
    }
    .modal .modal-footer {
        background: #ecf0f1;
        border-radius: 0 0 3px 3px;
    }
    .modal .modal-title {
        display: inline-block;
    }
    .modal .form-control {
        border-radius: 2px;
        box-shadow: none;
        border-color: #dddddd;
    }
    .modal textarea.form-control {
        resize: vertical;
    }
    .modal .btn {
        border-radius: 2px;
        min-width: 100px;
    }	
    .modal form label {
        font-weight: normal;
    }
</style>
<script type="text/javascript">
    var idDelete;
    var idEdit;
    function refresh() {
        $.ajax({
            type: 'POST',
            url: '/routes.php?action=listTagsRequest&id=' + $("#idRequest").val(),
            success: function (data) {
                $("#requete").html(data);
                $('a[class="delete"]').click(function () {
                    // event.preventDefault();
                    //var t=this;
                    idDelete = this.getAttribute('value');
                    // page = ($(this).attr("href"));
                    console.log(idDelete);
                });
                $('a[class="edit"]').click(function () {
                    // event.preventDefault();
                    //var t=this;
                    idEdit = this.getAttribute('value');
                    // page = ($(this).attr("href"));
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
        // Activation du tooltip
        $('[data-toggle="tooltip"]').tooltip();
        // Activation de la fenêtre modale AJOUTER UN TAG
        $("#addbutton").click(function () {
            $("#message").html('');
            $("#addTagModal").modal('show');
        });
        $('a[class="delete"]').click(function () {
            // event.preventDefault();
            //var t=this;
            idDelete = this.getAttribute('value');
            // page = ($(this).attr("href"));
            console.log(idDelete);
        });
        $('a[class="edit"]').click(function () {
            // event.preventDefault();
            //var t=this;
            idEdit = this.getAttribute('value');
            // page = ($(this).attr("href"));
            console.log(idEdit);
        });
        // CheckBox version RadioButton 
        //var checkbox = $('table tbody input[type="checkbox"]');
        //checkbox.click(function () {
        //  checkbox.each(function () {
        //    this.checked = false;
        // });
        // this.checked = true;
        //});
        // Requête AJAX pour validation
        $("#addTag").on('click', (function () {
            $.ajax({
                type: 'POST',
                url: '/routes.php?action=addTagOnRequest' + '&idRequest=' + $("#idRequest").val() + '&idTag=' + $("#idTag").val() + '&selectOperator=' + $("#selectOperator").val() + '&alphanumericValue=' + $("#alphanumericValue").val() + '&numericValue=' + $("#numericValue").val(),
                success: function (result) {
                    console.log('retour success' + result);
                    if (result != 1) {
                        $("#message").html("Erreur d\'insertion");
                    } else {
                        $('#cancel').trigger('click');
                        refresh();
                        //console.log('maj');
                        //window.location = 'routes.php?action=majOneRequest&id=' + $("#idRequest").val() + '&bu=' + $("#idBu").val();
                       /* $.ajax({
                            type: 'POST',
                            url: '/routes.php?action=listTagsRequest&id=' + $("#idRequest").val(),
                            success: function (data) {
                                $("#requete").html(data);
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                alert(textStatus);
                                $("#retour").html("Erreur d\'envoi de la requête");
                            }
                        });*/
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
                        //console.log('maj');
                        //window.location = 'routes.php?action=majOneRequest&id=' + $("#idRequest").val() + '&bu=' + $("#idBu").val();
                        /*$.ajax({
                            type: 'POST',
                            url: '/routes.php?action=listTagsRequest&id=' + $("#idRequest").val(),
                            success: function (data) {
                                $("#requete").html(data);
                                $('a[class="delete"]').click(function () {
                                    // event.preventDefault();
                                    //var t=this;
                                    idDelete = this.getAttribute('value');
                                    // page = ($(this).attr("href"));
                                    console.log(idDelete);
                                });
                                $('a[class="edit"]').click(function () {
                                    // event.preventDefault();
                                    //var t=this;
                                    idEdit = this.getAttribute('value');
                                    // page = ($(this).attr("href"));
                                    console.log(idEdit);
                                });
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                alert(textStatus);
                                $("#retour").html("Erreur d\'envoi de la requête");
                            }
                        });*/
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
                    <h2>Réponses</b></h2>
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
            <table class="table table-striped table-hover">
                <thead>
                    <tr><th>Nom du Tag</th><th>Libellé du Tag</th><th>Opérateur</th><th>Valeur Alphanum</th><th>Valeur numérique</th>
                        <th>Actions

                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($tagsRequest as $tagRequest) {
                        ?>
                        <tr><td><?= $tagRequest['tag_name'] ?></td><td><?= $tagRequest['tag_values'] ?></td><td><?= $tagRequest['request_tag_sign'] ?></td><td><?= $tagRequest['request_tag_value'] ?></td><td><?= $tagRequest['request_tag_numeric'] ?></td>
                            <td>
                                <a href="#editTagModal" value="<?= $tagRequest['tag_id'] ?>" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                <a href="#deleteTagModal" value="<?= $tagRequest['tag_id'] ?>"  class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                            </td>
                        </tr>
                    <?php } ?> 
                </tbody>
            </table>
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
                    <input type="submit" class="btn btn-success" value="save" id="save">
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
                        <select class="form-control" name="selectOperator" id="selectOperator">
                            <option value="=">=</option>
                            <option value=">">></option>
                            <option value="<"><</option>
                            <option value="EST">>=</option>
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
                    <input type="button" class="btn btn-info" value="add" id="addTag">
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
                    <h4 class="modal-title">Delete Employee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <p>Are you sure you want to delete these Records?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
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