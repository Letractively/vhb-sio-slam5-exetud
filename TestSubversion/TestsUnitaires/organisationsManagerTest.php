<?php
require_once("../organisationsManager.php");

/**
 * Classe de test de la classe OrganisationsManager
 * @author baraban
 *
 */
class OrganisationsManagerTest extends PHPUnit_Framework_TestCase {
    /**
     * @var OrganisationsManager 
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
        // $monPdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES \'UTF8\'");

        // suppression de toutes les lignes de la table organisation
        $monPdo->exec("delete from organisation");

        // insertion des lignes du jeu d'essai insertDonneesTests.sql
        // comprenant 36 organisations		
        $req = file_get_contents("insertDonneesTests.sql", "./");
        
        $req = str_replace("\n", "", $req);
        $req = str_replace("\r", "", $req);
        $monPdo->exec($req);
        
        unset($monPdo);

        // instanciation d'un manager qui va servir à toutes les méthodes de test
        $this->_unManager = new OrganisationsManager($hote, $nomBD, $compte, $mdp);
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
     * Méthode de test de la méthode delete
     * Cas de test :
     *      on demande à supprimer une organisation existante
     *      on demande à supprimer une organisation qui n'existe pas
     */
    public function testDelete() {
        // numéro organisation existant : on vérifie la valeur retour de la méthode
        // puis on s'assure que la suppression est effective dans la table de la bd
        $this->assertTrue($this->_unManager->deleteByNum(4));
        $this->assertFalse($this->_unManager->getByNum(4));
        // numéro organisation inexistant : on vérifie la valeur retour de la méthode
        $this->assertFalse($this->_unManager->deleteByNum(38));
    }
    /**
     * Méthode de test de la méthode getNextNum
     * Cas de test :
     *      un seul par rapport au jeu d'essai
     */
    public function testGetNextNum() {
        // dernier numéro du jeu d'essai : 37
        $this->assertEquals(38, $this->_unManager->getNextNum());
    }
    public function testCount() {
        $nb = $this->_unManager->count();
        $this->AssertEquals(36, $nb);
    }
        /**
     * Méthode de test de la méthode add
     */
    public function testAdd() {
              $orga = array(

                    "nom" => "TestAdd" ,
                    "rue" => "Rue2Test" ,
                    "cp" => "35000" ,
                    "ville" => "Rennes" ,
                    "tel" => "02 85 47 78 52" ,
                    "fax" => "02 85 47 74 12" ,
                    "email" => "test@gmail.com",
                    "urlSiteWeb" => "http://www.test.com"
        );
        
        $this->AssertEquals(38, $this->_unManager->add($orga));
  
    }
  


}
