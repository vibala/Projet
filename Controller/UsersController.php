<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsersController
 *
 * @author Anas
 */
class UsersController extends AppController
{
    //On inclut les modèles suivants
    public $uses = array('Player', 'Fighter', 'Event');
    
    public $components = array(
    'Session',
    'Flash',
    'Auth' => array(
        'authenticate' => array(
            'Form' => array(
                'userModel' => 'Player',
                'fields' => array('username' => 'email')
            )
        )
    ));    
      
    //Toutes les pages sont redirigé à la page de login
    //Sauf la page d'inscription qu'on authorise avec cette fonction
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('addUser','login');
    }
    
    //La page de connexion
    function login()
    {
        //Si le formulaire a été saisi
        if($this->request->is('postpt'))
        {
            //On utilise le composant Auth qui se charge de la connexion
            //Il verifie lui-même si les identifiants existent dans la bdd
            //Si ça marche:
            if($this->Auth->login())
            {
                //On redirige l'utilisateur vers la page qu'il a tenté d'accéder
               return $this->redirect($this->Auth->redirectUrl());
            }
        }
    }

    //Inscription
    function addUser()
    {   
        //Si le formulaire a été saisi
        if ($this->request->is('post'))
        {   
            //pr($this->request->data); //  print_r sert à afficher des infos à propos de la variable       
            $data = $this->request->data;
            //On ajoute l'utilisateur en utilisant la fonction du model Player
            if($this->Player->addPlayer($data['Player']['email'], $data['Player']['password']))
            {
                if($this->Auth->login())
            {
                //On redirige l'utilisateur vers la page qu'il a tenté d'accéder
               return $this->redirect($this->Auth->redirectUrl());
            }
            }
            
        }
    }
  
    //Fonction de déconnexion
    function logout(){
        $this->Auth->logout();
        //On le redirige vers la page d'accueil
        return $this->redirect('/');
    }
}
