<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AppModel','Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class Player extends AppModel{
    
    public $name = 'Player';
    
    // Un joueur peut poster plusieurs messages 
    // Un joueur peut avoir  plusieurs joueurs
    public $hasMany = array(
        'Player_Message' => array(
            'className' => 'Message'
        ),
        'Player_Fighter' => array(
            'className' => 'Fighter'
        )
    );    
    

    public function addPlayer($email, $password){
        $passwordHasher = new SimplePasswordHasher();
        $data = array('email' => $email, 'password' => $passwordHasher->hash($password));
        // Cela mettra à jour la Recipe avec un id 10
        if($this->save($data))
        {
            return true;
        }
        else{
            return false;
        }
        
    }

}