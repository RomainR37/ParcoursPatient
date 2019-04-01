<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Définit les méthodes liées à la composition des parcours patients
 * 
 * Ce fichier permet de définir les méthodes de gestion des parcours patients.
 * Affichage des précédences de chaque activité du parcours.
 * 
 * @author    Guillaume Pochet
 * @version   1.0
 * @since     09 Mars 2017
 */
class M_Composer extends CI_Model {

    /**
     * Supprime toutes les précédences d'un parcours en fonction de son id
     * @param $idParcours : l'id du parcours
     */
    public function deleteAllCompo($idParcours) {
        $txt_sql = "DELETE FROM composer
			WHERE id_parcours = " . $idParcours;
        $query = $this->db->query($txt_sql);
    }

    /**
     * Ajoute des liens de précédences entre les activités du parcours en 
     * fonction de son id.
     * @param $idParcours : l'id du parcours
     * @param $precedence : contient toutes les informations de précédences de 
     * chaque activité du parcours
     */
    public function addCompo($idParcours, $precedence) {
        if ($precedence['delaiMin'] == NULL)
            $queryDelaiMin = '0';
        else
            $queryDelaiMin = $precedence['delaiMin'];

        if ($precedence['delaiMax'] == NULL)
            $queryDelaiMax = '0';
        else
            $queryDelaiMax = $precedence['delaiMax'];

        $txt_sql = "INSERT INTO composer
        			(id_parcours, id_activite, id_activite_precedente,int_delaimin,int_delaimax)
                   VALUES(" . $idParcours . "," . $precedence['idActivite'] . "," . $precedence['idPrec'] . "," . $queryDelaiMin . "," . $queryDelaiMax . ")";
        $query = $this->db->query($txt_sql);
    }

}
