<?php

/**
 * Définit les méthodes liées au planning
 * 
 * Ce fichier permet de définir les méthodes de gestion du planning 
 * (ajout, suppression d'événements)
 * 
 * @author    Guillaume Pochet
 * @author    Romain Rousseau
 * @version   1.0
 * @since     09 Mars 2017
 */
class M_Planning extends CI_Model {

    /**
     * Récupère toutes les ressources humaines ou matérielles
     */
    public function getAllRessource() {
        // le personnel
        $txt_sql = "SELECT r.ID_RESSOURCE as id,P.txt_nom as nom, P.txt_prenom as prenom, TR.txt_nom as Type_nom
			FROM personnel P, typeressource TR, ressource R
			WHERE P.id_ressource = R.id_ressource
			AND R.id_typeressource = TR.id_typeressource";
        $query = $this->db->query($txt_sql);
        $res = array();

        foreach ($query->result() as $row) {
            $restemp = array();

            $restemp["id"] = $row->id;
            $restemp["title"] = $row->prenom . " " . $row->nom;
            $restemp["type_ressource"] = $row->Type_nom;
            array_push($res, $restemp);
        }

        // Les salles
        $txt_sql = "SELECT s.ID_RESSOURCE as id, s.TXT_NOM as nom, t.TXT_NOM as Type_nom
                    FROM salle s, ressource r, typeressource t
                    WHERE s.ID_RESSOURCE = r.ID_RESSOURCE
                    AND t.ID_TYPERESSOURCE = r.ID_TYPERESSOURCE";
        $query = $this->db->query($txt_sql);

        foreach ($query->result() as $row) {
            $restemp = array();

            $restemp["id"] = $row->id;
            $restemp["title"] = $row->nom;
            $restemp["type_ressource"] = $row->Type_nom;
            array_push($res, $restemp);
        }

        // Ressources hors hôpital
        
        $restemp = array();
        
        $restemp["id"] = 0;
        $restemp["title"] = "Autres ressources";
        $restemp["type_ressource"] = "Autres";
        
        array_push($res, $restemp);
        
        return $res;
    }

    /**
     * Récupère toutes les activités à planifier en fonction d'une date donnée
     * @param $date : la date 
     */
    public function getActiviteAplanifier($date) {

        // activité à planifier (rendez vous dans la table patient )
        $txt_sql = "SELECT DISTINCT(A.ID_ACTIVITE) as id_activite, Pat.ID_PATIENT as id_patient, Par.ID_PARCOURS as id_parcours, A.TXT_NOM as nom_activite, Pat.TXT_NOM as nom_patient, Pat.TXT_PRENOM as prenom_patient, Par.TXT_NOM as nom_parcours, A.INT_DUREE as duree
                    FROM patient Pat, parcours Par, composer C, activite A, dossierparcours D
                    WHERE Pat.ID_PATIENT = D.ID_PATIENT
                    AND D.ID_PARCOURS = Par.ID_PARCOURS
                    AND Par.ID_PARCOURS = C.ID_PARCOURS
                    AND C.ID_ACTIVITE = A.ID_ACTIVITE
                    AND DATE(D.DATE_DISPONIBLE_DEBUT) =" . $this->db->escape($date);
        $query = $this->db->query($txt_sql);
        $res = array();

        foreach ($query->result() as $row) {
            $restemp = array();

            $restemp["activite_id"] = $row->id_activite;
            $restemp["patient_id"] = $row->id_patient;
            $restemp["parcours_id"] = $row->id_parcours;
            $restemp["nom_activite"] = $row->nom_patient . " " . $row->prenom_patient . " - " . $row->nom_activite . " - " . $row->nom_parcours;
            //Convertir durée en minutes en heure, minutes, seconde (hh:mm:ss)
            $secondes = $row->duree * 60;
            $temp = $secondes % 3600;
            $time[0] = ( $secondes - $temp ) / 3600;
            $time[2] = $temp % 60;
            $time[1] = ( $temp - $time[2] ) / 60;
            $restemp["duree"] = $time[0] . ":" . $time[1] . ":" . $time[2];
            $restemp["activite_precedente"] = $this->precedence($row->id_activite, $row->id_parcours);
            $restemp["necessite"] = $this->necessite($row->id_activite);
            array_push($res, $restemp);
        }

        // activité déja planifiée
        $txt_sql2 = "SELECT DISTINCT(activite.ID_ACTIVITE) as id_activite, patient.ID_PATIENT as id_patient, parcours.ID_PARCOURS as id_parcours, activite.TXT_NOM as nom_activite, patient.TXT_NOM as nom_patient, patient.TXT_PRENOM as prenom_patient, parcours.TXT_NOM as nom_parcours, activite.INT_DUREE as duree
					FROM evenement, parcours, activite, patient
                	WHERE patient.ID_PATIENT = evenement.patientId
                	AND parcours.ID_PARCOURS = evenement.parcoursId
                	AND activite.ID_ACTIVITE = evenement.activiteId
                	and DATE(start) = " . $this->db->escape($date);
        $query2 = $this->db->query($txt_sql2);

        $res2 = array();
        foreach ($query2->result() as $row) {
            $restemp = array();

            $restemp["activite_id"] = $row->id_activite;
            $restemp["patient_id"] = $row->id_patient;
            $restemp["parcours_id"] = $row->id_parcours;
            $restemp["nom_activite"] = $row->nom_patient . " " . $row->prenom_patient . " - " . $row->nom_activite . " - " . $row->nom_parcours;
            //Convertir durée en minutes en heure, minutes, seconde (hh:mm:ss)
            $secondes = $row->duree * 60;
            $temp = $secondes % 3600;
            $time[0] = ( $secondes - $temp ) / 3600;
            $time[2] = $temp % 60;
            $time[1] = ( $temp - $time[2] ) / 60;
            $restemp["duree"] = $time[0] . ":" . $time[1] . ":" . $time[2];
            $restemp["activite_precedente"] = $this->precedence($row->id_activite, $row->id_parcours);
            $restemp["necessite"] = $this->necessite($row->id_activite);
            array_push($res2, $restemp);
        }

        //retiré du tableau les activités déja planifiées
        foreach ($res as $i => &$value) {
            foreach ($res2 as $j => $value1) {
                // Si les deux activités, patient, parcours sont identiques alors on supprime cette activité du tableau $res
                if (($value["activite_id"] == $value1["activite_id"]) && ($value["patient_id"] == $value1["patient_id"]) && ($value["parcours_id"] == $value1["parcours_id"])) {
                    unset($res[$i]);
                }
            }
        }

        $res = array_merge($res);
        return $res;
    }

