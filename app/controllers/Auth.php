<?php

/**
 * \file      Auth.php
 * \author    Guillaume Pochet
 * \version   1.0
 * \date      09 Mars 2017
 * \brief     Controller de gestion d'espace membre
 *
 * \details   Contient les différentes méthodes de gestion de l'espace de connexion
 */
class Auth extends CI_Controller {

    /**
     * \brief      Permet à un utilisateur de se connecter
     * \details    La méthode permet de charger le formulaire de connexion
     *            si la personne n'est pas connecté sinon la page d'accuil en fonction de ses droits
     *            On différencie 3 types d'utilisateur (patient, ressource, administrateur)
     * \param      Aucun
     */
    public function index() {
        if ($this->session->id == null) {                       // Si l'utilisateur n'est pas connecté
            $this->load->helper(array('form', 'url'));

            $this->load->library('form_validation');

            $this->form_validation->set_rules('username', 'Identifiant', 'required');            // Le champ pseudo est OBLIGATOIRE
            $this->form_validation->set_rules('password', 'Mot de passe', 'required');            // Le champ mot de passe est OBLIGATOIRE

            if ($this->form_validation->run() == FALSE) {                    // Si les entrées du formulaire ne respectent pas les règles
                $this->load->view('auth/V_login');                     // On recharge la page
            } else {
                $this->load->model('M_Auth');
                $data_session = $this->M_Auth->login($this->input->post('username'), crypt($this->input->post('password'), '$2a$07fhferjfjrjfhjerfbfcreef$'));    // On créé les données de session
                if ($data_session != null) {                       // On vérifie qu'il n'y a pas d'erreur
                    $this->session->set_userdata($data_session);                 // On les ajoute à la session
                    redirect('/', 'refresh');
                } else
                    $this->load->view('auth/V_login');                    // Erreur, on recharge la vue									
            }
        }else {                             // Sinon					
            redirect('/', 'refresh');                         // On redirige vers la page d'accueil
        }                              // Fin SI
    }

    /**
     * \brief      Permet à un utilisateur de se déconnecter
     * \details    La méthode permet de se déconnecter
     *            Détruit la session de l'utilisateur connecté
     * \param      Aucun
     */
    public function logout() {
        $this->session->sess_destroy();                       // On détruit la session

        $this->index();
    }

}
