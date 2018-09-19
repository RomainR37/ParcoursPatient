<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * \file      M_TypeRessource.php
 * \author    Guillaume Pochet
 * \version   1.0
 * \date      09 Mars 2017
 * \brief     Définit les méthodes liées aux différents types de ressources
 *
 * \details   Ce fichier permet de définir les méthodes de gestion des types de ressources
 */
class M_TypeRessource extends CI_Model {

    /**
     * \brief      Permet de récupérer l'id d'un type de ressource en fonction de son nom
     * \details    Permet de récupérer l'id d'un type de ressource en fonction de son nom
     * \param      $nomtype : nom du type de ressource
     */
    public function getIdType($nomType) {
        $this->db->select('id_typeressource');
        $query = $this->db->get_where('TypeRessource', array('txt_nom' => $nomType));
        $res = array();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $res["id"] = $row->id_typeressource;
        }
        return $res;
    }

    /**
     * \brief      Permet de récupérer les types de ressources humaines en fonction du type d'une ressource
     * \details    Permet de récupérer les types de ressources humaines en fonction du type d'une ressource
     * \param      $nom : nom du type de ressource
     */
    public function getTypesPersonnels($nom) {
        $txt_sql = "SELECT TR.id_typeressource, TR.txt_nom
            FROM typeressource TR
            WHERE TR.txt_nom LIKE '%" . $this->db->escape_str($nom) . "%'" .
                "AND EXISTS(SELECT * FROM personnel P, ressource R WHERE P.id_ressource = R.id_ressource AND TR.id_typeressource = R.id_typeressource)";
        $query = $this->db->query($txt_sql);
        $result = [];

        $new_row["value"] = $nom;
        $new_row["id"] = -1;
        $result[] = $new_row;

        foreach ($query->result() as $row) {
            $new_row["value"] = $row->txt_nom;
            $new_row["id"] = $row->id_typeressource;
            $result[] = $new_row;
        }
        return $result;
    }

    /**
     * \brief      Permet de récupérer les types de ressources matérielles en fonction du type d'une ressource
     * \details    Permet de récupérer les types de ressources matérielles en fonction du type d'une ressource
     * \param      $nom : nom du type de ressource
     */
    public function getTypesRessourcesMat($nom) {
        $txt_sql = "SELECT TR.id_typeressource, TR.txt_nom
            FROM typeressource TR
            WHERE TR.txt_nom LIKE '%" . $this->db->escape_str($nom) . "%'" .
                "AND EXISTS(SELECT * FROM salle P, ressource R WHERE P.id_ressource = R.id_ressource AND TR.id_typeressource = R.id_typeressource)";
        $query = $this->db->query($txt_sql);
        $result = [];

        $new_row["value"] = $nom;
        $new_row["id"] = -1;
        $result[] = $new_row;

        foreach ($query->result() as $row) {
            $new_row["value"] = $row->txt_nom;
            $new_row["id"] = $row->id_typeressource;
            $result[] = $new_row;
        }
        return $result;
    }

    /**
     * \brief      Permet de récupérer les types de ressources humaines liées aux différentes activités en fonction du type d'une ressource
     * \details    Permet de récupérer les types de ressources humaines liées aux différentes activités en fonction du type d'une ressource
     * \param      $nom : nom du type de ressource
     */
    public function getTypesPersonnelsActivite($nom) {
        $txt_sql = "SELECT TR.id_typeressource, TR.txt_nom
            FROM typeressource TR
            WHERE TR.txt_nom LIKE '%" . $this->db->escape_str($nom) . "%'" .
                "AND EXISTS(SELECT * FROM personnel P, ressource R WHERE P.id_ressource = R.id_ressource AND TR.id_typeressource = R.id_typeressource)";
        $query = $this->db->query($txt_sql);
        $result = [];

        foreach ($query->result() as $row) {
            $new_row["value"] = $row->txt_nom;
            $new_row["id"] = $row->id_typeressource;
            $result[] = $new_row;
        }
        return $result;
    }

    /**
     * \brief      Permet de récupérer les types de ressources matérielles liées aux différentes activités en fonction du type d'une ressource
     * \details    Permet de récupérer les types de ressources matérielles liées aux différentes activités en fonction du type d'une ressource
     * \param      $nom : nom du type de ressource
     */
    public function getTypesRessourcesMatActivite($nom) {
        $txt_sql = "SELECT TR.id_typeressource, TR.txt_nom
            FROM typeressource TR
            WHERE TR.txt_nom LIKE '%" . $this->db->escape_str($nom) . "%'" .
                "AND EXISTS(SELECT * FROM salle P, ressource R WHERE P.id_ressource = R.id_ressource AND TR.id_typeressource = R.id_typeressource)";
        $query = $this->db->query($txt_sql);
        $result = [];

        foreach ($query->result() as $row) {
            $new_row["value"] = $row->txt_nom;
            $new_row["id"] = $row->id_typeressource;
            $result[] = $new_row;
        }
        return $result;
    }

    /**
     * \brief      Permet d'insérer un nouveau type dans la base de données
     * \details    Permet d'insérer un nouveau type dans la base de données
     * \param      $nomType : nom du type de ressource à insérer
     */
    public function insererType($nomType) {
        $id = $this->getMaxID();
        $txt_sql = "INSERT INTO typeressource(id_typeressource,txt_nom) VALUES(" . $id . "," . $this->db->escape($nomType) . ")";
        $query = $this->db->query($txt_sql);
        return $id;
    }

    /**
     * \brief      Récupére l'id max d'un type ressource
     * \details    Récupére l'id max d'un type ressource
     * \param      Aucun
     */
    public function getMaxID() {
        $txt_sql = "SELECT MAX(id_typeressource) as id
                    FROM typeressource";
        $query = $this->db->query($txt_sql);
        $row = $query->row_array();

        return $row['id'] + 1;
    }

}

?>