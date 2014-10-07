<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <pre>
        <?php
	$monPdo = new PDO('mysql:host=localhost;dbname=bdstssio', 'stssio', 'secret');        
        $monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // tests avec paramètres non nommés ou nommés
        $insertSansNom = $monPdo->prepare(
    	'INSERT INTO organisation(numero, nom) VALUES (?, ?) ');

	$insertNomme = $monPdo->prepare(
    	'INSERT INTO organisation(numero, nom)  VALUES (:numero, :nom)');

	$insertSansNom->execute(array('40', '6TM'));
	$insertNomme->execute(array(	':numero' => '50',
                             		':nom' => 'Fournial'));

        // tests avec des requêtes d'action et de sélection
        $cmdSelectOrgas = $monPdo->prepare('SELECT numero, nom FROM organisation');
        $cmdSelectUneOrga= $monPdo->prepare('SELECT numero, nom FROM organisation 
                                                WHERE numero = ?');
        $cmdInsertOrga = $monPdo->prepare('INSERT INTO organisation(numero, nom) 
                                                VALUES (?, ?)');

        $cmdSelectOrgas->execute();
        $users = $cmdSelectOrgas->fetchAll();

        $cmdInsertOrga->execute(array('60', 'Keolis'));
        $cmdInsertOrga->execute(array('70', 'A2Com'));
        $cmdInsertOrga->execute(array('80', 'Sopra'));

        $cmdSelectOrgas->execute(); //récupère toutes les organisations (les 3)
        $lesOrgas = $cmdSelectOrgas->fetchAll();
        print_r($lesOrgas);

        $cmdSelectUneOrga->execute(array(60)); //récupère l'organisation numéro 60
        $uneOrga = $cmdSelectUneOrga->fetch();
        print_r($uneOrga);

        $cmdSelectUneOrga->execute(array(70)); //récupère l'étudiant numéro 70
        $uneOrga =  $cmdSelectUneOrga->fetch();
        print_r($uneOrga);

        $cmdSelectUneOrga->execute(array(80)); //récupère l'étudiant numéro 80
        $uneOrga = $cmdSelectUneOrga->fetch();
        print_r($uneOrga);
        
      	$cmdSelectOrgas = $monPdo->prepare('select numero, nom from organisation limit ?,?');
	$cmdSelectOrgas->bindValue(1, 10, PDO::PARAM_INT);
	$cmdSelectOrgas->bindValue(2, 20, PDO::PARAM_INT);
	$cmdSelectOrgas->execute();
	$lesOrgas = $cmdSelectOrgas->fetchAll(PDO::FETCH_ASSOC);
	print_r($lesOrgas);

        ?>
        </pre>
    </body>
</html>
