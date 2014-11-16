<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Organisation_Model extends CI_Model {
        /**
         * @var $_monPdo PDO 
         */
	private  $_monPdo;
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
	 *
	 * @return array tableau d'objets organisations (propriétés objet = colonnes table)
	 */
	public function getSubList($offset=0, $limit=0) {
		$req = "select * from organisation order by nom asc";
		if ($offset != 0 || $limit != 0) {
			$req .= " limit " . $offset . "," . $limit; 
		}
		$jeu = $this->_monPdo->query($req);
		$jeu->setFetchMode(PDO::FETCH_OBJ);
		$lignes = $jeu->fetchAll();
		$jeu->closeCursor();
		return $lignes;
	}
	
	public function getCount() {
		$req = "select count(*) from organisation";
		$jeu = $this->_monPdo->query($req);
		$jeu->setFetchMode(PDO::FETCH_NUM);
		$ligne = $jeu->fetch();
		$jeu->closeCursor();
		return $ligne[0];
		
	}

}
?>