    /**
     * Ajout d'un événement dans la base de données
     * 
     * @param $title : titre de l'événement
     * @param $start : date et heure de début
     * @param $end : date et heure de fin de l'événement
     * @param $ressourceId : ressource liée à l'événement
     * @param $activiteId : id de l'activité lié à l'événement
     * @param $patientId : id du patient
     * @param $parcoursId : id du parcours
     */
    public function addEvenement($title, $start, $end, $ressourceId, $activiteId, $patientId, $parcoursId) {

        // vérification de la ressource sur laquelle on drop l'event
        $ressourceDispo = $this->getDisponibiliteRessource($ressourceId, $start, $end);
        
        // necessite
        $txt_sql = "SELECT t.ID_TYPERESSOURCE as id, quantite as quantite
                    FROM typeressource t, activite a, necessiter n
                    WHERE t.ID_TYPERESSOURCE = n.ID_TYPERESSOURCE
                    AND n.ID_ACTIVITE = a.ID_ACTIVITE
                    AND a.ID_ACTIVITE = " . $this->db->escape($activiteId);

        $query = $this->db->query($txt_sql);

        if ($query->num_rows() >= 1) {

            $typeUtilise = 0;
        
            if($ressourceDispo){
                $txt_sql = "SELECT id_typeressource FROM ressource WHERE id_ressource = ". $ressourceId;

                $queryType = $this->db->query($txt_sql);

                foreach($queryType->result() as $row){
                    $typeUtilise = $row->id_typeressource;                    
                }
            }

            //Pour chaque besoin de l'activité, récupérer la première ressource disponible sinon la première
            foreach ($query->result() as $row) {
                if ($typeUtilise == $row->id){
                    if ($this->getCouleurEventPatient($patientId) != NULL) {
                        $this->insertEventBDD($start, $end, $title, $patientId, 
                             $ressourceId, $parcoursId, $activiteId, $this->getCouleurEventPatient($patientId));
                    } else {
                        $this->insertEventBDD($start, $end, $title, $patientId, 
                            $ressourceId, $parcoursId, $activiteId, $this->couleur_aleatoire());
                    }                    
                } else{
                    $idRessource = $this->getRessourceByType($row->id, $row->quantite, $start, $end);
                    for ($i = 0; $i < count($idRessource); $i++) {
                        if ($this->getCouleurEventPatient($patientId) != NULL) {
                            $this->insertEventBDD($start, $end, $title, $patientId, 
                                $idRessource[$i], $parcoursId, $activiteId, $this->getCouleurEventPatient($patientId));
                        } else {
                            $this->insertEventBDD($start, $end, $title, $patientId, 
                                $idRessource[$i], $parcoursId, $activiteId, $this->couleur_aleatoire());
                        }
                    }
                }
            }
        } else {
            if ($this->getCouleurEventPatient($patientId) != NULL) {
                //La ressource avec l'id 0 correspond à la ressource "Autres" sur le calendrier
                $this->insertEventBDD($start, $end, $title, $patientId, 0, 
                        $parcoursId, $activiteId, $this->getCouleurEventPatient($patientId));
            } else {
                $this->insertEventBDD($start, $end, $title, $patientId, 0, 
                        $parcoursId, $activiteId, $this->couleur_aleatoire());
            }
        }
    }
    
