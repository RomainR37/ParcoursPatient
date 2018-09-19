<?php

/**
 * \file      Activites.php
 * \author    Guillaume Pochet
 * \version   1.0
 * \date      09 Mars 2017
 * \brief     Définit les méthodes liées aux activités
 *
 * \details   Ce fichier permet de définir les méthodes d'ajout, 
 *              de suppression et de modification lié aux activités
 */
class Activites extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata("username") === null)
            redirect('/Auth', 'refresh');
        if ($this->session->userdata("level") === "1")
            redirect('/AffichageSejour', 'refresh');
    }

    /**
     * \brief      Affichage la liste des différentes activités
     * \details    La méthode récupérer la liste des activités
     *             et envoie ces données sur la page V_activite.
     *             Cette page se charge d'afficher les données
     * \param      Aucun
     */
    public function index() {
        $this->load->model('M_Activite');
        $data = array();
        $data['activite'] = $this->M_Activite->getAllActivites();
        $data['chemin'] = '/activite/V_activite';
        $this->load->view('/V_generale', $data);
    }

    /**
     * \brief      Affichage d'un formulaire pour ajouter
     * \details    La méthode afffichage un formulaire vide
     *             d'ajout d'activité
     *             Cette page se charge d'afficher les données
     * \param      Aucun
     */
    public function ajout() {
        $this->load->model('M_Activite');
        $data['chemin'] = '/activite/v_addActivite';
        $data["id"] = -1;
        $data["nom"] = "";
        $data["duree"] = 0;
        $data["comm"] = "";
        $data["personnels"] = array();
        $data["ressourcesMat"] = array();

        $this->load->view('/V_generale', $data);
    }

    /**
     * \brief      Méthode permettant d'ajouter ou de modifier
     *             une activité
     * \details    Ajoute ou modifie en base de données les différentes
     *             données d'une activité en base de données
     *             (id, nom, duree, commentaire, idType)
     * \param      Aucun
     */
    public function confirmModif() {
        $this->load->model('M_Activite');
        $activite = array();

        // on verifie que les champs essentiels sont entrés
        if (isset($_POST["nom"]) && isset($_POST["duree"])) {
            // on rempli l'objet activite
            $activite["id"] = $_POST["id"];
            $activite["nom"] = $_POST["nom"];
            $activite["duree"] = $_POST["duree"];
            $activite["commentaire"] = $_POST["commentaire"];
            $besoins = array();

            if (isset($_POST["idType"]) && isset($_POST["qte"])) {
                $idTypes = $_POST["idType"];
                $qtes = $_POST["qte"];
                for ($i = 0; $i < count($idTypes); $i++) {
                    $row = array();
                    $row['idType'] = $idTypes[$i];
                    $row['qte'] = $qtes[$i];
                    array_push($besoins, $row);
                }
            }
            $activite["besoins"] = $besoins;

            if ($activite['id'] == -1)
                $this->M_Activite->ajouteActivite($activite);
            else
                $this->M_Activite->modifActivite($activite);
        }
        $this->index();
    }

    /**
     * \brief      Méthode permettant d'ajouter ou de modifier
     *             une activité
     * \details    Ajoute ou modifie en base de données les différentes
     *             données d'une activité en base de données
     *             (id, nom, duree, commentaire, idType)
     * \param      Aucun
     */
    public function confirmModifParcours() {
        $this->load->model('M_Activite');
        $activite = array();

        // on verifie que les champs essentiels sont entrés
        if (isset($_POST["nom"]) && isset($_POST["duree"])) {
            // on rempli l'objet activite
            $activite["id"] = $_POST["id"];
            $activite["nom"] = $_POST["nom"];
            $activite["duree"] = $_POST["duree"];
            $activite["commentaire"] = $_POST["commentaire"];
            $besoins = array();
            if (isset($_POST["idType"]) && isset($_POST["qte"])) {
                $idTypes = $_POST["idType"];
                $qtes = $_POST["qte"];
                for ($i = 0; $i < count($idTypes); $i++) {
                    $row = array();
                    $row['idType'] = $idTypes[$i];
                    $row['qte'] = $qtes[$i];
                    array_push($besoins, $row);
                }
            }
            $activite["besoins"] = $besoins;

            if ($activite['id'] == -1)
                echo json_encode($this->M_Activite->ajouteActivite($activite));
            else
                echo json_encode($this->M_Activite->modifActivite($activite));
        }
    }

    /**
     * \brief      Méthode permettant d'ajouter ou de modifier
     *             une activité dans un parcours
     * \details    Ajoute ou modifie en base de données les différentes
     *             données d'une activité d'un parcours en base de données
     *             (id, nom, duree, commentaire, idType)
     * \param      Aucun
     */
    public function ajoutActiviteParcours() {
        $this->load->model('M_Activite');
        $data = array();
        $data["id"] = -1;
        if (isset($_POST["idActivite"]))
            $data["id"] = $_POST["idActivite"];
        if ($data["id"] == -1) {
            // creation d'une activite
            if (isset($_POST["nomActivite"]))
                $data["nom"] = $_POST["nomActivite"];
            else
                $data["nom"] = "";
            $data["duree"] = 0;
            $data["comm"] = "";
            $data["personnels"] = array();
            $data["ressourcesMat"] = array();
        }
        else {
            // modification d'une activite
            $activite = $this->M_Activite->getActiviteById($data["id"]);
            $data["nom"] = $activite["nom_activite"];
            $data["duree"] = $activite["duree"];
            $data["comm"] = $activite["comm"];
            $data["personnels"] = $activite["personnels"];
            $data["ressourcesMat"] = $activite["ressourcesMat"];
        }
        echo json_encode($this->load->view('/activite/Div_addActivite', $data, TRUE));
    }

    /**
     * \brief      Affichage d'un formulaire pour modifier une acitvité
     * \details    Formulaire de modiication d'une activité
     * \param      $id de l'activité à modifier
     */
    public function modif($id) {
        $this->load->model('M_Activite');
        $data['chemin'] = '/activite/v_addActivite';


        $activite = $this->M_Activite->getActiviteById($id);
        $data["id"] = $id;
        $data["nom"] = $activite["nom_activite"];
        $data["duree"] = $activite["duree"];
        $data["comm"] = $activite["comm"];
        $data["personnels"] = $activite["personnels"];
        $data["ressourcesMat"] = $activite["ressourcesMat"];

        $this->load->view('/V_generale', $data);
    }

    /**
     * \brief      Supprimer une activité
     * \details    Supprime une activité de la base de données
     * \param      $id, id de l'acitivité
     */
    public function suppr($id) {
        $this->load->model('M_Activite');
        $this->load->model('M_Necessiter');
        $this->M_Necessiter->deleteAllBesoin($id);
        $this->M_Activite->supprActivite($id);

        $this->index();
    }

    /**
     * \brief      Récupére la liste des ressources humaines
     * \details    Récupére la liste des ressources humaines depuis
     *             la base de données
     * \param      Aucun
     */
    public function getTypesPerso() {
        if (isset($_GET["term"])) {
            $this->load->model('M_TypeRessource');
            echo json_encode($this->M_TypeRessource->getTypesPersonnelsActivite(strtolower($_GET["term"])));
        }
    }

    /**
     * \brief      Récupére la liste des ressources matérielles
     * \details    Récupére la liste des ressources matérielles depuis
     *             la base de données
     * \param      Aucun
     */
    public function getTypesRessourcesMat() {
        if (isset($_GET["term"])) {
            $this->load->model('M_TypeRessource');
            echo json_encode($this->M_TypeRessource->getTypesRessourcesMatActivite(strtolower($_GET["term"])));
        }
    }

}

?>