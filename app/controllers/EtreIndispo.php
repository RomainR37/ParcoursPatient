<?php

/**
 * Contrôleur de gestion des indiponibilités des ressources humaines
 * 
 * Contient les différentes méthodes de gestion des indiponibilité des 
 * ressources humaines
 * 
 * @author    Guillaume Pochet
 * @version   1.0
 * @since     09 Mars 2017
 */
class EtreIndispo extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata("username") === null)
            redirect('/Auth', 'refresh');
        if ($this->session->userdata("level") === "1")
            redirect('/AffichageSejour', 'refresh');
    }

    /**
     * Permet d'afficher les différentes indisponibilités d'une ressource
     * 
     * Permet d'afficher les différentes indisponibilités d'une ressource 
     * avec l'identifiant de la ressource en paramètre
     * 
     * @param $id : identifiant de la ressource
     */
    public function afficher($id) {
        $this->load->model('M_EtreIndispo');

        $data = array();
        $data['chemin'] = '/ressource/v_indispo.php';
        $data['nom_personnel'] = $this->M_EtreIndispo->getNomPersonnel($id);

        $data['indispo'] = $this->M_EtreIndispo->getIndispoByIdRessource($id);
        $data['id_personnel'] = $id;

        $this->load->view('/V_generale', $data);
    }

    /**
     * Permet de supprimer une indisponibilité d'une ressource
     */
    public function supprimerIndispo() {
        $this->load->model('M_EtreIndispo');
        $id = 0;
        $idPerso = 0;
        if (isset($_POST) && isset($_POST["id"])) {
            $id = $_POST["id"];

            if (isset($_POST["idPerso"])) {
                $idPerso = $_POST["idPerso"];
            }
            $this->M_EtreIndispo->supprimerIndispoById($id);
        }


        $data = [];
        $data['nom_personnel'] = $this->M_EtreIndispo->getNomPersonnel($idPerso);

        $data['indispo'] = $this->M_EtreIndispo->getIndispoByIdRessource($idPerso);
        $data['id_personnel'] = $idPerso;

        echo json_encode($this->load->view('/ressource/table_indispo', $data, TRUE));
    }

    /**
     * Permet de formaliser les données sous forme de tableau
     * 
     * Permet de formaliser les données sous forme de tableau 
     * (id_personnel : , date_début : , date_fin : )
     * @param $old : liste des indispos
     */
    public function formaliserData($old) {
        $res = array();
        $i = 0;
        while ($i < count($old['datedebutnew'])) {
            $res[$i]['id_personnel'] = $old['idpersonnelnew'][$i];
            $res[$i]['date_debut'] = $old['datedebutnew'][$i];
            $res[$i]['date_fin'] = $old['datefinnew'][$i];
            $i++;
        }
        return $res;
    }

    /**
     * Permet de sauvergarder les changements d'indisponibiltés
     */
    public function savechanges() {
        $this->load->model('M_EtreIndispo');

        //s'il y a des modifications
        if (isset($_POST["id_indispo_0"]) && isset($_POST["id_personnel_0"]) && isset($_POST["datedebut_0"]) && isset($_POST["datefin_0"])) {
            $nb = 0;
            if (isset($_POST["nb_indispo"]))
                $nb = $_POST["nb_indispo"];
            $dataModif = array();
            $i = 0;
            while ($i < $nb) {
                $dataModif[$i]["id_indispo"] = $_POST["id_indispo_" . $i];
                $dataModif[$i]["id_personnel"] = $_POST["id_personnel_" . $i];
                $dataModif[$i]["date_debut"] = $_POST["datedebut_" . $i];
                $dataModif[$i]["date_fin"] = $_POST["datefin_" . $i];
                $i++;
            }
            if (isset($_POST["id_personnel_0"])) {
                $idpersonnel = $_POST["id_personnel_0"][0];
            }
            $this->M_EtreIndispo->modifierIndispo($dataModif);
        }
        //s'il y a des ajouts d'indisponibilités
        if (isset($_POST["newdatedebut"]) && isset($_POST["newdatefin"]) && isset($_POST["newidpersonnel"])) {
            $temp = array();
            $temp['datedebutnew'] = $_POST["newdatedebut"];
            $temp['datefinnew'] = $_POST["newdatefin"];
            $temp['idpersonnelnew'] = $_POST["newidpersonnel"];

            $idpersonnel = $_POST["newidpersonnel"][0];
            $dataNew = $this->formaliserData($temp);
            $this->M_EtreIndispo->ajoutIndispo($dataNew);
        }

        if (isset($idpersonnel)) {
            $this->afficher($idpersonnel);
        }
    }

}

?>