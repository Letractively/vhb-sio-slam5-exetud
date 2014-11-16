<?php
require_once("../models/organisation_model.php");

/**
 * Classe de test de la classe OrganisationsManager
 * @author baraban
 *
 */
class Organisation_ModelTest extends PHPUnit_Framework_TestCase {
    /**
     * @var Organisation_Model 
     */
    private $_unManager;

    /**
     * Méthode redéfinie dans le scénario de test
     * afin d'initialiser les ressources dans un contexte donné, et ce, avant chaque test
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp() {
        $hote = "localhost";
        $nomBD = "bdstssio";
        $compte = "root";
        $mdp = "";
        $monPdo = new PDO("mysql:host=" . $hote . ";dbname=" . $nomBD, $compte, $mdp);
        $monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $monPdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES \'UTF8\'");

        // suppression de toutes les lignes de la table organisation
        $monPdo->exec("delete from organisation");

        // insertion des lignes du jeu d'essai insertDonneesTests.sql
        // comprenant 36 organisations		
        $req = utf8_encode(file_get_contents("insertDonneesTests.sql", "./"));
        
        $req = str_replace("\n", "", $req);
        $req = str_replace("\r", "", $req);
        $monPdo->exec($req);
        
        unset($monPdo);

        // instanciation d'un manager qui va servir à toutes les méthodes de test
        $this->_unManager = new Organisation_Model();
    }
    /**
     * Méthode redéfinie dans le scénario de test
     * afin d'initialiser les ressources dans un contexte donné, et ce, avant chaque test
     * afin de libérer les ressources initialisées, et ce, après chaque test
     * @see PHPUnit_Framework_TestCase::tearDown()
     */
    protected function tearDown() {
        unset($this->_unManager);
    }
    /**
     * Méthode de test de la méthode getByNum
     * Cas de test : 	numéro organisation existant
     * 			numéro organisation inexistant
     */
    public function testGetByNum() {
        // numéro organisation existant
        $uneOrga = $this->_unManager->getByNum(5);
        $this->assertTrue(is_array($uneOrga));
        $this->assertCount(9, $uneOrga);
        $this->assertContains("5", $uneOrga);
        $this->assertContains("Lycée professionnel Coëtlogon", $uneOrga);
        $this->assertContains("Rue Antoine Joly - BP 18307", $uneOrga);
        $this->assertContains("02 99 54 62 62", $uneOrga);
        $this->assertContains("Rennes Cedex", $uneOrga);
        $this->assertContains("35083", $uneOrga);

        // numéro organisation inexistant
        $uneOrga = $this->_unManager->getByNum(100);
        $this->assertTrue(is_bool($uneOrga));
        $this->assertFalse($uneOrga);
    }

    /**
     * Méthode de test de la méthode getList
     * Cas de test : 	
     *      on demande la liste des organisations du jeu d'essai courant
     */
    public function testGetList() {
        $lesOrgas = $this->_unManager->getList();
        // on vérifie le type du retour et le nombre d'éléments du tableau
        $this->assertTrue(is_array($lesOrgas));
        $this->assertCount(36, $lesOrgas);
    }
    /**
     * Méthode de test de la méthode count
     * Cas de test : 	
     *      on demande le nombre d'organisations du jeu d'essai courant
     */
    public function testCount() {
        $nb = $this->_unManager->getCount();
        $this->AssertEquals('36', $nb);
    }
    /**
     * Méthode de test de la méthode getSubList
     * Le jeu d'essai des organisations utilisé ici regroupe 36 organisations
     * Cas de test : 	
     *      on demande un sous-ensemble à partir de la première organisation
     */
    public function testGetSubList() {
        $lesOrgas = $this->_unManager->getSubList(0, 20);
        // consultation d'enregistrements situé au début (premier intervalle)
        // on se cantonne à vérifier le type du retour et le nombre d'éléments du tableau
        $this->assertTrue(is_array($lesOrgas));
        $this->assertCount(20, $lesOrgas);
        
	  // consultation d'enregistrements situé dans un intervalle qui n'est
	  // pas intervalle limite, càd en début ou en fin
        $lesOrgas = $this->_unManager->getSubList(20, 10);
        // on vérifie le type du retour et le nombre d'éléments du tableau
        $this->assertTrue(is_array($lesOrgas));
        $this->assertCount(10, $lesOrgas);
        
	  // consultation d'enregistrements situé dans le dernier intervalle 
  // avec un nombre d'enregistrements supérieur au nombre restant
        $lesOrgas = $this->_unManager->getSubList(30, 10);
        // on vérifie le type du retour et le nombre d'éléments du tableau
        $this->assertTrue(is_array($lesOrgas));
        $this->assertCount(6, $lesOrgas);
        
	  // consultation d'enregistrements situé dans le dernier intervalle 
  // avec un nombre d'enregistrements égal au nombre restant
        $lesOrgas = $this->_unManager->getSubList(30, 6);
        // on vérifie le type du retour et le nombre d'éléments du tableau
        $this->assertTrue(is_array($lesOrgas));
        $this->assertCount(6, $lesOrgas);
        
	  // consultation d'enregistrements situé au-delà du dernier intervalle 
  $lesOrgas = $this->_unManager->getSubList(40, 6);
        // on vérifie le type du retour et le nombre d'éléments du tableau
        $this->assertTrue(is_array($lesOrgas));
        $this->assertCount(0, $lesOrgas);
    }
    public function testGetSubListOffsetNotInteger() {
        // paramètre offset n'est pas de type integer ; exception InvalidArgumentException lancée
        $this->setExpectedException("InvalidArgumentException");
        $lesOrgas = $this->_unManager->getSubList("40", 6);        
    }
    public function testGetSubListLimitNotInteger() {
        // paramètre limit n'est pas de type integer ; exception InvalidArgumentException lancée
        $this->setExpectedException("InvalidArgumentException");
        $lesOrgas = $this->_unManager->getSubList(10, "6");        
    }
    public function testGetSubListOffsetNegative() {
        // paramètre offset n'est pas positif ou nul ; exception InvalidArgumentException lancée
        $this->setExpectedException("InvalidArgumentException");
        $lesOrgas = $this->_unManager->getSubList(-10, 20);        
    }
    public function testGetSubListLimitNegative() {
        // paramètre limit n'est pas positif ou nul ; exception InvalidArgumentException lancée
        $this->setExpectedException("InvalidArgumentException");
        $lesOrgas = $this->_unManager->getSubList(10, -20);        
    }
    public function testGetSubListOffsetNotIntegerLimiteNegative() {
        // paramètre offset n'est pas de type integer et limit negative ; exception InvalidArgumentException lancée
        $this->setExpectedException("InvalidArgumentException");
        $lesOrgas = $this->_unManager->getSubList("&", -5);        
    }
    public function testGetSubListOffsetNotIntegerLimiteNotInteger() {
        // paramètres offset et limit ne sont pas de type integer; exception InvalidArgumentException lancée
        $this->setExpectedException("InvalidArgumentException");
        $lesOrgas = $this->_unManager->getSubList("&", 6.2);        
    }   
}
