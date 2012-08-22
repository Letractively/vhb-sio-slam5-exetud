<?php
  require("_bdGestionDonnees.inc.php");
  require("_gestionSession.inc.php");
  require("_controlesEtGestionErreurs.inc.php");
  // initialement, aucune erreur ...
  $tabErreurs = array();

  // Démarrage ou poursuite d'une session 
  initSession();
  
  // Demande-t-on une déconnexion ?
  $demandeDeconnexion = lireDonneeUrl("cmdDeconnecter");
  if ( $demandeDeconnexion == "on") 
  {
      deconnecterVisiteur();
      header("Location: cAccueil.php");
  }
    
  // établissement d'une connexion avec le serveur de données 
  // puis sélection de la BD qui contient les données des anciens   
  $idConnexion=connecterServeurBD();
  if (!$idConnexion) 
  {
     ajouterErreur($tabErreurs, "Echec de la connexion au serveur MySql");
  }
  elseif (!activerBD($idConnexion)) 
  {
     ajouterErreur($tabErreurs, "La base de données exetud est inexistante ou non accessible");
  }
  
?>