<!-- Division principale -->
<div id="contenu">
      <form id="frmConnexion" action="<?php echo site_url("gererConnexion");?>" method="post">
      <div id="corpsForm">
	      <p>
	     	 <label for="txtNom">Nom : </label>
	         <input type="text" id="txtNom" name="txtNom" maxlength="30" size="15" value="" 
                        title="Entrez votre nom de compte utilisateur" /> 
                 <?php echo form_error('txtNom') ; ?>
	         </p>
	      <p>
	      	<label for="txtMdp">Mot de passe : </label>
	        <input type="password" id="txtMdp" name="txtMdp" maxlength="8" size="15" value=""  
                       title="Entrez votre mot de passe"/>
	      </p>
	   </div>
	      <div id="piedForm">
	      <p>
	        <input type="submit" id="ok" value="OK" />
	        <input type="reset" id="annuler" value="Effacer" />
	      </p> 
      </div>
      </form>

</div>