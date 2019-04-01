<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Définit les méthodes liées aux activités.
 * 
 * Ce fichier permet de définir les méthodes d'ajout, de suppression et de 
 * modification liées aux activités
 * 
 * @author    Guillaume Pochet
 * @author    Romain Rousseau
 * @version   1.0
 * @since     09 Mars 2017
 */
class M_Activite extends CI_Model {

    /**
     * Méthode qui récupère les activités enregistrées en base.
     * 
     * @return la liste des activités
     */
    public function getAllActivites() {
        //	On simule l'envoi d'une requête
        $txt_sql = "SELECT A.id_activite, A.txt_nom, A.txt_commentaire, A.int_duree
			FROM activite A WHERE A.id_activite <> 0 ";
        $query = $this->db->query($txt_sql);
        $res = array();

        foreach ($query->result() as $row) {
            $restemp = array();

            $restemp["id_activite"] = $row->id_activite;
            $restemp["nom_activite"] = $row->txt_nom;
            $restemp["commentaire"] = $row->txt_commentaire;
            $restemp["duree"] = $row->int_duree;
            // On liste les ressources humaines
            $txt_sql2 = "SELECT N.quantite, TR.txt_nom
						FROM necessiter N, typeressource TR
						WHERE N.id_activite = " . $restemp["id_activite"] .
                    " AND N.id_typeressource = TR.id_typeressource
						 AND EXISTS( 
						 	SELECT * 
						 	FROM personnel P, ressource R 
						 	WHERE P.id_ressource = R.id_ressource AND R.id_typeressource = TR.id_typeressource)";
            $query2 = $this->db->query($txt_sql2);
            $res2 = array();
            foreach ($query2->result() as $row2) {
                $restemp2["nom_ressource"] = $row2->txt_nom;
                $restemp2["quantite"] = $row2->quantite;
                array_push($res2, $restemp2);
            }

            $restemp["ressourcesH"] = $res2;
            // On liste les salles
            $txt_sql2 = "SELECT N.quantite, TR.txt_nom
						FROM necessiter N, typeressource TR
						WHERE N.id_activite = " . $restemp["id_activite"] .
                    " AND N.id_typeressource = TR.id_typeressource
						 AND EXISTS( 
						 	SELECT * 
						 	FROM salle S, ressource R 
						 	WHERE S.id_ressource = R.id_ressource AND R.id_typeressource = TR.id_typeressource)";
            $query2 = $this->db->query($txt_sql2);
            $res2 = array();
            foreach ($query2->result() as $row2) {
                $restemp2["nom_ressource"] = $row2->txt_nom;
                $restemp2["quantite"] = $row2->quantite;
                array_push($res2, $restemp2);
            }
            $restemp["ressourcesMat"] = $res2;

            array_push($res, $restemp);
        }
        return $res;
    }

    /**
     * Méthode qui récupère la liste des activités selon le nom d'activité.
     * 
     * @param string $val : le nom de l'activité
     * @return la liste des activités recherchées
     */
    public function getListeActivites($val) {
        //	On simule l'envoi d'une requête
        $txt_sql = "SELECT id_activite, txt_nom
			FROM activite WHERE txt_nom Like '%" . $this->db->escape_str($val) . "%' AND id_activite <> 0	";
        $query = $this->db->query($txt_sql);
        $res = array();

        $restemp = array();
        $restemp["id"] = -1;
        $restemp["value"] = $val;
        array_push($res, $restemp);

        foreach ($query->result() as $row) {
            $restemp = array();

            $restemp["id"] = $row->id_activite;
            $restemp["value"] = $row->txt_nom;
            array_push($res, $restemp);
        }
        return $res;
    }

    /**
     * Méthode de suppression d'une activité en base selon son id
     * 
     * @param int $id
     */
    public function supprActivite($id) {
        $txt_sql = "DELETE FROM activite 
			WHERE id_activite = " . $id;
        $query = $this->db->query($txt_sql);
        $sql = "DELETE FROM onglet
                        WHERE id_onglet = " . $id;
        $query = $this->db->query($sql);
    }

