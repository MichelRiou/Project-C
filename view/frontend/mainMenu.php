<?php $title = 'Calestor'; ?>
<?php ob_start(); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
                    <img src="/public/images/logo calestor.gif" class="main_logo mx-auto d-block">
                 </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
    