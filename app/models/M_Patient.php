<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Définit les méthodes liées aux patients
 * 
 * Ce fichier permet de définir les méthodes de gestion des patients 
 * (modification, suppression , ajout)
 * 
 * @author    Guillaume Pochet
 * @version   1.0
 * @since     09 Mars 2017
 */
class M_Patient extends CI_Model {

    /**
     * Récupère l'id max des patients
     */
    public function getMaxIdPatient() {
        $txt_sql = "SELECT MAX(ID_PATIENT) as maxId FROM patient";

        $query = $this->db->query($txt_sql);
        $row = $query->row();

        return $row->maxId;
    }

    /**
     * Récupére l'id max des comptes
     */
    public function getMaxIdCompte() {
        $txt_sql = "SELECT MAX(ID_COMPTE) as maxId FROM compte";

        $query = $this->db->query($txt_sql);
        $row = $query->row();

        return $row->maxId;
    }

    /**
     * Méthode d'ajout d'un nouveau patient et d'un compte à un patient
     * @param $uname : login du patient sous la forme (nom.prenom)
     * @param $password : mot de passe sous la forme (date de naissance)
     * @param $nom : nom du patient
     * @param $prenom : prenom du patient
     * @param $adressenum : numéro de rue du patient
     * @param $codePostale : code postal du patient
     * @param $ville : ville du patient
     * @param $apays : pays du patient
     * @param $mail : mail du patient
     * @param $telefix :  téléphone fixe du patient
     * @param $tele : téléphone portable
     * @param $numsecu : numéro de sécurité sociale du patient
     * @param $naissance : date de naissance du patient
     * @param $idParcours : parcours que le patient doit effectué
     * @param $dateDebut : date de début de dispo du patient
     * @param $dateFin : date de fin de dispo du patient
     */
    public function ajouterUnPatient($uname, $pwd, $nom, $prenom, $adressenum, $adresseure, $codepostale, $ville, $pays, $mail, $telefix, $tele, $numsecu, $naissance, $idParcours, $dateDebut, $dateFin) {
        $idCompte = $this->creerUnCompte($uname, $pwd);
        $idPatient = $this->getMaxIdPatient() + 1;
        $date = date('Y-m-d', strtotime(str_replace('-', '/', $naissance)));
        $txt_sql = "INSERT INTO patient VALUES (" . $this->db->escape($idPatient) . ", " . $this->db->escape($idCompte) . ", " . $this->db->escape($nom) . ", " . $this->db->escape($prenom) . ", " . $this->db->escape($adressenum) . ", " . $this->db->escape($adresseure) . ", " . $this->db->escape($codepostale) . ", " . $this->db->escape($ville) . ", " . $this->db->escape($pays) . ", " . $this->db->escape($mail) . ", " . $this->db->escape($telefix) . ", " . $this->db->escape($tele) . ", " . $this->db->escape($numsecu) . ", " . $this->db->escape($date) . ", " . $this->db->escape($idParcours) . ", " . $this->db->escape($dateDebut) . ", " . $this->db->escape($dateFin) . ")";

        $this->db->query($txt_sql);
        return $idPatient;
    }

    /**
     * Méthode de modification d'un patient
     * @param $nom : nom du patient
     * @param $prenom : prenom du patient
     * @param $adressenum : numéro de rue du patient
     * @param $codePostale : code postal du patient
     * @param $ville : ville du patient
     * @param $apays : pays du patient
     * @param $mail : mail du patient
     * @param $telefix :  téléphone fixe du patient
     * @param $numsecu : numéro de sécurité sociale du patient
     * @param $naissance : date de naissance du patient
     * @param $idPatient : id du patient à modifié
     */
    public function modifierUnPatient($idpatient, $nom, $prenom, $adressenum, $adresseure, $codepostale, $ville, $pays, $mail, $telefix, $tele, $numsecu, $naissance) {
        $txt_sql = "UPDATE patient SET TXT_NOM = " . $this->db->escape($nom) . ", TXT_PRENOM =" . $this->db->escape($prenom) . ", TXT_ADRESSENUM = " . $this->db->escape($adressenum) . ", TXT_ADRESSERUE = " . $this->db->escape($adresseure) .
                ", TXT_ADRESSECODEPOSTAL = " . $this->db->escape($codepostale) . ", TXT_ADRESSEVILLE = " . $this->db->escape($ville) . ", TXT_ADRESSEPAYS = " . $this->db->escape($pays) . ", TXT_MAIL = " . $this->db->escape($mail) . ", TXT_TELEPHONEFIXE = "
                . $this->db->escape($telefix) . ", TXT_TELEPHONEPORTABLE = " . $this->db->escape($tele) . ", TXT_NUMSECU = " . $this->db->escape($numsecu) . ", DATE_NAISSANCE = " . $this->db->escape($naissance) . " WHERE ID_PATIENT = " . $this->db->escape($idpatient) . "";

        $this->db->query($txt_sql);
    }

