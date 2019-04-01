<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Définit les méthodes liées aux nombre maximum de patients qu'un parcours 
 * peut accueillir par jour
 * 
 * Ce fichier permet de définir la méthode d'authentification
 * @author    Guillaume Pochet
 * @version   1.0
 * @since     09 Mars 2017
 */
class M_PlanParcours extends CI_Model {

    /**
     * Retourne toutes les informations de tous les parcours
     */
    public function getAllPlanParcours() {
        $txt_sql = "SELECT PL.ID_PARCOURS, TXT_NOM, TXT_JOUR, INT_NB_PATIENT
			FROM planparcours PL, parcours PA, jour JO
			WHERE PL.ID_PARCOURS=PA.ID_PARCOURS AND PL.ID_JOUR=JO.ID_JOUR
                        ORDER BY PL.ID_PARCOURS;
			";
        $query = $this->db->query($txt_sql);
        $res = array();

        foreach ($query->result() as $row) {
            $restemp = array();

            $restemp["id_parcours"] = $row->ID_PARCOURS;
            $restemp["nom_parcours"] = $row->TXT_NOM;
            $restemp["jour"] = $row->TXT_JOUR;
            $restemp["nb_patient"] = $row->INT_NB_PATIENT;
            array_push($res, $restemp);
        }
        return $res;
    }

    /**
     * Retourne le nom de tous les parcours
     */
    public function getNomParcours() {
        $txt_sql = "SELECT DISTINCT PL.ID_PARCOURS, TXT_NOM
			FROM planparcours PL, parcours PA
			WHERE PL.ID_PARCOURS=PA.ID_PARCOURS
			";
        $query = $this->db->query($txt_sql);
        $res = array();

        foreach ($query->result() as $row) {
            $restemp = array();
            $restemp["id_parcours"] = $row->ID_PARCOURS;
            $restemp["nom_parcours"] = $row->TXT_NOM;
            array_push($res, $restemp);
        }
        return $res;
    }

    /**
     * Retourne toutes les informations d'un parcours en fonction de son id
     * @param $id : id du parcours
     */
    public function getPlanParcoursById($id) {
        $txt_sql = "SELECT PL.ID_PARCOURS, TXT_NOM, TXT_JOUR, INT_NB_PATIENT
			FROM planparcours PL, parcours PA, jour JO
			WHERE PL.ID_PARCOURS=PA.ID_PARCOURS AND PL.ID_JOUR=JO.ID_JOUR 
                        AND PL.ID_PARCOURS=" . $id;

        $query = $this->db->query($txt_sql);
        $res = array();

        foreach ($query->result() as $row) {
            $restemp["id_parcours"] = $row->ID_PARCOURS;
            $restemp["nom_parcours"] = $row->TXT_NOM;
            $restemp["jour"] = $row->TXT_JOUR;
            $restemp["nb_patient"] = $row->INT_NB_PATIENT;
            array_push($res, $restemp);
        }
        return $res;
    }

    /**
     * Retourne le nom d'un parcours en fonction de son id
     * @param $id : id du parcours
     */
    public function getNomParcoursById($id) {
        $txt_sql = "SELECT TXT_NOM
		FROM parcours
		WHERE ID_PARCOURS = " . $id;

        $query = $this->db->query($txt_sql);
        $row = $query->row();
        $res = $row->TXT_NOM;

        return $res;
    }

    /**
     * Modifie un parcours en fonction de son id
     * @param $data : les nouvelles données du parcours
     * @param $idparcours : id du parcours
     */
    public function modifierplanparcours($data, $idparcours) {
        $i = 0;
        while ($i < count($data['jour'])) {
            $txt_sql = "UPDATE planparcours
                    SET NB_PATIENT=" . $data['nbr'][$i] . "
                    WHERE JOUR='" . $data['jour'][$i] . "' AND ID_PARCOURS=" . $idparcours;
            $query = $this->db->query($txt_sql);
            $i++;
        }
        return $txt_sql;
    }

    /**
     * Modifie tous les parcours
     * @param $data : les nouvelles données des parcours
     */
    public function modifierallplanparcours($data) {
        $i = 0;
        while ($i < count($data['jour'])) {
            $txt_sql = "UPDATE planparcours
                    SET INT_NB_PATIENT=" . $data['nbr'][$i] . "
                    WHERE ID_JOUR='" . $data['jour'][$i] . "' AND ID_PARCOURS=" . $data['idparcours'][$i];
            $query = $this->db->query($txt_sql);
            $i++;
        }
        return $txt_sql;
    }

    /**
     * Retourne l'id du jour de la semaine en fonction de son nom
     * @param $name : nom du jour
     */
    public function getIdJourByJour($name) {
        $i = 0;
        
        $res = array();
        
        while($i < count($name)){
            $txt_sql = "SELECT ID_JOUR
            FROM jour
            WHERE TXT_JOUR = " . $this->db->escape($name[$i]);

            $query = $this->db->query($txt_sql);
            $row = $query->row();
            $res[] = $row->ID_JOUR;
            
            $i++;
        }
        
        return $res;
    }
    
}
