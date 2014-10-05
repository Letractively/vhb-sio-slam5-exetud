<?php
/**
 * Classe du cache ARP pour gérer une table d'association entre adresses IP et adresses MAC
 * @author baraban
 *
 */
class CacheARP {
	private  $_leCache;	

	/**
	 * Fournit le cache ARP sous forme de tableau associatif
	 * @return array
	 */
	public function getEntrees() {
		return $this->_leCache;
	}	
	/**
	 * Construit un cache ARP vide
	 */
	public function __construct() {
		$this->_leCache = array();
	}	
	/**
	 * Ajoute une entrée dans le cache ARP pour l'adresse IP $adrIP
	 * portant l'adresse MAC $adrMAC
	 * Retourne true si l'entrée a bien été ajoutée, false sinon
	 * @param string $adrIP
	 * @param string $adrMAC
	 * @return boolean
	 */
	public function ajouteEntree($adrIP, $adrMAC) {		
		// vérifier le format des adresses fournies
		if (! isset($this->_leCache[$adrIP])) {
			$this->_leCache[$adrIP] = $adrMAC;
			$ok = true;
		}	
		else {
			$ok = false;
		}
		return $ok;
	}
	/**
	 * Supprime l'entrée dans le cache ARP pour l'adresse IP $adrIP
	 * portant l'adresse MAC $adrMAC.
	 * Renvoie true si la suppression a réussi, false sinon
	 * @param string $adrIP
	 * @return boolean 
	 */	
	/**
	 * Fournit le nombre d'entrées du cache ARP
	 * @return integer
	 */
	/**
	 * Vérifie le format de l'adresse IP
	 * @param string $adrIP
	 * @return boolean
	 */
	public static function estAdrIP($adrIP) {
		// construction d'un tableau 
		// en extrayant les parties de chaîne situées entre chaque point
		$tab = explode(".", $adrIP);
		// on compte le nombre d'octets
		$nbOctets = count($tab);
		$ok = true;
		if ( $nbOctets == 4 ) {
			// parcours du tableau avec arrêt
			// dès qu'un des octets n'est pas numérique ou compris entre 0 et 255
			for ( $i=0 ; $i < $nbOctets && $ok ; $i++ ) {
				$ok = is_numeric($tab[$i]) && $tab[$i] >= 0 && $tab[$i] <= 255;
			}
		}
		else {
			$ok = false;
		}
		return $ok;
	}	
}