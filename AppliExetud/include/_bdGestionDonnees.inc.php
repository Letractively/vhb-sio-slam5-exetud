<?php
// FONCTIONS DE GESTION DU SERVEUR DE DONNEES MYSQL
/* IFDoc connecterServeurBD
  resource connecterServeurBD (void)
  Retourne l'identifiant de connexion si succès obtenu à partir de valeurs
  prédéfinies de connexion (machine, compte utilisateur et mot de passe)
  retourne le booléen false si problème de connexion.
*/
function connecterServeurBD() 
{
   $hote="localhost";
   $login="userExetud";
   $mdp="secret";
   return mysql_connect($hote, $login, $mdp);
}

/* IFDoc activerBD
  boolean activerBD( resource $idCnx)
  Sélectionne (rend active) la bd prédéfinie bdExetud sur la connexion
  identifiée par $idCnx.
  Retourne true si succès, false sinon.
*/
function activerBD($idCnx) 
{
   $bd="bdExetud";
   $query="SET CHARACTER SET utf8";
   // Modification du jeu de caractères de la connexion
   $res=mysql_query($query, $idCnx); 
   $ok=mysql_select_db($bd, $idCnx);
   return $ok;
}

/* IFDoc deconnecterServeur
  void deconnecterServeur (resource $idCnx)
  Ferme la connexion identifiée par $idCnx.
*/
function deconnecterServeurBD($idCnx) 
{
    mysql_close($idCnx);
}

// FONCTIONS DE GESTION DES ETUDIANTS
/* IFDoc obtenirReqListeEtudiants
   string obtenirReqListeEtudiants( void )
   Retourne le texte de la requête select concernant les étudiants
*/
function obtenirReqListeEtudiants() 
{
    $requete="select num_etud, nom_etud, prenom_etud, option_etud, confid_etud, annee_session_etud 
              from etudiant order by nom_etud" ;
    return $requete ;
}

/* IFDoc obtenirDetailEtudiant
   array obtenirDetailEtudiant($idCnx, $num)
   Retourne les informations de l'étudiant de numéro $num
   sous la forme d'un tableau associatif de clés code et libelle
*/
function obtenirDetailEtudiant($idCnx, $num) 
{
    $requete="select etudiant.*, lib_option from etudiant, options 
              where num_etud=" . $num ." and etudiant.option_etud = options.code_option;" ;

    $idJeuRes=mysql_query($requete, $idCnx);  
    $ligne = false;     
    if ( $idJeuRes ) 
    {
        $ligne = mysql_fetch_assoc($idJeuRes);
        mysql_free_result($idJeuRes);
    }
    return $ligne ;
}

/* IFDoc estEtudiantVisible
   boolean estEtudiantVisible($idCnx, $num)
   Retourne true si l'étudiant de numéro $num existe et n'a pas demandé 
   la confidentialité de ses informations. Retourne false sinon
*/
function estEtudiantVisible($idCnx, $num) 
{
    $requete="select num_etud, confid_etud from etudiant where num_etud=" . $num .";" ;
    $idJeuRes=mysql_query($requete, $idCnx);
    $ligne = mysql_fetch_assoc($idJeuRes);
    if ( is_array($ligne) ) 
    { // étudiant trouvé dans la table
        $estVisible = ($ligne['confid_etud'] == "0") ; // true si confidentialité non demandée, false sinon
    }
    else 
    {  // étudiant non trouvé dans la table
        $estVisible = false;
    }
    mysql_free_result($idJeuRes);
    return $estVisible;
}

/* IFDoc verifierInfosConnexion
   string verifierInfosConnexion(resource $idCnx, string $ident, string $mdp)
   Fonction qui vérifie si les informations de connexion sont ou non valides
   Retourne true si ident et mot de passe existent, le numéro étudiant sinon
*/
function verifierInfosConnexion($idCnx, $login, $mdp)
{
   $req="select num_etud from etudiant where nomutil_etud='".$login."' and mdp_etud='" . $mdp . "'";
   $idJeuRes=mysql_query($req, $idCnx);
   $num = false;
   if ( $idJeuRes ) 
   {
      $ligne = mysql_fetch_assoc($idJeuRes);
      $num = $ligne['num_etud'] ;
      mysql_free_result($idJeuRes);
   }
   return $num;
}

/* IFDoc modifierFichePersoAncien
   void modifierFichePersoAncien(resource $idCnx, string $num, string $adr,
   string $codePostal, string $ville, string $tel, string $etudSup, string $confid)
   Procédure qui filtre (annule l'effet de certains caractères comme la quote,
   considérés comme spéciaux par MySql) chaque donnée, puis met à jour l'étudiant
   dans la table Etudiant
*/
function modifierFichePersoAncien($idCnx, $num, $adr, $codePostal, $ville, $tel, $etudSup, $confid) 
{
    $adr = filtreChainePourBD($adr);
    $codePostal = filtreChainePourBD($codePostal);
    $ville = filtreChainePourBD($ville);
    $tel = filtreChainePourBD($tel);
    $etudSup = filtreChainePourBD($etudSup);

    $requete = "update etudiant set adr_etud = '" . $adr . "', cp_etud='" . $codePostal .
                "', ville_etud='" . $ville . "', tel_etud='" . $tel . 
                "', etudsup_etud='" . $etudSup . "', confid_etud=". $confid . " where num_etud = " . $num . ";";
    mysql_query($requete, $idCnx);                
}
?>