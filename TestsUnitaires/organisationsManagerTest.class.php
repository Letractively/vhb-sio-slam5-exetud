<?php
require_once("organisationsManager.class.php");

/**
 * Classe de test de la classe OrganisationsManager
 * @author baraban
 *
 */
class OrganisationsManagerTest extends PHPUnit_Framework_TestCase {
	private $_unManager;
	private $_monPdo;
	/**
	 * Méthode redéfinie dans le scénario de test
	 * afin d'initialiser les ressources dans un contexte donné, et ce, avant chaque test
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->_monPdo = new PDO("mysql:host=localhost;dbname=stssio", "stssio", "secret");
		$this->_monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$this->_unManager = new OrganisationsManager($this->_monPdo);
		
		// suppression de toutes les lignes dans les tables
		$this->_monPdo->exec("delete from jouerrole");
		$this->_monPdo->exec("delete from stage");
		$this->_monPdo->exec("delete from contact");
		$this->_monPdo->exec("delete from organisation");
		$this->_monPdo->exec("delete from categorie");
		$this->_monPdo->exec("delete from etudiant");
		$this->_monPdo->exec("delete from periodestage");
		$this->_monPdo->exec("delete from dept");
		$this->_monPdo->exec("delete from role");

		// insertion des lignes du jeu d'essai insertDonneesBDStages_Tests.sql
		// comprenant 36 organisations
		
		$req=file_get_contents("defaut.sql","./");
		$req=str_replace("\n","",$req);
		$req=str_replace("\r","",$req);
		$this->_monPdo->exec($req);
	}
	/**
	 * Méthode redéfinie dans le scénario de test
	 * afin de libérer les ressources initialisées, et ce, après chaque test
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$this->_monPdo = null;
	}
	/**
	 * Méthode de test de la méthode count
	 * Cas de test : 	on compte le nombre d'organisations du jeu d'essai courant
	 */
	public function testCount() {
		$nb = $this->_unManager->count();
		self::assertEquals(36, $nb);
		$this->_monPdo->exec("delete from organisation");
		$nb = $this->_unManager->count();
		self::assertEquals(0, $nb);
	}
	
	/**
	 * Méthode de test de la méthode getByNum
	 * Cas de test : 	numéro organisation existant
	 * 					numéro organisation inexistant
	 */
	public function testGetByNum() {
		// numéro organisation existant
		$uneOrga = $this->_unManager->getByNum(5);
		self::assertTrue(is_array($uneOrga));
		self::assertCount(13, $uneOrga);
		self::assertContains("5", $uneOrga);
		self::assertContains("Lycée professionnel Coëtlogon", $uneOrga);
		self::assertContains("Rue Antoine Joly - BP 18307", $uneOrga);
		self::assertContains("02 99 54 62 62", $uneOrga);
		self::assertContains("Rennes Cedex", $uneOrga);
		self::assertContains("35083", $uneOrga);
		self::assertContains("35", $uneOrga);
		self::assertContains("7", $uneOrga);
		
		// numéro organisation inexistant
		$uneOrga = $this->_unManager->getByNum(100);
		self::assertTrue(is_bool($uneOrga));
		self::assertFalse($uneOrga);
	}

	/**
	 * Méthode de test de la méthode getList
	 * Cas de test : 	on demande la liste des organisations du jeu d'essai courant
	 */
	public function testGetList() {
		$lesOrgas = $this->_unManager->getList();
		// on vérifie le type du retour et le nombre d'éléments du tableau
		self::assertCount(36, $lesOrgas);
		// on vérifie juste que le nom de la première organisation et de la dernière sont corrects
		self::assertContains("AGI Informatique", $lesOrgas[0]);
		self::assertContains("Wizdeo", $lesOrgas[35]);
	}
	
	/**
	 * Méthode de test de la méthode existe
	 * Cas de test : 	numéro organisation existant
	 * 					numéro organisation inexistant
	 */
	public function testExiste() {
		// numéro organisation existant
		$existe = $this->_unManager->existe(37);
		self::assertTrue($existe);
	
		// numéro organisation inexistant
		$existe = $this->_unManager->existe(50);
		self::assertFalse($existe);
	}
	
	/**
	 * Méthode de test de la méthode add
	 * Cas de test : 	nouvelle organisation avec plusieurs colonnes renseignées
	 * 					nouvelle organisation avec seulement deux colonnes renseignées
	 */
	public function testAdd() {
		// nouvelle organisation avec plusieurs colonnes renseignées
		$tabOrga = array(	"nom" => "MaPetiteEntreprise",
							"ville" => "ChezMoi",
							"cp" => "35200",
							"numeroDept" => "35",
							"idCategorie" => 5,
							"email" => "chezmoi@gmail.com"
					);
		$numero = $this->_unManager->add($tabOrga);
		self::assertTrue($numero == 38);
		self::assertTrue($this->_unManager->existe($numero));

		// nouvelle organisation avec seulement deux colonnes renseignées
		$tabOrga = array(	"nom" => "MaGrandeEntreprise",
							"ville" => "Paris"
					);
		$numero = $this->_unManager->add($tabOrga);
		self::assertTrue($numero == 39);
		self::assertTrue($this->_unManager->existe($numero));
	}
	/**
	 * Méthode de test de la méthode update
	 * Cas de test : 	organisation existante avec une seule colonne modifiée
	 * 					organisation existante avec 4 colonnes modifiées
	 */
	public function testUpdate() {
		// organisation existante avec 1 colonne modifiée
		$tabOrga = array(	"email" => "contact@agi-informatique.fr"
						);
		$numero = 10;
		$ok = $this->_unManager->update($numero, $tabOrga);
		self::assertTrue($ok);
		$copie = $this->_unManager->getByNum($numero);
		self::assertContains("contact@agi-informatique.fr", $copie);

		// organisation existante avec 5 colonnes modifiées
		$tabOrga = array(	"nom" => "AGIT",
							"rue" => "2 rue de la Houssais",
							"ville" => "Acigné",
							"cp" => "35540",
							"tel" => "0299123456"
					);
		$numero = 10;
		$ok = $this->_unManager->update($numero, $tabOrga);
		self::assertTrue($ok);
		$copie = $this->_unManager->getByNum($numero);
		self::assertContains("AGIT", $copie);
		self::assertContains("2 rue de la Houssais", $copie);
		self::assertContains("Acigné", $copie);
		self::assertContains("35540", $copie);
		self::assertContains("0299123456", $copie);

		// organisation existante avec 4 colonnes modifiées
		$tabOrga = array(	"nom" => "AGI",
				"rue" => "2 rue de la Poterne",
				"ville" => "Cesson-Sévigné",
				"cp" => "35510",
				"email" => "agi"
		);
		$numero = 10;
		$ok = $this->_unManager->update($numero, $tabOrga);
		self::assertTrue($ok);
		$copie = $this->_unManager->getByNum($numero);
		self::assertContains("AGI", $copie);
		self::assertContains("2 rue de la Poterne", $copie);
		self::assertContains("Cesson-Sévigné", $copie);
		self::assertContains("", $copie);
		
		
		// organisation inexistante avec 1 colonne modifiée
		$tabOrga = array("email" => "contact@agi-informatique.fr" );
		$numero = 100;
		$ok = $this->_unManager->update($numero, $tabOrga);
		self::assertFalse($ok);
	}
	/**
	 * Méthode de test de la méthode delete
	 * Cas de test : organisation existante avec des stages associés
	 * 				 organisation existante sans contact
	 * 				 organisation inexistante
	 */
	public function testDelete() {
		
	}
}