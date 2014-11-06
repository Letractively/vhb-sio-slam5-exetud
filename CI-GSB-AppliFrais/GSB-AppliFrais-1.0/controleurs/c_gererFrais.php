<?php

// vérification du droit d'accès au cas d'utilisation
if ( ! estConnecte() ) {
    ajouterErreur("L'accès à cette page requiert une authentification !", $tabErreurs);
    include('vues/v_erreurConnexion.php');
}
else  { // accès autorisé
  include("vues/v_sommaire.php");
  include("vues/v_debutContenu.php");
  $idVisiteur = $_SESSION['idVisiteur'];
  $mois = getMois(date("d/m/Y"));
  $numAnnee =substr( $mois,0,4);
  $numMois =substr( $mois,4,2);
  $action = lireDonneeUrl('action');
  switch($action){
  	default :   // vaut pour action à sasirEtatFrais
  		if($pdo->estPremierFraisMois($idVisiteur,$mois)){
  			$pdo->creeNouvellesLignesFrais($idVisiteur,$mois);
  		}
  		break;
  	
  	case 'validerMajFraisForfait':
  		$lesFrais = lireDonneePost('lesFrais');
  		if(lesQteFraisValides($lesFrais)){
  	  	 	$pdo->majFraisForfait($idVisiteur,$mois,$lesFrais);
  		}
  		else{
  			ajouterErreur("Les valeurs des frais doivent être numériques", $tabErreurs);
  			include("vues/v_erreurs.php");
  		}
  	  break;
  	
  	case 'validerCreationFrais':
  		$dateFrais = lireDonneePost('dateFrais');
  		$libelle = lireDonneePost('libelle');
  		$montant = lireDonneePost('montant');
  		valideInfosFrais($dateFrais,$libelle,$montant,$tabErreurs);
  		if (nbErreurs($tabErreurs) != 0 ){
  			include("vues/v_erreurs.php");
  		}
  		else{
  			$pdo->creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$dateFrais,$montant);
  		}
  		break;
  	
  	case 'supprimerFrais':
  		$idFrais = lireDonneeUrl('idFrais');
  	    $pdo->supprimerFraisHorsForfait($idFrais);
  		break;
  }
  $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
  $lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
  include("vues/v_listeFraisForfait.php");
  include("vues/v_listeFraisHorsForfait.php");
}  
?>