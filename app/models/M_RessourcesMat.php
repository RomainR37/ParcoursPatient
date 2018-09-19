<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * \file      M_RessourcesMat.php
 * \author    Guillaume Pochet
 * \version   1.0
 * \date      09 Mars 2017
 * \brief     Définit les méthodes liées aux ressources matérielles
 *
 * \details   Ce fichier permet de définir les méthodes de gestion des ressources matérielles (ajout, modification, suppression)
 */
class M_RessourcesMat extends CI_Model {

    /**
     * \brief      Récupére toute la liste des ressources matérielles
     * \details    Récupére toute la liste des ressources matérielles
     * \param      Aucun
     */
    public function getAllRessourcesMat() {
        $txt_sql = "SELECT S.id_salle,S.txt_nom, TR.txt_nom as Type_nom
			FROM salle S, typeressource TR, ressource R
			WHERE S.id_ressource = R.id_ressource
			AND R.id_typeressource = TR.id_typeressource";
        $query = $this->db->query($txt_sql);
        $res = array();

        foreach ($query->result() as $row) {
            $restemp = array();

            $restemp["id_salle"] = $row->id_salle;
            $restemp["txt_nom"] = $row->txt_nom;
            $restemp["type"] = $row->Type_nom;
            array_push($res, $restemp);
        }
        return $res;
    }

    /**
     * \brief      Récupére toute la liste des types de ressources matérielles
     * \details    Récupére toute la liste des types de ressources matérielles
     * \param      Aucun
     */
    public function getAllTypeRessourcesMat() {
        //	On simule l'envoi d'une requête
        $txt_sql = "SELECT TR.id_typeressource,TR.txt_nom
			FROM salle S, typeressource TR, ressource R
			WHERE S.id_ressource = R.id_ressource
			AND R.id_typeressource = TR.id_typeressource";
        $query = $this->db->query($txt_sql);
        $res = array();

        foreach ($query->result() as $row) {
            $restemp = array();

            $restemp["id_typeressource"] = $row->id_typeressource;
            $restemp["txt_nom"] = $row->txt_nom;
            array_push($res, $restemp);
        }
        return $res;
    }

    /**
     * \brief      Récupére la ressource matérielle en fonction de son id
     * \details    Récupére la ressource matérielle en fonction de son id
     * \param      $id : id de la ressource matérielle
     */
    public function getRessourcesMatById($id) {
        $txt_sql = "SELECT S.id_salle,S.txt_nom, TR.txt_nom as Type_nom, S.id_ressource, TR.id_typeressource as id_type
			FROM salle S, typeressource TR, ressource R
			WHERE S.id_ressource = R.id_ressource
			AND R.id_typeressource = TR.id_typeressource
			AND S.id_salle =" . $id;
        $query = $this->db->query($txt_sql);

        return $query->row_array();
    }

    /**
     * \brief      Supprime la ressource matérielle en fonction de son id
     * \details    Supprime la ressource matérielle en fonction de son id
     * \param      $id : id de la ressource matérielle à supprimer
     */
    public function supprRessourcesMat($id) {
        $txt_sql = "DELETE FROM salle
			WHERE id_salle = " . $id;
        $txt_sql2 = "DELETE FROM ordonnancer O 
                        LEFT JOIN salle S
                        ON O.ressourceId = S.id_ressource 
                        WHERE S.ID_SALLE = ". $id;       
        $txt_sql2 = "DELETE FROM evenement E 
                        LEFT JOIN salle S
                        ON E.ressourceId = S.id_ressource 
                        WHERE S.ID_SALLE = ". $id; 
        $query = $this->db->query($txt_sql);
        $query2 = $this->db->query($txt_sql2);
        $query3 = $this->db->query($txt_sql3);
       
    }

    /**
     * \brief      Modifie une ressource matérielle
     * \details    Modifie une ressource matérielle
     * \param      $salle : nouveau nom de la ressource
     */
    public function ModifRessourcesMat($salle) {
        //	On simule l'envoi d'une requête
        $this->load->model('M_TypeRessource');

        $txt_sql = "UPDATE salle
                    SET txt_nom = " . $this->db->escape($salle['nom']) .
                " WHERE id_salle=" . $this->db->escape($salle['id']);
        $query = $this->db->query($txt_sql);

        if ($salle['idType'] == -1) {
            $salle['idType'] = $this->M_TypeRessource->insererType($salle['type']);
        }

        $txt_sql = "UPDATE ressource
                    SET id_typeressource = " . $this->db->escape($salle['idType']) . "
                    WHERE id_ressource=" . $this->db->escape($salle['idRessource']);
        $query = $this->db->query($txt_sql);
    }

    /**
     * \brief      Ajoute une ressource matérielle
     * \details    Ajoute une ressource matérielle
     * \param      $salle : nom de la ressource à ajouter
     */
    public function ajouteRessourcesMat($salle) {
        $this->load->model('M_TypeRessource');
        $this->load->model('M_Ressource');

        if ($salle['idType'] == -1) {
            $salle['idType'] = $this->M_TypeRessource->insererType($salle['type']);
        }

        $salle['idRessource'] = $this->M_Ressource->insererRessource($salle['idType']);

        $txt_sql = "INSERT INTO salle
                    (id_salle,id_ressource,txt_nom)        
                    VALUES(" . $salle['idRessource'] . "," . $salle['idRessource'] . "," . $this->db->escape($salle['nom']) . ")";
        $this->db->query($txt_sql);
    }

}
