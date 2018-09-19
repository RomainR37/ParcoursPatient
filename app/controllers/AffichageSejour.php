<?php

/**
 * \file      AffichageSejour.php
 * \author    Guillaume Pochet
 * \version   1.0
 * \date      09 Mars 2017
 * \brief     Affichage le planning d'un patient
 *
 * \details   Permet d'afficher le planning d'un patient ou séjour
 */
class AffichageSejour extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata("username") === null)
            redirect('Auth', 'refresh');
    }

    /**
     * \brief      Affichage la liste des différentes actvités
     * \details    La méthode récupérer la liste des activités d'un patient
     *                  et envoie ces données sur la page V_patient.
     *             Cette page se charge d'afficher les données
     * \param      Aucun
     */
    public function index() {
        $data = array();
        $this->load->model('M_Patient');
        $data['activites'] = $this->M_Patient->getAllActivities($this->session->userdata("id_individu"));
        $this->load->view('patient/V_patient', $data);
    }

}
