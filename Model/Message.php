<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses ('AppModel','Model');

class Message extends AppModel{
    
    // Un message appartient à un joueur
    public $belongsTo = array(
        'Message_Message' => array(
            'className' => 'Player',            
        )
    );
}