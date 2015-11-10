<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    class Position{
        
        private $x;
        private $y;
        
        public function __construct($x,$y){
            $this->x = $x;
            $this->y = $y;                  
        }        
        
        // Setters
        public function setPositionX($x){
            $this->x = $x;
        }
        
        public function setPositionY($Y){
            $this->y = $y;
        }
        
        // Getters
        public function positionX(){
            return $this->x;
        }
        
        public function positionY(){
            return $this->y;
        }   
        
    }

?>