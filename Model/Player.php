<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AppModel','Model');

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
    
    
}