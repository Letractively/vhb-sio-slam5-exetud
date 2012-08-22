<?php
  
  $repInclude = './include/';
  require($repInclude . "_init.inc.php");
  
  // est-on au 1er appel du programme ou non ?
  $etape=(count($_POST)!=0)?'validerConnexion' : 'demanderConnexion';
  
  if ($etape=='validerConnexion')  // un client demande à s'authentifier
  {
      // acquisition des données envoyées, ici nom de compte utilisateur et mot de passe
      $nomCompte = lireDonneePost("txtNom");
      $mdp = lireDonneePost("txtMdp");   
      $numEtud = verifierInfosConnexion($idConnexion, $nomCompte, $mdp) ;
      if ( $numEtud )  // le numéro étudiant a été trouvé, donc converti en valeur booléenne true
      {
          affecterInfosConnecte($numEtud, 'A');
      }
      else 
      {
          ajouterErreur($tabErreurs, "Login et/ou mot de passe incorrects");
      }
  }

  require($repInclude . "_entete.inc.html");
  require($repInclude . "_sommaire.inc.php");
  
?>
<!-- Division pour le contenu principal -->
    <div id="contenu">
      <h2>Identification utilisateur</h2>
<?php
  if ( $etape == "validerConnexion" && nbErreurs($tabErreurs) == 0 ) 
  {
?>      
      <p>Bienvenue dans l'espace privé du site des anciens de la section !</p>    
<?php
   }
  else  // pas en étape de validation ou au moins une erreur : on doit tenter de se connecter à nouveau
  {
?>
      <form id="frmConnexion" action="#" method="post">
      <div id="corpsForm">
      <p>
        <label for="txtNom" accesskey="n">Nom : </label>
        <input type="text" id="txtNom" name="txtNom" maxlength="30" size="15" value="" title="Entrez votre nom de compte utilisateur" />
    
      </p>
      <p>
        <label for="txtMdp" accesskey="m">Mot de passe : </label>
        <input type="password" id="txtMdp" name="txtMdp" maxlength="8" size="15" value=""  title="Entrez votre mot de passe"/>
      </p>
      </div>
      <div id="piedForm">
      <p>
        <input type="submit" id="ok" value="OK" />
        <input type="reset" id="annuler" value="Effacer" />
      </p> 
      </div>
      </form>
<?php
  }
?>
    </div>
<?php
    require($repInclude . "_pied.inc.html");
    require($repInclude . "_fin.inc.php");
?>