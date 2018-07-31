/**
 * 
 * FICHIER DES FONCTIONS JAVASCRIPT / JQUERY COMMUNES
 */
/**
 * 
 * FONCTION DE RECHERCHE DANS UN TABLEAU HTML
 */
function searchString() {
    var search = $('#search').val();
    $("td:contains('" + search + "')").css("background", "lightgrey");
    var n = $("td:contains('" + search + "')").length;
    //alert(n + " occurence(s) trouvée(s)");
    $("td:contains('" + search + "')")[0].scrollIntoView(true);
}
function clearSearch() {
    var search = $('#search').val();
    if (search != '') {
        $("td:contains('" + search + "')").css("background", "none");
        $('#search').val('');
    }
}