<?php

/**
 * \file      TypeRessource.php
 * \author    Guillaume Pochet
 * \version   1.0
 * \date      09 Mars 2017
 * \brief     Controller des types de ressources
 *            
 *
 * \details   Controller de gestion des types de ressources
 */
class DossierParcours extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata("username") === null)
            redirect('/Auth', 'refresh');
        if ($this->session->userdata("level") === "1")
            redirect('/AffichageSejour', 'refresh');
    }

    /**
     * \brief      Permet d'afficher la liste de tout les types ressources
     * \details    Permet d'afficher la liste de tout les types ressources
     * \param      Aucun
     */
    public function getAllTypes() {
        $this->load->model('M_TypeRessource');
        return json_encode($this->M_TypeRessource->getAllTypes());
    }

}
