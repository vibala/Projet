<?php 

App::uses('AppController', 'Controller');

/**
 * Main controller of our small application
 *
 * @author Vignesh BALA
 */
class ArenasController extends AppController
{
    public $components = array( 'Session' ); 
    /*Notre controller ArenasController proposera un accès à son model via $this->Event (par exemple)*/
    public $uses = array('Player', 'Fighter', 'Event','Arena');
    
    /**
     * index method : first page
     *
     * @return void
     */
    public function index()
    {
        //die ('ok');
        $this->set('myname', "Vignesh BALA");
    }
    
    public function login(){
        $this->set('login', "Vivi");
        //die ('login');
    }
    
    public function fighter(){
        $this->set('fighter', "Vignesh");
        /*CakePhp simulait un model correspondant à une table de la base de donnée. */
        $this->set('raw',$this->Fighter->findById(1));
        //die ('login');
       // $fighter = new Fighter();
        //echo "Vue = $fighter->vue, (X,Y) = ($fighter->Position->positionX(),$fighter->Position->positionY())";
    }
    
    public function sight(){
        //die ('sight');
        //$this->set('sight', "Good sight");
        //$this->set('raw',$this->Fighter->find('all'));
        //$this->set('raw',$this->Fighter->find(1));
        // Création d'une table vide        
        
        $var = $this->capterFormulaire();
        
        // On crée un tableau vide d'adversaires qui est utile lorsqu'on utilise pour la première fois 
        // la page sight
        $tmp_for_ennemies = array();
        $tmp_for_options = array();
        
        // Initialisation des tableaux vides des ennnemis et des options
        $this->set('ennemies', $tmp_for_ennemies);
        $this->set('options_view',$tmp_for_options);
        $this->set('options_force',$tmp_for_options);
        $this->set('options_lp',$tmp_for_options);
       
        
        if(isset($var['Fightermove']['direction_move'])){
           $this->Fighter->doMove(1, $var['Fightermove']['direction_move']);
           
           /*Message de notification*/
           //$this->Session->setFlash('Une action a été réalisée.'); 
           $this->Session->setFlash('L\'action domove a été réalisée.'); 

        }else if(isset($var['MovetotheNextLevel']['next_level'])){             
            $this->Fighter->moveTothenextLevel(1, $var['MovetotheNextLevel']['next_level']);  
            /*Message de notification*/
            $this->Session->setFlash('L\'action moveTothenextLevel a été réalisée.'); 
             
        }else if(isset($var['Designyourcharacter']['character_name']) && isset($var['Designyourcharacter']['player_id'])){
            $this->Fighter->createCharacter($var['Designyourcharacter']['character_name'],$var['Designyourcharacter']['player_id']);
            /*Message de notification*/
            $this->Session->setFlash('L\'action createCharacter a été réalisée.'); 
             
        }else if(isset($var['Createyouravatar']['avatar_name']) && isset($var['Createyouravatar']['avatar_identifier']) && !empty($var['Createyouravatar']['avatar_image']['tmp_name'])  && is_uploaded_file($var['Createyouravatar']['avatar_image']['tmp_name'])){
            $this->Fighter->uploadAvatarImage($var['Createyouravatar']['avatar_name'],$var['Createyouravatar']['avatar_identifier'],$var['Createyouravatar']['avatar_image']['tmp_name']);
            /*Message de notification*/
            $this->Session->setFlash('L\'action uploadAvatarImage a été réalisée.'); 
        
            
        }else if(isset($var['Enterfightername']['fighter_name'])){
           // $default_name = $var['Enterfightername']['fighter_name'];
            $ennemies = $this->Fighter->trackEnnemy($var['Enterfightername']['fighter_name']);
            $this->set('ennemies',$ennemies);   
           // $this->set('default',$default_name);
            
        }else if(isset($var['Listofennemies']['list_ennemies'])){            
           // $tmp_for_options = $this->Fighter->doAttack($var['Enterfightername']['fighter_name'],$var['Listofennemies']['list_ennemies']);
            //$this->set('options_view',$tmp_for_options['views_options']);
            //$this->set('options_force',$tmp_for_options['force_options']);
            //$this->set('options_lp',$tmp_for_options['life_points_options']);
           
        }            
       
        
    }
    
    public function diary(){
        //die ('diary');
        $this->set('diary', "This is mine");
        $this->set('raw',$this->Event->find());
    }
    
    public function capterFormulaire(){
        
        if ($this->request->is('post')){
            //pr($this->request->data); //  print_r sert à afficher des infos à propos de la variable       
            return $this->request->data;
        }
    }
    
                
}
?>