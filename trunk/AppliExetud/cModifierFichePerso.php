<?php
  $repInclude = './include/';
  require($repInclude . "_init.inc.php");
  require($repInclude . "_entete.inc.html");
  require($repInclude . "_sommaire.inc.php");

  // vérification du droit d'accès au cas d'utilisation
  if ( ! estAncienConnecte() ) 
  {
      ajouterErreur($tabErreurs, "L'accès à cette page requiert une authentification !");
      echo toStringErreurs($tabErreurs) ;
  }
  else  // accès autorisé
  {
      // est-on au 1er appel du programme ou non ?
      $etape=(count($_POST)!=0)?'validerModif' : 'demanderModif';
    
      // on récupère le login de la personne connectée 
      $numEtud = obtenirIdentConnecte() ;
      // on récupère de la base certaines données qui ne peuvent être changées par l'étudiant
      $lEtudiant = obtenirDetailEtudiant($idConnexion, $numEtud);
      $prenom = $lEtudiant["prenom_etud"];
      $nom = $lEtudiant["nom_etud"];
      $anneePromo = $lEtudiant["annee_session_etud"];
      $libOption = $lEtudiant["lib_option"];
      
      switch ($etape) 
      {
          case 'demanderModif' : // on est au 1er appel, les données sont initialisées
                                 // à partir de celles renseignées dans la base
                  $adr = $lEtudiant["adr_etud"];
                  $codePostal = $lEtudiant["cp_etud"];
                  $ville = $lEtudiant["ville_etud"];
                  $tel = $lEtudiant["tel_etud"];
                  $etudSup = $lEtudiant["etudsup_etud"];
                  $confid = $lEtudiant["confid_etud"];
                  break;
      
          case 'validerModif' : // l'utilisateur valide ses nouvelles données,
                                    // les données sont renseignées à partir du formulaire
                  $adr = lireDonneePost("txtAdr");
                  $codePostal = lireDonneePost("txtCp");
                  $ville = lireDonneePost("txtVille");
                  $tel = lireDonneePost("txtTel");
                  $etudSup = lireDonneePost("txtEtudSup");
                  $confid = lireDonneePost("chkConfid", 0);
                  // elles doivent être vérifiées, puis enregistrées si ok
                  if (verifierDonneesPersoEtudiant ($numEtud, $adr, $codePostal, $ville, $tel, $etudSup, $confid, $tabErreurs) ) 
                  {
                      modifierFichePersoAncien($idConnexion, $numEtud, $adr, $codePostal, $ville, $tel, $etudSup, $confid);                  
                  }
                  break;                                  
      }
?>

<!-- Division pour le contenu principal -->
    <div id="contenu">
      <h2>Ma fiche - Perso</h2>
      <form id="frmPerso" action="#" method="post">
<?php
    if ( $etape == 'validerModif') 
    {
        if ( nbErreurs($tabErreurs) != 0 ) 
        {
          echo toStringErreurs($tabErreurs);
        } 
        else 
        {
?>
    <p class="info">Les modifications ont bien été enregistrées</p>        
<?php   }        
    }
?>
  <div id="corpsForm">
  <fieldset>
    <legend><?php echo filtreChainePourNavig($prenom);?>&nbsp;<?php echo filtreChainePourNavig($nom); ?>
     Promotion <?php echo filtreChainePourNavig($anneePromo) ; ?> 
     Option <?php echo filtreChainePourNavig($libOption); ?></legend>
  <p>
    <label for="txtAdr" accesskey="a">Adresse : </label>
    <input id="txtAdr" name="txtAdr" maxlength="255" size="70" value="<?php echo filtreChainePourNavig($adr) ; ?>" />
  </p>

  <p>
    <label for="txtCp" accesskey="c">Code postal : </label>
    <input id="txtCp" name="txtCp" maxlength="5" size="6" value="<?php echo filtreChainePourNavig($codePostal) ; ?>" />
  </p>
  <p>
    <label for="txtVille" accesskey="v">Ville : </label>
    <input id="txtVille" name="txtVille" maxlength="100" size="60" value="<?php echo filtreChainePourNavig($ville) ; ?>" />
  </p>

  <p>
    <label for="txtTel" accesskey="t">Téléphone : </label>
    <input id="txtTel" name="txtTel" maxlength="15" size="15" value="<?php echo filtreChainePourNavig($tel) ; ?>" />
  </p>
  <p>
    <label for="chkConfid" accesskey="f">Confidentialité</label>
    <input type="checkbox" id="chkConfid" name="chkConfid" title="Vos données ne seront pas visibles par d'autres anciens" value="-1" 
    <?php if ( $confid ) echo 'checked="checked"'; ?> />
  </p>
  <p>
    <label for="txtEtudSup" accesskey="s">Etudes supérieures : </label>
    <textarea id="txtEtudSup" name="txtEtudSup" rows="2" cols="70" title="Vos poursuites d'études après le BTS IG : année, intitulé formation, etc."><?php echo filtreChainePourNavig($etudSup) ; ?></textarea>
  </p>
  </fieldset>
  </div>
  <div id="piedForm">
  <p>
    <button id="ok" type="submit">OK</button>
    <button id="annuler" type="reset">Effacer</button>
  </p> 
  </div>
  </form>
<?php
  } // fin accès autorisé au script
?>
</div>
<?php
    require($repInclude . "_pied.inc.html");
    require($repInclude . "_fin.inc.php");
?>