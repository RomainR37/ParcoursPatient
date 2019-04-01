<?php

defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Contrôleur d'affichage de la page principale
 * 
 * Affiche la page d'accueil après connexion d'un utilisateur
 * 
 * @author    Guillaume Pochet
 * @version   1.0
 * @since     09 Mars 2017
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
     * Permet d'afficher la page d'accueil
     */
    public function index() {
        $data = array();
        $data['chemin'] = 'welcome_message';
        $this->load->view('/V_generale', $data);
    }

}
