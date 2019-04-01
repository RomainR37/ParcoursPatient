<?php

/**
 * Contrôleur de la page de plannification
 * 
 * Contient les différentes méthodes de gestion du planning
 * 
 * @author    Guillaume Pochet
 * @version   1.0
 * @since      09 Mars 2017
 */
class Planning extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata("username") === null)
            redirect('/Auth', 'refresh');
        if ($this->session->userdata("level") === "1")
            redirect('/AffichageSejour', 'refresh');
    }

    /**
     * Permet d'afficher la vue de planification générale
     */
    public function planifier() {
        $data['chemin'] = '/planning/V_planning_planifier';
        $this->load->view('/V_generale', $data);
    }

    /**
     * Permet d'afficher la page de création de jeux de données
     */
    public function creerJeuxDeDonnees() {
        $data['chemin'] = '/planning/V_planning_creerDonnees';
        $this->load->view('/V_generale', $data);
    }

    /**
     * Permet de récupérer la liste de toutes les ressources humaines ou 
     * matérielles
     * 
     * Permet de récupérer la liste de toutes les ressources humaines ou 
     * matérielles. Retourne la liste des ressources au format JSON :
     * {id: "1", title: "Soumaya Cheniour", type_ressource: "IDE obésité"}
     */
    public function getRessources() {

        $this->load->model('M_Planning');
        $data = $this->M_Planning->getAllRessource();

        echo json_encode($data);
    }

    /**
     * Permet de récupérer la liste de tous les événements à ajouter au planning
     * 
     * Permet de récupérer la liste de tous les événements à ajouter au 
     * planning. Retourne la liste des événements au format JSON :
      {activiteId:"1",
      activite_precedente:"Début",
      color:"#FF1490",
      end:"2017-03-28 10:20:00",
      id:"325",
      necessite:"1 IDE obésité, 1 HDJ obésité",
      parcoursId:"1",
      patientId:"1",
      resourceId:"1",
      start:"2017-03-28 10:00:00",
      title:"Martin Simon - RDV paramédical - Obésité sévère – diagnostique}"
     */
    public function getEvenement() {

        $this->load->model('M_Planning');
        $data = $this->M_Planning->getAllEvenement();

        echo json_encode($data);
    }

    /**
     * Permet d'afficher la liste de toutes les activités à planifier
     * 
     * Permet d'afficher la liste de toutes les activités à planifier pour une 
     * date donnée. Retourne la liste des activités au format JSON :
     * {activite_id:"1",
      activite_precedente:"Début",
      duree:"0:20:0",
      necessite:"1 IDE obésité, 1 HDJ obésité",
      nom_activite:"pochet guillaume - RDV paramédical - Obésité sévère – diagnostique",
      parcours_id:"1",
      patient_id:"11"}
     */
    public function getActiviteAPlanifier() {

        $this->load->model('M_Planning');

        $date = $this->input->post("date");
        $data["activite"] = $this->M_Planning->getActiviteAplanifier($date);

        echo json_encode($data);
    }

    /**
     * Permet d'afficher la liste de toutes les activités à planifier en 
     * recherchant un nom de patient
     * 
     * Permet d'afficher la liste de toutes les activités à planifier en 
     * recherchant un nom de patient pour une date donnée. Retourne la liste 
     * des activités au format JSON :
     *             {activite_id:"1",
      activite_precedente:"Début",
      duree:"0:20:0",
      necessite:"1 IDE obésité, 1 HDJ obésité",
      nom_activite:"pochet guillaume - RDV paramédical - Obésité sévère – diagnostique",
      parcours_id:"1",
      patient_id:"11"}
     */
    public function getActiviteAPlanifierRecherche() {

        $this->load->model("M_Planning");
        $recherche = $this->input->post("recherche");
        $date = $this->input->post("date");

        $data["activite"] = $this->M_Planning->getActiviteAplanifierRecherche($date, $recherche);

        echo json_encode($data);
    }

    /**
     * Permet d'ajouter un événement
     * 
     * Permet d'ajouter un événement. Récupére la liste des informations d'un 
     * événement et les ajoute en base de données.
     */
    public function addEvent() {

        $this->load->model('M_Planning');
        $title = $this->input->post("title");
        $start = new DateTime($this->input->post("start"));
        $start = $start->format('Y-m-d H:i:s');
        $end = new DateTime($this->input->post("end"));
        $end = $end->format('Y-m-d H:i:s');
        $ressourceId = $this->input->post("ressourceId");
        $activiteId = $this->input->post("activiteId");
        $patientId = $this->input->post("patientId");
        $parcoursId = $this->input->post("parcoursId");

        $this->M_Planning->addEvenement($title, $start, $end, $ressourceId, $activiteId, $patientId, $parcoursId);
        $data["sucess"] = 'ok';

        echo json_encode($data);
    }

    /**
     * Permet de supprimer un événement
     * 
     * Permet de supprimer un événement de la base de données
     */
    public function deleteEvent() {
        $this->load->model('M_Planning');

        $idActivite = $this->input->post("idActivite");
        $idPatient = $this->input->post("idPatient");
        $idParcours = $this->input->post("idParcours");
        $this->M_Planning->deleteEvent($idActivite, $idPatient, $idParcours);

        $data["sucess"] = 'ok';
        echo json_encode($data);
    }

    /**
     * Permet de vérifier les contraintes liées à la planification
     * 
     * Permet de vérifier les contraintes liées à la planification. Retourne 
     * la liste des contraintes au format JSON :
     * 0:"Toutes les activités ne sont pas planifiées."
      1:"Un patient ne peut pas faire 2 activités à la fois. (Patient : Robert Garcia)"
     * 
     * Voici la liste des contraintes à vérifier :
     * 
     * Vérifier fenetre de temps du patient - 1  - FAIT
     * Delai min et max entre chaque activité d'un même pp - 2 - FAIT
     * Précédences dans un pp - 3 - FAIT 
     * Affecter ressources à une activité + vérifier le nombre - 4 -FAIT
     * Toutes les activités sont planifiés - 5- FAIT
     * Ressources synchronisés - 6 - FAIT
     * 1 ressource = 1 activité à la fois - 7 - FAIT
     * 
     * 1 : gérer avec les contraintes
     * 2 : gérer avec les contraintes
     * 3 : gérer avec les contraintes
     * 4 : Type ressource affecté gérer avec fullCalendar, vérifier le nombre avec les contraintes
     * 5 : gérer avec les contraintes
     * 6 : gérer avec fullCalendar
     * 7 : gérer avec les contraintes
     */
    public function constraints() {

        $constraints = array();

        $date = new DateTime($this->input->post("date"));
        $date = $date->format("Y-m-d");
        $this->load->model("M_Planning");
        $this->load->model("M_Patient");
        $this->load->model("M_Parcours");
        $this->load->model("M_Activite");

        $evenements = $this->M_Planning->getAllEvenementByDate($date);
        $activites = $this->M_Planning->getActiviteAplanifier($date);


        if ($activites != null) {
            array_push($constraints, "Toutes les activités ne sont pas planifiées.");
        }

        foreach ($evenements as $evenement) {
            /*
             * Vérifier fenetre de temps du patient - 1  - FAIT
             * Delai min et max entre chaque activités d'un même pp - 2 - FAIT
             * Précédences dans un pp - 3 - FAIT 
             * Affecter ressources à une activité + vérifier le nombre - 4 -FAIT
             * Toutes les activités sont planifiés - 5- FAIT
             * Ressources synchronisés - 6 - FAIT
             * 1 ressource = 1 activité à la fois - 7 - FAIT
             * 
             * 1 : gérer avec les contraintes
             * 2 : gérer avec les contraintes
             * 3 : gérer avec les contraintes
             * 4 : Type ressource affecté gérer avec fullCalendar, vérifier le nombre avec les contraintes
             * 5 : gérer avec les contraintes
             * 6 : gérer avec fullCalendar
             * 7 : gérer avec les contraintes
             */

            // Verifier fenetre de temps de chaque patient
            if ($evenement['patientId'] != null) {
                $patient = $this->M_Patient->getPatientById($evenement['patientId']);
                if ($patient['DATE_DISPONIBLE_DEBUT'] > $evenement['start'] || $patient['DATE_DISPONIBLE_FIN'] < $evenement['end']) {
                    if (!in_array("Le patient " . $patient["TXT_NOM"] . " " . $patient['TXT_PRENOM'] . " n'est pas disponible.", $constraints)) {
                        array_push($constraints, "Le patient " . $patient["TXT_NOM"] . " " . $patient['TXT_PRENOM'] . " n'est pas disponible.");
                        array_push($constraints, "Le patient " . $patient["TXT_NOM"] . " " . $patient['TXT_PRENOM'] . " est disponible de " . date_format(date_create($patient['DATE_DISPONIBLE_DEBUT']), "G:ia") . " à " . date_format(date_create($patient['DATE_DISPONIBLE_FIN']), "G:ia"));
                    }
                }
            }

            // 1 ressource = 1 activité à la fois
            // 1 patient = 1 activité à la fois
            foreach ($evenements as $evenement2) {
                if (!($evenement['resourceId'] == 0 || $evenement2['resourceId'] == 0)){
                    if ($evenement['resourceId'] == $evenement2['resourceId'] && $evenement['id'] != $evenement2['id']) {
                        if ($evenement['end'] > $evenement2['start'] && $evenement['start'] < $evenement2['end']) {
                            if (!in_array("Une ressource ne peut pas faire 2 activités à la fois.", $constraints)) {
                                array_push($constraints, "Une ressource ne peut pas faire 2 activités à la fois.");
                            }
                        }
                    }                    
                }
                if ($evenement['patientId'] == $evenement2['patientId'] && $evenement['id'] != $evenement2['id']) {
                    if ($evenement['end'] > $evenement2['start'] && $evenement['start'] < $evenement2['end']) {
                        if ($evenement['title'] != $evenement2['title']) {
                            $patient = $this->M_Patient->getPatientById($evenement['patientId']);
                            if (!in_array("Un patient ne peut pas faire 2 activités à la fois. (Patient : " . $patient["TXT_NOM"] . " " . $patient['TXT_PRENOM'] . ")", $constraints)) {
                                array_push($constraints, "Un patient ne peut pas faire 2 activités à la fois. (Patient : " . $patient["TXT_NOM"] . " " . $patient['TXT_PRENOM'] . ")");
                            }
                        }
                    }
                }
            }
        }

        $listeParcours = $this->M_Planning->getParcoursByDate($date);

        foreach ($listeParcours as $parcours) {
            // contraintes de précedences
            if ($parcours['parcoursId'] != null) {
                $parcoursPlanifie = $this->M_Planning->getParcoursByDateAndPatient($date, $parcours['patientId'], $parcours['parcoursId']);
                // pour chaque activitéPlanifié
                foreach ($parcoursPlanifie as $act) {
                    // On récupére la liste des activités précédentes
                    $activitePrecedentes = $this->M_Parcours->getDependancesActivites($act['activiteId'], $parcours['parcoursId']);
                    // pour chaque activite précédente, on vérifie qu'ils sont planifiées avant
                    foreach ($activitePrecedentes as $actPrecedentes) {
                        if ($actPrecedentes != 0) {
                            $detail = $this->M_Planning->getDetailEvenement($actPrecedentes['id'], $parcours['parcoursId'], $parcours['patientId'], $date);
                            if ($detail != null) {
                                if ($detail[0]['end'] > $act['start']) {
                                    $activite = $this->M_Activite->getActiviteById($act["activiteId"]);
                                    $activitePrec = $this->M_Activite->getActiviteById($detail[0]["activiteId"]);
                                    $patient = $this->M_Patient->getPatientById($parcours['patientId']);
                                    if (!in_array($activite['nom_activite'] . " ne peut pas être avant " . $activitePrec['nom_activite'] . " (Patient : " . $patient["TXT_NOM"] . " " . $patient['TXT_PRENOM'] . ")", $constraints)) {
                                        array_push($constraints, $activite['nom_activite'] . " ne peut pas être avant " . $activitePrec['nom_activite'] . " (Patient : " . $patient["TXT_NOM"] . " " . $patient['TXT_PRENOM'] . ")");
                                    }
                                } else {
                                    // l'activité est bien planifiée (précédence)
                                    // vérification des délais min et max
                                    $end_min = new DateTime($detail[0]['end']);
                                    $end_max = new DateTime($detail[0]['end']);
                                    $delaiMin = $end_min->add(new DateInterval('PT' . $actPrecedentes['delaiMin'] . 'M'));
                                    $min = $delaiMin->format('Y-m-d H:i:s');
                                    $delaiMax = $end_max->add(new DateInterval('PT' . $actPrecedentes['delaiMax'] . 'M'));
                                    $max = $delaiMax->format('Y-m-d H:i:s');
                                    if ($min > $act['start']) {
                                        $activite = $this->M_Activite->getActiviteById($act["activiteId"]);
                                        $activitePrec = $this->M_Activite->getActiviteById($detail[0]["activiteId"]);
                                        $patient = $this->M_Patient->getPatientById($parcours['patientId']);
                                        if (!in_array("Le delai min entre " . $activite['nom_activite'] . " et " . $activitePrec['nom_activite'] . " n'est pas respecté (DelaiMin : " . $actPrecedentes['delaiMin'] . "minutes) (Patient : " . $patient["TXT_NOM"] . " " . $patient['TXT_PRENOM'] . ")", $constraints)) {
                                            array_push($constraints, "Le delai min entre " . $activite['nom_activite'] . " et " . $activitePrec['nom_activite'] . " n'est pas respecté (DelaiMin : " . $actPrecedentes['delaiMin'] . "minutes) (Patient : " . $patient["TXT_NOM"] . " " . $patient['TXT_PRENOM'] . ")");
                                        }
                                    }
                                    if ($max < $act['start']) {
                                        $activite = $this->M_Activite->getActiviteById($act["activiteId"]);
                                        $activitePrec = $this->M_Activite->getActiviteById($detail[0]["activiteId"]);
                                        $patient = $this->M_Patient->getPatientById($parcours['patientId']);
                                        if (!in_array("Le delai max entre " . $activite['nom_activite'] . " et " . $activitePrec['nom_activite'] . " n'est pas respecté (DelaiMax : " . $actPrecedentes['delaiMax'] . "minutes) (Patient : " . $patient["TXT_NOM"] . " " . $patient['TXT_PRENOM'] . ")", $constraints)) {
                                            array_push($constraints, "Le delai max entre " . $activite['nom_activite'] . " et " . $activitePrec['nom_activite'] . " n'est pas respecté (DelaiMax : " . $actPrecedentes['delaiMax'] . "minutes) (Patient : " . $patient["TXT_NOM"] . " " . $patient['TXT_PRENOM'] . ")");
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }


        if ($constraints == null) {
            array_push($constraints, "Aucune erreur de planification.");
        }

        echo json_encode($constraints);
    }

    /**
     * Permet de mettre à jour un événement
     * 
     * Permet de mettre à jour un événement. Récupére la liste des informations 
     * d'un événement et les met à jour en base de données
     */
    public function updateEvent() {
        $this->load->model('M_Planning');
        $id = $this->input->post("id");
        $start = new DateTime($this->input->post("start"));
        $start = $start->format('Y-m-d H:i:s');
        $end = new DateTime($this->input->post("end"));
        $end = $end->format('Y-m-d H:i:s');
        $idRessource = $this->input->post("idRessource");
        $idActivite = $this->input->post("idActivite");
        $idPatient = $this->input->post("idPatient");
        $idParcours = $this->input->post("idParcours");

        $this->M_Planning->updateEvent($start, $end, $idRessource, $idActivite, $idPatient, $idParcours, $id);
        $data["sucess"] = 'ok';
        echo json_encode($data);
    }

    /**
     * Permet de supprimer tous les événements liés à un patient pour une date 
     * donnée
     */
    public function deleteEventsPatient() {
        $this->load->model('M_Planning');
        $id = $this->input->post("idPatient");
        $date = new DateTime($this->input->post("date"));
        $date = $date->format("Y-m-d");
        $this->M_Planning->deleteAllEventPatient($id, $date);

        $data["sucess"] = 'ok';
        echo json_encode($data);
    }

    /**
     * Permet de sauvegarder le planning
     */
    public function sauvegarder() {
        $this->load->model('M_Planning');
        $this->M_Planning->sauvegarderPlanning();
        $this->planifier();
    }

    /**
     * Permet de restaurer (reprise de la dernière sauvegarde) le planning
     */
    public function restaurer() {
        $this->load->model('M_Planning');
        $this->M_Planning->restaurerPlanning();
        $this->planifier();
    }

    
    /**
     * Fonction appelée lors du lancement d'une planification automatique.
     * 
     * Récupère la date en cours sur le calendrier et lance la fonction de 
     * planification du fichier M_Planning. Renvoie un message "ok" en cas de 
     * succès de la planification.
     */
    public function planAuto(){
        $this->load->model('M_Planning');
        $date = new DateTime($this->input->post("date"));
        $date = $date->format("Y-m-d");
        $this->M_Planning->planAuto($date);
     
        $data["success"] = 'ok';
        echo json_encode($data);
    }
    
}

?>