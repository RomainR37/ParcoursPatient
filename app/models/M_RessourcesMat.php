<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Définit les méthodes liées aux ressources matérielles.
 * 
 * Ce fichier permet de définir les méthodes de gestion des ressources 
 * matérielles (ajout, modification, suppression).
 * 
 * @author    Guillaume Pochet
 * @version   1.0
 * @since     09 Mars 2017
 */
class M_RessourcesMat extends CI_Model {

    /**
     * Récupère la liste des ressources matérielles
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
     * Récupère la liste des types de ressources matérielles
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
     * Récupère la ressource matérielle en fonction de son id
     * @param $id : id de la ressource matérielle
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
     * Supprime la ressource matérielle en fonction de son id
     * @param $id : id de la ressource matérielle à supprimer
     */
    public function supprRessourcesMat($id) {
        $sql = "SELECT E.end 
                    FROM evenement E
                    INNER JOIN salle S
                    ON S.id_ressource = E.ressourceId
                    WHERE S.id_salle = " . $this->db->escape($id);
        $query = $this->db->query($sql);
        $End = array();
        foreach($query->result() as $row){
                            if(!empty($row)){
                            $End["end"] = $row->end;
                            $sql = "DELETE FROM evenement WHERE evenement.end = ". $this->db->escape($End["end"]);
                            $query = $this->db->query($sql);
                            $sql = "DELETE FROM ordonnancer WHERE ordonnancer.end = ". $this->db->escape($End["end"]);
                            $query = $this->db->query($sql);
                            }
                    }
        
        $txt_sql = "DELETE S, R
                        FROM salle S 
                        LEFT JOIN ressource R
                        ON R.id_ressource = S.id_ressource
			WHERE S.id_salle = " . $this->db->escape($id);
        $query = $this->db->query($txt_sql);  
        
        
        
       
    }

    /**
     * Modifie une ressource matérielle
     * @param $salle : nouveau nom de la ressource
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
     * Ajoute une ressource matérielle
     * @param $salle : nom de la ressource à ajouter
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