    /**
     * Ajout d'un événement en base sans préciser de ressource à 
     * attribuer.
     * 
     * Cette méthode est utilisée notamment pour la planification automatique 
     * car les ressources ne sont pas allouées de façon manuelle dans ce cas. 
     * Les ressources doivent donc être attribuées à la volée. 
     * 
     * @param $title : titre de l'événement
     * @param $start : date et heure de début
     * @param $end : date et heure de fin de l'événement
     * @param $activiteId : id de l'activité lié à l'événement
     * @param $patientId : id du patient
     * @param $parcoursId : id du parcours
     */
    public function addEvenementAuto($title, $start, $end, $activiteId, $patientId, $parcoursId) {
    
        // necessite
        $txt_sql = "SELECT t.ID_TYPERESSOURCE as id, quantite as quantite
                    FROM typeressource t, activite a, necessiter n
                    WHERE t.ID_TYPERESSOURCE = n.ID_TYPERESSOURCE
                    AND n.ID_ACTIVITE = a.ID_ACTIVITE
                    AND a.ID_ACTIVITE = " . $this->db->escape($activiteId);

        $query = $this->db->query($txt_sql);
        
        if($query->num_rows() >= 1) {
            //Pour chaque besoin de l'activité, récupérer la première ressource disponible sinon la première
            $date = array(
                "Debut" => $start,
                "Fin" => $end
            );
            
            // Ajustement de la date par rapport à toutes les ressources
            foreach($query->result() as $row){
                $ressourceAvailable = $this->getRessourceAvailable($row->id, $row->quantite, $date["Debut"], $date["Fin"]);
                
                // Le -2 permet de récupérer les dates provenant de la méthode getRessourceAvailable
                $newDate = array_slice($ressourceAvailable, -2);
                if($newDate["Debut"]>$date["Debut"]){
                    $date["Debut"] = $newDate["Debut"];
                    $date["Fin"] = $newDate["Fin"];
                }               
            }
            
            foreach ($query->result() as $row) {
                $ressourceAvailable = $this->getRessourceAvailable($row->id, $row->quantite, $start, $end);
                
                for ($i = 0; $i < count($ressourceAvailable)-2; $i++) {
                    if ($this->getCouleurEventPatient($patientId) != NULL) {
                        $this->insertEventBDD($date["Debut"], $date["Fin"], $title, $patientId, 
                                $ressourceAvailable[$i], $parcoursId, $activiteId, $this->getCouleurEventPatient($patientId));
                    } else {
                        $this->insertEventBDD($date["Debut"], $date["Fin"], $title, $patientId, 
                                $ressourceAvailable[$i], $parcoursId, $activiteId, $this->couleur_aleatoire());
                    }
                }
            }
            return $date["Fin"];
        } else {
            if ($this->getCouleurEventPatient($patientId) != NULL) {
                //La ressource avec l'id 0 correspond à la ressource "Autres" sur le calendrier
                $this->insertEventBDD($start, $end, $title, $patientId, 0, 
                        $parcoursId, $activiteId, $this->getCouleurEventPatient($patientId));
            } else {
                $this->insertEventBDD($start, $end, $title, $patientId, 0, 
                        $parcoursId, $activiteId, $this->couleur_aleatoire());
            }
            return $end;
        }      
    }
    
    /**
     * Insertion d'un évènement en base de données
     * 
     * Insère un évènement dans la base de données avec les attributs en 
     * paramètre.
     * 
     * @param $start : date et heure de début de l'évènement
     * @param $end : date et heure de fin de l'évènement
     * @param $title : nom de l'évènement
     * @param $patientId : id du patient
     * @param $ressourceId : id de la ressource
     * @param $parcoursId : id du parcours
     * @param $activiteId : id de l'activité
     * @param $color : couleur associée à l'évènement sur le calendrier
     */
    public function insertEventBDD($start, $end, $title, $patientId, $ressourceId, $parcoursId, $activiteId, $color) {

        $txt_sql = "INSERT INTO `evenement`(`start`, `end`, `title`, `patientId`, `ressourceId`, `parcoursId`, `activiteId`, `color`) "
            . "VALUES (" . $this->db->escape($start) . "," . $this->db->escape($end)
            . "," . $this->db->escape($title)
            . "," . $this->db->escape($patientId)
            . "," . $this->db->escape($ressourceId)
            . "," . $this->db->escape($parcoursId)
            . "," . $this->db->escape($activiteId)
            . "," . $this->db->escape($color) . ")";
        $this->db->query($txt_sql);
    }
    
    
    /**
     * Récupère tous les événements de la base de données
     */
    public function getAllEvenement() {

        $txt_sql = "SELECT `id`, `start`, `end`, `title`, `patientId`, `ressourceId`, `parcoursId`, `activiteId`, `color` FROM `evenement`";
        $query = $this->db->query($txt_sql);
        $res = array();

        foreach ($query->result() as $row) {
            $restemp = array();
            $restemp["id"] = $row->id;
            $restemp["resourceId"] = $row->ressourceId;
            $restemp["start"] = $row->start;
            $restemp["end"] = $row->end;
            $restemp["title"] = $row->title;
            $restemp["patientId"] = $row->patientId;
            $restemp["parcoursId"] = $row->parcoursId;
            $restemp["activiteId"] = $row->activiteId;
            if ($row->activiteId != NULL && $row->parcoursId != NULL) {
                $restemp["necessite"] = $this->necessite($row->activiteId);
                $restemp["activite_precedente"] = $this->precedence($row->activiteId, $row->parcoursId);
            }
            $restemp["color"] = $row->color;
            array_push($res, $restemp);
        }

        $txt_sql = "SELECT ID_RESSOURCE as ressourceId, DATE_DEBUT as start, DATE_FIN as end
		FROM etreindisponible";

        $query = $this->db->query($txt_sql);

        foreach ($query->result() as $row) {
            $restemp = array();
            $restemp["resourceId"] = $row->ressourceId;
            $restemp["activite_precedente"] = "";
            $restemp["id"] = -1;
            $restemp["title"] = "Indisponible";
            $restemp["start"] = $row->start;
            $restemp["end"] = $row->end;
            $restemp["color"] = "#000000";
            $restemp["editable"] = false;
            $restemp["eventOverlap"] = false;
            $restemp["patientId"] = null;
            $restemp["parcoursId"] = null;
            array_push($res, $restemp);
        }
        return $res;
    }

