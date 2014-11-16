<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Contrôleur gérant les pages statiques
 * @author baraban
 *
 */
class Accueil extends CI_Controller {
    /**
     * Prépare et demande l'affichage de la liste des études post-bts sio
     */
    public function licencesProGen() {
        $this->traiterDemande("Licences professionnelles et générales", "licencesProGen");
    }
    /**
     * Prépare et demande l'affichage de la liste de sites d'offres emplois et stages
     */
    public function sitesEmplois() {
        $this->traiterDemande("Sites d'offres emplois et stages", "sitesEmplois");
    }
    /**
     * Prépare et demande l'affichage des informations générales sur le site
     */
    public function infosGenes() {
        $this->traiterDemande("Informations générales", "infosGenes");
    }
    /**
     * Prépare et demande l'affichage d'une page complète d'après un titre et un nom de page
     * @param string $title
     * @param string $page
     */
    private function traiterDemande($title, $page) {
        $data['title']=$title;
        $this->load->view('include/entete', $data);
        $this->load->view('include/sommaire');
        $this->load->view('pages/' . $page);
        $this->load->view('include/pied');                
        
    }
    public function index() {
        $this->infosGenes();
    }
}
?>