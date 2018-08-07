<!DOCTYPE html>
<?= phpinfo(); ?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>TEST</title>
        <link href="../../public/css/style.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    </head>
    <nav>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">CALESTOR</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#">Admin</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav> 
    </nav>

    <body>
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
        <div class="form-group row mobile">
            <label for="roomType">Type de Salle</label>
            <select id="roomType" class="form-control form-control-sm">
                <option selected></option>
                <option>Grande (20 à 40 m2)</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4 offset-md-2 fixe">
            <label for="luxType">Lumière</label>
            <select id="luxType" class="form-control form-control-sm">
                <option selected></option>
                <option>Baie vitrée</option>
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
    </body>
</html>