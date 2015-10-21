<?php

    App::uses('AppModel', 'Model');

    class Event extends AppModel{
        
        public $name = "Event";
        
        public $hasOne = array(        
        'Event_Fighter' => array(
            'className' => 'Fighter',
            'foreignKey' => 'next_action_time'
        )         
    );
        
        public function addCharacterEvent($character_name,$date,$posx,$posy){
            $char_name = "Entree de " . $character_name . "";
            $data = array(
                'name' => $char_name,
                'date' => $date,
                'coordinate_x' => $posx,
                'coordinate_y' => $posy 
            );
            
            // Enregistrement dans la base de données
            $this->save($data);
        }
    }
?>