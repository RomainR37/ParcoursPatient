<?php

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Définit les méthodes liées à la gestion des comptes utilisateurs
 * 
 * Ce fichier permet de définir la méthode d'insertion des comptes utilisateurs.
 * 
 * @author    Guillaume Pochet
 * @version   1.0
 * @since     09 Mars 2017
 */
class M_Compte extends CI_Model {

    /**
     * Fonction de récupération de l'id max. Retourne l'id maximum de la table 
     * Compte.
     */
    public function getMaxIDCompte() {
        $txt_sql = "SELECT MAX(id_compte) as id
                    FROM compte";
        $query = $this->db->query($txt_sql);
        $row = $query->row_array();

        return $row['id'] + 1;
    }

    /**
     * Insère un nouveau compte dans la table compte (compte personnel 
     * uniquement). Retourne l'id du compte.
     * @param $login : login 
     * @param $password : mot de passe
     */
    public function insererCompte($login, $password) {
        $id = $this->getMaxIDCompte();
        $txt_sql = "INSERT INTO compte(id_compte,txt_login,txt_motdepasse,id_typecompte) VALUES(" . $id . "," . $this->db->escape($login) . "," . $this->db->escape($password) . ",2)";
        $this->db->query($txt_sql);
        return $id;
    }

}
