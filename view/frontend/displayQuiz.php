
<div class="container-fluid">
    <div class="table-wrapper">
        <div class="table-title ">
            <div class="row">
                <div class="col-sm-10">
                    <h5>AFFICHAGE DU FORMULAIRE : <?= $form->getForm_name() ?>&nbsp&nbsp Mode :<?= $searchtype->getSearchtype_name() ?></h5><input type="hidden" value="<?= $form->getForm_category() ?>" id="category"><input type="hidden" value="<?= $form->getForm_bu() ?>" id="bu">
                    <input type="hidden" value="<?= $form->getForm_searchtype() ?>" id="searchtype">
                </div>
                <div class="col-sm-2">
                    <!--<button class="pull-right">Envoi Email</button>-->
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
                    if (!isset($headerRequest))
                        $headerRequest = array();
                  // print_r($headerRequest);
                    foreach ($headerRequest as $t) {
                        $class = explode('#', $t['header']);
                       // print_r($class);
                        ?>
                        <div class="form-group <?= $class[1] ?> ">
                            <label for="<?= $class[0] ?>"><?= $class[0] ?></label>
                            <select id="<?= $class[0] ?>" class="form-control form-control-sm">
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
        <div class="col-md-9 scrollDiv2" style="background-color: gainsboro" id="requete"></div>
    </div>

</div>
<script>
    $(document).ready(function () {
        $(function () {
            $('#formChoice').on('change', function () {
                lsparams = '';
                $('select').each(function () {
                    if ($(this).is(':visible')) {
                        lsparams = lsparams + $(this).val() + '-';
                    }
                });
                lsparams = lsparams.substring(0, lsparams.lastIndexOf("-"));
                bu = $('#bu').val();
                console.log(bu);
                category = $('#category').val();
                searchtype = $('#searchtype').val();
                $.ajax({
                    type: "POST",
                    url: '/routes.php?action=listProductSelection',
                    data:
                            {
                                "bu": bu,
                                "category": category,
                                "params": lsparams,
                                "searchtype": searchtype
                            },
                    success: function (data) {
                        console.log(data);
                        $("#requete").html(data);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert('Erreur interne: ' + xtStatus);
                    }
                });
                return false;
            });
        });
    });
</script>

    