/**
 * 
 * FICHIER DES FONCTIONS JAVASCRIPT / JQUERY COMMUNES
 */
/**
 * 
 * FONCTION DE RECHERCHE DANS UN TABLEAU HTML
 */
function searchString() {
    

     // RE-ECRITURE DE L'EXPRESSION contains POUR DEVENIR CASE INSENSITIVE 

    jQuery.expr[':'].contains = function (a, i, m) {
        return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
    }
    
    var search = $('#search').val();
    $("td:contains('" + search + "')").css("background", "lightgrey");
    var n = $("td:contains('" + search + "')").length;
    $("td:contains('" + search + "')")[0].scrollIntoView(true);
}
function clearSearch() {
    var search = $('#search').val();
    if (search != '') {
        $("td:contains('" + search + "')").css("background", "none");
        $('#search').val('');
    }
}