    /**
     * Récupère tous les événements d'un parcours pour un patient pour une date donnée
     * @param $date : date
     * @param $patient : id du patient
     * @param $parcours : id du parcours
     */
    public function getParcoursByDateAndPatient($date, $patient, $parcours) {
        $txt_sql = "select id, title, end, start, ressourceId, patientId, parcoursId, activiteId, color from evenement
                    WHERE parcoursId = " . $this->db->escape($parcours) . "
                    AND patientId = " . $this->db->escape($patient) . "
                    AND date(start) = " . $this->db->escape($date);
        $query = $this->db->query($txt_sql);
        $res = array();
        foreach ($query->result() as $row) {
            $restemp = array();
            $restemp["id"] = $row->id;
            $restemp["title"] = $row->title;
            $restemp["start"] = $row->start;
            $restemp["end"] = $row->end;
            $restemp["patientId"] = $row->patientId;
            $restemp["ressourceId"] = $row->ressourceId;
            $restemp["activiteId"] = $row->activiteId;
            array_push($res, $restemp);
        }

        return $res;
    }

    /**
     * Récupère tous les événements (juste le parcours) pour une date donnée
     * @param $date : date
     */
    public function getParcoursByDate($date) {
        $txt_sql = "SELECT DISTINCT parcoursId, patientId
                    from evenement
                    WHERE date (start) = " . $this->db->escape($date);

        $query = $this->db->query($txt_sql);
        $res = array();
        foreach ($query->result() as $row) {
            $restemp = array();
            $restemp["parcoursId"] = $row->parcoursId;
            $restemp["patientId"] = $row->patientId;
            array_push($res, $restemp);
        }

        return $res;
    }

    /**
     * Récupère les détails d'un événement pour une activité, un parcours, un 
     * patient et une date donnée
     * 
     * @param $idActivite : id de l'activité 
     * @param $idParcours : id du parcours
     * @param $idPatient : id du patient
     * @param $date : date
     */
    public function getDetailEvenement($idActivite, $idParcours, $idPatient, $date) {
        $txt_sql = "select id, title, end, start, activiteId from evenement
                    WHERE activiteId = " . $this->db->escape($idActivite) . "
                    AND patientId = " . $this->db->escape($idPatient) . "
                    AND parcoursId = " . $this->db->escape($idParcours) . "
                    AND date(start) = " . $this->db->escape($date) . " LIMIT 1";
        $query = $this->db->query($txt_sql);
        $res = array();

        foreach ($query->result() as $row) {
            $restemp = array();
            $restemp["id"] = $row->id;
            $restemp["title"] = $row->title;
            $restemp["start"] = $row->start;
            $restemp["end"] = $row->end;
            $restemp["activiteId"] = $row->activiteId;
            array_push($res, $restemp);
        }

        return $res;
    }

    /**
     * Récupère tous les événements (tous les attributs) de la base de données pour une date donnée
     */
    public function getAllEvenementByDate($date) {

        $txt_sql = "SELECT `id`, `start`, `end`, `title`, `patientId`, `ressourceId`, "
                . "`parcoursId`, `activiteId`, `color` FROM `evenement` WHERE date(start)=" . $this->db->escape($date);
        $query = $this->db->query($txt_sql);
        $res = array();

        foreach ($query->result() as $row) {
            $restemp = array();
            $restemp["id"] = $row->id;
            $restemp["resourceId"] = $row->ressourceId;
            $restemp["start"] = $row->start;
            $restemp["end"] = $row->end;
            $restemp["title"] = $row->title;
            $restemp["patientId"] = $row->patientId;
            $restemp["parcoursId"] = $row->parcoursId;
            $restemp["activiteId"] = $row->activiteId;
            if ($row->activiteId != NULL && $row->parcoursId != NULL) {
                $restemp["necessite"] = $this->necessite($row->activiteId);
                $restemp["activite_precedente"] = $this->precedence($row->activiteId, $row->parcoursId);
            }
            $restemp["color"] = $row->color;
            array_push($res, $restemp);
        }

        $txt_sql = "SELECT ID_RESSOURCE as ressourceId, DATE_DEBUT as start, DATE_FIN as end
		FROM etreindisponible
                WHERE date(DATE_DEBUT)=" . $this->db->escape($date);

        $query = $this->db->query($txt_sql);

        foreach ($query->result() as $row) {
            $restemp = array();
            $restemp["resourceId"] = $row->ressourceId;
            $restemp["activite_precedente"] = "";
            $restemp["id"] = -1;
            $restemp["title"] = "Indisponible";
            $restemp["start"] = $row->start;
            $restemp["end"] = $row->end;
            $restemp["color"] = "#000000";
            $restemp["editable"] = false;
            $restemp["eventOverlap"] = false;
            $restemp["patientId"] = null;
            $restemp["parcoursId"] = null;
            array_push($res, $restemp);
        }
        return $res;
    }

