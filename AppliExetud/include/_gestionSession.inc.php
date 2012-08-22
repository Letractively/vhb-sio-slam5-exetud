<?php
// FONCTIONS DE GESTION D'UNE SESSION
/* IFDoc initSession
  void initSession(void)
  Démarre on poursuit une session
*/
function initSession()
{
    session_start();
}

/* IFDoc obtenirIdentConnecte
  string obtenirIdentConnecte(void)
  Retourne l'identifiant du visiteur connecté.
*/
function obtenirIdentConnecte() 
{
   $ident = (isset($_SESSION['ident'])) ? $_SESSION['ident'] : '';
   return $ident ;
}

/* IFDoc affecterInfosConnecte
  void affecterInfosConnecte(string $ident, string $type)
  Conserve en variables session l'identifiant et le type du visiteur connecté.
*/
function affecterInfosConnecte($ident, $type) 
{
    $_SESSION['ident'] = $ident;
    $_SESSION['type'] = $type;
}

/* IFDoc deconnecterVisiteur
  void deconnecterVisiteur(void)
  Déconnecte le visiteur qui s'est identifié sur le site
*/
function deconnecterVisiteur()
{
    unset($_SESSION['ident']);
    unset($_SESSION['type']);
}

/* IFDoc estVisiteurConnecte
  boolean estVisiteurConnecte(void)
  Retourne true si un visiteur s'est identifié sur le site, false sinon.
*/
function estVisiteurConnecte()
{
   return isset($_SESSION['ident']);
}

/* IFDoc estAncienConnecte
  boolean estAncienConnecte(void)
  Retourne true si un ancien s'est identifié sur le site, false sinon.
*/
function estAncienConnecte() 
{
    return isset($_SESSION['type']) && $_SESSION['type'] == 'A';
}
?>