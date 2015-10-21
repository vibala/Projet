<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Model','AppModel');

class Tool extends AppModel{
    
    public $name = 'Tool';
    
    public $belongsTo = array(
        'Tool_Fighter' => array(
            'className' => 'Fighter',
            'foreignKey' => 'id'            
        )
    );
}