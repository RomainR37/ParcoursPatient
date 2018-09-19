<?php

defined('BASEPATH') || exit('No direct script access allowed');
/**
 * \file      Welcome.php
 * \author    Guillaume Pochet
 * \version   1.0
 * \date      09 Mars 2017
 * \brief     Controller d'affichage de la page principale
 *            
 *
 * \details   Affiche la page d'accueuil apres connexion d'un utilisateur
 */
class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata("username") === null) {
            redirect('/Auth', 'refresh');
        }
        if ($this->session->userdata("level") === "1") {
            redirect('/AffichageSejour', 'refresh');
        }
    }
    /**
     * \brief      Permet d'afficher la page d'accueil
     * \details    Permet d'afficher la page d'accueil
     * \param      Aucun
     */
    public function index() {
        $data = array();
        $data['chemin'] = 'welcome_message';
        $this->load->view('/V_generale', $data);
    }

}
