<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * \file      M_Parcours.php
 * \author    Guillaume Pochet
 * \version   1.0
 * \date      09 Mars 2017
 * \brief     Définit les méthodes liées aux parcours patients
 *            (Suite d'activités médicales engendrant des ressources matérielles ou humaines)
 *
 * \details   Ce fichier permet de définir les méthodes de gestion des parcours patients
 */
class M_Parcours extends CI_Model {

    /**
     * \brief   Récupére les informations de tout les parcours
     * \details    Récupére les informations de tout les parcours
     */
    public function getAllParcours() {
       /* $txt_sql = "SELECT id_parcours, txt_nom, int_objectif, txt_code
			FROM parcours";*/
        $txt_sql = "SELECT id_parcours, txt_nom, txt_code
			FROM parcours";                
        
        $query = $this->db->query($txt_sql);
        $res = array();

        foreach ($query->result() as $row) {
            $restemp = array();

            $restemp["id_parcours"] = $row->id_parcours;
            $restemp["nom"] = $row->txt_nom;
            $restemp["code"] = $row->txt_code;
            array_push($res, $restemp);
        }
        return $res;
    }

    /**
     * \brief     Récupére les informations d'un parcours
     * \details   Récupére toutes les informations d'un parcours
     *           (chaque activité du parcours ainsi que chaque précédence de chaque activité)
     * \param     $id : id du parcours
     */
    public function getParcoursById($id) {
        //	On récupère les infos liées au parcours dans la table Parcours
        $txt_sql = "SELECT txt_nom, txt_code
			FROM parcours WHERE id_parcours =" . $id;
        
        $query = $this->db->query($txt_sql);
        $res = $query->row_array();

        $row = array();
        $row["id"] = $id;
        $row["nom"] = $res['txt_nom'];
        $row["code"] = $res['txt_code'];

        // On récupère la liste des activités nécessaires pour le parcours
        $txt_sql2 = "SELECT DISTINCT(C.id_activite), A.txt_nom
					FROM composer C, activite A 
					Where C.id_parcours =" . $id . " AND C.id_activite = A.id_activite";
        $query2 = $this->db->query($txt_sql2);
        $resAct = array();
        $resPrec = array();
        foreach ($query2->result() as $row2) {
            $restemp = array();
            $restemp["id_activite"] = $row2->id_activite;
            $restemp["nom_activite"] = $row2->txt_nom;

            // Pour chaque activite, on récupère ses contraintes de précédence
            $txt_sql3 = "SELECT C.id_activite_precedente, A.txt_nom, C.int_delaimin, C.int_delaimax 
						FROM composer C, activite A 
						WHERE C.id_parcours =" . $id . " AND C.id_activite=" . $restemp["id_activite"] .
                    " AND C.id_activite_precedente = A.id_activite AND C.id_activite_precedente <> 0";
            $query3 = $this->db->query($txt_sql3);
            $res = array();
            foreach ($query3->result() as $row3) {
                $restemp2 = array();
                $restemp2["id_prec"] = $row3->id_activite_precedente;
                $restemp2["nom_prec"] = $row3->txt_nom;
                // on sauvegarde des précédences pour chaque activité
                array_push($res, $restemp2);
                // on sauvegarde les précédences séparément
                $restemp2["delai_min"] = $row3->int_delaimin;
                $restemp2["delai_max"] = $row3->int_delaimax;
                $restemp2["id_act"] = $restemp["id_activite"];
                $restemp2["nom_act"] = $restemp["nom_activite"];
                array_push($resPrec, $restemp2);
            }
            $restemp["prec"] = $res;
            array_push($resAct, $restemp);
        }
        $row["precedences"] = $resPrec;
        $row["activites"] = $resAct;

        return $row;
    }

    /**
     * \brief     Récupére toutes les activités d'un parcours
     * \details   Récupére toutes les activités d'un parcours
     *            Retourne les données au format JSON
     * \param     $id : id du parcours
     */
    public function getActiviteParcoursByIdToJson($id) {
        // On récupère la liste des activités nécessaires pour le parcours
        $res = array();
        $txt_sql2 = "SELECT DISTINCT A.id_activite, A.txt_nom
					FROM composer C, activite A 
					Where C.id_parcours =" . $id . " AND C.id_activite = A.id_activite";
        $query2 = $this->db->query($txt_sql2);
        foreach ($query2->result() as $row2) {
            $restemp = array();
            $restemp["key"] = $row2->id_activite;
            $restemp["text"] = $row2->txt_nom;
            array_push($res, $restemp);
        }

        return json_encode($res, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    }

    /**
     * \brief     Récupére tout les liens de précécendes entre les activités d'un parcours
     * \details   Récupére tout les liens de précécendes entre les activités d'un parcours
     *            Retourne les données au format JSON
     * \param     $id : id du parcours
     */
    public function getDependencesActivitesToJson($id) {
        $res = array();
        $txt_sql2 = "SELECT DISTINCT C.id_activite, C.id_activite_precedente
                                        FROM composer C
					Where C.id_parcours =" . $id;
        $query2 = $this->db->query($txt_sql2);
        foreach ($query2->result() as $row2) {
            $restemp = array();
            $restemp["from"] = $row2->id_activite_precedente;
            $restemp["to"] = $row2->id_activite;
            array_push($res, $restemp);
        }

        return json_encode($res, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    }

    /**
     * \brief     Récupére toutes les dépendances entre les activités d'un parcours
     * \details   Récupére toutes les dépendances entre les activités d'un parcours (délai min et délai max)
     *            Retourne les données au format JSON
     * @param     $idActivite : id de l'activité
     * @param     $idParcours : id du parcours
     */
    public function getDependancesActivites($idActivite, $idParcours) {
        $res = array();
        $txt_sql2 = "SELECT ID_ACTIVITE_PRECEDENTE as id, INT_DELAIMIN as delaiMin, INT_DELAIMAX as delaiMax
                     from composer
                     WHERE ID_ACTIVITE = " . $this->db->escape($idActivite) . "AND ID_PARCOURS = " . $this->db->escape($idParcours);
        $query2 = $this->db->query($txt_sql2);

        foreach ($query2->result() as $row2) {
            $restemp = array();
            $restemp["id"] = $row2->id;
            $restemp["delaiMin"] = $row2->delaiMin;
            $restemp["delaiMax"] = $row2->delaiMax;
            array_push($res, $restemp);
        }

        return $res;
    }

    /**
     * \brief     Ajoute un parcours ainsi que toutes les activités liées à ce parcours
     * \details   Ajoute un parcours ainsi que toutes les activités liées à ce parcours
     * \param     $parcours : contient toutes les données du parcours (activité, précédences)
     */
    public function ajouteParcours($parcours) {
        $this->load->model("M_Composer");
        $parcours['id'] = $this->getMaxIdParcours();

        // on cree l'activite
        /*
        $txt_sql = "INSERT INTO parcours
        			(id_parcours,txt_nom,int_objectif,txt_code)
                   VALUES(" . $parcours['id'] . "," . $this->db->escape($parcours['nom']) . "," . $this->db->escape($parcours['objectif']) . "," . $this->db->escape($parcours['code']) . ")";*/
        
        $txt_sql = "INSERT INTO parcours
        			(id_parcours,txt_nom,txt_code)
                   VALUES(" . $parcours['id'] . "," . $this->db->escape($parcours['nom']) . "," . $this->db->escape($parcours['code']) . ")";
        $query = $this->db->query($txt_sql);

        //Ajout du plan parcours pour chaque jour
        $i = 1;
        /*
        for ($i = 1; $i <= 5; $i++) {
            $txt_sql = "INSERT INTO planparcours
                   VALUES(" . $parcours['id'] . "," . $i . "," . $this->db->escape($parcours['objectif']) . ")";
            $query = $this->db->query($txt_sql);
        }*/
         for ($i = 1; $i <= 5; $i++) {
            $txt_sql = "INSERT INTO planparcours
                   VALUES(" . $parcours['id'] . "," . $i . ", 5)";
            $query = $this->db->query($txt_sql);
         }


        foreach ($parcours["precedences"] as $prec) {
            // on ajoute une relation de composition pour les activités avec les liens de précédence
            $this->M_Composer->addCompo($parcours['id'], $prec);
        }

        return $parcours;
    }

    /**
     * \brief     Supprime un parcours
     * \details   Supprime un parcours en fonction de son id
     * \param     $id : id du parcours à supprimer
     */
    public function supprimerParcours($id) {
        $txt_sql = "DELETE FROM parcours
			WHERE id_parcours = " . $id;
        $query = $this->db->query($txt_sql);
    }

    /**
     * \brief     Permet de modifier un parcours
     * \details   Permet de modifier un parcours
     * \param     $parcours : contient toutes les nouvelles données du parcours
     */
    public function modifParcours($parcours) {
        $this->load->model("M_Composer");
        // on cree l'activite
        // on verifie les valeurs nulles
        $parcours["objectif"] = (empty($parcours['objectif'])) ? "NULL" : $this->db->escape($parcours['objectif']);
        $txt_sql = "UPDATE parcours SET
        			txt_nom=" . $this->db->escape($parcours['nom']) .
                ",int_objectif=" . $parcours['objectif'] .
                ",txt_code=" . $this->db->escape($parcours['code']) .
                " WHERE id_parcours=" . $parcours['id'];
        $query = $this->db->query($txt_sql);
        $this->M_Composer->deleteAllCompo($parcours['id']);
        foreach ($parcours["precedences"] as $prec) {
            // on ajoute une relation de composition pour les activités avec les liens de précédence
            $this->M_Composer->addCompo($parcours['id'], $prec);
        }

        return $parcours;
    }

    /**
     * \brief     Récupère l'id max des parcours
     * \details   Récupère l'id max des parcours
     * \param     Aucun
     */
    public function getMaxIdParcours() {
        $txt_sql = "SELECT MAX(id_parcours) as id
                    FROM parcours";
        $query = $this->db->query($txt_sql);
        if ($query->num_rows() == 0)
            return (1);
        $row = $query->row_array();

        return $row['id'] + 1;
    }

}
