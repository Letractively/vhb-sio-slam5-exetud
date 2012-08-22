<?php
  $repInclude = './include/';
  require($repInclude . "_init.inc.php");
  require($repInclude . "_entete.inc.html");
  require($repInclude . "_sommaire.inc.php");
  
?>
  <!-- Division pour le contenu principal -->
      <div id="contenu">
    <?php
  // vérification du droit d'accès au cas d'utilisation
  if ( ! estAncienConnecte() ) 
  {
      ajouterErreur($tabErreurs, "L'accès à cette page requiert une authentification !");
      echo toStringErreurs($tabErreurs) ;
  }
  else 
  {
      // acquisition des données entrées, ici le numéro d'étudiant
      $numEtud = lireDonneeUrl("num");
      $ok = estEtudiantVisible($idConnexion, $numEtud) ;
      if ( $ok ) 
      {
          $lEtudiant = obtenirDetailEtudiant($idConnexion, $numEtud);
          $prenom = $lEtudiant["prenom_etud"];
          $nom = $lEtudiant["nom_etud"];
          $anneePromo = $lEtudiant["annee_session_etud"];
          $libOption = $lEtudiant["lib_option"];
          $adr = $lEtudiant["adr_etud"];
          $codePostal = $lEtudiant["cp_etud"];
          $ville = $lEtudiant["ville_etud"];
          $tel = $lEtudiant["tel_etud"];
          $email = $lEtudiant["email_etud"];
          $urlPerso = $lEtudiant["url_etud"];
          $etudSup = $lEtudiant["etudsup_etud"];
    ?>
          <h2>Fiche de <?php echo filtreChainePourNavig($prenom) ; ?>&nbsp;<?php echo filtreChainePourNavig($nom) ; ?>&nbsp;
          Promo <?php echo filtreChainePourNavig($anneePromo) ;?> Option <?php echo filtreChainePourNavig($libOption) ; ?></h2>
          <table class="tabNonQuadrille">
            <tr>
              <td class="libelle">Adresse :</td>
              <td><?php echo filtreChainePourNavig($adr) ; ?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><?php echo filtreChainePourNavig($codePostal); ?>&nbsp;<?php echo filtreChainePourNavig($ville) ; ?>
            </tr>
            <tr>
              <td class="libelle">Tél. :</td>
              <td><?php echo filtreChainePourNavig($tel) ; ?>&nbsp;</td>
            </tr>
            <tr>
              <td class="libelle">Email :</td>     
              <td><a href="mailto:<?php echo filtreChainePourNavig($email) ;?>"><?php echo filtreChainePourNavig($email) ; ?></a></td>
            </tr>
            <tr>
              <td class="libelle">URL personnelle :</td>
              <td><a href="http://<?php echo filtreChainePourNavig($urlPerso) ?>"><?php echo filtreChainePourNavig($urlPerso) ; ?></a></td>
            </tr>
            <tr>
              <td class="libelle">Etudes supérieures :</td>
              <td><?php echo filtreChainePourNavig($etudSup) ; ?></td>
            </tr>
            
          </table>
    <?php
      } // fin étudiant existant et autorisant à voir ses données
      else 
      {
    ?>
      <p class="msgErreur">Numéro étudiant inexistant ou ayant demandé la confidentialité de ses données</p>
    <?php  
      }
    } // fin accès autorisé au script   
    ?>      
      <p>
        <a href="cListeEtudiants.php">Retour annuaire</a>
      </p>
    </div>
<?php
    require($repInclude . "_pied.inc.html");
    require($repInclude . "_fin.inc.php");
?>