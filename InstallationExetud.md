L'application web de suivi des anciens sera opérationnelle après avoir suivi les deux étapes suivantes. On suppose ici que le serveur web hébergeant les scripts PHP et le serveur de base de données tournent sur la même machine.

# Installation des scripts PHP #

  * Téléchargez l'archive appliExetud\_Vx.zip sous l'onglet Downloads.
  * Dézippez ce fichier sous le répertoire racine du serveur web utilisé, par exemple c:\xampp\htdocs dans le cas du serveur web Apache inclus dans le package xampp.


# Installation de la base de données #
  * Assurez-vous d'avoir démarré votre serveur de données MySql local
  * Lancez l'outil client de votre choix pour administrer votre serveur MySql, soit MySql WorkBench ou l'application web PhpMyAdmin.
  * Se connecter sous le compte root du serveur MySql ou tout autre compte ayant le droit de créer une base de données, un compte utilisateur et lui attribuer des droits.
  * Importez le fichier create\_exetud\_mysql.sql qui va créer la base de données de nom bdExetud, le compte utilisateur userExetud et affecter à ce dernier tous les droits sur la base bdExetud.
  * Importez le fichier insert\_exetud\_mysql.sql qui va alimenter les lignes des tables de la base de données bdExetud.

# Vérification du bon fonctionnement de l'application web #
  * Lancez un navigateur sur le même poste que celui qui héberge l'application web et la base de données
  * Saisir l'url !http://localhost/appliExetud_vx/Accueil.php et vérifier que la page qui s'affiche soit la page d'accueil de l'application sans message d'erreur