<?php

/**
 * \file      PlanParcours.php
 * \author    Guillaume Pochet
 * \version   1.0
 * \date      09 Mars 2017
 * \brief     Controller de gestion des plan parcours
 *            
 *
 * \details   Controller de gestion des plan parcours
 *            Nombre de clients attendus par jour pour un parcours donné
 */
class PlanParcours extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata("username") === null)
            redirect('/Auth', 'refresh');
        if ($this->session->userdata("level") === "1")
            redirect('/AffichageSejour', 'refresh');
    }

    /**
     * \brief      Permet d'afficher la liste de tous les parcours
     * \details    Permet d'afficher la liste de tous les parcours et de tout leur nombre de patients attendus pour une semaine
     * \param      Aucun
     */
    public function index() {

        $this->load->model('M_PlanParcours');
        $data = array();
        $data['planparcours'] = $this->M_PlanParcours->getAllPlanParcours();
        $data['nomparcours'] = $this->M_PlanParcours->getNomParcours();
        $data['chemin'] = '/parcours/V_planparcours';
        $this->load->view('/V_generale', $data);
    }

    /**
     * \brief      Permet d'afficher la liste d'un parcours de leurs objetifs
     * \details    cette fonction prend le ID du parcours choisi et construit un nouveau tableau qui contient que les infos du parcours choisi
     * \param      Aucun
     */
    public function afficheParcours() {
        $this->load->model('M_PlanParcours');
        $data = array();

        //récupérer l'id choisi
        $id = 0;
        if (isset($_POST) && isset($_POST["id"])) {
            $id = $_POST["id"];
        }

        //selectionner les info du parcous choisi dans la BdD
        $data['id'] = $id;
        if ($id == 0) {
            $data['planparcours'] = $this->M_PlanParcours->getAllPlanParcours();
        } else {
            $data['planparcours'] = $this->M_PlanParcours->getPlanParcoursById($id);
        }

        //afficher le nouveau tableau
        echo '<table id="mytable" class="table table-responsive table-hover">
			<thead>         
				<tr>
					<th class="col-xs-1">Parcours</th>
					<th class="col-xs-1">Jour</th>
					<th class="col-xs-1">NB Patient</th>
				</tr>
			</thead>';
        echo '<form id="newform" method="POST">';
        echo "<tbody id='dataform'>";
        foreach ($data['planparcours'] as $row) {
            echo '<tr>';
            echo "<td>" . $row["nom_parcours"] . "</td>";
            echo "<td>" . $row["jour"] . "</td>";
            echo "<input name='id_parcours[]' type='hidden' value='" . $row["id_parcours"] . "'/>";
            echo "<input name='info_jour[]' type='hidden' value='" . $row["jour"] . "'/>";
            echo "<td><input name='info_nb[]' type='number' value='" . $row["nb_patient"] . "' style='width:45px' onchange=\"$(this).attr('value',$(this).val().toString())\" min=0 max=10 /></td>";
            echo '</tr>';
        }
        echo '</tbody>
		</form>
		</table>';
    }

    /**
     * \brief      Permet d'enregistrer les modifications sur les plan parcours
     * \details    Permet d'enregistrer les modifications sur les plan parcours dans la base de données
     * \param      Aucun
     */
    public function savechanges() {

        //print_r($_POST);
        $this->load->model('M_PlanParcours');

        $data = array();
        //$idparcours=$_POST["selectedid"];
        $data["idparcours"] = $_POST["id_parcours"];
        $data["jour"] = $_POST["info_jour"];
        $data["nbr"] = $_POST["info_nb"];

        //echo $idparcours."\n";
        foreach ($data["jour"] as $jour)
            echo $jour . "\n";
        foreach ($data["nbr"] as $nbr)
            echo $nbr . "\n";
        foreach ($data["idparcours"] as $id)
            echo $id . "\n";

        $res = $this->M_PlanParcours->modiferallplanparcours($data);

        echo $res;
    }

}

?>