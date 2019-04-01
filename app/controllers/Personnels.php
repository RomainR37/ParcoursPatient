<?php

/**
 * Contrôleur des ressources humaines
 * 
 * Contient les différentes méthodes de gestion du personnels
 * 
 * @author    Guillaume Pochet
 * @version   1.0
 * @since     09 Mars 2017
 */
class Personnels extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata("username") === null)
            redirect('/Auth', 'refresh');
        if ($this->session->userdata("level") === "1")
            redirect('/AffichageSejour', 'refresh');
    }

    /**
     * Permet d'afficher toutes les ressources humaines
     * 
     * Méthode permettant la liaison entre la vue du personnel et le modèle 
     * personnel
     * Récupère tout le personnel et les envoie à la vue qui se charge de les 
     * afficher
     */
    public function index() {
        $this->load->model('M_Personnel');
        $data = array();
        $data['personnels'] = $this->M_Personnel->getAllPersonnes();

        $data['chemin'] = '/ressource/V_personnels';

        $this->load->view('/V_generale', $data);
    }

    /**
     * Permet d'ajouter une ressource humaine 
     * 
     * Fonction permettant d'afficher la vue d'ajout d'une nouvelle personne
     */
    public function ajout() {
        $data['chemin'] = '/ressource/v_addPersonnel';
        $data['id'] = -1;
        $data['nom'] = '';
        $data['prenom'] = '';
        $data['type'] = '';

        $data['idRessource'] = -1;
        $data['idType'] = -1;

        $this->load->view('/V_generale', $data);
    }

    /**
     * Permet d'ajouter ou de modifier une personne
     * 
     * Récupère la liste des informations d'une personne (ajout ou 
     * modification) et les ajoute en base de données
     */
    public function confirmModif() {
        $this->load->model('M_Personnel');
        $personne = array();
        $personne['nom'] = $_POST['nom'];
        $personne['prenom'] = $_POST['prenom'];
        $personne['type'] = $_POST['type'];
        $personne['id'] = $_POST['id'];
        $personne['idType'] = $_POST['idType'];
        $personne['idRessource'] = $_POST['idRessource'];
        if ($personne['id'] == -1) {
            $personne['login'] = $_POST['login'];
            $personne['password'] = $_POST['password'];
            $this->M_Personnel->ajoutePersonne($personne);
        } else {
            $this->M_Personnel->ModifPersonne($personne);
        }

        $this->index();
    }

    /**
     * Permet d'afficher la vue de modification d'une personne
     * 
     * Permet d'afficher la vue de modification d'une personne avec les informations de la personne
     * @param $id : identifiant de la personne à modifier
     */
    public function modif($id) {
        $this->load->model('M_Personnel');
        $data['chemin'] = '/ressource/v_addPersonnel';
        $data['id'] = $id;
        $personnel = $this->M_Personnel->getPersonneById($id);
        
        $data['nom'] = $personnel['txt_nom'];
        $data['prenom'] = $personnel['txt_prenom'];
        $data['type'] = $personnel['Type_nom'];
        $data['idRessource'] = $personnel['id_ressource'];
        $data['idType'] = $personnel['id_type'];
        
        $this->load->view('/V_generale', $data);
    }

    /**
     * Permet de supprimer une personne
     * 
     * Fonction permettant la suppression d'une personne en fonction de son id
     * @param $id : id de la personne à supprimer
     */
    public function suppr($id) {
        $this->load->model('M_Personnel');
        $this->M_Personnel->supprPersonne($id);

        $this->index();
    }

    /**
     * Permet de récupérer la liste de tous les types de personnels présentes 
     * dans la base de données
     * 
     * Permet de récupérer la liste de tous les types de personnels présentes 
     * dans la base de données et les retroune en format JSON
     */
    public function getTypes() {
        if (isset($_GET["term"])) {
            $this->load->model('M_TypeRessource');
            echo json_encode($this->M_TypeRessource->getTypesPersonnels(strtolower($_GET["term"])));
        }
    }

}

?>