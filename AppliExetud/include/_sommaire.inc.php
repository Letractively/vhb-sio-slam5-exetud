    <!-- Division pour le sommaire -->
    <div id="menugauche">
        <ul id="menulist">
         <li class="smenu">
            <a href="cAccueil.php" title="Page d'accueil">Accueil</a>
         </li>
         <li class="smenu">
            <a href="cListeSitesEmplois.php" title="Les adresses de sites d'offres d'emploi et de stage">Site emplois et stages</a>
         </li>
<?php      
  if (estAncienConnecte() ) {
?>
         <li class="smenu">
            <a href="cListeEtudiants.php" title="L'annuaire des anciens étudiants de la section">Etudiants</a>
         </li>
         <li class="smenu">
            <a href="cModifierFichePerso.php" title="Mes informations personnelles">Modifier ma fiche</a>
         </li>
<?php      
  }
  if (estVisiteurConnecte() ) {
?>
          <li class="smenu">
            <a href="?cmdDeconnecter=on" title="Se déconnecter">Se déconnecter</a>
          </li>
<?php
  }
  else {
?>  
          <li>
            <a href="cSeConnecter.php">Garder le contact</a>
          </li>
<?php
  }
?>  
        </ul>
 <div id="infosUtil">
<?php      
  if (estVisiteurConnecte() ) {
?>
    <h2>Vous êtes</h2>
    <p> 
<?php  
    $num = obtenirIdentConnecte() ;
    if ( estAncienConnecte() ) { 
        $lEtudiant = obtenirDetailEtudiant($idConnexion, $num);
        $nom = $lEtudiant['nom_etud'];
        $prenom = $lEtudiant['prenom_etud'];
        echo $nom . " " . $prenom ;
    }
     ?></p>
<?php
  }
?>  
  </div>  
        <?php
          if ( nbErreurs($tabErreurs) > 0 ) {
              echo toStringErreurs($tabErreurs) ;
          }
        ?>

    </div>
