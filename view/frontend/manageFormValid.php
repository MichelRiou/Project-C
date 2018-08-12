
<script type="text/javascript">
    function refresh() {
        $.ajax({
            type: 'POST',
            url: '/routes.php?action=listFormValid',
            success: function (data) {
                $("#requete").html(data);
                $('[data-toggle="tooltip"]').tooltip();


            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(textStatus);
                $("#retour").html("Erreur d\'envoi de la requête");
            }
        });
    }
    $(document).ready(function () {
        refresh();
        $("#back").click(function () {
            window.history.back();
        });
        // Activation du tooltip
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<div class="container-fluid">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="form-group row">
                <div class="col-md-7">
                    <h5>Gestion des Formulaires</h5>
                </div >
                <div class="col-md-5">
                    <button id="back" class="btn btn-default btn-sm" data-toggle="modal">
                        <i class="material-icons">&#xE314;</i> 
                        <span class="black-write">Retour</span></button>
                    <input class=" pull-right btn-sm" type="submit" 
                           value="Rechercher" onclick="searchString()" />
                    <input class="pull-right " id="search" name="search" 
                           type="text" value="" onfocus="clearSearch()" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 form-group">
                <h5>Business Unit :  <?= $bu->getBu_name() ?></h5>  
            </div>

        </div>
        <div class="scrollDiv2" id="requete">
        </div>
    </div>
</div>
