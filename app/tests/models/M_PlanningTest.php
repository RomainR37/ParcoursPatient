<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_PlanningTest
 *
 * @author Romain
 */
class M_PlanningTest extends TestCase{
    
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('M_Planning');
        $this->obj = $this->CI->M_Planning;
        $this->obj->restaurerPlanning();
    }
    
    private function addEvenementForTest($patientId){

        $titre = "Bernard Laurent - RDV paramédical Obésité - Obésité sévère – diagnostique";
        $start = "2019-03-30 08:30:00";
        $end = "2019-03-30 08:50:00";
        $activiteId = 1;
        $parcoursId = 1;
        
        $this->obj->addEvenementAuto($titre, $start, $end, $activiteId, 
                $patientId, $parcoursId);                
    }
    
    public function test_getCouleurEventPatient(){

        $patientId = 2;
        $this->addEvenementForTest($patientId);
        
        $colors = array('#FF6633', '#ffcc99', '#99cccc', '#669999', '#CC9999', 
            'FFCCCC', '99CCCC', '#999999', '#00FFFF', '#000090', '#008C90',
            '#B88410', '#A8ACA8', '#006400', '#B8B868', '#880088', '#586C30',
            '#FF8C00', '#9830C8', '#880000', '#F09880', '#90BC90', '#483C88',
            '#305050', '#00D0D8', '#9800D8', '#FF1490', '#00BCFF', '#686868',
            '#2090FF');
        $colorBdd = $this->obj->getCouleurEventPatient($patientId);
        $this->assertContains($colorBdd, $colors);
    }
    
    /**
     * Test de la planification automatique. Vérification de la création 
     * d'évènements lors de l'appel à la méthode. La table 'evenement' est vide
     * avant le test. 
     */
    public function test_planautoCreationEvenement(){
        
        $date = new DateTime('2019-03-30');
        $date = $date->format('Y-m-d');
        
        $beforePlanAuto = $this->obj->getAllEvenementByDate($date);
        
        $this->obj->planAuto($date);
        
        $afterPlanAuto = $this->obj->getAllEvenementByDate($date);
        
        $this->assertGreaterThan(count($beforePlanAuto), count($afterPlanAuto));
    }

    /**
     * Test de la planification automatique. Planification d'un patient suivant 
     * le parcours 1 (Obésité sévère diagnostic). 11 activités doivent être 
     * réalisées sur ce parcours, chacune avec deux ressources excepté deux 
     * activités avec 1 ressource seulement. Au total, 20 évènements (9*2 + 2) 
     * doivent être présents dans la base après application de la méthode.
     */
    public function test_planautoAjoutPatient(){
        
        $date = new DateTime('2019-01-22');
        $date = $date->format('Y-m-d');
        
        $this->obj->planAuto($date);
        
        $afterPlanAuto = $this->obj->getAllEvenementByDate($date);
        
        $this->assertEquals(20, count($afterPlanAuto));
    }
    
    /**
     * Test de l'ajout d'évènement automatique. Ici l'évènement qu'on souhaite 
     * ajouter est lié à deux ressources, ainsi 2 entrées doivent être 
     * créés dans la table "evenement". La table "evenement" doit être vide 
     * avant le test.
     */
    public function test_addEvenementAuto(){
        
        $patientId = 2;
        
        $this->addEvenementForTest($patientId);

        $res = array();
        $res = $this->obj->getAllEvenement();
        
        $this->assertEquals(2, count($res));
    }
    
    /**
     * Test de disponibilité d'une ressource. Un évènement est ajouté pour la 
     * ressource 1 entre 8:30 et 8:50. Teste la méthode 
     * getDisponibiliteRessource() avec plusieurs horaires pour vérifier si la 
     * méthode renvoie les bons résultats.
     */
    public function test_getDisponibiliteRessource(){
        
        $ressourceId = 1;
        $patientId = 2;
        $this->addEvenementForTest($patientId);
        
        $startRessourceDispo = "2019-03-30 09:30:00";
        $endRessourceDispo = "2019-03-30 10:30:00";
        
        $this->assertTrue($this->obj->getDisponibiliteRessource($ressourceId, 
                $startRessourceDispo, $endRessourceDispo));
        
        $startRessourceNonDispo = "2019-03-30 08:15:00";
        $endRessourceNonDispo = "2019-03-30 08:40:00";
        
        $this->assertFalse($this->obj->getDisponibiliteRessource($ressourceId, 
                $startRessourceNonDispo, $endRessourceNonDispo));

        $startRessourceNonDispo = "2019-03-30 08:40:00";
        $endRessourceNonDispo = "2019-03-30 09:00:00";
        
        $this->assertFalse($this->obj->getDisponibiliteRessource($ressourceId, 
                $startRessourceNonDispo, $endRessourceNonDispo));
        
        $startRessourceNonDispo = "2019-03-30 08:20:00";
        $endRessourceNonDispo = "2019-03-30 08:50:00";
        
        $this->assertFalse($this->obj->getDisponibiliteRessource($ressourceId, 
                $startRessourceNonDispo, $endRessourceNonDispo));
    }
    
    public function tearDown() {
        $this->obj->restaurerPlanning();
    }
}
