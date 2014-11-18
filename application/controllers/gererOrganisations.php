<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GererOrganisations extends CI_Controller {

         public function __construct() {
 
            parent::__construct();
            // on charge le modèle dont on a besoin
            $this->load->model("Organisation_Model", "mOrga");
        }
	/**
	 * Contrôle la validité du numéro d'organisation dont on demande le détail
         * Fait appel au modèle Organisation pour récupérer l'organisation souhaitée
	 * puis demande à afficher cette organisation
	 */
        function detail($numero=0) {

            // contrôle de validité du nuémro d'organisation
            if ($numero == 0) {
                show_error("Numéro organisation non renseigné");
            }
            else if ( !is_numeric($numero) || $numero <=0 ) {
                show_error("Numéro organisation non numérique positif");
            }
            else if ( !$this->mOrga->existe($numero) ) {
                show_error("Numéro organisation inexistante");
            }            
            else {
                // on demande au modèle l'organisation d'après son numéro
                // puis on communique ces infos à la vue detailOrganisation
                $data['uneOrganisation'] = $this->mOrga->getByNum($numero);
                $data['title'] = "Organisations";
                $this->load->view('include/entete', $data);
                $this->load->view('include/sommaire');
                $this->load->view('pages/detailOrganisation', $data);
                $this->load->view('include/pied');		           
            }
        }
	/**
	 * Fait appel au modèle Organisation pour récupérer la liste de toutes les organisations
	 * puis demande à afficher cette liste
	 */
	public function lister() {      
			
            // on fait appel à une méthode du modèle pour récupérer les organisations
            // et on stocke les résultats dans un tableau prêts pour la ou les vues
            $data['lesOrganisations'] = $this->mOrga->getList();	 	
            $data['title'] = "Organisations";
            
            $this->load->view('include/entete', $data);
            $this->load->view('include/sommaire');
            $this->load->view('pages/organisations', $data);
            $this->load->view('include/pied');		
	}
        /**
         * Méthode par défaut index
         */
        public function index() {
            $this->lister();
        }                 
}
?>