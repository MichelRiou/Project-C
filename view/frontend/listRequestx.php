<?php
ob_start();
?>
<script type="text/javascript">
    $(document).ready(function () {
        // Activate tooltip
        $('[data-toggle="tooltip"]').tooltip();
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
                console.log(checkbox);
                $("#message").html('');
                $("#deleteQuestionModal").modal('show');
            } else {
                $("#messageModal").modal('show');
            }
        });
        // Select/Deselect checkboxes
        var checkbox = $('table tbody input[type="checkbox"]');
        /*  $("#selectAll").click(function () {
         if (this.checked) {
         checkbox.each(function () {
         this.checked = true;
         });
         } else {
         checkbox.each(function () {
         this.checked = false;
         });
         }
         });*/

        checkbox.click(function () {
            var s = this.checked;
            console.log(s)
            checkbox.each(function () {
                this.checked = false;
            });
            this.checked = s;
            /*   alert();
             if (!this.checked) {
             $("#selectAll").prop("checked", false);
             }*/
        });
        $("#addResponse").click(function () {
            // alert();
            var checkbox = $('table tbody input[type="checkbox"]');
            //alert(checkbox);
            console.log(checkbox);
        });
    });

</script>

<div class="container">
    <div class="table-wrapper">
        <div class="table-title ">
            <div class="row">
                <div class="col-sm-4">
                    <h2>Gestion des formulaires</h2>
                </div>
                <div class="col-sm-8">
                    
                    <button id="okbutton" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Ajouter une réponse</span></button>
                    <button id="deletebutton" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Supprimer une question</span></button>						
                    <button id="addbutton" class="btn btn-info" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Ajouter une question</span></button>
                
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>Nom</th>
                    <th>Libellé</th>
                    <th>Ordre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $request_save = '';
                $index = 0;
                foreach ($requests as $request) {
                    if ($request['header_designation'] != $request_save) {
                        $request_save = $request['header_designation'];
                        ?>
                        <tr>
                            <td>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="checkbox<?= $index ?>" name="options[]" value="1">
                                    <label for="checkbox1"></label>
                                </span>
                            </td>
                            <td>Question: <b><?= $request['header_designation'] ?></b></td><td></td><td></td><td></td></tr>
                        <?php
                        $index++;
                    }
                    ?>
                    <tr><td></td><td><?= $request['request_name'] ?></td><td><?= $request['request_libelle'] ?></td><td><?= $request['request_order'] ?></td>
                        <td>
                            <a href="routes.php?action=majOneRequest&id=<?= $request['request_id'] ?>&bu=<?= $request['header_bu'] ?>" class="edit"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>

                            <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                        </td>
                    </tr>
                    <?php
                }
                ?> 
            </tbody>
        </table>

        <!--     <div class="clearfix">
                 <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                 <ul class="pagination">
                     <li class="page-item disabled"><a href="#">Previous</a></li>
                     <li class="page-item"><a href="#" class="page-link">1</a></li>
                     <li class="page-item"><a href="#" class="page-link">2</a></li>
                     <li class="page-item active"><a href="#" class="page-link">3</a></li>
                     <li class="page-item"><a href="#" class="page-link">4</a></li>
                     <li class="page-item"><a href="#" class="page-link">5</a></li>
                     <li class="page-item"><a href="#" class="page-link">Next</a></li>
                 </ul>
             </div>
         </div> -->
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
                        <p>Are you sure you want to delete these Records?</p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-danger" value="Delete">
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
