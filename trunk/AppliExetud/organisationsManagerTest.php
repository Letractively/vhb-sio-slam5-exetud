<?php
require_once("organisationsManager.class.php");

/**
 * Classe de test de la classe OrganisationsManager
 * @author baraban
 *
 */
class OrganisationsManagerTest extends PHPUnit_Framework_TestCase {
	private $_unManager;
	/**
	 * M�thode red�finie dans le sc�nario de test
	 * afin d'initialiser les ressources dans un contexte donn�, et ce, avant chaque test
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$monPdo = new PDO("mysql:host=localhost;dbname=stssio", "stssio", "secret");
		$monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$this->_unManager = new OrganisationsManager($monPdo);
		
		// suppression de toutes les lignes dans les tables
		$monPdo->exec("delete from jouerrole");
		$monPdo->exec("delete from stage");
		$monPdo->exec("delete from contact");
		$monPdo->exec("delete from organisation");
		$monPdo->exec("delete from categorie");
		$monPdo->exec("delete from etudiant");
		$monPdo->exec("delete from periodestage");
		$monPdo->exec("delete from dept");
		$monPdo->exec("delete from role");

		// insertion des lignes du jeu d'essai insertDonneesBDStages_Tests.sql
		// comprenant 36 organisations
		
		$req=file_get_contents("defaut.sql","./");
		$req=str_replace("\n","",$req);
		$req=str_replace("\r","",$req);
		$monPdo->exec($req);
	}
	/**
	 * M�thode red�finie dans le sc�nario de test
	 * afin de lib�rer les ressources initialis�es, et ce, apr�s chaque test
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$monPdo = null;
	}
	/**
	 * M�thode de test de la m�thode count
	 * Cas de test : 	on compte le nombre d'organisations du jeu d'essai courant
	 */
	public function testCount() {
		$nb = $this->_unManager->count();
		self::assertEquals(36, $nb);
	}
	
	/**
	 * M�thode de test de la m�thode getByNum
	 * Cas de test : 	num�ro organisation existant
	 * 					num�ro organisation inexistant
	 */
	public function testGetByNum() {
		// num�ro organisation existant
		$uneOrga = $this->_unManager->getByNum(5);
		self::assertTrue(is_array($uneOrga));
		self::assertCount(13, $uneOrga);
		self::assertContains("5", $uneOrga);
		self::assertContains("Lyc�e professionnel Co�tlogon", $uneOrga);
		self::assertContains("Rue Antoine Joly - BP 18307", $uneOrga);
		self::assertContains("02 99 54 62 62", $uneOrga);
		self::assertContains("Rennes Cedex", $uneOrga);
		self::assertContains("35083", $uneOrga);
		self::assertContains("35", $uneOrga);
		self::assertContains("7", $uneOrga);
		
		// num�ro organisation inexistant
		$uneOrga = $this->_unManager->getByNum(100);
		self::assertTrue(is_bool($uneOrga));
		self::assertFalse($uneOrga);
	}

	/**
	 * M�thode de test de la m�thode getList
	 * Cas de test : 	on demande la liste des organisations du jeu d'essai courant
	 */
	public function testGetList() {
		$lesOrgas = $this->_unManager->getList();
		// on v�rifie le type du retour et le nombre d'�l�ments du tableau
		self::assertCount(36, $lesOrgas);
		// on v�rifie juste que le nom de la premi�re organisation et de la derni�re sont corrects
		self::assertContains("AGI Informatique", $lesOrgas[0]);
		self::assertContains("Wizdeo", $lesOrgas[35]);
	}
	
	/**
	 * M�thode de test de la m�thode existe
	 * Cas de test : 	num�ro organisation existant
	 * 					num�ro organisation inexistant
	 */
	public function testExiste() {
		// num�ro organisation existant
		$existe = $this->_unManager->existe(37);
		self::assertTrue($existe);
	
		// num�ro organisation inexistant
		$existe = $this->_unManager->existe(50);
		self::assertFalse($existe);
	}
	
	/**
	 * M�thode de test de la m�thode add
	 * Cas de test : 	nouvelle organisation avec plusieurs colonnes renseign�es
	 * 					nouvelle organisation avec seulement deux colonnes renseign�es
	 */
	public function testAdd() {
		// nouvelle organisation avec plusieurs colonnes renseign�es
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

		// nouvelle organisation avec seulement deux colonnes renseign�es
		$tabOrga = array(	"nom" => "MaGrandeEntreprise",
							"ville" => "Paris"
					);
		$numero = $this->_unManager->add($tabOrga);
		self::assertTrue($numero == 39);
		self::assertTrue($this->_unManager->existe($numero));
	}
	/**
	 * M�thode de test de la m�thode update
	 * Cas de test : 	organisation existante avec une seule colonne modifi�e
	 * 					organisation existante avec 4 colonnes modifi�es
	 */
	public function testUpdate() {
		// organisation existante avec 1 colonne modifi�e
		$tabOrga = array(	"email" => "contact@agi-informatique.fr"
						);
		$numero = 10;
		$ok = $this->_unManager->update($numero, $tabOrga);
		self::assertTrue($ok);
		$copie = $this->_unManager->getByNum($numero);
		self::assertContains("contact@agi-informatique.fr", $copie);

		// organisation existante avec 4 colonnes modifi�es
		$tabOrga = array(	"nom" => "AGI",
							"adresse" => "2 rue de la Poterne",
							"ville" => "Cesson-S�vign�",
							"cp" => "35510",
					);
		$numero = 10;
		$ok = $this->_unManager->update($numero, $tabOrga);
		self::assertTrue($ok);
		$copie = $this->_unManager->getByNum($numero);
		self::assertContains("AGI", $copie);
		self::assertContains("2 rue de la Poterne", $copie);
		self::assertContains("Cesson-S�vign�", $copie);
		self::assertContains("", $copie);

		// organisation inexistante avec 1 colonne modifi�e
		$tabOrga = array("email" => "contact@agi-informatique.fr" );
		$numero = 100;
		$ok = $this->_unManager->update($numero, $tabOrga);
		self::assertFalse($ok);
		$copie = $this->_unManager->getByNum($numero);
		self::assertContains("contact@agi-informatique.fr", $copie);		
	}
}