    /**
     *  Affiche la liste de tous les patients
     */
    public function afficherTousPatient() {
        $txt_sql = "SELECT ID_PATIENT, ID_COMPTE,TXT_NOM, TXT_PRENOM, TXT_ADRESSENUM, TXT_ADRESSERUE, TXT_ADRESSECODEPOSTAL, TXT_ADRESSEVILLE, 
        TXT_ADRESSEPAYS, TXT_MAIL, TXT_TELEPHONEFIXE, TXT_TELEPHONEPORTABLE, TXT_NUMSECU, DATE_NAISSANCE FROM patient";

        $query = $this->db->query($txt_sql);
        $res = array();
        foreach ($query->result() as $row) {
            $restemp = array();
            $restemp["idpatient"] = $row->ID_PATIENT;
            $restemp["idcompte"] = $row->ID_COMPTE;
            $restemp["nom"] = $row->TXT_NOM;
            $restemp["prenom"] = $row->TXT_PRENOM;
            $restemp["adressenum"] = $row->TXT_ADRESSENUM;
            $restemp["adresserue"] = $row->TXT_ADRESSERUE;
            $restemp["codepostale"] = $row->TXT_ADRESSECODEPOSTAL;
            $restemp["ville"] = $row->TXT_ADRESSEVILLE;
            $restemp["pays"] = $row->TXT_ADRESSEPAYS;
            $restemp["mail"] = $row->TXT_MAIL;
            $restemp["telefix"] = $row->TXT_TELEPHONEFIXE;
            $restemp["tele"] = $row->TXT_TELEPHONEPORTABLE;
            $restemp["numsecu"] = $row->TXT_NUMSECU;
            $restemp["datenaissance"] = $row->DATE_NAISSANCE;
            array_push($res, $restemp);
        }
        return $res;
    }

    /**
     * Méthode de création d'un compte
     * @param $uname : login
     * @param $pwd :  mot de passe
     */
    public function creerUnCompte($uname, $pwd) {
        $maxId = $this->getMaxIdCompte();
        $maxIdCompte = $maxId + 1;
        $txt_sql = "INSERT INTO compte (ID_COMPTE, TXT_LOGIN, TXT_MOTDEPASSE, ID_TYPECOMPTE) VALUES (" . $this->db->escape($maxIdCompte) . ", " . $this->db->escape($uname) . ", " . $this->db->escape($pwd) . ", (SELECT ID_TYPECOMPTE FROM typecompte WHERE TXT_NOM='patient'))";

        $this->db->query($txt_sql);

        return $maxIdCompte;
    }

    /**
     * Retourne le nombre de patient d'un parcours en fonction d'une date de 
     * début
     * @param $idParcours : l'id du parcours
     * @param $datedebut : date de début
     */
    public function nombreDePatientParcour($idparcours, $datedebut) {
        /** Nombre de parcours ordonnnancé * */
        
        $txt_sql = "SELECT D.DATE_DISPONIBLE_DEBUT as day, 
        count( DISTINCT(D.ID_PATIENT))/P.INT_NB_PATIENT as ratio 
        FROM dossierparcours D, planparcours P, jour J 
        WHERE D.ID_PARCOURS = P.ID_PARCOURS 
        AND P.ID_JOUR = J.ID_JOUR 
        AND D.DATE_DISPONIBLE_DEBUT >=" . $this->db->escape($datedebut) . " 
        AND D.ID_PARCOURS = " . $this->db->escape($idparcours) . "
        group by day";
        $query = $this->db->query($txt_sql);
        $res = array();

        foreach ($query->result() as $row) {
            $restemp = array();
            $restemp["date"] = $row->day;
            $restemp["ratio"] = $row->ratio;
            array_push($res, $restemp);
        }

        return $res;
    }

    /**
     * Permet de récupérer toutes les activités effectuées (ou en cours) d'un 
     * patient
     * @param $idPatient : l'id du patient
     */
    public function getAllActivities($idPatient) {
        $txt_sql = "
        SELECT a.TXT_NOM, e.start as start, e.end as end, UCASE(p.TXT_NOM) as ressNom, p.TXT_PRENOM as ressPrenom
        FROM ordonnancer e, activite a, personnel p
        WHERE e.patientId = " . $this->db->escape($idPatient) . "
        AND e.activiteId = a.ID_ACTIVITE
        AND e.ressourceId = p.ID_RESSOURCE
        AND date(e.start) = CURRENT_DATE";
        $query = $this->db->query($txt_sql);
        return $query->result_array();
    }

