<?php
session_start();
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
include("vues/v_entete.php") ;
$pdo = new PdoGsb("localhost", "gsbfrais", "userGsb", "secret");
$tabErreurs = array();
$estConnecte = estConnecte();
$uc = lireDonneeUrl('uc');
switch($uc){
	case 'connexion' :
		include("controleurs/c_connexion.php");break;
	
	case 'gererFrais' :
		include("controleurs/c_gererFrais.php");break;
	
	default :
    if ( $estConnecte ) {
		  include("controleurs/c_etatFrais.php");
    }
    else {
      include("controleurs/c_connexion.php");
    }
    break; 
	
}
include("vues/v_pied.php") ;
?>

