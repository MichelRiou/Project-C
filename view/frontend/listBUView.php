<?php $title = 'Recherche'; ?>

<?php ob_start(); ?>
<h1>Elément correspondant</h1>
<div class="row align-items-center justify-content-center">
    <div>
        <select  id="BU_select" > 
            <option value="" selected>Select</option>
            <?php
            while ($data = $BUs->fetch()) {
                ?>
                <option value="<?= $data['bu_name'] ?>" ><?= $data['bu_name'] ?></option>

                <?php
            }
            $BUs->closeCursor();
            ?>
        </select>
    </div>
</div>
<script>
    $(function () {
        $('#BU_select').on('change', function () {
            var id = $(this).val(); // get selected value
            if (id === "AUDIOVISUEL") {
                //controleur a faire
                window.location ="routes.php?action=addHeaders";
                //window.location = "/view/frontend/form1view.php";
                //alert();
            }

            return false;
        });
    });
</script>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
    