    /**
     * Mettre à jour les disponibilités d'un patient
     * @param $idPatient : l'id du patient
     * @param $idParcours : l'id du parcours
     * @param $dateDebut : date de début de dispo du patient
     * @param $dateFin : date de fin de dispo du patient
     */
    public function majDisponibilitePatient($idPatient, $idParcours, $dateDebut, $dateFin) {
        $txt_sql = "UPDATE patient SET ID_PARCOURS_SUP=" . $this->db->escape($idParcours) . " ,DATE_DISPONIBLE_DEBUT=" . $this->db->escape($dateDebut) . " ,DATE_DISPONIBLE_FIN=" . $this->db->escape($dateFin) . " WHERE ID_PATIENT = " . $this->db->escape($idPatient);

        $this->db->query($txt_sql);
    }

    /**
     * Recherche d'un patient par nom ou prenom
     * @param $recherche : chaine de recherche d'un patient
     */
    public function patientParNomOuPrenom($recherche) {
        $txt_sql = "SELECT ID_PATIENT, TXT_NOM, TXT_PRENOM, DATE_NAISSANCE, TXT_NUMSECU FROM patient 
        WHERE UPPER(TXT_NOM) like '%" . $this->db->escape_str(strtoupper($recherche)) . "%'           
        OR UPPER(TXT_PRENOM) like '%" . $this->db->escape_str(strtoupper($recherche)) . "%'
        ORDER BY TXT_NOM ASC
        ";
        $query = $this->db->query($txt_sql);
        $res = array();
        foreach ($query->result() as $row) {
            $restemp = array();
            $restemp["ID_PATIENT"] = $row->ID_PATIENT;
            $restemp["TXT_NOM"] = $row->TXT_NOM;
            $restemp["TXT_PRENOM"] = $row->TXT_PRENOM;
            $restemp["DATE_NAISSANCE"] = $row->DATE_NAISSANCE;
            $restemp["TXT_NUMSECU"] = $row->TXT_NUMSECU;
            array_push($res, $restemp);
        }
        return $res;
    }

    /**
     * Retourne toutes les informations d'un patient en fonction de son id
     * @param $id : id du patient
     */
    public function getPatientById($id) {
        $txt_sql = "SELECT * FROM patient 
        WHERE ID_PATIENT=" . $this->db->escape($id);
        $query = $this->db->query($txt_sql);
        $res = array();
        foreach ($query->result() as $row) {
            
            $restemp = array();
            $restemp["ID_PATIENT"] = $row->ID_PATIENT;
            $restemp["ID_COMPTE"] = $row->ID_COMPTE;
            $restemp["TXT_NOM"] = $row->TXT_NOM;
            $restemp["TXT_PRENOM"] = $row->TXT_PRENOM;
            $restemp["TXT_ADRESSENUM"] = $row->TXT_ADRESSENUM;
            $restemp["TXT_ADRESSERUE"] = $row->TXT_ADRESSERUE;
            $restemp["TXT_ADRESSECODEPOSTAL"] = $row->TXT_ADRESSECODEPOSTAL;
            $restemp["TXT_ADRESSEVILLE"] = $row->TXT_ADRESSEVILLE;
            $restemp["TXT_ADRESSEPAYS"] = $row->TXT_ADRESSEPAYS;
            $restemp["TXT_MAIL"] = $row->TXT_MAIL;
            $restemp["TXT_TELEPHONEFIXE"] = $row->TXT_TELEPHONEFIXE;
            $restemp["TXT_TELEPHONEPORTABLE"] = $row->TXT_TELEPHONEPORTABLE;
            $restemp["TXT_NUMSECU"] = $row->TXT_NUMSECU;
            $restemp["DATE_NAISSANCE"] = $row->DATE_NAISSANCE;
            $restemp["ID_PARCOURS_SUP"] = $row->ID_PARCOURS_SUP;
            $restemp["DATE_DISPONIBLE_DEBUT"] = $row->DATE_DISPONIBLE_DEBUT;
            $restemp["DATE_DISPONIBLE_FIN"] = $row->DATE_DISPONIBLE_FIN;
             
          
            array_push($res, $restemp);
            
        }
        return $res[0];
    }
    
    /**
     * Supprime un patient en fonction de son id
     * @param $id : id du patient à supprimer
     */
    public function supprimerPatient($id) {
        $txt_sql = "DELETE FROM patient                   
			WHERE id_patient = " . $id;
        $query = $this->db->query($txt_sql);
    }

}
