<?php $title = 'Recherche'; ?>
<!-- <input type="radio" name="typeDevicetott" value="true" checked="checked" /> -->
<?php ob_start(); ?>
<div class="container-fluid">
            <div class="form-group row">
                <div class="col-md-6 offset-md-5" >

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
            <div class="row">
                <div class="col-md-5" style="background-color: gray" > 
                    <div class="col-md-6 offset-md-3">
                        <form id="formChoice">
                            <div class="form-group fixe ">
                                <label for="roomType">Type de Salle</label>
                                <select id="roomType" class="form-control form-control-sm">
                                    <option value="0" selected></option>
                                    <option value="1">Grande (20 à 40 m2)</option>
                                </select>
                            </div>


                            <div class="form-group fixe">
                                <label for="luxType">Lumière</label>
                                <select id="luxType" class="form-control form-control-sm">
                                    <option value="0" selected></option>
                                    <option value="1">Baie vitrée</option>
                                </select>
                            </div>

                            <div class="form-group fixe">
                                <label for="heightType">Hauteur</label>
                                <select id="heightType" class="form-control form-control-sm">
                                    <option value="0" selected></option>
                                    <option value="1">Grande Hauteur > 4,00m</option>
                                </select>
                            </div>

                            <div class="form-group fixe">
                                <label for="useType">Hauteur</label>
                                <select id="useType" class="form-control form-control-sm">
                                    <option value="0" selected></option>
                                    <option value="1">Bureautique</option>
                                </select>
                            </div>

                            <div class="form-group fixe">
                                <label for="important1Type">Important</label>
                                <select id="important1Type" class="form-control form-control-sm">
                                    <option value="0" selected></option>
                                    <option value="1">Rendu des noirs</option>
                                </select>
                            </div>

                            <div class="form-group fixe">
                                <label for="important2Type">Important</label>
                                <select id="important2Type" class="form-control form-control-sm">
                                    <option value="0" selected></option>
                                    <option value="1">Grand Public</option>
                                </select>
                            </div>

                            <div class="form-group mobile">
                                <label for="important2">Type d'utilisation</label>
                                <select id="placeType" class="form-control form-control-sm">
                                    <option value="0" selected></option>
                                    <option value="1">Dans l'entreprise</option>
                                    <option value="2">A l'extérieur</option>
                                </select>
                            </div>

                            <div class="form-group  mobile">
                                <div class="checkbox_inline">
                                    <label><input id="autonome" type="checkbox" value="">Autonome</label>
                                </div>
                            </div>

                        </form>            

                    </div>
                </div>
                <div class="col-md-7" style="background-color: gainsboro" id="requete">requete</div>
            </div>

        </div>
<script>
    var lsdomaine;
    var lsroomType;
    var lsluxType;
    var lsheightType;
    var lsuseType;
    var lsimportant1Type;
    var lsimportant2Type;
    var lsparams;
    var lsplaceType;
    var lsautonome;
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
                lsdomaine="1";
                lsroomType = document.getElementById('roomType').value;
                lsluxType = document.getElementById('luxType').value;
                lsheightType = document.getElementById('heightType').value;
                lsuseType = document.getElementById('useType').value;
                lsimportant1Type = document.getElementById('important1Type').value;
                lsimportant2Type = document.getElementById('important2Type').value;
                lsparams=lsroomType+lsluxType+lsheightType+lsuseType+lsimportant1Type+lsimportant2Type;
            } else {
                lsdomaine="2";
                lsplaceType = document.getElementById('placeType').value;
                lsautonome = document.getElementById('autonome').checked == true ? "1" : "0";
                lsparams=lsplaceType+lsautonome;     
            }

            $.ajax({
                type: "POST",
                url: '/index.php?action=addSelection&domaine=lsdomaine&queryparam=lsparams',
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
    