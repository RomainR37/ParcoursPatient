<?php

/**
 * La classe AffichageSejour gère l'affichage du planning d'un patient.
 * 
 * Ce fichier permet d'afficher le planning d'un patient ou séjour.
 * 
 * @author    Guillaume Pochet
 * @version   1.0
 * @since     09 Mars 2017
 */
class AffichageSejour extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata("username") === null)
            redirect('Auth', 'refresh');
    }

    /**
     * Affichage de la liste des différentes actvités
     * 
     * La méthode récupère la liste des activités d'un patient
     * et envoie ces données sur la page V_patient.
     * Cette page se charge d'afficher les données.
     */
    public function index() {
        $data = array();
        $this->load->model('M_Patient');
        $data['activites'] = $this->M_Patient->getAllActivities($this->session->userdata("id_individu"));
        $this->load->view('patient/V_patient', $data);
    }

}
