<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('ApisController', 'Controller');

class ApisController extends AppController{
    
    public $uses = array('Player', 'Fighter', 'Event');
    
    public function fighterview($id){
        $this->set('fighter_name', "Vivi"); 
        $this->layout = 'ajax';             
        $this->set('datas', $this->Fighter->find('all'));

    }

    
    public function playerview($id){
        $this->set('player_name', "Vignesh"); 
        $this->layout = 'ajax';             
        $this->set('datas', $this->Player->find('all'));
    }
    
    public function eventview($id){
        $this->set('event_name', "Main Event"); 
        //$this->layout = 'ajax';             
        $this->set('datas', $this->Event->find('all'));
    }
 

}

?>