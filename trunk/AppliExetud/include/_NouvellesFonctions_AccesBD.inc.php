<?php
/* IFDoc obtenirNombreAnciens
   int obtenirNombreAnciens(resource $idCnx)
   Retourne le nombre d'anciens étudiants recensés dans l'annuaire.
*/
function obtenirNombreAnciens($idCnx) 
{
    $requete="select count(*) as nbAnciens from etudiant;";

    $idJeuRes=mysql_query($requete, $idCnx);  
    $nb = 0;     
    if ( $idJeuRes ) 
    {
        $ligne = mysql_fetch_assoc($idJeuRes);
        $nb = $ligne['nbAnciens'];
        mysql_free_result($idJeuRes);
    }
    return $nb ;
}

/* IFDoc obtenirDateDerniereOffreEmploi
   string obtenirDateDerniereOffreEmploi(resource $idCnx)
   Retourne la date de l'offre d'emploi la plus récente
*/
function obtenirDateDerniereOffreEmploi($idCnx) 
{
    $requete="select distinct date_format(date_offre, '%Y-%m-%d') as dateDern from offre_emploi where date_offre = ( select max(date_format(date_offre, '%Y-%m-%d')) from offre_emploi )";

    $idJeuRes=mysql_query($requete, $idCnx);  
    $date = 0;     
    if ( $idJeuRes ) 
    {
        $ligne = mysql_fetch_assoc($idJeuRes);
        $date = $ligne['dateDern'];
        mysql_free_result($idJeuRes);
    }
    return $date ;
}

?>