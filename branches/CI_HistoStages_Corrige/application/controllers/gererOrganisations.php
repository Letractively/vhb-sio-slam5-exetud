<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GererOrganisations extends CI_Controller {
/*
         public function __construct() {
 
            parent::__construct();
            // on charge le modèle dont on a besoin
            $this->load->model("OrganisationModel", "mOrga");
        }
*/
  	/**
 	 * Fait appel au modèle Organisation pour récupérer la liste de toutes les organisations
	 * puis demande à afficher cette liste
	 */
	public function lister() {      	
            // on charge le modèle dont on a besoin
            $this->load->model("Organisation_Model", "mOrga");
		
            // on fait appel à une méthode du modèle pour récupérer les organisations
            // et on stocke les résultats dans un tableau prêts pour la ou les vues
            $data['lesOrganisations'] = $this->mOrga->getList();
            $data['title'] = "Organisations";
	 	
	 	
            $this->load->view('include/entete', $data);
            $this->load->view('include/sommaire');
            $this->load->view('pages/organisations', $data);
            $this->load->view('include/pied');		
        }
        
        public function index() {
            $this->lister();
        }        
}
?>