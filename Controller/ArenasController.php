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
    public $uses = array('Player', 'Fighter', 'Event');
    
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
        $var = $this->capterFormulaire();
             
        if(isset($var['Fightermove']['direction_move'])){
           $this->Fighter->doMove(1, $var['Fightermove']['direction_move']);
          
        }else if(isset($var['Fighterattack']['direction_attack'])){            
            $this->Fighter->doAttack(1, $var['Fighterattack']['direction_attack']);        
            
        }else if(isset($var['MovetotheNextLevel']['next_level'])){             
            $this->Fighter->moveTothenextLevel(1, $var['MovetotheNextLevel']['next_level']);        
             
        }else if(isset($var['Designyourcharacter']['character_name']) && isset($var['Designyourcharacter']['player_id'])){
            $this->Fighter->createCharacter($var['Designyourcharacter']['character_name'],$var['Designyourcharacter']['player_id']);
             
        }else if(isset($var['Createyouravatar']['avatar_name']) && isset($var['Createyouravatar']['avatar_identifier']) && !empty($var['Createyouravatar']['avatar_image']['tmp_name'])  && is_uploaded_file($var['Createyouravatar']['avatar_image']['tmp_name'])){
            $this->Fighter->uploadAvatarImage($var['Createyouravatar']['avatar_name'],$var['Createyouravatar']['avatar_identifier'],$var['Createyouravatar']['avatar_image']['tmp_name']);
        }    
        
        $this->Session->setFlash('Une action a été réalisée.'); 
        
    }
    
    public function diary(){
        //die ('diary');
        $this->set('diary', "This is mine");
        $this->set('raw',$this->Event->find());
    }
    
    public function capterFormulaire(){
        
        if ($this->request->is('post')){
            pr($this->request->data); //  print_r sert à afficher des infos à propos de la variable       
            return $this->request->data;
        }
    }
    
                
}
?>