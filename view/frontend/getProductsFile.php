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
                <div class="col-sm-6">
                    <h2>Mise à jour du fichier product</h2>
                </div>
                <div class="col-sm-6">

                    <button id="okbutton" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Ajouter une réponse</span></button>
                    <button id="deletebutton" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Supprimer une question</span></button>						
                </div>
            </div>
        </div>
         <div class="col-sm-6">
        <form class="form-group" method="post" action="routes.php?action=majProductsFile" enctype="multipart/form-data">

            <label class="control-label" for="fichier">Fichier (tous formats | max. 1 Mo) :</label><br />
            <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
            <input type="file" class ="filestyle" name="fichier" id="fichier" data-icon="false" accept=".xls, .xlsx"/><br />
            <input type="submit" name="submit" value="Envoyer" />
        </form>
             <div><?=$message ?></div>
 </div>
    </div>
</div>
<div class="col-xs-4">
 
<div class="form-group">
 
<label class="control-label">A file upload button without icon</label>
 
<input type="file" class="filestyle" data-icon="false">
 
</div>
 
</div>
<div class="col-sm-4">
<div class="custom-file">
  <input type="file" class="custom-file-input" id="customFile">
  <label class="custom-file-label" for="customFile">Choose file</label>
</div>
    </div>

    <?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>