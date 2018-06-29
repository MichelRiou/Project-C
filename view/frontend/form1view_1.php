<?php $title = 'Recherche'; ?>
<!-- <input type="radio" name="typeDevicetott" value="true" checked="checked" /> -->
<?php ob_start(); ?>
<div class="container-fluid">

<div class="col-md-2 offset-md-2" >
    <div class="form-group row">
        <fieldset id="group1">
            <div class="form-check radio-green">
                <input class="form-check-input" name="deviceType" type="radio" id="deviceMobile">
                <label class="form-check-label" for="deviceType">Mobile</label>
            </div>

            <div class="form-check radio-green">
                <input class="form-check-input" name="deviceType" type="radio" id="deviceFixe" checked>
                <label class="form-check-label" for="deviceType">Installé</label>
            </div>
        </fieldset>
    </div>
</div>
    </div>
<div class="container-fluid">
<form class="d-inline" id="formChoice">

    <div class="form-group-row col-md-4 offset-md-2 fixe">
        <div class="form-group row fixe">
            <label for="roomType">Type de Salle</label>
            <select id="roomType" class="form-control form-control-sm">
                <option selected></option>
                <option value="1">Grande (20 à 40 m2)</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4 offset-md-2 fixe">
            <label for="luxType">Lumière</label>
            <select id="luxType" class="form-control form-control-sm">
                <option value="00"selected></option>
                <option value="01">Baie vitrée</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4 offset-md-2 fixe">
            <label for="heightType">Hauteur</label>
            <select id="heightType" class="form-control form-control-sm">
                <option selected></option>
                <option>Grande Hauteur > 4,00m</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4 offset-md-2 fixe">
            <label for="useType">Hauteur</label>
            <select id="useType" class="form-control form-control-sm">
                <option selected></option>
                <option>Bureautique</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4 offset-md-2 fixe">
            <label for="important1Type">Important</label>
            <select id="important1Type" class="form-control form-control-sm">
                <option selected></option>
                <option>Rendu des noirs</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4 offset-md-2 fixe">
            <label for="important2Type">Important</label>
            <select id="important2Type" class="form-control form-control-sm">
                <option selected></option>
                <option>Grand Public</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4 offset-md-2 mobile">
            <label for="important2">Type d'utilisation</label>
            <select id="placeType" class="form-control form-control-sm">
                <option selected></option>
                <option value="1">Dans l'entreprise</option>
                <option value="2">A l'extérieur</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4 offset-md-2 mobile">
            <div class="checkbox_inline">
                <label><input type="checkbox" value="">Autonome</label>
            </div>
        </div>

    </div>
</form>
    </div>
<div class="d-inline">
    <input type="button" value="TEST" name="test" id="test"/>
    <div id="requete"></div>
</div>
<script>
    var lsroomType;
    var lsPlaceType;
    $(document).ready(function () {
        $('.mobile').hide();
        $('.fixe').show();
        //document.getElementById('deviceFixe').checked;

    });

    $(function () {
        $('#group1').on('change', function () {
            if (document.getElementById('deviceMobile').checked) {
                //var id = $(this).val(); // get selected value
                //if (id === "AUDIOVISUEL") {
                // window.location = "../../index.php?action=listPosts"; 
                //alert();
                //}
                $('.fixe').hide();
                $('.mobile').show();
                //alert(id);

            } else {
                $('.mobile').hide();
                $('.fixe').show();
            }
            //var lsPlaceType  = document.getElementById('placeType').value;
            //alert(lsPlaceType);
            return false;
        });
    });

    $(function () {
        $('#formChoice').on('change', function () {

            if (document.getElementById('deviceFixe').checked) {

                var lsPlaceType = document.getElementById('placeType').value;
                lsroomType = document.getElementById('roomType').value;
                var lsPlaceType = document.getElementById('placeType').value;
                var lsPlaceType = document.getElementById('placeType').value;
                var lsPlaceType = document.getElementById('placeType').value;
                var lsPlaceType = document.getElementById('placeType').value;
            } else {

            }

            $.ajax({
                type: "POST",
                url: '/index.php?action=addSelection',
                success: function (retour) {
                    $("#requete").html(retour);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(textStatus);
                }
            });
            //alert(lsPlaceType);
            return false;
        });
    });

    $(function () {
        $("#test").click(function () {
            //alert();
            $.ajax({
                type: "POST",
                url: '/index.php?action=addSelection',
                success: function (retour) {
                    $("#requete").html(retour);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(textStatus);
                }
            });
            return false;
        });
    });
</script>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
    