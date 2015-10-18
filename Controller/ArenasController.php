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

    
    public function accueil(){
        $this->set('accueil','Ceci est un message d\'accueil');
    }
    
    public function connexion(){
        $this->set('connexion','Une page «Connexion». Elle devra offrir les actions (formulaires) suivantes: s\'inscrire, se connecter, récupérer son mot de passe');        
    }
    
    public function hall_of_fame(){
        
       //$fighters_xp;
       //$fighter_skill_sight;
    }
    
    public function hall_of_fame_ajax_processing(){
        // Récupération des valeurs de chaque caractéristique des combattants
        $fightersname = $this->Fighter->getFightersName();
        $fighters_current_health = $this->Fighter->getCurrentHealthFromFighter();
        $fighters_skill_sight = $this->Fighter->getSkillSightFromFighter();
        $fighters_xp = $this->Fighter->getXPFromFighter();
        $data = array(
          'names' => $fightersname,
          'current_healths' => $fighters_current_health,
          'skill_sights'  => $fighters_skill_sight,
          'experiences' => $fighters_xp
        );
        
        
        // On encode au format JSON et on affiche directement ce résultat (pour le récupérer dans la vue)
        echo json_encode($data);
        
        exit();
    }
    public function news(){
        $this->set('journal','Une page «Journal». Elle devra offrir les actions (formulaires) suivantes: s\'inscrire, se connecter, récupérer son mot de passe');
    }
    
    public function forum(){
        
    }
    
    public function contact(){
        
    }
    /**
     * index method : first page
     *
     * @return void
     */
    public function index() {
        //die ('ok');
        $this->set('myname', "Vignesh BALA");
    }

    public function login() {
        $this->set('login', "Vivi");
        //die ('login');
    }

    public function fighter() {
        $this->set('fighter', "Vignesh");
        /* CakePhp simulait un model correspondant à une table de la base de donnée. */
        $this->set('raw', $this->Fighter->findById(1));
        //die ('login');
        // $fighter = new Fighter();
        //echo "Vue = $fighter->vue, (X,Y) = ($fighter->Position->positionX(),$fighter->Position->positionY())";
    }
    
    
    public function sight() {

        $var = $this->capterFormulaire();

        // On crée un tableau vide d'adversaires qui est utile lorsqu'on utilise pour la première fois 
        // la page sight
        $tmp_for_ennemies = array();
        $tmp_for_options = array();

        // Initialisation des tableaux vides des ennnemis et des options
        $this->set('ennemies', $tmp_for_ennemies);
        $this->set('options_view', $tmp_for_options);
        $this->set('options_force', $tmp_for_options);
        $this->set('options_lp', $tmp_for_options);


        if (isset($var['data']['direction_move'])) {
            $this->Fighter->doMove(1, $var['data']['direction_move']);

            /* Message de notification */
            $this->Session->setFlash('L\'action domove a été réalisée.');
        } else if (isset($var['data']['next_level'])) {
            $this->Fighter->moveTothenextLevel(1, $var['data']['next_level']);
            /* Message de notification */
            $this->Session->setFlash('L\'action moveTothenextLevel a été réalisée.');
        } else if (isset($var['data']['character_name']) && isset($var['data']['player_id'])) {
            $this->Fighter->createCharacter($var['data']['character_name'], $var['data']['player_id']);
            /* Message de notification */
            $this->Session->setFlash('L\'action createCharacter a été réalisée.');
       }else if(isset($var['Createyouravatar']['avatar_name']) && isset($var['Createyouravatar']['avatar_identifier']) && !empty($var['Createyouravatar']['avatar_image']['tmp_name'])  && is_uploaded_file($var['Createyouravatar']['avatar_image']['tmp_name'])){
            $this->Fighter->uploadAvatarImage($var['Createyouravatar']['avatar_name'],$var['Createyouravatar']['avatar_identifier'],$var['Createyouravatar']['avatar_image']['tmp_name']);
       }
    }

    // Traitement de la requête AJAX (côté serveur, dans le contrôleur
    public function ajaxProcessing() {
        // Cas des requêtes AJAX
        $i = 0;
        if ($this->request->is('ajax')) {
            $var = $this->capterFormulaire();
            $ret = array(); // variable de retour
            // On récupère la liste des adversaires à partir du nom de combattant         
            $ennemies = $this->Fighter->trackEnnemy($var['fighter_name']);
            // Stockage des données à renvoyer à la vue dans un tableau
            if ($ennemies) {
                foreach ($ennemies as $value) {
                    $ret[$i] = $value;
                    $i++;
                }
            } else {
                $ret['name'] = 'Aucun résultat n\'a été trouvé...';
            }
            // On encode au format JSON et on affiche directement ce résultat (pour le récupérer dans la vue)
            echo json_encode($ret);

            // Il faut penser à terminer le script brutalement pour court-circuiter les mécanismes
            // de CakePHP (méthodes de la classe mère AppController par exemple)
            exit();
        } else {
            // Code qui servirait dans le cas de requêtes http classiques (par opposition à AJAX)
            // Pour nous dans cet exemple, c'est inutile...
        }
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
        } else {
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
           // pr($this->request->query); //  print_r sert à afficher des infos à propos de la variable       
            return $this->request->query;
        } else if ($this->request->is('post')) {
            return $this->request->data; // pour le chargement des avatars
        }
    }

}