    /**
     * Supprime un évènement de la base de données en fonction de l'id de son 
     * activité, l'id de son patient et l'id de son parcours
     * @param $idActivite : id de l'activité
     * @param $idPatient : id du patient
     * @param $idParcours : id du parcours
     */
    public function deleteEvent($idActivite, $idPatient, $idParcours) {
        $txt_sql = "DELETE FROM evenement WHERE activiteId=" . $this->db->escape($idActivite) . " AND patientId=" . $this->db->escape($idPatient) . "AND parcoursId=" . $this->db->escape($idParcours);
        $this->db->query($txt_sql);
    }

    /**
     * Met à jour un événement de la base de données
     * @param $start : date de début de l'événement
     * @param $end : date de fin de l'activité
     * @param $idRessource : id de la ressource
     * @param $idActivite : id de l'activité
     * @param $idPatient : id du patient
     * @param $idParcours : id du parcours
     * @param $id : id de l'événement à modifier
     */
    public function updateEvent($start, $end, $idRessource, $idActivite, $idPatient, $idParcours, $id) {

        $ressourcePossible = $this->getRessourcePossiblePourUneActivite($idActivite);
        if ($ressourcePossible == null) {
            $possible = true;
        } else {
            $possible = false;
        }

        foreach ($ressourcePossible as $r) {
            if ($idRessource == $r["id"]) {
                $possible = $this->getDisponibiliteRessource($idRessource, $start, $end);
            }
        }

        if ($possible) {

            $txt_sql = "UPDATE evenement
                    SET ressourceId= " . $this->db->escape($idRessource) . " WHERE id=" . $this->db->escape($id);
            $this->db->query($txt_sql);

            $txt_sql = "UPDATE evenement
                    SET start = " . $this->db->escape($start) . ", end=" . $this->db->escape($end) . " WHERE activiteId=" . $this->db->escape($idActivite) . ""
                    . " AND patientId=" . $this->db->escape($idPatient) . "AND parcoursId=" . $this->db->escape($idParcours);
            $this->db->query($txt_sql);
        }
    }

    /**
     * Récupére tous les besoins d'un événement en fonction de l'id de son activité
     * @param $idActivite : id de l'activité de l'événement
     */
    public function necessite($idActivite) {
        $txt_sql = "SELECT n.QUANTITE as quantite, t.TXT_NOM as nom
                    FROM necessiter n, activite a, typeressource t
                    WHERE n.ID_TYPERESSOURCE = t.ID_TYPERESSOURCE
                    and n.ID_ACTIVITE = a.ID_ACTIVITE
                    and a.ID_ACTIVITE = " . $idActivite;

        $query = $this->db->query($txt_sql);
        $necessite = "";
        $i = 0;

        foreach ($query->result() as $row) {
            if ($i == 0) {
                $necessite = $row->quantite . " " . $row->nom;
            } else {
                $necessite .= ", " . $row->quantite . " " . $row->nom;
            }
            $i++;
        }

        return $necessite;
    }

    /**
     * Récupére toutes les précédences d'une activité d'un événement pour un parcours
     * @param $idActivite : id de l'activité de l'événement
     * @param $idParcours : id du parcours
     * @return une chaîne de caractère de la forme "NOM_ACTIVITE1, NOM_ACTIVITE2..."
     */
    public function precedence($idActivite, $idParcours) {
        $txt_sql = "SELECT a.TXT_NOM as precedent
                    FROM composer c, activite a, parcours p
                    Where a.ID_ACTIVITE = c.ID_ACTIVITE_PRECEDENTE
                    and p.ID_PARCOURS = c.ID_PARCOURS
                    and c.ID_ACTIVITE = " . $idActivite . "
                    and p.ID_PARCOURS = " . $idParcours;

        $query = $this->db->query($txt_sql);
        $precedent = "";

        $i = 0;

        foreach ($query->result() as $row) {
            if ($i == 0) {
                $precedent = $row->precedent;
            } else {
                $precedent .= ", " . $row->precedent;
            }
            $i++;
        }

        return $precedent;
    }

    /**
     * Récupère toutes les précédences d'une activité d'un événement pour un parcours
     * @param $idActivite : id de l'activité de l'événement
     * @param $idParcours : id du parcours
     * @return un tableau regroupant les id des activités précédentes
     */
    public function precedenceId($idActivite, $idParcours) {
        $txt_sql = "SELECT a.ID_ACTIVITE as precedent
                    FROM composer c, activite a, parcours p
                    Where a.ID_ACTIVITE = c.ID_ACTIVITE_PRECEDENTE
                    and p.ID_PARCOURS = c.ID_PARCOURS
                    and c.ID_ACTIVITE = " . $idActivite . "
                    and p.ID_PARCOURS = " . $idParcours;

        $query = $this->db->query($txt_sql);
        $precedent = array();

        foreach ($query->result() as $row) {
            $precedent[] = $row->precedent;
        }
        
        return $precedent;
    }
    
