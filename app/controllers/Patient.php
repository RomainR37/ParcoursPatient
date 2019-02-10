<?php

/**
 * \file      Patient.php
 * \author    Guillaume Pochet
 * \version   1.0
 * \date      09 Mars 2017
 * \brief     Controller d'un patient
 *            
 *
 * \details   Contient les différentes méthodes de gestion des patients
 */
class Patient extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata("username") === null) {
            redirect('/Auth', 'refresh');
        }
        if ($this->session->userdata("level") === "1") {
            redirect('/AffichageSejour', 'refresh');
        }
    }

    /**
     * \brief      Permet d'afficher la liste des différents patients
     * \details    Méthode permettant la liaison entre la vue des patients et le modèle patient
     *             Récupére tous les patients et les envoie à la vue qui se charge de les afficher
     * \param      Aucun
     */
    function index() {
        $data = array();
        $data['chemin'] = '/patient/V_patient';
        $data['activites'] = $this->M_Patient->getAllActivities($this->session->userdata("id_individu"));
        $this->load->view('patient/V_patient', $data);
    }

    /**
     * \brief      Permet d'afficher le planning d'un patient
     * \details    Permet d'afficher le planning d'un patient
     *             Récupére la liste des activités planifiées d'un patient
     * \param      $id : identifiant du patient
     */
    public function afficherSejour($id) {
        $this->load->model('M_Patient');
        $data = array();
        $data['chemin'] = '/patient/V_patient';
        $data['activites'] = $this->M_Patient->getAllActivities($id);
        $this->load->view('patient/V_patient', $data);
    }

    /**
     * \brief      Permet de récuperer la liste des activitées d'un patient
     * \details    Récupère la liste des activités planifiées d'un patient
     *             Retourne la liste des activités au format JSON
     * \param      $id : identifiant du patient
     */
    public function getAllActivites($id) {
        $this->load->model('M_Patient');
        $data = array();
        $data = $this->M_Patient->getAllActivities($id);

        header('Content-Type: application/jsonp');
        echo json_encode($data);
    }

    /**
     * \brief      Permet d'afficher la vue de recherche d'un patient
     * \details    Récupère la liste des activités planifiées d'un patient
     * \param      Aucun
     */
    public function rechercher() {

        $data['chemin'] = '/patient/V_rechercher';
        $this->load->view('/V_generale', $data);
    }

    /**
     * \brief      Permet de rechercher un patient
     * \details    Permet de rechercher un patient
     * \param      Aucun
     */
    public function faireRecherche() {
        $this->load->model('M_Patient');
        $rechercher = $this->input->post("recherche");
        $data["patients"] = $this->M_Patient->patientParNomOuPrenom($rechercher);
        echo json_encode($this->load->view('/patient/Div_tableauPatient', $data, TRUE));
    }

    /**
     * \brief      Afficher un patient en fonction de son id
     * \details    Affiche toutes les informations liées à un patient
     * \param      $id : id du patient
     */
    public function afficherPatient($id) {

        $this->load->library('form_validation');

        $this->load->helper('form');
        $this->load->model('M_Patient');
//        $patient = [];
        $patient = $this->M_Patient->getPatientById($id);
//        $patient = $patient[0];
        $_POST["id-patient"] = $patient['ID_PATIENT'];
        $_POST["nom-patient"] = $patient['TXT_NOM'];
        $_POST["prenom-patient"] = $patient['TXT_PRENOM'];
        $_POST["num-add-patient"] = $patient['TXT_ADRESSENUM'];
        $_POST["rue-add-patient"] = $patient['TXT_ADRESSERUE'];
        $_POST["cp-add-patient"] = $patient['TXT_ADRESSECODEPOSTAL'];
        $_POST["ville-add-patient"] = $patient['TXT_ADRESSEVILLE'];
        $_POST["pays-add-patient"] = $patient['TXT_ADRESSEPAYS'];
        $_POST["email-patient"] = $patient['TXT_MAIL'];
        $_POST["num-fixe-patient"] = $patient['TXT_TELEPHONEFIXE'];
        $_POST["tel-port-patient"] = $patient['TXT_TELEPHONEPORTABLE'];
        $_POST["num-secu-patient"] = $patient['TXT_NUMSECU'];
        $_POST["date-naiss-patient"] = $patient['DATE_NAISSANCE'];

        $data['chemin'] = '/patient/V_creation';

        $data['pathForm'] = "patient/modifierPatient";
        $this->load->view('/V_generale', $data);
    }

    /**
     * \brief      Affiche le formulaire d'ajout d'un patient
     * \details    Affiche le formulaire d'ajout d'un patient
     * \param      Aucun
     */
    public function creation() {

        $this->load->library('form_validation');

        $this->load->helper('form');

        $data['chemin'] = '/patient/V_creation';
        $data['pathForm'] = "patient/ajoutPatient";
        $this->load->view('/V_generale', $data);
    }

    /**
     * \brief      Affiche le formulaire d'ajout d'un rendez vous d'un patient (disponibilité)
     * \details    Affiche le formulaire d'ajout d'un rendez vous d'un patient (disponibilité)
     * \param      Aucun
     */
    public function jour() {

        $this->load->model('M_Parcours');
        $data['chemin'] = '/patient/V_jour';

        $data['parcours'] = $this->M_Parcours->getAllParcours();
        $this->load->view('/V_generale', $data);
    }

    /**
     * \brief      Permet de récupérer le nombre de patient planifié
     * \details    Permet de récupérer le nombre de patient planifié en fonction du jour et du parcours
     * \param      Aucun
     */
    public function getNbByDay() {
        $this->load->model('M_Patient');
        $idP = $this->input->post("idParcours");
        $date = $this->input->post("dateDebut");
        echo json_encode($this->M_Patient->nombreDePatientParcour($idP, $date));
    }

    /**
     * \brief      Permet d'ajout un rendez vous (ou disponibilité) à un patient
     * \details    Permet d'ajout un rendez vous (ou disponibilité) à un patient
     * \param      Aucun
     */
    public function majDisponibilite() {
        $this->load->model('M_Patient');
        $this->load->model('M_DossierParcours');
        $idParcours = $this->input->post("idParcours");
        $idPatient = $this->input->post("idPatient");
        $dateDebut = $this->input->post("heureDebut");
        $dateFin = $this->input->post("heureFin");
        $this->M_Patient->majDisponibilitePatient($idPatient, $idParcours, $dateDebut, $dateFin);
        $this->M_DossierParcours->nouvelleDossier($idPatient, $idParcours, $dateDebut, $dateFin);
        $data['chemin'] = '/patient/V_rechercher';
        $this->load->view('/V_generale', $data);
    }

    /**
     * \brief       Permet de modifier un patient
     * \details     permet de renouvler les infos sur un patient
     * \param       Aucun
     */
    public function majPatient(){
        $this->load->model("M_Patient");
        $idPatient = $this->input->post("id-patient");
        $nom = $this->input->post("nom-patient");
        $prenom = $this->input->post("prenom-patient");
        $noAdd = $this->input->post("num-add-patient");
        $rue = $this->input->post("rue-add-patient");
        $codePostel = $this->input->post("cp-add-patient");
        $ville = $this->input->post("ville-add-patient");
        $pays = $this->input->post("pays-add-patient");
        $email = $this->input->post("email-patient");
        $noFixe = $this->input->post("num-fixe-patient");
        $portable = $this->input->post("tel-port-patient");
        $secu = $this->input->post("num-secu-patient");
        $naissance = $this->input->post("date-naiss-patient");
        
        $this->M_Patient->modifierUnPatient($idPatient,$nom,$prenom,$noAdd,$rue,$codePostel,$ville,$pays,$email,$noFixe,$portable,$secu,$naissance);
        $data['chemin'] = '/patient/V_rechercher';
        $this->load->view('/V_generale', $data);
    }
    
    /*
     * \brief permet de modifier un dossier
     * \details permet de vérifier le renouvellement d'un dossier
     *          renouveler le parcours affecté au dossier
     *          renouveler la date début et fin de nouveau RDV
     * \param aucun
     * 
     */
    public function majDossier(){
        $this->load->model('M_Patient');
        $this->load->model('M_DossierParcours');
        $idParcours = $this->input->post("idParcours");
        $idPatient = $this->input->post("idPatient");
        $dateDebut = $this->input->post("heureDebut");
        $dateFin = $this->input->post("heureFin");
        $id_dossier = $this->uri->segment(3);
        $this->M_Patient->majDisponibilitePatient($idPatient, $idParcours, $dateDebut, $dateFin);
        $this->M_DossierParcours->majDossier( $id_dossier,$idParcours, $dateDebut, $dateFin);
        $this->gererRDV($idPatient);
        
    }
    
    /*
     * \brief permet d'ajouter un nouveau dossier
     * \details permet d'ajouter un nouveau dossier dans la base de donnée 
     * \param aucun
     */
    public function ajoutDossier(){
        $this->load->model('M_Patient');
        $this->load->model('M_DossierParcours');
        $idParcours = $this->input->post("idParcours");
        $idPatient = $this->input->post("idPatient");
        $dateDebut = $this->input->post("heureDebut");
        $dateFin = $this->input->post("heureFin");
        $this->M_Patient->majDisponibilitePatient($idPatient, $idParcours, $dateDebut, $dateFin);
        $this->M_DossierParcours->nouvelleDossier($idPatient, $idParcours, $dateDebut, $dateFin);
        $this->gererRDV($idPatient);
    }
    
    /**
     * \brief      Permet de verifier l'ajout d'un patient
     * \details    Permet de verifier l'ajout d'un patient à l'aide de form_validation
     *             Vérifier l'intégrité des données saisies à l'aide du formulaire d'ajout
     * \param      Aucun
     */
    
    public function ajoutPatient() {

        $this->load->library('form_validation');

        $this->load->helper('form');

        $this->form_validation->set_rules('nom-patient', 'Nom', 'trim|required|max_length[255]|alpha');
        $this->form_validation->set_rules('prenom-patient', 'Prénom', 'trim|required|max_length[255]|alpha');
        $this->form_validation->set_rules('num-add-patient', 'Numéro de rue', 'trim|required|max_length[5]|numeric');
        $this->form_validation->set_rules('rue-add-patient', 'Rue', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('cp-add-patient', 'Code postal', 'trim|required|max_length[5]|numeric');
        $this->form_validation->set_rules('ville-add-patient', 'Ville', 'trim|required|max_length[255]|alpha');
        $this->form_validation->set_rules('pays-add-patient', 'Pays', 'trim|required|max_length[255]|alpha');
        $this->form_validation->set_rules('email-patient', 'Email', 'trim|required|max_length[255]|valid_email');
        $this->form_validation->set_rules('num-fixe-patient', 'Téléphone fixe', 'trim|required|exact_length[10]|numeric');
        $this->form_validation->set_rules('tel-port-patient', 'Téléphone portable', 'trim|required|exact_length[10]|numeric');
        $this->form_validation->set_rules('num-secu-patient', 'Numéro de sécurité sociale', 'trim|required|exact_length[15]|numeric');
        $this->form_validation->set_rules('date-naiss-patient', 'Date de naissance', 'trim|required|max_length[255]');

        if ($this->form_validation->run() == FALSE) {
            $data['chemin'] = '/patient/V_creation';

            $data['pathForm'] = "patient/ajoutPatient";
            $this->load->view('/V_generale', $data);
        } else {

            $this->load->model('M_Parcours');
            $this->load->model('M_Patient');
            $nom = $this->input->post("nom-patient");
            $prenom = $this->input->post("prenom-patient");
            $adressenum = $this->input->post("num-add-patient");
            $adresseure = $this->input->post("rue-add-patient");
            $codepostale = $this->input->post("cp-add-patient");
            $ville = $this->input->post("ville-add-patient");
            $pays = $this->input->post("pays-add-patient");
            $mail = $this->input->post("email-patient");
            $telefix = $this->input->post("num-fixe-patient");
            $tele = $this->input->post("tel-port-patient");
            $numsecu = $this->input->post("num-secu-patient");
            $naissance = $this->input->post("date-naiss-patient");
            $uname = $nom.".".$prenom;
            $pwd = crypt($naissance, '$2a$07fhferjfjrjfhjerfbfcreef$');
            $idPatient = $this->M_Patient->ajouterUnPatient($uname, $pwd, $nom, $prenom, $adressenum, $adresseure, $codepostale, $ville, $pays, $mail, $telefix, $tele, $numsecu, $naissance, null, null, null);
            $data['chemin'] = '/patient/V_jour';
            //$data['pathForm'] = "patient/majDisponibilite";
            $data['pathForm'] = "patient/ajoutPatient";
            $data['idPatient'] = $idPatient;
            $data['parcours'] = $this->M_Parcours->getAllParcours();
            $this->load->view('/V_generale', $data);
        }
    }
     
    
     
    /**
     * \brief      Permet de verifier la modification d'un patient
     * \details    Permet de verifier la modification d'un patient à l'aide de form_validation
     *             Vérifier l'intégrité des données saisies à l'aide du formulaire de modification
     * \param      Aucun
     */
    
    public function modifierPatient($id) {

        $this->load->library('form_validation');

        $this->load->helper('form');
        $this->load->model('M_Patient');
//        $patient = [];
        $patient = $this->M_Patient->getPatientById($id);
//        $patient = $patient[0];
        $_POST["id-patient"] = $patient['ID_PATIENT'];
        $_POST["nom-patient"] = $patient['TXT_NOM'];
        $_POST["prenom-patient"] = $patient['TXT_PRENOM'];
        $_POST["num-add-patient"] = $patient['TXT_ADRESSENUM'];
        $_POST["rue-add-patient"] = $patient['TXT_ADRESSERUE'];
        $_POST["cp-add-patient"] = $patient['TXT_ADRESSECODEPOSTAL'];
        $_POST["ville-add-patient"] = $patient['TXT_ADRESSEVILLE'];
        $_POST["pays-add-patient"] = $patient['TXT_ADRESSEPAYS'];
        $_POST["email-patient"] = $patient['TXT_MAIL'];
        $_POST["num-fixe-patient"] = $patient['TXT_TELEPHONEFIXE'];
        $_POST["tel-port-patient"] = $patient['TXT_TELEPHONEPORTABLE'];
        $_POST["num-secu-patient"] = $patient['TXT_NUMSECU'];
        $_POST["date-naiss-patient"] = $patient['DATE_NAISSANCE'];

        $data['chemin'] = '/patient/V_creation';

        $data['pathForm'] = "patient/majPatient";
        $this->load->view('/V_generale', $data);
  
    }
    
    /**
     * \brief      Permet de verifier la validité d'une date
     * \details    Permet de verifier la validité d'une date à l'aide des expressions régulières
     * \param      Aucun
     */
    public function _dateRegex($date) {

        if (preg_match("/^(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1]\/[0-9]{4})$/", $date)) {
            $this->form_validation->set_message('Date de naissance', 'OK');
            return true;
        } else {
            $this->form_validation->set_message('Date de naissance', 'Le champ %s doit être une date.');
            return false;
        }
    }
    
    /**
     * \brief      Permet de supprimer un PATIENT
     * \details    Fonction permettant la suppression d'un patient en fonction de son id
     * \param      $id : id du patient à supprimer
     */
    public function supprimer($id) {
        $this->load->model('M_Patient');
        $this->M_Patient->supprimerPatient($id);
        $this->rechercher();
    }
    
    /*
     * \brief Permet d'ajouter un RDV pour un patient
     * \details permet d'ajouter un nouveau rdv pour un patinet
     * \param aucun
     */
    public function ajouterRDV(){
        $this->load->model('M_Parcours');
        $this->load->model('M_Patient');
        
        $id_patient = $this->uri->segment(3);
        
        $data['chemin'] = '/patient/V_jour';
        //$data['pathForm'] = "patient/ajoutDossier";
        $data['pathForm'] = 'patient/ajouterRDV';
        $data['idPatient'] = $id_patient;
        $data['parcours'] = $this->M_Parcours->getAllParcours();
        $this->load->view('/V_generale', $data);
        //$this->gererRDV($id_patient);
    }
    
    /*
     * \brief Permet de modifier un RDV pour un patient
     * \details permet de modifier un RDV pour un patient
     *          renouvler le parcours affecté
     *          renouver la date début et fin de RDV
     * \param aucun
     */
    public function modifierRDV(){
        $this->load->model('M_Parcours');
        $this->load->model('M_Patient');
        
        $id_patient = $this->uri->segment(3);
        $id_dossierparcours = $this->uri->segment(4);
        
        $data['chemin'] = '/patient/V_jour';
        $data['pathForm'] = 'patient/modifierRDV';
        $data['idPatient'] = $id_patient;
        $data['id_dossier'] = $id_dossierparcours;
        $data['parcours'] = $this->M_Parcours->getAllParcours();
        $this->load->view('/V_generale', $data);
        
    }
    
    /*
     * \brief Permet de supprimer un RDV d'un patinet
     * \param aucun
     */
    public function supprimerRDV(){
        $this->load->model('M_DossierParcours');
        $id_patient = $this->uri->segment(3);
        $id_dossierparcours = $this->uri->segment(4);
        $this->M_DossierParcours->supprimerDossier($id_dossierparcours);
        //$id_patient = $this->M_DossierParcours->findPatientByIdDossier($id_dossierParcours);
        $this->gererRDV($id_patient);
        
    }
    
    /*
     * \brief Permet de gérer les RDVs d'un patient
     * \param $id l'id de patient
     */
    public function gererRDV($id){
        $this->load->library('form_validation');

        $this->load->helper('form');
        $this->load->model('M_DossierParcours');
        $data = array();
        
        $data['dossierParcours'] = $this->M_DossierParcours->getDossierByIdPatient($id, -1, -1);
        $data['chemin'] = '/patient/V_rdv';
        $data["id_patient"] = $id;
        $this->load->view('/V_generale', $data);
    }
    
}
