<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="ISO-8859-1" />
    <title>PHP - Programme de tests unitaires de la fonction estNumTel</title>
  </head>
  <body>
    <p>
<?php
require("../include/_controlesEtGestionErreurs.inc.php"); // contient la définition de la fonction estNumTel

// Programme de tests unitaires de la fonction estNumtel
        $msgErreur = "";
    
        if ( estNumtel("100") ) {
            $msgErreur .= "Test 1 KO : nombre à 3 chiffres n'est pas un numéro de tél. <br \/>" ;
        }
       
        if ( estNumtel("01234567890") ) {
            $msgErreur .= "Test 1 KO : nombre à 11 chiffres n'est pas un numéro de tél. <br \/>" ;
        }
       
        if ( estNumTel("-100") ) {
            $msgErreur .="Test2 KO : nombre négatif n'est pas un numéro de tél.<br \/>" ;
        }
        
        if ( !estNumTel("0123456789") ) {
            $msgErreur .="Test3 KO : numéro de téléphone sur 10 chiffres différents<br \/>" ;
        }
        
        if ( !estNumTel("2222222222") ) {
            $msgErreur .="Test4 KO : numéro de téléphone sur 10 chiffres identiques<br \/>";
        }
        
        if ( estNumTel("") ) {
            $msgErreur .="Test5 KO : chaîne vide <br \/>";
        }
    
        echo "Resultats des tests de la fonction estNumTel : <br \/>" ;
        // on regarde comment a évolué la variable $msgErreur
        if ( $msgErreur != "" ) { // une ou plusieurs erreurs ont été rencontrées
          echo $msgErreur ;
        } 
        else {  // $msgErreur contient toujours une chaîne vide : aucune erreur donc
            echo "OK";
        }

?>
  </p>
</body>
</html>