    /**
     * Récupère toutes les ressources disponibles entre deux dates
     * 
     * @param $id : id du type de ressource
     * @param $quantite : quantite de ressource nécessaire
     * @param $start : date de début
     * @param $end : date de fin
     */
    public function getRessourceByType($id, $quantite, $start, $end) {

        $res = array();
        // la première ressource disponible
        $txt_sql = "SELECT r.ID_RESSOURCE as id
                    FROM ressource r, typeressource tr
                    WHERE r.ID_TYPERESSOURCE = tr.ID_TYPERESSOURCE
                    AND tr.ID_TYPERESSOURCE = " . $id . "
                    AND r.ID_RESSOURCE not in (SELECT e.ressourceId 
							FROM evenement e
                                                        WHERE (e.start >= " . $this->db->escape($start) . " AND e.start < " . $this->db->escape($end) .")
                                                        OR (e.end > " . $this->db->escape($start) . " AND e.end <= " . $this->db->escape($end) .")
                                                        OR (e.start <= " . $this->db->escape($start) . " AND e.end >= " . $this->db->escape($end) . "))
                    LIMIT " . $quantite;

        $query = $this->db->query($txt_sql);

        foreach ($query->result() as $row) {
            array_push($res, $row->id);
        }

        if (empty($res)) {
            // sinon la première ressource
            $txt_sql = "SELECT r.ID_RESSOURCE as id
                    FROM ressource r, typeressource t
                    WHERE r.ID_TYPERESSOURCE = t.ID_TYPERESSOURCE
                    AND t.ID_TYPERESSOURCE = " . $id . "
                    LIMIT " . $quantite;

            $query = $this->db->query($txt_sql);

            foreach ($query->result() as $row) {
                array_push($res, $row->id);
            }
        }

        return $res;
    }

    /**
     * Récupère toutes les ressources disponibles entre deux dates
     * 
     * @param $id : id du type de ressource
     * @param int $quantite : la quantite
     * @param string $start : date de début
     * @param string $end : date de fin
     */
    public function getRessourceAvailable($id, $quantite, $start, $end) {

        $res = array();
        // la première ressource disponible
        $txt_sql = "SELECT r.ID_RESSOURCE as id
                    FROM ressource r, typeressource tr
                    WHERE r.ID_TYPERESSOURCE = tr.ID_TYPERESSOURCE
                    AND tr.ID_TYPERESSOURCE = " . $id . "
                    AND r.ID_RESSOURCE not in (SELECT e.ressourceId 
							FROM evenement e
                                                        WHERE (e.start > " . $this->db->escape($start) . " AND e.start <= " . $this->db->escape($end) .")
                                                        OR (e.end >= " . $this->db->escape($start) . " AND e.end < " . $this->db->escape($end) .")
                                                        OR (e.start <= " . $this->db->escape($start) . " AND e.end >= " . $this->db->escape($end) . ")
                                                        OR (e.start > " . $this->db->escape($start) . " AND e.end < " . $this->db->escape($end) . "))
                    LIMIT " . $quantite;

        $query = $this->db->query($txt_sql);

        foreach ($query->result() as $row) {
            array_push($res, $row->id);
        }

        $startObject = DateTime::createFromFormat('Y-m-d H:i:s', $start);
        $endObject = DateTime::createFromFormat('Y-m-d H:i:s', $end);
        
        while(empty($res)){            
            $startObject->modify('+5 minutes');
            $endObject->modify('+5 minutes');

            $start = $startObject->format('Y-m-d H:i:s');
            $end = $endObject->format('Y-m-d H:i:s');
                    
            $txt_sql = "SELECT r.ID_RESSOURCE as id
                    FROM ressource r, typeressource tr
                    WHERE r.ID_TYPERESSOURCE = tr.ID_TYPERESSOURCE
                    AND tr.ID_TYPERESSOURCE = " . $id . "
                    AND r.ID_RESSOURCE not in (SELECT e.ressourceId 
							FROM evenement e
                                                        WHERE (e.start > " . $this->db->escape($start) . " AND e.start <= " . $this->db->escape($end) .")
                                                        OR (e.end >= " . $this->db->escape($start) . " AND e.end < " . $this->db->escape($end) .")
                                                        OR (e.start <= " . $this->db->escape($start) . " AND e.end >= " . $this->db->escape($end) . ")
                                                        OR (e.start > " . $this->db->escape($start) . " AND e.end < " . $this->db->escape($end) . "))
                    LIMIT " . $quantite;
                    
            $query = $this->db->query($txt_sql);
            foreach ($query->result() as $row) {
                array_push($res, $row->id);
            }
        }
        
        $newDate = array(
            "Debut" => $start,
            "Fin"   => $end
        );
 
        return array_merge($res, $newDate);
    }

    /**
     * Récupère la liste des ressources possibles pour une activité d'un événement
     * @param $idActivite : id de l'activite
     */
    public function getRessourcePossiblePourUneActivite($idActivite) {
        $txt_sql = "SELECT r.ID_RESSOURCE as id
                    FROM necessiter n, ressource r
                    WHERE n.ID_TYPERESSOURCE = r.ID_TYPERESSOURCE
                    AND n.ID_ACTIVITE =" . $this->db->escape($idActivite);

        $query = $this->db->query($txt_sql);
        $res = array();

        foreach ($query->result() as $row) {
            $restemp = array();
            $restemp["id"] = $row->id;
            array_push($res, $restemp);
        }

        return $res;
    }

