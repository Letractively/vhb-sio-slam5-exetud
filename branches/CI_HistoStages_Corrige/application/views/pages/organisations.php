	<div id="contenu">
		<h2>Liste des organisations</h2>
		<table class="tabQuadrille" id="listeOrganisations">
			<tr>
				<td colspan="2"><a href="<?php echo site_url("GererOrganisations/ajouter"); ?>">Nouvelle organisation</a></td>
			</tr>
			<tr>
				<th>Nom</th>
				<th>Ville</th>
      		</tr>
<?php      
    // obtention du texte de la requête de sélection des organisations
    foreach ($lesOrganisations as $uneOrganisation) {
        // traitement de l'organisation (enregistrement) courante
        $numero = $uneOrganisation->numero;
    	$nom = $uneOrganisation->nom;
        $ville = $uneOrganisation->ville;
        ?>
        	<tr>
        		<td><?php echo anchor('GererOrganisations/detail/' . $numero, $nom) ; ?></td>
                        <td><?php echo $ville; ?></td>
        	</tr>
        <?php
    }
?>
		</table>
	</div>
