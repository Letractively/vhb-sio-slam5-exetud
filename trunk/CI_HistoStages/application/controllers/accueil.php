<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Contrôleur gérant les pages statiques
 * @author baraban
 *
 */
class Accueil extends CI_Controller {
    /**
     * Prépare pour l'affichage les informations générales sur le site
     */
    public function infosGenes() {
                $this->load->view('include/entete');
                $this->load->view('include/sommaire');
		$this->load->view('pages/infosGenes');
                $this->load->view('include/pied');                
    }
}
?>