    /**
     * Récupère la liste des activités à planifier pour une date donnée en 
     * fonction du nom du patient
     * @param string $date : date
     * @param string $recherche : nom du patient à rechercher
     */
    public function getActiviteAplanifierRecherche($date, $recherche) {
        if ($recherche != "") {
            // activité à planifier (rendez vous dans la table patient )
            $txt_sql = "SELECT DISTINCT(activite.ID_ACTIVITE) as id_activite, patient.ID_PATIENT as id_patient, parcours.ID_PARCOURS as id_parcours, activite.TXT_NOM as nom_activite, patient.TXT_NOM as nom_patient, patient.TXT_PRENOM as prenom_patient, parcours.TXT_NOM as nom_parcours, activite.INT_DUREE as duree
                    FROM patient, parcours, composer, activite
                    WHERE patient.ID_PARCOURS_SUP = parcours.ID_PARCOURS
                    AND parcours.ID_PARCOURS = composer.ID_PARCOURS
                    AND composer.ID_ACTIVITE = activite.ID_ACTIVITE
                    AND DATE(DATE_DISPONIBLE_DEBUT) =" . $this->db->escape($date) . "
                    AND UPPER(patient.TXT_nom) like '%" . $this->db->escape_str(strtoupper($recherche)) . "%'";
            $query = $this->db->query($txt_sql);
            $res = array();

            foreach ($query->result() as $row) {
                $restemp = array();

                $restemp["activite_id"] = $row->id_activite;
                $restemp["patient_id"] = $row->id_patient;
                $restemp["parcours_id"] = $row->id_parcours;
                $restemp["nom_activite"] = $row->nom_patient . " " . $row->prenom_patient . " - " . $row->nom_activite . " - " . $row->nom_parcours;
                //Convertir durée en minutes en heure, minutes, seconde (hh:mm:ss)
                $secondes = $row->duree * 60;
                $temp = $secondes % 3600;
                $time[0] = ( $secondes - $temp ) / 3600;
                $time[2] = $temp % 60;
                $time[1] = ( $temp - $time[2] ) / 60;
                $restemp["duree"] = $time[0] . ":" . $time[1] . ":" . $time[2];
                $restemp["activite_precedente"] = $this->precedence($row->id_activite, $row->id_parcours);
                $restemp["necessite"] = $this->necessite($row->id_activite);
                array_push($res, $restemp);
            }

            // activité déja planifiée
            $txt_sql2 = "SELECT DISTINCT(activite.ID_ACTIVITE) as id_activite, patient.ID_PATIENT as id_patient, parcours.ID_PARCOURS as id_parcours, activite.TXT_NOM as nom_activite, patient.TXT_NOM as nom_patient, patient.TXT_PRENOM as prenom_patient, parcours.TXT_NOM as nom_parcours, activite.INT_DUREE as duree
					FROM evenement, parcours, activite, patient
                	WHERE patient.ID_PATIENT = evenement.patientId
                	AND parcours.ID_PARCOURS = evenement.parcoursId
                	AND activite.ID_ACTIVITE = evenement.activiteId
                	AND DATE(start) = " . $this->db->escape($date) . "
                        AND UPPER (patient.TXT_nom) like '%" . $this->db->escape_str(strtoupper($recherche)) . "%'";
            $query2 = $this->db->query($txt_sql2);

            $res2 = array();
            foreach ($query2->result() as $row) {
                $restemp = array();
                $restemp["activite_id"] = $row->id_activite;
                $restemp["patient_id"] = $row->id_patient;
                $restemp["parcours_id"] = $row->id_parcours;
                $restemp["nom_activite"] = $row->nom_patient . " " . $row->prenom_patient . " - " . $row->nom_activite . " - " . $row->nom_parcours;
                //Convertir durée en minutes en heure, minutes, seconde (hh:mm:ss)
                $secondes = $row->duree * 60;
                $temp = $secondes % 3600;
                $time[0] = ( $secondes - $temp ) / 3600;
                $time[2] = $temp % 60;
                $time[1] = ( $temp - $time[2] ) / 60;
                $restemp["duree"] = $time[0] . ":" . $time[1] . ":" . $time[2];
                $restemp["activite_precedente"] = $this->precedence($row->id_activite, $row->id_parcours);
                $restemp["necessite"] = $this->necessite($row->id_activite);
                array_push($res2, $restemp);
            }

            //retiré du tableau les activités déja planifiées
            foreach ($res as $i => &$value) {
                foreach ($res2 as $j => $value1) {
                    // Si les deux activités, patient, parcours sont identiques alors on supprime cette activité du tableau $res
                    if (($value["activite_id"] == $value1["activite_id"]) && ($value["patient_id"] == $value1["patient_id"]) && ($value["parcours_id"] == $value1["parcours_id"])) {
                        unset($res[$i]);
                    }
                }
            }
        } else {
            $res = $this->getActiviteAplanifier($date);
        }

        return array_merge($res);
    }

    /**
     * Fonction de récupération d'une couleur aléatoire
     */
    function couleur_aleatoire() {
        $couleur = array('#FF6633', '#ffcc99', '#99cccc', '#669999', '#CC9999', 'FFCCCC', '99CCCC', '#999999',
            '#00FFFF',
            '#000090',
            '#008C90',
            '#B88410',
            '#A8ACA8',
            '#006400',
            '#B8B868',
            '#880088',
            '#586C30',
            '#FF8C00',
            '#9830C8',
            '#880000',
            '#F09880',
            '#90BC90',
            '#483C88',
            '#305050',
            '#00D0D8',
            '#9800D8',
            '#FF1490',
            '#00BCFF',
            '#686868',
            '#2090FF');
        $valeur = rand(0, 29);
        return $couleur[$valeur];
    }

