<?php

/**
 * La classe Activités définit les méthodes liées aux activités.
 * 
 * Ce fichier permet de définir les méthodes d'ajout, 
 * de suppression et de modification liées aux activités.
 * 
 * @author    Guillaume Pochet
 * @author    Romain Rousseau
 * @version   3.0
 * @since     09 Mars 2017
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
     * Affiche la liste des différentes activités
     * 
     * La méthode récupére la liste des activités
     * et envoie ces données sur la page V_activite.
     * Cette page se charge ensuite d'afficher les données.
     */
    public function index() {
        $this->load->model('M_Activite');
        $data = array();
        $data['activite'] = $this->M_Activite->getAllActivites();
        $data['chemin'] = '/activite/V_activite';
        $this->load->view('/V_generale', $data);
    }

    /**
     * Affichage d'un formulaire pour ajouter une activité
     * 
     * La méthode affiche un formulaire vide d'ajout d'activité
     * avec les informations nécessaires (l'id de l'activité, le nom,
     * la durée, les commentaires, le personnel associé et les ressources
     * matérielles.
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
     * Méthode permettant d'ajouter ou de modifier une activité.
     * 
     * Ajoute ou modifie en base de données les différentes
     * caractéristiques d'une activité en base de données
     * (id, nom, duree, commentaire, idType).
     */
    public function confirmModif() {
        $this->load->model('M_Activite');
        $activite = array();

        // on verifie que les champs essentiels sont entrés
        if (isset($_POST["nom"]) && isset($_POST["duree"])) {
            // on remplit l'objet activite
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
     * Méthode permettant d'ajouter ou de modifier une activité.
     * 
     * Ajoute ou modifie en base de données les différentes
     * données d'une activité en base de données
     * (id, nom, duree, commentaire, idType)
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
     * Méthode permettant d'ajouter ou de modifier une activité 
     * dans un parcours.
     * 
     * Ajoute ou modifie en base de données les différentes données 
     * d'une activité d'un parcours en base de données
     * (id, nom, duree, commentaire, idType)
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
     * Affichage d'un formulaire pour modifier une activité.
     * 
     * Formulaire de modification d'une activité.
     *
     * @param $id de l'activité à modifier
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
     * Supprimer une activité
     * 
     * Supprime une activité de la base de données avec l'id 
     * indiqué en paramètre.
     * 
     * @param  $id id de l'acitivité
     */
    public function suppr($id) {
        $this->load->model('M_Activite');
        $this->load->model('M_Necessiter');
        $this->M_Necessiter->deleteAllBesoin($id);
        $this->M_Activite->supprActivite($id);

        $this->index();
    }

    /**
     * Récupère la liste des ressources humaines.
     * 
     * Récupère la liste des ressources humaines depuis la base de données
     * 
     */
    public function getTypesPerso() {
        if (isset($_GET["term"])) {
            $this->load->model('M_TypeRessource');
            echo json_encode($this->M_TypeRessource->getTypesPersonnelsActivite(strtolower($_GET["term"])));
        }
    }

    /**
     * Récupère la liste des ressources matérielles
     * 
     * Récupère la liste des ressources matérielles depuis
     * la base de données.
     */
    public function getTypesRessourcesMat() {
        if (isset($_GET["term"])) {
            $this->load->model('M_TypeRessource');
            echo json_encode($this->M_TypeRessource->getTypesRessourcesMatActivite(strtolower($_GET["term"])));
        }
    }

}

?>