<?php

/**
 * Contrôleur des types de ressources
 * 
 * Contrôleur de gestion des types de ressources
 * 
 * @author    Guillaume Pochet
 * @version   1.0
 * @since     09 Mars 2017
 * 
 */
class TypeRessource extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata("username") === null)
            redirect('/Auth', 'refresh');
        if ($this->session->userdata("level") === "1")
            redirect('/AffichageSejour', 'refresh');
    }

    /**
     * Permet d'afficher la liste de tous les types ressources.
     */
    public function getAllTypes() {
        $this->load->model('M_TypeRessource');
        return json_encode($this->M_TypeRessource->getAllTypes());
    }

}
