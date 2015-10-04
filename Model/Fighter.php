<?php

App::uses('AppModel', 'Model');
//Déclaration Constante
Configure::write('Longueur',15);
Configure::write('Largeur',10);

class Fighter extends AppModel {
    
    /*Attributs de la classe*/
    public $coordinate_x,$coordinate_y;    
    public $skill_sight;
    public $skill_strength;
    public $skill_health;
    public $current_health;
    public $level;
    public $xp;
    public $id;
    public $next_action_time;
    public $displayField = 'name';
    
    /*Constructeur*/    
    //public function __construct($name, $id = false, $table = false, $ds = false) {
        /*Equivalent de super(..) en java && en gros on appelle le constructeur de la classe père        
        $data = $this->find('first',array('conditions' => array('Fighter.name' => $name)));
    
        $this->id = $data['Fighter']['id'];
        $this->name = $name;
        $this->coordinate_x = $data['Fighter']['coordinate_x'];
        $this->coordinate_y = $data['Fighter']['coordinate_y'];
        $this->level = $data['Fighter']['level'];
        $this->xp = $data['Fighter']['xp'];
        $this->skill_sight = $data['Fighter']['skill_sight'];
        $this->skill_strength = $data['Fighter']['skill_strength'];;
        $this->skill_health = $data['Fighter']['skill_health'];
        $this->current_health = $data['Fighter']['current_health'];
        $this->next_action_time = $data['Fighter']['next_action_time'];        
        parent::__construct($id, $table, $ds);
    }
    */
    /*. By default, the model uses the lowercase, plural form of the model’s class name. */
     public $belongsTo = array(
        'Arena' => array(
            'className' => 'Arena',
            'foreignKey' => 'arena_id'
        )
    );
    

    /*Plusieurs combattants peuvent appartenir à un joueur*/
    public $belongsTo = array(

        'Player' => array(
            'className' => 'Player',
            'foreignKey' => 'player_id',
        ),
    );
    
   
    
    
    public function checkThreshold($level_attaque,$level_attaquant){
        $threshold = (10 + $level_attaque) - $level_attaquant;
        if(rand(1,20) > $threshold){
            return TRUE;
        }
            return FALSE;
    }
   
   /*
    * Fonction doMove prenant deux arguments
    * @todo écrire du code pour empecher de sortir des limites de l’arène
    * @todo écrire du code pour empecher d'entrer sur une case occupée.
    */
    
   public function doMove($fighterId, $direction_move){
       
      //récupérer la position et fixer l'id de travail, on met null pour recup tous les champs
           $data = $this->read(null, $fighterId);
        //ligneId contient maintenant la table "Fighter" de 1 ligne avec les champs associés
        //Oui les var sont des tableaux            
       //faire la modif
       
        if ($direction_move == 'north' && ($data['Fighter']['coordinate_y'] + 1) < Configure::read('Longueur')) {
            // Longueur est une var globale déclarée en haut de cette classe           
            $this->set('coordinate_y', $data['Fighter']['coordinate_y'] + 1);
        
            
        } elseif ($direction_move == 'south' && ($data['Fighter']['coordinate_y'] - 1) >= 0) {
            $this->set('coordinate_y', $data['Fighter']['coordinate_y'] - 1);
        
            
        } elseif ($direction_move == 'east' && ($data['Fighter']['coordinate_x'] + 1) < Configure::read('Largeur')) {
            $this->set('coordinate_x', $data['Fighter']['coordinate_x'] + 1);
        
            
        } elseif ($direction_move == 'west' && ($data['Fighter']['coordinate_x'] - 1) >= 0) {
            $this->set('coordinate_x', $data['Fighter']['coordinate_x'] - 1);
        
            
        } else {
            return false;
        }

        //sauver la modif
        $this->save();
        return true;
   }
   
   public function doAttack($fighterId, $direction_attack){
       
       //renvoie le tuple correspondant à l'identifiant $fighterId dans la BD
       $data = $this->read(null,$fighterId);
       //$data contient maintenant la table "Fighter" de 1 ligne avec les champs associés
       //Oui les var sont des tableaux
       
       /*Conditions pour vérifier si on ne sort pas de l'arène*/
       if ($direction_attack == 'north' && ($data['Fighter']['coordinate_y'] + 1) < Configure::read('Longueur')) {
        // Longueur est une var globale déclaré en haut de cette classe
            $this->set('coordinate_y', $data['Fighter']['coordinate_y'] + 1);
        } elseif ($direction_attack == 'south' && ($data['Fighter']['coordinate_y'] - 1) >= 0) {
            $this->set('coordinate_y', $data['Fighter']['coordinate_y'] - 1);
        } elseif ($direction_attack == 'east' && ($data['Fighter']['coordinate_x'] + 1) < Configure::read('Largeur')) {
            $this->set('coordinate_x', $data['Fighter']['coordinate_x'] + 1);
        } elseif ($direction_attack == 'west' && ($data['Fighter']['coordinate_x'] - 1) >= 0) {
            $this->set('coordinate_x', $data['Fighter']['coordinate_x'] - 1);
        } else {
            return false;
        }       
            
        //sauvegarder la modification
        $this->save();
        return true;
   }   
   
   public function moveTothenextLevel($fighterId,$next_level){
       
       $data = $this->read(null,$fighterId);       
       switch($next_level){
           case 'one':
               $this->set('level',$data['Fighter']['level'] + 1);
               break;
           case 'two':
               $this->set('level',$data['Fighter']['level'] + 2);
               break;
           case 'three':
               $this->set('level',$data['Fighter']['level'] + 3);
               break;
           case 'four':
               $this->set('level',$data['Fighter']['level'] + 4);
               break;
           case 'five':
               $this->set('level',$data['Fighter']['level'] + 5);
               break;
           case 'six':
               $this->set('level',$data['Fighter']['level'] + 6);
               break;
           default:
               return false;           
       }       
        //sauvegarder la modification
        $this->save();
        return true;       
   }

   
   public function createCharacter($character_name,$player_id){
       
       /*On t'impose de commencer par create*/
       $this->create();
       $data = 
               array(
                   "Fighter" => array(
                       "name" => $character_name,
                       "player_id" => $player_id,
                       "coordinate_x" => rand(0,14),
                       "coordinate_y" => rand(0,9),
                       "level" => 0,
                       "xp" => 10,
                       "skill_sight" => 0,
                       "skill_strength" => 1,
                       "health" => 3,
                       "current_health" => 3,
                       "next_action_time" => "0000-00-00 00:00:00",
                       "guild_id" => NULL
                    )
                );
       
       // save
       $this->save($data);
       
   }
   
   public function uploadAvatarImage($avatar_name,$avatar_identifier,$avatar_image){       
       $filename = $avatar_name . $avatar_identifier . '.png';
       move_uploaded_file($avatar_image, WWW_ROOT . DS . 'img' . DS . $filename);
   }
   
  
   
}
      
    
?>
