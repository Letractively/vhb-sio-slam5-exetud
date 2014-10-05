<?php
require_once("../cacheARP.php");

class CacheARPTest extends PHPUnit_Framework_TestCase {
	private $unCache;

	/**
	 * Redéfinit la méthode setup de PHPUnit_Framework_TestCase
	 * lancée avant chaque appel de méthode de test.
	 * Permet de réinitialiser les ressources du contexte.
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	/**
	 * Redéfinit la méthode tearDown de PHPUnit_Framework_TestCase
	 * lancée après chaque appel de méthode de test.
	 * Permet de libérer les ressources du contexte.
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		unset($this->unCache);
	}
	/**
	 * Redéfinit la méthode assertPreConditions de PHPUnit_Framework_TestCase
	 * Réalise toutes les assertions partagées par toutes les méthodes de test
	 * de la classe de test. 
	 * @see PHPUnit_Framework_TestCase::assertPreConditions()
	 */
	public function assertPreConditions() {
		// $this->assertCount(0, $this->unCache->getEntrees());
	}
	/**
	 * Test de la méthode d'instance ajouteEntree
	 * Cas de test : une adresse IP inexistante
	 *               une adresse IP déjà existante dans le cache 
	 * @covers CacheARP::ajouteEntree
	 */
	public function testAjouteEntree() {
		// cas de test : adresse IP inexistante
            		$this->unCache= new CacheARP();

		$ok = $this->unCache->ajouteEntree("172.20.0.1", "A1-B2-C3-D4-E5-F6");
		$this->assertTrue($ok);
		$ok = $this->unCache->ajouteEntree("172.20.0.50", "A7-B8-C9-D0-E1-F2");
		$this->assertTrue($ok);
		
		$tab = $this->unCache->getEntrees();
		$this->assertCount(2,$tab);
		$this->assertEquals("A1-B2-C3-D4-E5-F6", $tab["172.20.0.1"]);
		$this->assertEquals("A7-B8-C9-D0-E1-F2", $tab["172.20.0.50"]);
		
		// cas de test : adresse IP déjà existante
		$ok = $this->unCache->ajouteEntree("172.20.0.1", "A1-B2-C3-D4-E5-F6");
		$this->assertFalse($ok);
	}
	/**
	 * Méthode de test de la méthode statique CacheARP::estAdrIP
	 * Cas de test : 	adresse IP valide avec 4 octets compris entre 0 et 255
	 * 			adresses IP invalides
	 * @covers CacheARP::estAdrIP
	 */
	public function testEstAdrIP() {
		// cas de test : adresse IP avec 4 octets valides pris dans l'intervalle 0 à 255
		$this->assertTrue(CacheARP::estAdrIP("172.20.1.50"));
		// cas de test : adresse IP avec 2 octets valides pris aux valeurs limites
		$this->assertTrue(CacheARP::estAdrIP("247.100.0.255"));
		// cas de test : adresse IP avec moins de 4 octets
		$this->assertFalse(CacheARP::estAdrIP("247.100.2"));
		// cas de test : adresse IP avec plus de 4 octets 
		$this->assertFalse(CacheARP::estAdrIP("247.100.2.255.40"));
		// cas de test : adresse IP avec un octet en dehors de l'intervalle 0 à 255
		$this->assertFalse(CacheARP::estAdrIP("256.100.2.255"));
		// cas de test : adresse IP avec un octet en dehors de l'intervalle 0 à 255
		$this->assertFalse(CacheARP::estAdrIP("250.-100.2.255"));
		// cas de test : adresse IP avec un octet comprenant un caractère autre qu'un chiffre
		$this->assertFalse(CacheARP::estAdrIP("247.100.2a.255"));
		// cas de test : adresse IP avec un spérateur autre qu'un point
		$this->assertFalse(CacheARP::estAdrIP("256-100-2-255"));		
		// cas de test : adresse IP avec un spérateur autre qu'un point
		$this->assertFalse(CacheARP::estAdrIP("256:100-2-255"));		
	}		
}
