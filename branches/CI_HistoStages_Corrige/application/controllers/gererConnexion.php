<?php

class GererConnexion extends CI_Controller {
    /**
     * Méthode par défaut appelée lorsque le nom de méthode est absent
     * Par défaut, c'est une demande de connexion qui sera traitée
     */
    function index()
    {		
        $this->load->library('form_validation');
	$data['title']	 = "Connexion";
        $this->load->view('include/entete', $data);
        $this->load->view('include/sommaire');
    	 
        // définition des règles de validation des champs du formulaire de connexion
	$this->form_validation->set_rules('txtNom', 'Nom de compte utilisateur', 'required|max_length[30]');
		
	// demande de validation des champs du formulaire
	if ($this->form_validation->run() == FALSE) {
            $this->load->view('pages/formulaireConnexion');
	}
	else {		
            // affiche la page de connexion réussie
            $this->load->view('pages/connexionReussie');
	}
		
        $this->load->view('include/pied');
    }

    /**
     * Fonction de validation appelée par la méthode run lors de la validation du champ mot de passe
     * Elle vérifie que le mot de passe existe bien.
     * @param string $mdp
     * @return boolean valide ou non
     */
    public function verifMdp($mdp) {
       $ok = true;
       if ( $mdp != 'PASSE') {
               $this->form_validation->set_message('verifMdp', 'The %s field is not correct');
               $ok = false;
       }
     return $ok;
    }
}
?>