<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Essais sur les exceptions</title>
</head>
<body>
<pre>
<?php
require("organisationsManager.php");

try {
    $bd = new PDO("mysql:host=localhost;dbname=stsio", "stssio", "stssio");
    echo "Connexion réussie.\n";
}
catch (Exception $e) {
	  echo "la connexion a échoué. \n";
	  echo "Informations : [". $e->getCode() . "] ". $e->getMessage() ."\n";
} 
/*
La connexion a échoué.
Informations : [1044] SQLSTATE[HY000] [1044] Access denied for user 'stssio'@'localhost' 
Informations : [1045] SQLSTATE[HY000] [1045] Access denied for user 'stssio'@'localhost' (usign password : yes)
Informations : [2002] SQLSTATE[HY000] [2002] Aucune connexion n'a pu être établie car l'ordinateur cible l'a expressément refusée.
*/

/*
$num = (isset($_GET["num"])) ? $_GET["num"] : 0;
$unManager = new OrganisationsManager("localhost", "bdstssio", "stssio", "secret");
$unManager->deleteByNum($num);
echo "L'organisation numéro " . $num . " a été supprimée\n";
*/
?>
</pre>
</body>
</html>