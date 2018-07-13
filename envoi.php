
<html>

    <head>
    </head>
    <body>
<form method="post" action="reception.php" enctype="multipart/form-data">
     <label for="mon_fichier">Fichier (tous formats | max. 1 Mo) :</label><br />
     <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
     <input type="file" name="fichier" id="fichier" /><br />
     <input type="submit" name="submit" value="Envoyer" />
</form>
    </body>