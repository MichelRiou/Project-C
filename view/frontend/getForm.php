<?php $title = 'ListRequest'; ?>
<?php ob_start(); ?>
<div class="container-fluid">
    <div class="table-wrapper">
        <div class="table-title ">
            <div class="row">
                <div class="col-sm-4">
                    <h5>AFFICHAGE FORMULAIRE</h5><input type="hidden" value="" id="idForm">
                </div>

            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3" style="background-color: #D0DCF3" > 
            <div class="col-md-12 scrollDiv">
                <form id="formChoice">
                    <?php
                    //print_r($headerRequest);
                    foreach ($headerRequest as $t) {
                        $class = explode('#', $t['header']);
                        //print_r($class);
                        ?>

                        <div class="form-group <?= $class[1] ?> ">
                            <label for="<?= $class[2] ?>"><?= $class[0] ?></label>
                            <select id="<?= $class[2] ?>" class="form-control form-control-sm">
                                <option value="0" selected></option>
                                <?php
                                foreach ($t['request'] as $n) {
                                    $request = explode('#', $n);
                                    ?>
                                    <option value="<?= $request[1] ?>"><?= $request[0] ?></option>

                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                </form>            

            </div>
        </div>
          <!-- RAFRAICHISSEMENT DU DETAIL VIA AJAX -->
        <div class="col-md-9" style="background-color: gainsboro" id="requete"></div>
    </div>

</div>
<script>
    var lsparams;
    var lsplaceType;
    var lsautonome;
    var form;
    var selects;

    $(document).ready(function () {
        $(function () {
            $('#formChoice').on('change', function () {
                lsparams = '';
                $('select').each(function () {
                    if ($(this).is(':visible')) {
                        lsparams = lsparams + $(this).val() + '-';
                    }
                });
                //lsparams=len(params,-1);
                lsparams = lsparams.substring(0, lsparams.lastIndexOf("-"));
                $.ajax({
                    type: "POST",
                    url: '/routes.php?action=listProductSelection&params=' + lsparams,
                    success: function (data) {
                        $("#requete").html(data);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(textStatus);
                    }
                });
                //alert(lsPlaceType);
                return false;
            });
        });
    });
</script>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
    