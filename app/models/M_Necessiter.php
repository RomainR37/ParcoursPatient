<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Définit les méthodes liées aux différents besoin d'une activité
 * 
 * Ce fichier permet de définir les méthodes d'ajout ou de suppression de besoin d'une activité
 * 
 * @author    Guillaume Pochet
 * @version   1.0
 * @since     09 Mars 2017
 */
class M_Necessiter extends CI_Model {

    /**
     * Supprime tous les besoins en type de ressource d'une activité
     * @param $idActivite : id de l'activité
     */
    public function deleteAllBesoin($idActivite) {
        $txt_sql = "DELETE FROM necessiter
			WHERE id_activite = " . $idActivite;
        $query = $this->db->query($txt_sql);
    }

    /**
     * Ajoute un besoin à une activité (id de l'activité, idTypeRessource, 
     * quantité)
     * @param $idActivite : id de l'activité
     * @param $idTypeRes : id du type de la ressource
     * @param $qte : quantité nécessaire
     */
    public function addBesoin($idActivite, $idTypeRes, $qte) {

        $txt_sql = "INSERT INTO necessiter
        			(id_activite,id_typeressource,quantite)
                   VALUES(" . $idActivite . "," . $idTypeRes . "," . $qte . ")";
        $query = $this->db->query($txt_sql);
    }

}
