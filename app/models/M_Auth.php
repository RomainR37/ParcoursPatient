<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Définit les méthodes liées à l'authentification
 * 
 * Ce fichier permet de définir la méthode d'authentification
 * 
 * @author    Guillaume Pochet
 * @version   1.0
 * @since     09 Mars 2017
 */
class M_Auth extends CI_Model {

    /**
     * Fonction de vérification du couple password login
     * 
     * Fonction de vérification du couple password login. Retourne le type de 
     * compte de l'utilisateur
     * 
     * @param $pseudo : login
     * @param $password : mot de passe
     */
    function login($pseudo, $password) {
        $txt_sql = "SELECT c.ID_TYPECOMPTE, c.ID_COMPTE, tc.INT_NIVEAU from compte c, typecompte tc WHERE c.ID_TYPECOMPTE = tc.ID_TYPECOMPTE AND TXT_LOGIN = " . $this->db->escape($pseudo) . " AND TXT_MOTDEPASSE = " . $this->db->escape($password);
        $query = $this->db->query($txt_sql);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $result = array();
            $result['username'] = $pseudo;
            $result['id'] = $row->ID_COMPTE;
            $result['level'] = $row->INT_NIVEAU;
            if ($row->ID_TYPECOMPTE === "1")
                $result['id_individu'] = $this->db->query("SELECT ID_PATIENT FROM patient WHERE ID_COMPTE = " . $this->db->escape($row->ID_COMPTE))->row()->ID_PATIENT;
            elseif ($row->ID_TYPECOMPTE === "2")
                $result['id_individu'] = $this->db->query("SELECT ID_RESSOURCE FROM personnel WHERE ID_COMPTE = " . $this->db->escape($row->ID_COMPTE))->row()->ID_RESSOURCE;
            else
                $result['id_individu'] = 0;
            return $result;
        } else
            return null; // On retourne un tableau vide
    }

}