    /**
     * Fonction de suppression de tous les événements liés à un patient pour 
     * une date donnée
     * @param $idPatient : id du patient
     * @param $date : date
     */
    function deleteAllEventPatient($idPatient, $date) {
        $txt_sql = "DELETE FROM evenement WHERE patientId=" . $this->db->escape($idPatient) . " AND DATE(start) =" . $this->db->escape($date);
        $this->db->query($txt_sql);
    }

    /**
     * Récupère la couleur d'un évènement pour un patient
     * @param $idPatient : id du patient
     */
    public function getCouleurEventPatient($idPatient) {
        $txt_sql = "SELECT color as couleur
                    FROM evenement e
                    WHERE e.patientId = " . $this->db->escape($idPatient);

        $query = $this->db->query($txt_sql);

        $row = $query->row_array();

        return $row['couleur'];
    }

    /**
     * Sauvegarde le planning (suppression des événements déja planifiés)
     */
    public function sauvegarderPlanning() {
        $txt_sql = "DELETE FROM ordonnancer";
        $this->db->query($txt_sql);

        $txt_sql = "INSERT INTO ordonnancer SELECT * FROM evenement";
        $this->db->query($txt_sql);
    }

    /**
     * Permet de restaurer un planning (chargement de la dernière sauvegarde).
     * 
     * La restauration d'un planning entraîne la suppression des modifications 
     * non enregistrées.
     */
    public function restaurerPlanning() {
        $txt_sql = "DELETE FROM evenement";
        $this->db->query($txt_sql);

        $txt_sql = "INSERT INTO evenement SELECT * FROM ordonnancer";
        $this->db->query($txt_sql);
    }

    /**
     * Méthode de planification automatique des évènements selon une date donnée.
     * 
     * La planification des activités se fait ici patient par patient par ordre 
     * d'id.
     * 
     * @param $date : jour que l'on souhaite planifier
     */
    public function planAuto($date) {
        $this->load->model('M_Patient');
    
        $activites = $this->getActiviteAplanifier($date);        

        $patientIdColumn = array_column($activites, 'patient_id');
        
        $patientArray = array_count_values($patientIdColumn);
        
        $listeIdPatient = array_keys($patientArray);
        
        for($i = 0; $i < count($listeIdPatient); $i++){
            $activitesPatient = array();
            foreach ($activites as $value){
                if ($listeIdPatient[$i]==$value["patient_id"]){
                   array_push($activitesPatient, $value);
                }
            }
            
            reset($activites);
            
            $donneesPatient = $this->M_Patient->getPatientById($listeIdPatient[$i]);
            
            $start = DateTime::createFromFormat('Y-m-d H:i:s', $donneesPatient["DATE_DISPONIBLE_DEBUT"]);
            
            $idTemp = array(0);
            while(!empty($activitesPatient)){
                $activitesAAjouter = array();
                
                foreach($activitesPatient as $actPatient){
                    $actPrecPatient = $this->precedenceId($actPatient["activite_id"],
                            $actPatient["parcours_id"]);
                    
                    if (empty(array_diff($actPrecPatient, $idTemp))){
                        array_push($activitesAAjouter, $actPatient);
                    }
                }
                
                foreach($activitesAAjouter as $act){
                    $dureeActivite = explode(":", $act["duree"]);

                    $startTemp = clone($start);
                    
                    $end = $start->modify('+'.$dureeActivite[0].' hour');            
                    $end = $start->modify('+'.$dureeActivite[1].' minutes');

                    $startString = $startTemp->format('Y-m-d H:i:s');
                    $endString = $end->format('Y-m-d H:i:s');

                    $endDate = $this->addEvenementAuto($act["nom_activite"], 
                                $startString, $endString, 
                                $act["activite_id"], $act["patient_id"], $act["parcours_id"]);
                    
                    //Ajuste le prochain début d'activité sur la fin de la dernière
                    $start = DateTime::createFromFormat('Y-m-d H:i:s', $endDate);
                    
                    array_push($idTemp, $act["activite_id"]);
                    array_splice($activitesPatient, array_search($act, $activitesPatient), 1);
                }
            }
        }
    }
    
    /**
     * Récupération des disponibilités d'une ressource
     * 
     * Cette méthode permet d'indiquer si une ressource est disponible dans 
     * l'intervalle de temps [$start;$end]
     * 
     * @param int $idRessource identifiant de la ressource
     * @param string $start heure de début
     * @param string $end heure de fin
     */
    public function getDisponibiliteRessource($idRessource, $start, $end){
        
    //s'il y a une activité sur la ressource dont le début est avant le $end
    //et dont la fin est après le $start -> return false
        $txt_sql = "SELECT start, end 
            FROM evenement 
            WHERE ressourceId=" . $this->db->escape($idRessource);

        $query = $this->db->query($txt_sql);

        $start = new DateTime($start);
        $end = new DateTime($end);        
        
        foreach($query->result() as $row){
            $startRow = new DateTime($row->start);
            $endRow = new DateTime($row->end);
                  
            if(($start < $endRow && $start >= $startRow) //vrai si $start est inclue dans une activité 
                    || ($end > $startRow && $end <= $endRow) //vrai si $end est inclue dans une activité
                    || ($start <= $startRow && $end >= $endRow)){// vrai si une activité existe sur la plage $start-$end
                return FALSE;
            }
        }
        
        return TRUE;
    }
}
