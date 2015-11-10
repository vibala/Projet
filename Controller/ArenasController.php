<?php

App::uses('AppController', 'Controller');

/**
 * Main controller of our small application
 *
 * @author Vignesh BALA
 */
class ArenasController extends AppController {

    public $components = array('Session', 'RequestHandler');
    /* Notre controller ArenasController proposera un accès à son model via $this->Event (par exemple) */
    public $uses = array('Player', 'Fighter', 'Event', 'Arena');
    // on sélectionne le moteur js
    public $helpers = array('Js' => array('Jquery'), 'Html');

    /**
     * index method : first page
     *
     * @return void
     */
    public function accueil(){
        $this->set('accueil','Ceci est un message d\'accueil');
    }

    public function index() {        
        $this->set('myname', "Vignesh BALA");
    }

    public function login() {
        $this->set('login', "Vivi");
        
    }

    public function fighter() {
        $this->set('fighter', "Vignesh");        
        $this->set('raw', $this->Fighter->findById(1));       
    }
    
    
    public function sight() {
        
       $this->set('raw',$this->Fighter->getAllFighterDatas());
    }

    // Traitement de la requête AJAX (côté serveur, dans le contrôleur
    public function ajaxProcessing() {
        // Cas des requêtes AJAX
        $i = 0;
        if ($this->request->is('ajax')) {
            $var = $this->capterFormulaire();
            $ret = array(); // variable de retour            
            $ennemies = $this->Fighter->trackEnnemy($var['fighter_name']);            
            if ($ennemies) {
                foreach ($ennemies as $value) {
                    $ret[$i] = $value;
                    $i++;
                }
            } else {
                $ret['name'] = 'Aucun résultat n\'a été trouvé...';
            }            
            echo json_encode($ret);
            exit();
        } else {            
        }
    }
    // initialise la position aléatoire du jouer et la modifie aussi à chaque fois qu'il bouge
    public function InitialisePositionFighter()
    {
            $var = $this->capterFormulaire();
            $name = 'Donat';
            $this->Fighter->saveInitialisationByName($name,$var['coord_x'],$var['coord_y']);
            exit();
    }
    public function dataTableState()
    {
        $fighters = $this->Fighter->getAllFighterDatas();
        echo json_encode($fighters);
        exit();
    }
    public function showEnemies()
    {
        $var = $this->capterFormulaire();
        $name = $var['fighter_name'];        
        
        $enemies = $this->Fighter->getAllEnemies($name);
       echo json_encode($enemies);
        exit();
    }
    public function damageAfterAttack()
    {
        $var = $this->capterFormulaire();
        $enemyNameToAttack = $var['fighter_toattack'];
        $myFighterName = $var['myFighter_name'];
        $option_lp = 1;
        $option_forces = 1;
        $option_views = 1;
        /*$this->Fighter->reduceSkills($nameToAttack);    
        $this->Fighter->update_skill_of_myfighter($myFighter);
        */
        $this->Fighter->executeAttack($myFighterName,$enemyNameToAttack);
        $this->Fighter->executeOptions($name,$option_lp,$option_forces,$option_views);
      
        $stateFighter = $this->Fighter->getAllFighterDatas();
        echo json_encode($stateFighter);
        
        exit();
    }
    
    // actualise la base de données et renvoie la liste des ennemis
    public function save_coordinate_and_show_ennemies(){
            $var = $this->capterFormulaire();
            $this->Fighter->saveInitialisation(1,$var['coord_x'],$var['coord_y']);
            $enemiesVisibles = $this->Fighter->trackEnnemy('Aragorn');
            echo json_encode($enemiesVisibles);
            exit();
    }
    
    
    /*Fonction qui traite les données reçues par le formulaire*/
    /*Fonction permettant de récupérer la liste des adversaires puis la renvoyer au formulaire*/
    public function ajaxProcessingVFLP() {
        
        if ($this->request->is('ajax')) {
            $var = $this->capterFormulaire();
            
            // On récupère la liste des adversaires à partir du nom de combattant                     
            $ret = $this->Fighter->doAttack($var['fighter_name'], $var['ennemy_name']);

            if ($ret['attack'] == 'success') {
                $this->Session->setFlash("L'attaque est réussie");
            } else {
                $this->Session->setFlash("L'attaque est échouée");
            }               
            // On encode au format JSON et on affiche directement ce résultat (pour le récupérer dans la vue)
            echo json_encode($ret);

            // Il faut penser à terminer le script brutalement pour court-circuiter les mécanismes
            // de CakePHP (méthodes de la classe mère AppController par exemple)
            exit();
        }   else {
            // Code qui servirait dans le cas de requêtes http classiques (par opposition à AJAX)
            // Pour nous dans cet exemple, c'est inutile...
        }
    }

    /*Fonction qui traite les données reçues par le formulaire*/
    /*Fonction permettant de récupérer les options choisies par le joueur puis les passe au modèle qui va
     exécuter les options. Le modèle renvoie ensuite les différentes valeurs qui ont été mises à jour à cette fonction
     qui va à son tour les renvoyer à la vue     */
    public function ajaxFinishingVFLP(){
        
        if($this->request->is('ajax')){
            $var = $this->capterFormulaire();
            $ret = $this->Fighter->executeOptions($var['name'],$var['lp_choosen'],$var['forces_choosen'],$var['views_choosen']);
            $this->Session->setFlash("L'attaque est réussie");
            echo json_encode($ret);
            exit();
        }
    }
    public function diary() {
        //die ('diary');
        $this->set('diary', "This is mine");
        $this->set('raw', $this->Event->find());
    }

    /*Fonction chargée de vérifier si les données transmises en post ou en get*/
    public function capterFormulaire() {

        if ($this->request->is('get')) {
           /*pr($this->request->query);*/ //  print_r sert à afficher des infos à propos de la variable       
            return $this->request->query;
        } else if ($this->request->is('post')) {
            return $this->request->data; // pour le chargement des avatars
        }
    }

}
