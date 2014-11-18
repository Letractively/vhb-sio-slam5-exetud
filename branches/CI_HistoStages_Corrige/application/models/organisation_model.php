<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Organisation_Model {
        /**
         * @var $_monPdo PDO 
         */
	private  $_monPdo;
        /**
         * @var $_cmdGetByNum PDOStatement
         */
        private $_cmdGetByNum;
        /**
         * @var $_cmdSubList PDOStatement
         */
        private $_cmdSubList;
	/**
	 * Initialise une instance de la classe Categorie_Model
	 * - Etablit une connexion vers le serveur MySql
	 * - Prépare les requêtes SQL qui comportent des parties variables
	 */
	public function __construct() {
		parent::__construct();
		$server = "localhost";
		$bdd = "bdstssio";
 		$user = "stssio";
 		$mdp ="secret";
 		$driver = "mysql";

 		// ouverture d'une connexion vers le serveur MySql 
                $this->_monPdo = new PDO($driver . ":host=" . $server . ";dbname=" . $bdd, 
                                        $user, $mdp, 
                                        array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'UTF8'"));
            // préparation de la requête de sélection d'une organisation
            $this->_cmdGetByNum = $this->_monPdo->prepare("select * from organisation where numero = ? "); 
            // préparation de la requête de sélection d'une sous-liste d'organisations
            $req = "select * from organisation order by nom limit :offset, :limit";
            $this->_cmdSubList = $this->_monPdo->prepare($req);
 	}
	/**
	 * Retourne l'ensemble des organisations sous forme d'un tableau d'objets.
	 *
	 * @return array tableau d'objets organisations (propriétés objet = colonnes table)
	 */
	public function getList() {
            $req = "select * from organisation order by nom asc";
            $jeu = $this->_monPdo->query($req);
            $jeu->setFetchMode(PDO::FETCH_OBJ);
            $lignes = $jeu->fetchAll();
            $jeu->closeCursor();
            return $lignes;
	}
	/**
	 * Retourne l'ensemble des organisations sous forme d'un tableau d'objets.
	 * @param int $offset
         * @param int $limit
	 * @return array tableau d'objets organisations (propriétés objet = colonnes table)
         * @throws InvalidArgumentException
	 */
	public function getSubList($offset, $limit) {
            if ( !is_integer($offset) || $offset < 0 || !is_integer($limit) || $limit < 0 ) {
                throw new InvalidArgumentException("Paramètre offset ou limit incorrect.");
            }
            else {
                $this->_cmdSubList->bindValue("offset", $offset, PDO::PARAM_INT);
                $this->_cmdSubList->bindValue("limit", $limit, PDO::PARAM_INT);
                $this->_cmdSubList->execute();
                $this->_cmdSubList->setFetchMode(PDO::FETCH_OBJ);
                $lignes = $this->_cmdSubList->fetchAll();
                $this->_cmdSubList->closeCursor();
                return $lignes;
            }
	}
	/**
         * Fournit le nombre d'organisations recensées
         * @return int nombre d'organisations
         */
	public function getCount() {
		$req = "select count(*) from organisation";
		$jeu = $this->_monPdo->query($req);
		$jeu->setFetchMode(PDO::FETCH_NUM);
		$ligne = $jeu->fetch();
		$jeu->closeCursor();
		return $ligne[0];		
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
            $uneOrga = $this->_cmdGetByNum->fetch(PDO::FETCH_OBJ);
            $this->_cmdGetByNum->closeCursor();
            return $uneOrga;    
	}	
	/**
	 * Retourne true si le numéro spécifié correspond à celui d'une organisation existante,
	 * false sinon
	 * @param integer $numero
	 * @return boolean
	 */
	public function existe($numero) {
            return is_object($this->getByNum($numero));
	}
        
}
?>