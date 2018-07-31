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
                <div >
                    <h2>Mise à jour du fichier product</h2>
                </div>
            </div>
        </div>
        <div class="row col-md-4">
        <div class="col-md-4 center-block">
            <form class="form-group" method="post" action="/routes.php?action=majProductsFile" enctype="multipart/form-data">
                   
                <label class="control-label" for="fichier">Fichier (tous formats | max. 20 Mo) :</label><br />
                <input type="hidden" name="MAX_FILE_SIZE" value="1073741824" />
                <input type="file" class ="filestyle" name="fichier" id="fichier" data-icon="false" accept=".xls, .xlsx"/><br />
                <input type="submit" name="submit" value="Envoyer" />
            </form>
            <div><?= $msg ?></div>
        </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>