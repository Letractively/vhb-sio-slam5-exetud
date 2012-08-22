<?php
  $repInclude = './include/';
  require($repInclude . "_init.inc.php");
  require($repInclude . "_entete.inc.html");
  require($repInclude . "_sommaire.inc.php");
  require($repInclude . "_NouvellesFonctions_AccesBD.inc.php");
?>
<!-- Division pour le contenu principal -->
    <div id="contenu">
      <h2>Annuaire des anciens</h2>
<?php
  // vérification du droit d'accès au cas d'utilisation
  if ( ! estAncienConnecte() )
  {
      ajouterErreur($tabErreurs, "L'accès à cette page requiert une authentification !");
      echo toStringErreurs($tabErreurs) ;
  }
  else 
  {
  echo "Annuaire : " . obtenirNombreAnciens($idConnexion);
  echo "Date offre la plus récente : " . obtenirDateDerniereOffreEmploi($idConnexion);
?>
      <table class="tabQuadrille" id="listeEtudiants">
        <tr>
          <th>Nom</th><th>Prénom</th><th>Option</th>
        </tr>
<?php      
    // obtention du texte de la requête de sélection des étudiants
    $req = obtenirReqListeEtudiants();
    // demande d'exécution de la requête de sélection 
    // qui fournit l'identifiant d'un jeu d'enregistrements résultats
    $idJeuResultat = mysql_query($req, $idConnexion) ;
    // lecture du premier enregistrement lu sous forme de tableau associatif
    $lgEtudiant = mysql_fetch_assoc($idJeuResultat) ;
    while ( is_array($lgEtudiant) )  // vaut false si plus d'enregistrement lu, converti à true sinon
    {
        // traitement de l'étudiant (enregistrement) courant
        $num = $lgEtudiant["num_etud"];
        $nom = $lgEtudiant["nom_etud"];
        $prenom = $lgEtudiant["prenom_etud"];
        $confid = $lgEtudiant["confid_etud"];
        $option = $lgEtudiant["option_etud"];
?>        
       <tr>
           <td>
<?php           
      if ( $confid != 0) // l'étudiant a demandé la confidentialité de ses données
      { 
            echo $nom;
      }
      else // pas de confidentialité demandée
      {
?>     
                <a href="cDetailEtudiant.php?num=<?php echo $num; ?>"><?php echo $nom; ?></a>
<?php                  
      }            
?>           
           </td>
           <td><?php echo $prenom ; ?></td>
           <td><?php echo $option ;?></td>
       </tr>
<?php
        // lecture de l'enregistrement suivant
        $lgEtudiant = mysql_fetch_assoc($idJeuResultat);    
    
    }
    // demande de libération du jeu d'enregistrements résultats
    mysql_free_result($idJeuResultat);
?>
      </table>
<?php
  }  // fin accès autorisé au script
?>
     </div>
<?php
    require($repInclude . "_pied.inc.html");
    require($repInclude . "_fin.inc.php");
?>