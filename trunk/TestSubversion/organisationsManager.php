<?php
class OrganisationsManager {
        /**
         * @var $_db PDO 
         */
	private $_db;   
        /**
         * @var $_cmdGetByNum PDOStatement
         */
        private $_cmdGetByNum;
        /**
         * @var $_cmdGetMaxNum PDOStatement
         */
        private $_cmdGetMaxNum;
        /**
         * @var $_cmdDelete PDOStatement
         */
        private $_cmdDelete;
	/**
	 * Initialise une instance de OrganisationsManager
         * 
         * @param string $unHote
         * @param string $uneBD
         * @param string $unCompte
         * @param string $unMdp
         */
	public function __construct($unHote, $uneBD, $unCompte, $unMdp) {
            // $extraParams = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'');
            $uneChaineConnexion = "mysql:host=" . $unHote . ";dbname=" . $uneBD;
            $this->_db = new PDO($uneChaineConnexion, $unCompte, $unMdp);
            // demande à ce que les erreurs rencontrées sur la connexion
            // se traduisent par le lancement d'exceptions, le message d'erreur complet 
            // étant affiché
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);           
            // préparation de la requête de suppression d'une organisation
            $this->_cmdGetByNum = $this->_db->prepare("select * from organisation where numero = ? "); 
            // préparation de la requête d'obtention du plus grand numéro d'organisation
            $this->_cmdGetMaxNum = $this->_db->prepare("select max(numero) as maxi from organisation");            
            // préparation de la requête d'obtention du plus grand numéro d'organisation
            $this->_cmdDelete = $this->_db->prepare("delete from organisation where numero = :num");   
            $this->_addOrga=  $this->_db->prepare('insert into organisation values( :numero, :nom, :rue, :cp, :ville, :tel, :fax, :email, :urlSiteWeb)');

	}
	/**
	 * Fournit les données de l'organisation portant le numéro spécifié
	 * sous forme de tableau associatif, les clés correspondant au nom des colonnes de la table
	 * Retourne le booléen false dans le cas d'un numéro inexistant
	 * @param integer $numero
	 * @return mixed
	 */
	public function getByNum($numero) {		
            // affecte la valeur du numéro, puis exécution de la requête
            $this->_cmdGetByNum->bindValue(1, $numero, PDO::PARAM_INT);
            $this->_cmdGetByNum->execute();
            // récupération de l'unique ligne représentant l'organisation
            $uneOrga = $this->_cmdGetByNum->fetch(PDO::FETCH_ASSOC);
            $this->_cmdGetByNum->closeCursor();
            return $uneOrga;    
	}	
	/**
	 * Fournit les données de l'ensemble des organisations présentes
	 * sous forme de tableau de tableaux
	 * @return array
	 */
	public function getList() {
            $requete = "select numero, nom, ville from organisation";
            $jeu = $this->_db->query($requete);
            $lesOrgas = $jeu->fetchAll(PDO::FETCH_ASSOC);
            $jeu->closeCursor();
            return $lesOrgas;    
	}	
	/**
	 * Fournit le prochain numéro d'organisation à affecter
	 * @return integer
	 */
	public function getNextNum() {
            // exécution de la requête d'obtention du plus grand numéro sans 
            // valeur de paramètre puisqu'aune partie variable           
            $this->_cmdGetMaxNum->execute();
            // récupération de l'unique ligne dans un tableau, ligne elle-même réduite à un seul élément
            $ligne = $this->_cmdGetMaxNum->fetch(PDO::FETCH_ASSOC);
            $this->_cmdGetMaxNum->closeCursor();
            $prochainNumero = intval($ligne["maxi"]) + 1;
            return $prochainNumero;
	}
	/**
	 * Supprime l'organisation portant le numéro spécifié.
	 * Retourne true si l'organisation a bien été supprimée, false sinon.
	 * @param integer $unNum
	 * @return boolean
	 */
	public function deleteByNum($unNum) {
            // affecte la valeur du numéro, puis exécution de la requête de suppression
            $this->_cmdDelete->execute(array(":num" => $unNum));
            // récupération de l'unique ligne représentant l'organisation
            return  $this->_cmdDelete->rowCount() > 0 ;
	}
	/**
	 * Retourne le nombre d'organisations présentes
	 * @return integer
	 */
	public function count() {
		return 0;
	}
	/**
	 * Retourne true si le numéro spécifié correspond à celui d'une organisation existante,
	 * false sinon
	 * @param integer $numero
	 * @return boolean
	 */
	public function existe($numero) {
            return false;
	}
	/**
	 * Ajoute la nouvelle organisation dans la base à partir des données spécifiées
	 * sous forme de tableau associatif ayant pour clés le nom des colonnes de la table organisation
	 * Retourne le numéro attribué à l'organisation si l'ajout a été réalisé avec succès,
	 * le booléen false sinon.
	 * @param array $uneOrga
	 * @return mixed
	 */
	public function add($uneOrga) {
            $ok=false;
            $num= $this->getNextNum();
            $this->_addOrga->bindValue(":numero", $num, PDO::PARAM_INT);            
            $this->_addOrga->bindValue(":nom",NULL);
            $this->_addOrga->bindValue(":ville",NULL);
            $this->_addOrga->bindValue(":rue",NULL);
            $this->_addOrga->bindValue(":cp",NULL);
            $this->_addOrga->bindValue(":tel",NULL);
            $this->_addOrga->bindValue(":fax",NULL);
            $this->_addOrga->bindValue(":email",NULL);
            $this->_addOrga->bindValue(":urlSiteWeb",NULL);
            
            foreach ($uneOrga as $key => $value) 
            {
                $this->_addOrga->bindValue(":". $key,$value);
            }
            if($this->_addOrga->execute())
            {
                $ok=$num;
            }
            return $ok;
	}
	/**
	 * Modifie dans la base l'organisation à partir du numéro spécifié et des données à mettre à jour
	 * sous forme de tableau associatif ayant pour clés le nom des colonnes de la table organisation
	 * Retourne true si la modification a été réalisée, false sinon.
	 * @param integer $unNum
	 * @param array $uneOrga
	 * @return mixed
	 */
	public function update($unNum, $uneOrga) {
		return false;
	}
}