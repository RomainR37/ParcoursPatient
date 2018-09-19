<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * \file      M_Personnel.php
 * \author    Guillaume Pochet
 * \version   1.0
 * \date      09 Mars 2017
 * \brief     Définit les méthodes liées aux personnels 
 *
 * \details   Ce fichier permet de définir les méthodes de gestion du personnel
 */
class M_Personnel extends CI_Model {

    /**
     * \brief      Récupère toute la liste du personnel
     * \details    Récupère toute la liste du personnel
     * \param      Aucun
     */
    public function getAllPersonnes() {
        //	On simule l'envoi d'une requête
        $txt_sql = "SELECT P.id_personnel,P.txt_nom, P.txt_prenom, TR.txt_nom as Type_nom
			FROM personnel P, typeressource TR, ressource R
			WHERE P.id_ressource = R.id_ressource
			AND R.id_typeressource = TR.id_typeressource";
        $query = $this->db->query($txt_sql);
        $res = array();

        foreach ($query->result() as $row) {
            $restemp = array();

            $restemp["id_personnel"] = $row->id_personnel;
            $restemp["txt_nom"] = $row->txt_nom;
            $restemp["txt_prenom"] = $row->txt_prenom;
            $restemp["type"] = $row->Type_nom;
            array_push($res, $restemp);
        }
        return $res;
    }

    /**
     * \brief      Récupère toute la liste des types de personnel
     * \details    Récupère toute la liste des types de personnel
     * \param      Aucun
     */
    public function getAllTypePersonnes() {
        //	On simule l'envoi d'une requête
        $txt_sql = "SELECT TR.id_typeressource,TR.txt_nom
			FROM personnel P, typeressource TR, ressource R
			WHERE P.id_ressource = R.id_ressource
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
     * \brief      Supprime une personne
     * \details    Supprimer une persone
     * \param      $id : id de la personne à supprimer
     */
    public function supprPersonne($id) {
        $txt_sql = "DELETE FROM personnel
			WHERE id_personnel = " . $id;
        $txt_sql2 = "DELETE FROM ordonnancer O 
                        LEFT JOIN personnel P
                        ON O.ressourceId = P.id_ressource 
                        WHERE P.ID_PERSONNEL = ". $id;        
        $txt_sql2 = "DELETE FROM evenement E 
                        LEFT JOIN personnel P
                        ON E.ressourceId = P.id_ressource 
                        WHERE P.ID_PERSONNEL = ". $id;
        $query = $this->db->query($txt_sql);
        $query2 = $this->db->query($txt_sql2);
        $query3 = $this->db->query($txt_sql3);
    }

    /**
     * \brief      Récupère les infos d'une personne en fonction de son id
     * \details    Récupère les infos d'une personne en fonction de son id
     * \param      $id : id de la personne
     */
    public function getPersonneById($id) {
        //	On simule l'envoi d'une requête
        $txt_sql = "SELECT P.id_personnel,P.txt_nom, P.txt_prenom, TR.txt_nom as Type_nom, P.id_ressource, TR.id_typeressource as id_type
			FROM personnel P, typeressource TR, ressource R
			WHERE P.id_ressource = R.id_ressource
			AND R.id_typeressource = TR.id_typeressource
			AND P.id_personnel =" . $id;
        $query = $this->db->query($txt_sql);
        $row = $query->row_array();

        return $row;
    }

    /**
     * \brief      Modifie les informations liés à une personne
     * \details    Modifie les informations liés à une personne
     * \param      $personne : contient les nouvelles informations de la personne ainsi que son id
     */
    public function ModifPersonne($personne) {
        //	On simule l'envoi d'une requête
        $this->load->model('M_TypeRessource');

        $txt_sql = "UPDATE personnel
                    SET txt_nom = " . $this->db->escape($personne['nom']) . ", txt_prenom=" . $this->db->escape($personne['prenom']) . "
                    WHERE id_personnel=" . $this->db->escape($personne['id']);
        $query = $this->db->query($txt_sql);

        if ($personne['idType'] == -1) {
            $personne['idType'] = $this->M_TypeRessource->insererType($personne['type']);
        }

        $txt_sql = "UPDATE ressource
                    SET id_typeressource = " . $this->db->escape($personne['idType']) . "
                    WHERE id_ressource=" . $this->db->escape($personne['idRessource']);
        $query = $this->db->query($txt_sql);
    }

    /**
     * \brief      Ajoute une personne
     * \details    Ajoute une personne
     * \param      $personne : contient les informations de la personne à ajouter
     */
    public function ajoutePersonne($personne) {
        $this->load->model('M_TypeRessource');
        $this->load->model('M_Ressource');
        $this->load->model('M_Compte');

        if ($personne['idType'] == -1) {
            $personne['idType'] = $this->M_TypeRessource->insererType($personne['type']);
        }

        $personne['idRessource'] = $this->M_Ressource->insererRessource($personne['idType']);
        $idCompte = $this->M_Compte->insererCompte($personne['login'], $personne['password']);

        $txt_sql = "INSERT INTO personnel
                    (id_personnel,id_ressource,id_compte,txt_nom,txt_prenom)        
                    VALUES(" . $personne['idRessource'] . "," . $personne['idRessource'] . "," . $idCompte . "," . $this->db->escape($personne['nom']) . "," . $this->db->escape($personne['prenom']) . ")";
        $query = $this->db->query($txt_sql);
    }

}
