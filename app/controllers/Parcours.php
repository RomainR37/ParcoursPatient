<?php

/**
 * \file      Parcours.php
 * \author    Guillaume Pochet
 * \version   1.0
 * \date      09 Mars 2017
 * \brief     Controller d'un parcours patients
 *            
 *
 * \details   Contient les différentes méthodes de gestion des parcours patients
 */
class Parcours extends CI_Controller {

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
     * \brief      Permet d'afficher les différentes parcours patients présents dans notre système
     * \details    Méthode permettant la liaison entre la vue des parcours et le modèle parcours
     *             Récupére tous les parcours et les envoie à la vue qui se charge de les afficher
     * \param      Aucun
     */
    public function index() {
        $this->load->model('M_Parcours');
        $data = array();
        //	On lance une requête
        $data['parcours'] = $this->M_Parcours->getAllParcours();

        $data['chemin'] = '/parcours/V_parcours';

        $this->load->view('/V_generale', $data);
    }

    /**
     * \brief      Permet d'ajouter un parcours 
     * \details    Fonction permettant d'afficher la vue d'ajout d'un nouvueau parcours
     * \param      Aucun
     */
    public function ajout() {
        $this->load->model('M_Parcours');
        $data['chemin'] = '/parcours/v_addParcours';
        $data['id'] = -1;
        $data['nom'] = "";
        //$data['objectif'] = 0;
        $data['code'] = "";
        $data['activites'] = array();
        $data['precedences'] = array();
        $data["listeActivites"] = "vide";
        $data["listePrecedences"] = "vide";
        $this->load->view('/V_generale', $data);
    }

    /**
     * \brief      Permet de supprimer un parcours
     * \details    Fonction permettant la suppression d'un parcours en fonction de son id
     * \param      $id : id du parcours à supprimer
     */
    public function supprimer($id) {
        $this->load->model('M_Parcours');
        $this->M_Parcours->supprimerParcours($id);
        $this->index();
    }

    /**
     * \brief      Permet de récupérer toute les activites lié à un parcours
     * \details    Permet de récupérer toute les activites lié à un parcours
     * \param      Aucun
     */
    public function getAllActivites() {
        if (isset($_GET["term"])) {
            $this->load->model('M_Activite');
            echo json_encode($this->M_Activite->getListeActivites(strtolower($_GET["term"])));
        }
    }

    /**
     * \brief      Permet d'ajouter ou de modifier un parcours patient
     * \details    Permet d'ajouter ou de modifier un parcours patient
     *             Récupére la liste des informations d'un parcours (ajout ou modification) et les ajoute en base de données
     * \param      Aucun
     */
    public function confirmModif() {
        $this->load->model('M_Parcours');
        $parcours = array();
        $parcours['nom'] = "";
        $parcours['code'] = "";
        //$parcours['objectif'] = "";
        $parcours['id'] = "";
        /*
        if (isset($_POST['nom']) && isset($_POST['code']) && isset($_POST['objectif']) && isset($_POST['id'])) {
            $parcours['nom'] = $_POST['nom'];
            $parcours['code'] = $_POST['code'];
            $parcours['objectif'] = $_POST['objectif'];
            $parcours['id'] = $_POST['id'];
        }*/
        if (isset($_POST['nom']) && isset($_POST['code']) && isset($_POST['id'])) {
            $parcours['nom'] = $_POST['nom'];
            $parcours['code'] = $_POST['code'];
            
            $parcours['id'] = $_POST['id'];
        }
        $parcours["precedences"] = array();

        // on récupère les informations liées aux activités et leur précédence
        if (isset($_POST["activite"])) {
            $activites = $_POST["activite"];
            $precedence = array();
            if (isset($_POST["idActivite"]) && isset($_POST["idPrec"])) {
                $idActivite = $_POST["idActivite"];
                $idPrec = $_POST["idPrec"];
                $delaiMin = $_POST["delaiMin"];
                $delaiMax = $_POST["delaiMax"];
                for ($i = 0; $i < count($idActivite); $i++) {
                    $row = array();
                    $row['idActivite'] = $idActivite[$i];
                    $row['idPrec'] = $idPrec[$i];
                    if (intval($delaiMin[$i]) <= intval($delaiMax[$i])) {
                        $row['delaiMin'] = $delaiMin[$i];
                        $row['delaiMax'] = $delaiMax[$i];
                    } else { // Il ne faut pas qu'un delai min soit supérieur à un délai max
                        $row['delaiMin'] = '';
                        $row['delaiMax'] = '';
                    }
                    array_push($precedence, $row);
                }
            }

            // on formate les données pour une plus grande facilité lors de l'ajout en base de données
            if ($activites != null) {
                foreach ($activites as $a) {
                    $hasPrec = false;
                    foreach ($precedence as $p) {
                        if ($p["idActivite"] == $a) {
                            array_push($parcours["precedences"], $p);
                            $hasPrec = true;
                        }
                    }
                    if ($hasPrec == false) {
                        $row = array();
                        $row['idActivite'] = $a;
                        $row['idPrec'] = '0';
                        $row['delaiMin'] = '0';
                        $row['delaiMax'] = '0';
                        array_push($parcours["precedences"], $row);
                    }
                }
            }
            if ($parcours['id'] == -1) {
                $this->M_Parcours->ajouteParcours($parcours);
            } else {
                $this->M_Parcours->modifParcours($parcours);
            }
            $this->index();
        }
    }

    /**
     * \brief      Permet d'afficher la vue de modification d'un parcours
     * \details    Permet d'afficher la vue de modification d'un parcours
     * \param      $id : identifiant du parcours à modifier
     */
    public function modif($id) {
        $this->load->model('M_Parcours');
        $data['chemin'] = '/parcours/v_addParcours';
        $parcours = $this->M_Parcours->getParcoursById($id);
        $activites = $this->M_Parcours->getActiviteParcoursByIdToJson($id);
        $precedences = $this->M_Parcours->getDependencesActivitesToJson($id);
        $data["listeActivites"] = $activites;
        $data["listePrecedences"] = $precedences;
        $data["id"] = $id;
        $data["nom"] = $parcours["nom"];
        //$data["objectif"] = $parcours["objectif"];
        $data["code"] = $parcours["code"];
        $data["activites"] = $parcours["activites"];
        $data["precedences"] = $parcours["precedences"];
        $this->load->view('/V_generale', $data);
    }

    /**
     * \brief      Permet d'afficher la vue de visualisation d'un parcours
     * \details    Permet d'afficher la vue de visualisation d'un parcours
     * \param      $id : identifiant du parcours à visualiser
     */
    public function visualiser($id) {
        $this->load->model('M_Parcours');
        $data['chemin'] = '/parcours/v_VisualiserParcours';
        $parcours = $this->M_Parcours->getParcoursById($id);
        $activites = $this->M_Parcours->getActiviteParcoursByIdToJson($id);
        $precedences = $this->M_Parcours->getDependencesActivitesToJson($id);
        $data["id"] = $id;
        $data["nom"] = $parcours["nom"];
        //$data["objectif"] = $parcours["objectif"];
        $data["code"] = $parcours["code"];
        $data["activites"] = $parcours["activites"];
        $data["precedences"] = $parcours["precedences"];
        $data["listeActivites"] = $activites;
        $data["listePrecedences"] = $precedences;
        $this->load->view('/V_generale', $data);
    }

}

?>