    /**
     * Méthode pour récupérer une activité en base selon son identifiant
     * 
     * @param int $id : l'identifiant de l'activité recherchée
     * @return l'activité recherché
     */
    public function getActiviteById($id) {
        //	On récupère les infos liées à l'activité dans la table Activite
        $txt_sql = "SELECT id_activite, txt_nom, txt_commentaire, int_duree
			FROM activite WHERE id_activite =" . $id;
        $query = $this->db->query($txt_sql);
        $res = $query->row_array();

        $row = array();
        $row["id"] = $id;
        $row["nom_activite"] = $res["txt_nom"];
        $row["duree"] = $res["int_duree"];
        $row["comm"] = $res["txt_commentaire"];

        // On récupère la liste des ressources nécessaires pour l'activité
        // On liste les Personnels
        $txt_sql2 = "SELECT N.quantite, TR.txt_nom, TR.id_typeressource
					FROM necessiter N, typeressource TR
					WHERE N.id_activite = " . $id .
                " AND N.id_typeressource = TR.id_typeressource
					 AND EXISTS( 
						SELECT * 
						FROM personnel P, ressource R 
						WHERE P.id_ressource = R.id_ressource AND R.id_typeressource = TR.id_typeressource)";
        $query2 = $this->db->query($txt_sql2);
        $res = array();
        foreach ($query2->result() as $row2) {
            $restemp["id_type"] = $row2->id_typeressource;
            $restemp["nom_type"] = $row2->txt_nom;
            $restemp["qte"] = $row2->quantite;
            array_push($res, $restemp);
        }

        $row["personnels"] = $res;
        // On liste les salles
        $txt_sql2 = "SELECT N.quantite, TR.txt_nom, TR.id_typeressource	
					FROM necessiter N, typeressource TR
					WHERE N.id_activite = " . $id .
                " AND N.id_typeressource = TR.id_typeressource
					 AND EXISTS( 
					 	SELECT * 
					 	FROM salle S, ressource R 
					 	WHERE S.id_ressource = R.id_ressource AND R.id_typeressource = TR.id_typeressource)";
        $query2 = $this->db->query($txt_sql2);
        $res2 = array();
        foreach ($query2->result() as $row2) {
            $restemp2["id_type"] = $row2->id_typeressource;
            $restemp2["nom_type"] = $row2->txt_nom;
            $restemp2["qte"] = $row2->quantite;
            array_push($res2, $restemp2);
        }
        $row["ressourcesMat"] = $res2;

        return $row;
    }

    /**
     * Méthode de modification d'une activité
     * 
     * @param $activite : l'activité avec les modifications nécessaires
     * @return l'activité modifiée
     */
    public function modifActivite($activite) {
        $this->load->model("M_Necessiter");

        // update de l'activite 
        $txt_sql = "UPDATE activite
                    SET txt_nom = " . $this->db->escape($activite['nom']) . ", int_duree=" . $this->db->escape($activite['duree']) .
                ", txt_commentaire= " . $this->db->escape($activite['commentaire']) . " WHERE id_activite=" . $activite['id'];
        $query = $this->db->query($txt_sql);
        // on supprime toutes les compositions avec les ressources existantes
        $this->M_Necessiter->deleteAllBesoin($activite["id"]);
        foreach ($activite["besoins"] as $besoin) {
            // on ajoute une relation de composition pour toutes les ressources ajoutees
            $this->M_Necessiter->addBesoin($activite["id"], $besoin["idType"], $besoin["qte"]);
        }
        return $activite;
    }

    /**
     * Méthode d'ajout d'une activité en base.
     * 
     * @param array $activite : l'activité à ajouter
     * @return l'activité ajoutée en base
     */
    public function ajouteActivite($activite) {
        $this->load->model("M_Necessiter");
        $activite['id'] = $this->getMaxIdActivite();

        // on cree l'activite
        $txt_sql = "INSERT INTO activite
        			(id_activite,txt_nom,int_duree,txt_commentaire)
                   VALUES(" . $activite['id'] . "," . $this->db->escape($activite['nom']) . "," . $this->db->escape($activite['duree']) . "," . $this->db->escape($activite['commentaire']) . ")";
        $query = $this->db->query($txt_sql);

        $sql = "INSERT INTO onglet
                                (id_onglet, txt_nom, id_activite)
                                VALUES(" . $activite['id'] . "," . $this->db->escape($activite['nom']) . "," . $activite['id'] . ")";
        $query = $this->db->query($sql);

        foreach ($activite["besoins"] as $besoin) {
            // on ajoute une relation de composition pour toutes les ressources ajoutees
            $this->M_Necessiter->addBesoin($activite['id'], $besoin["idType"], $besoin["qte"]);
        }

        return $activite;
    }

    /**
     * Méthode pour récupérer le numéro d'identifiant maximum enregistré en 
     * base
     * 
     * @return l'identifiant maximum
     */
    public function getMaxIdActivite() {
        $txt_sql = "SELECT MAX(id_activite) as id
                    FROM activite";
        $query = $this->db->query($txt_sql);
        if ($query->num_rows() == 0)
            return (1);
        $row = $query->row_array();

        return $row['id'] + 1;
    }

}
