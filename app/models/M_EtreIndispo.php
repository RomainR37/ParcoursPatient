<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Définit les méthodes liées aux différentes indisponibilités des ressources 
 * humaines.
 * 
 * Ce fichier permet de définir les méthodes de gestion d'indiponibilités des 
 * ressources humaines.
 * 
 * @author    Guillaume Pochet
 * @version   1.0
 * @since     09 Mars 2017
 */
class M_EtreIndispo extends CI_Model {

    /**
     * Fonction de récupération des indiponibiltés d'une ressource en fonction de son id
     * @param $id : id de la ressource
     */
    public function getIndispoByIdRessource($id) {
        $txt_sql = "SELECT ID_ETREINDISPONIBLE, DATE_DEBUT, DATE_FIN
		FROM etreindisponible
		WHERE ID_RESSOURCE = " . $id;

        $query = $this->db->query($txt_sql);
        $res = array();

        foreach ($query->result() as $row) {
            $restemp["id_eindispo"] = $row->ID_ETREINDISPONIBLE;
            $restemp["date_debut"] = $row->DATE_DEBUT;
            $restemp["date_fin"] = $row->DATE_FIN;
            array_push($res, $restemp);
        }
        return $res;
    }

    /**
     * Récupère le nom d'une personne en fonction de son id
     * @param $id : id de la personne
     */
    public function getNomPersonnel($id) {
        $txt_sql = "
			SELECT TXT_NOM, TXT_PRENOM
			FROM personnel
			WHERE ID_PERSONNEL = " . $id;

        $query = $this->db->query($txt_sql);
        $row = $query->row();
        $nom = $row->TXT_NOM;
        $prenom = $row->TXT_PRENOM;
        $res = $nom . " " . $prenom;

        return $res;
    }

    /**
     * Supprime une indispo d'une resource en fonction de son id
     * @param $id : id de la personne
     */
    public function supprimerIndispoById($id) {
        $txt_sql = "
			DELETE from etreindisponible
			WHERE ID_ETREINDISPONIBLE = " . $id;

        $query = $this->db->query($txt_sql);
    }

    /**
     * Modifie une indisponibilité d'une ressource 
     * @param $data : tableau avec la date de début, de fin et l'identifiant de 
     * la ressource à modifier
     */
    public function modifierIndispo($data) {
        $i = 0;
        while ($i < count($data)) {
            $txt_sql = "UPDATE etreindisponible
					SET DATE_DEBUT=" . $this->db->escape($data[$i]['date_debut']) . ", DATE_FIN=" . $this->db->escape($data[$i]['date_fin']) . "
					WHERE ID_ETREINDISPONIBLE=" . $data[$i]['id_indispo'];

            $query = $this->db->query($txt_sql);
            $i++;
        }
    }

    /**
     * Ajoute une indispo à une resource
     * @param $data : contient les données à ajouter ainsi que l'id de ressource
     */
    public function ajoutIndispo($data) {
        $i = 0;
        while ($i < count($data)) {
            $data[$i]['id_indispo'] = $this->getMaxIDIndispo();
            $txt_sql = "INSERT INTO etreindisponible 
				VALUES('" . $data[$i]['id_indispo'] . "'," . $this->db->escape($data[$i]['id_personnel']) . "," . $this->db->escape($data[$i]['date_debut']) . ", " . $this->db->escape($data[$i]['date_fin']) . ")";

            $query = $this->db->query($txt_sql);
            $i++;
        }
    }

    /**
     * Retourne l'id max des indipos
     */
    public function getMaxIDIndispo() {
        $txt_sql = "SELECT MAX(ID_ETREINDISPONIBLE) as id
                    FROM etreindisponible";
        $query = $this->db->query($txt_sql);
        if ($query->num_rows() == 0)
            retrun(1);
        $row = $query->row_array();
        return $row['id'] + 1;
    }

}

?>