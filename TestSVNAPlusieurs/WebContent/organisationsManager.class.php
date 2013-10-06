<?php
class OrganisationsManager {
	private $_db;
	private $_cmdSelectByNum;
	/**
	 * Initialise une instance de OrganisationsManager
	 * @param PDO $pdo
	 */
	public function __construct($pdo) {
		$this->_db = $pdo;
		$sql = "select * from organisation where numero = ?";
		$this->_cmdSelectByNum = $this->_db->prepare($sql);
		
	}
	/**
	 * Retourne le nombre d'organisations présentes
	 * @return integer
	 */
	public function count() {		
		$sql = "select count(*) as nbOrgas from organisation";
		$jeu = $this->_db->query($sql);
		
		$ligne = $jeu->fetch(PDO::FETCH_ASSOC);
		$nb = $ligne["nbOrgas"];
		$jeu->closeCursor();
		return $nb;

	}
	/**
	 * Fournit les données de l'organisation portant le numéro spécifié
	 * sous forme de tableau associatif, les clés correspondant au nom des colonnes de la table
	 * Retourne le booléen false dans le cas d'un numéro inexistant
	 * @param integer $numero
	 * @return mixed
	 */
	public function getByNum($numero) {
		$this->_cmdSelectByNum->execute(array($numero));
		$ligne = $this->_cmdSelectByNum->fetch(PDO::FETCH_ASSOC);
		$this->_cmdSelectByNum->closeCursor();
		return $ligne;
		return false;
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
	 * Fournit les données de l'ensemble des organisations présentes
	 * sous forme de tableau de tableaux
	 * Les lignes sont indicées numériquement et séquentiellement à partir de 0. 
	 * L'ordre des organisations suit l'ordre alphabétique sur le nom des organisations.
	 * Chaque ligne est un tableau associatif, les clés correspondant au nom des colonnes de la table
	 * @return array
	 */
	public function getList() {
		return array();
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
		return false;
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
	/**
	 * Fournit le prochain numéro d'organisation à affecter
	 * @return integer
	 */
	private function getNextNum() {
		$jeu=$this->_db->query("select max(numero) as maxNum from organisation");
		$ligne = $jeu->fetch(PDO::FETCH_ASSOC);
		$num = intval($ligne['maxNum'] + 1);
		$jeu->closeCursor();
		return $num;
	}
}