<?php
// FONCTIONS DE GESTION DES ERREURS
/* IFDoc ajouterErreur
   void ajouterErreur(array &$tabErr, string $msg)
   Ajoute le message $msg en fin de tableau $tabErr
*/   
function ajouterErreur(&$tabErr,$msg) 
{
   $tabErr[count($tabErr)]=$msg;
}

/* IFDoc nbErreurs
   integer nbErreurs(array $tabErr)
   Retourne le nombre de messages d'erreurs enregistrés dans le tableau $tabErr
*/   
function nbErreurs($tabErr) 
{
   return count($tabErr);
}
 
/* IFDoc toStringErreurs
   void toStringErreurs(array $tabErr)
   Renvoie les éléments du tableau $tabErr sous forme d'une liste à puces XHTML
*/    
function toStringErreurs($tabErr) 
{
   $str = '<div class="msgErreur">';
   $str .= '<ul>';
   foreach($tabErr as $erreur){
      $str .= '<li>' . $erreur . '</li>';
	 }
   $str .= '</ul>';
   $str .= '</div>';
   return $str;
} 

// FONCTIONS DE FILTRAGE DES CHAINES
/* IFDoc filtreChainePourBD
   string filtreChainePourBD(string $str)
   Renvoie la chaîne $str échappée, càd avec les caractères considérés spéciaux
   par MySql (tq la quote simple) précédés d'un \, ,ce qui annule leur effet spécial
*/    
function filtreChainePourBD($str) 
{
  if ( ! get_magic_quotes_gpc() ) 
  { 
      // si la directive de configuration magic_quotes_gpc est activée dans php.ini,
      // toute chaîne reçue par get, post ou cookie est déjà échappée 
      // par conséquent, il ne faut pas échapper la chaîne une seconde fois                              
      $str = mysql_real_escape_string($str);
  }
  return $str;
}

/* IFDoc filtreChainePourNavig
   string filtreChainePourNavig(string $str)
   Renvoie la chaîne $str avec les caractères considérés spéciaux en HTML
   transformés en entités HTML, ceci pour éviter que des données fournies 
   par les utilisateurs contiennent des balises HTML
*/    
function filtreChainePourNavig($str) 
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// FONCTIONS DE CONTRÔLE DE SAISIE

/* IFDoc estEntierPositif
   boolean estEntierPositif(string $valeur)
   Si la valeur transmise ne contient pas d'autres caractères que des chiffres, 
   la fonction retourne true, false sinon.
*/
function estEntierPositif($valeur) 
{
    return preg_match("/[^0-9]/", $valeur) == 0;
}

/* IFDoc estCodePostal
   boolean estCodePostal(string $valeur)
   Retourne true si $valeur respecte le format d'un code postal, 5 chiffres.
*/
function estCodePostal($valeur) 
{
   return strlen($valeur) == 5 && estEntierPositif($valeur);
}

//définition et chargement des fonctions

/*  IFDoc lireDonneeUrl 
 string lireDonneeUrl(string $nomDonnee, string $valDefaut)
 Retourne la valeur de la donnée portant le nom $nomDonnee
 reçue dans l'url, $valDefaut si aucune donnée de nom $nomDonnee dans l'url
*/ 
function lireDonneeUrl($nomDonnee, $valDefaut="") 
{
  if ( isset($_GET[$nomDonnee]) ) 
  {
      $val = $_GET[$nomDonnee];
  }
  else 
  {
      $val = $valDefaut;
  }
  return $val;
}

/* IFDoc donnerNbDonneesUrl
    integer donnerNbDonneesUrl($void)  
    Retourne le nombre de données passées par l'url              
*/ 
function donnerNbDonneesUrl() 
{
    return count($_GET);
}

/*  IFDoc lireDonneePost
string lireDonneePost (string $nomDonnee [, string $valDefaut])
 Retourne la valeur de la donnée portant le nom $nomDonnee
 reçue dans le corps de la requête http (méthode post), 
 ou $valDefaut si aucune donnée de nom $nomDonnee dans le corps de requête
*/ 
function lireDonneePost($nomDonnee, $valDefaut="") {
  if ( isset($_POST[$nomDonnee]) ) 
  {
      $val = $_POST[$nomDonnee];
  }
  else 
  {
      $val = $valDefaut;
  }
  return $val;
}

/* IFDoc donnerNbDonneesPost
  integer donnerNbDonneesPost($void)  
  Retourne le nombre de données passées par le corps de la requête http           
*/ 
function donnerNbDonneesPost() 
{
    return count($_POST);
}

/* IFDoc lireDonnee
   string lireDonnee(string $nomDonnee[, string $valDefaut]) 
   Fournit la valeur d'une donnée transmise par la méthode get (url) ou post 
  (corps de la requête HTTP).            
   Fournit $valDefaut si aucune donnée de nom $nomDonnee ni dans l'url, ni dans corps.
   Si le même nom a été transmis à la fois dans l'url et le corps de la requête,
   c'est la valeur transmise par l'url qui est retournée.  
*/ 
function lireDonnee($nomDonnee, $valDefaut="") {
    if ( isset($_GET[$nomDonnee]) ) 
    {
        $val = $_GET[$nomDonnee];
    }
    elseif ( isset($_POST[$nomDonnee]) ) 
    {
        $val = $_POST[$nomDonnee];
    }
    else 
    {
        $val = $valDefaut;
    }
    return $val;
}

/* IFDoc verifierDonneesPersoEtudiant
    boolean verifierDonneesPersoEtudiant(string $numEtud, string $adr, string $cp, string $ville, string $tel,
    string $etudSup, string $confid, array &$tabErreurs)
    Fonction qui vérifie le domaine de valeurs des données. Renvoie true si les
    données sont correctes, false sinon.
    Pour chaque erreur, un message est ajouté à la liste des erreurs $tabErr.
    Le principe ici est de prévenir du maximum d'erreurs.
*/
function verifierDonneesPersoEtudiant($numEtud, $adr, $cp, $ville, $tel, $etudSup, $confid, &$tabErr) 
{
    $ok = true;
    if ( $cp != "" && !estCodePostal($cp) ) 
    {
        ajouterErreur($tabErr, "Code postal invalide");
        $ok = false;
    }
    
    return $ok;
}
?>