<?php

App::uses('AppModel', 'Model');
//Déclaration Constante
Configure::write('Longueur', 10);
Configure::write('Largeur', 15);

class Fighter extends AppModel {

    public $displayField = 'name';
    public $name = "Fighter";

    /* . By default, the model uses the lowercase, plural form of the model’s class name. */
    public $belongsTo = array(
        /* 'Surrounding' => array(
          'className' => 'Surrounding',
          'foreignKey' => 'surrounding_id'
          ), NE marche pas car il n'y a pas d'attributs surroundings ds la table Fighters */
        'Player' => array(
            'className' => 'Player',
            'foreignKey' => 'player_id',
        ),
    );

    /* Fonction pour vérifier si une attaque est réussie ou pas */

    public function checkThreshold($level_attaque, $level_attaquant) {
        $threshold = (10 + $level_attaque) - $level_attaquant;
        $random_value = rand(0, 20);
        if ($random_value > $threshold) {
            return TRUE;
        }
        return FALSE;
    }

    public function getAllEnemies($name)
    {
        $all_data = $this->find('all'); 
        $fighter_data = $this->find('first',array('conditions' => array('Fighter.name' => $name))); 
        $enemies = array();
        for($i=0;$i<$this->find('count');$i++)
        {
            if($all_data[$i]['Fighter']['name'] != $fighter_data['Fighter']['name'])
            {
                $enemies[$i]['Fighter']['name'] = $all_data[$i]['Fighter']['name'];
                $enemies[$i]['Fighter']['coordinate_x'] = $all_data[$i]['Fighter']['coordinate_x'];
                $enemies[$i]['Fighter']['coordinate_y'] = $all_data[$i]['Fighter']['coordinate_y'];
            }
        }
        return $enemies;
    }

    public function getAllFighterDatas() {
        $all_data = $this->find('all');
        $fighter = array();
        for ($i = 0; $i < $this->find('count'); $i++) {
            $fighter[$i]['Fighter']['name'] = $all_data[$i]['Fighter']['name'];
            $fighter[$i]['Fighter']['level'] = $all_data[$i]['Fighter']['level'];
            $fighter[$i]['Fighter']['xp'] = $all_data[$i]['Fighter']['xp'];
            $fighter[$i]['Fighter']['skill_sight'] = $all_data[$i]['Fighter']['skill_sight'];
            $fighter[$i]['Fighter']['skill_strength'] = $all_data[$i]['Fighter']['skill_strength'];
            $fighter[$i]['Fighter']['skill_health'] = $all_data[$i]['Fighter']['skill_health'];
            $fighter[$i]['Fighter']['current_health'] = $all_data[$i]['Fighter']['current_health'];
        }
        return $fighter;
    }

    public function getNumberMaxFighter() {
        $nbr = $this->find('count');
        return $nbr;
    }

    public function getFighterIdByName($name) {
        $all_data = $this->find('all');
        for ($i = 0; $i < $this->find('count'); $i++) {
            if ($all_data[$i]['Fighter']['name'] == $name) {
                return $all_data[$i]['Fighter']['id'];
            }
        }
    }

    /* Fonction permettant de chercher les adversaires qui se trouvent à la portée de la vue du combattant dont l'id est passé en paramètre */

    public function trackEnnemy($name) {

        /* Recupérer toute les données de la table */
        $all_data = $this->find('all');
        $fighter_data = $this->find('first', array('conditions' => array('Fighter.name' => $name)));
        $ennemies_sight_used = array();
        //$ennemies = array();
        $ennemy_position_x = 0;
        $ennemy_position_y = 0;

        /* Compteur */
        $compt = 0;
        /* Portée de la vue du combattant */
        $view_value = $fighter_data['Fighter']['skill_sight'];
        /* Coordonnées du combattant */
        $position_x = $fighter_data['Fighter']['coordinate_x'];
        $position_y = $fighter_data['Fighter']['coordinate_y'];

        for ($i = 0; $i < $this->find('count'); $i++) {

            /* Coordonnées x,y de chaque adversaire */
            $ennemy_position_x = $all_data[$i]['Fighter']['coordinate_x'];
            $ennemy_position_y = $all_data[$i]['Fighter']['coordinate_y'];

            // Calcul de la distance de manhattan qui sépare le joueur d'un ennemi
            $distance = abs($position_x - $ennemy_position_x) + abs($position_y - $ennemy_position_y);

            if ($distance <= $view_value && $fighter_data['Fighter']['id'] != $all_data[$i]['Fighter']['id']) {
                //$ennemies[$all_data[$i]['Fighter']['id']] = $all_data[$i]['Fighter']['name'];
                
                $ennemy_name = $all_data[$i]['Fighter']['name'];
                $ennemies_sight_used[$compt] = array('ennemy_name' => $ennemy_name, 'sight_used' => $distance);
                $compt++;
            }
        }
        //pr($ennemies);  
        //pr($all_data);
        //debug($data);            
        //return $ennemies;
        return $ennemies_sight_used;
    }

    /*
     * Fonction doMove prenant deux arguments permet aux personnages de se déplacer dans l'arène
     * @todo écrire du code pour empecher de sortir des limites de l’arène
     * @todo écrire du code pour empecher d'entrer sur une case occupée.
     */

    public function saveInitialisationByName($fighterName, $coord_x, $coord_y) {
        $fighterId = $this->getFighterIdByName($fighterName);
        $data = $this->read(null, $fighterId);
        $data['Fighter']['coordinate_x'] = $coord_x;
        $data['Fighter']['coordinate_y'] = $coord_y;
        $this->set('coordinate_x', $data['Fighter']['coordinate_x']);
        $this->set('coordinate_y', $data['Fighter']['coordinate_y']);
        //sauver la modif
        $this->save();
        return true;
    }
    
    public function saveInitialisation($fighterId, $coord_x,$coord_y)
    {
       $data = $this->read(null, $fighterId);
       $data['Fighter']['coordinate_x'] = $coord_x;
        $data['Fighter']['coordinate_y'] = $coord_y;
        $this->set('coordinate_x', $data['Fighter']['coordinate_x']);
        $this->set('coordinate_y', $data['Fighter']['coordinate_y']);
       
         //sauver la modif
        $this->save();
        return true;            
    } 
    

    public function reduceSkills($fighterName) {
        $data = $this->read(null, $this->getFighterIdByName($fighterName));

        $this->set('current_health', $data['Fighter']['current_health'] - 1);
        $this->save();

        return true;
    }

    public function update_skill_of_myfighter($fighterName) {
        $data = $this->read(null, $this->getFighterIdByName($fighterName));

        /* if( ($a % 4 == 0))
          {

          } */

        $this->set('current_health', $data['Fighter']['xp'] + 1); // fighter gain one xp point
        $this->set('current_health', $data['Fighter']['current_health'] + 1);
        $this->save();
    }

    public function doMove($fighterId, $direction_move) {

        //récupérer la position et fixer l'id de travail, on met null pour recup tous les champs
        $data = $this->read(null, $fighterId);
        //ligneId contient maintenant la table "Fighter" de 1 ligne avec les champs associés
        //Oui les var sont des tableaux            
        //faire la modif

        if ($direction_move == 'north' && ($data['Fighter']['coordinate_x'] + 1) < Configure::read('Longueur')) {
            // Longueur est une var globale déclarée en haut de cette classe           
            $this->set('coordinate_y', $data['Fighter']['coordinate_y'] + 1);
        } elseif ($direction_move == 'south' && ($data['Fighter']['coordinate_x'] - 1) >= 0) {
            $this->set('coordinate_y', $data['Fighter']['coordinate_y'] - 1);
        } elseif ($direction_move == 'east' && ($data['Fighter']['coordinate_y'] + 1) < Configure::read('Largeur')) {
            $this->set('coordinate_x', $data['Fighter']['coordinate_x'] + 1);
        } elseif ($direction_move == 'west' && ($data['Fighter']['coordinate_y'] - 1) >= 0) {
            $this->set('coordinate_x', $data['Fighter']['coordinate_x'] - 1);
        } else {
            return false;
        }

        //sauver la modif
        $this->save();
        return true;
    }

    /* Cette fonction permet d'exécuter les conséquences d'une attaque réussie du fighter */

    public function executeAttack($fighterName, $ennemyName) {

        // utilisez find uniquement pour lire les données ; en cas de modification des données utilisez read
        //renvoie le tuple correspondant au nom $fighterName dans la BD
        $fighter_data = $this->find('first', array('conditions' => array('Fighter.name' => $fighterName)));


        // renvoie le tuple correspondant au nom $ennemyName dans la BD
        $enemy_data = $this->find('first', array('conditions' => array('Fighter.name' => $ennemyName)));


        // $this->set(field,value)       
        /* Variables utilisées dans le calcul des valeurs de forces, d'expérience et du nombre de vie */
        $fighter_previous_xp = $fighter_data['Fighter']['xp']; // stockage du niveau d'expérience du fighter avant la modif
        $ennemi_previous_level = $enemy_data['Fighter']['level']; // stockage du niveau de l'ennemi avant la modif
        $ennemi_current_health = $enemy_data['Fighter']['current_health']; // stockage du nombre de vie actuel de l'adversaires
        // MAJ du nombre de vies de l'ennemi
        $this->updateAll(
                array('current_health' => ($enemy_data['Fighter']['current_health'] - $fighter_data['Fighter']['skill_strength'])), array('name' => $enemy_data['Fighter']['name'])
        );

        $this->updateAll(
                array('skill_strength' => ($enemy_data['Fighter']['skill_strength'] - 1 )), array('name' => $enemy_data['Fighter']['name'])
        );
        $ennemi_current_health -= $fighter_data['Fighter']['skill_strength']; // 
        // Combattant gagne 1pt xp              
        // Pas de set car comme je devais modifier à la fois les données du comb et de l'ennemi et donc 
        // j'avais crée deux read sauf que $set ne comprenait pas lequel des deux read j'utilisais
        $this->updateAll(
                array('xp' => $fighter_data['Fighter']['xp'] + 1), array('name' => $fighter_data['Fighter']['name'])
        );

        $fighter_current_xp = $fighter_data['Fighter']['xp'] + 1;
        // Si l'adversaire a un pt de vie = 0 ==> retirer du jeu et inviter l'user d'en recréer un nouveau
        if ($ennemi_current_health <= 0) {

            $this->updateAll(
                    array('xp' => ($fighter_data['Fighter']['xp'] + $ennemi_previous_level)), array('name' => $fighter_data['Fighter']['name'])
            );
            //La caractéristique de force détermine combien de point de vie perd son adversaire 
            // quand le combattant réussit son action d'attaque.
            $fighter_current_xp = ($fighter_data['Fighter']['xp'] + $ennemi_previous_level);
            //$this->delete($enemy_data['Fighter']['id']); // supprime le tuple             
        }

        // tous les 4 points d'expériences, le combattant change de niveau 
        $nb_times = floor($fighter_current_xp / 4) - floor($fighter_previous_xp / 4);
        $this->updateAll(
                array('level' => ($fighter_data['Fighter']['level'] + $nb_times)), array('name' => $fighter_data['Fighter']['name'])
        );

        // on regroupe ds la variable $gathered_options deux variables que sont 'attack' (var booléen pour dire
        // si l'attaque a été réussie ou non) et une autre variables 'nb_times' pour indiquer combien de fois 
        // le combattant a gagné une série de 4 points d'expérience
        $gathered_options = array('attack' => 'success', 'nb_times' => $nb_times);

        // Si l'attaque est réussie : 
        // - code pour executer ceci : La caractéristique de force détermine combien de point de vie perd son adversaire 
        // quand le combattant réussit son action d'attaque.
        // - combattant gagne 1pt xp
        // - si l'adversaire a un pt de vie = 0 ==> retirer du jeu et inviter l'user d'en recréer un nouveau
        // - si l'adversaire est tué : experience_combattant += niveau de l'adversaire vaincu
        // tous les 4 points d'expériences, le combattant change de niveau et peut choisir 
        // d'augmenter une de ses caractéristiques:  vue +1 ou  force+1 ou point de vie+3

        $this->save();
        return $gathered_options;
    }

    /* Cette fonction permet de récupérer la direction à prendre par le fighter pour attaquer son adversaire */

    public function getDirection($fighterName, $enemyName) {

        $fighter_data = $this->find('first', array('conditions' => array('Fighter.name' => $fighterName)));
        $enemy_data = $this->find('first', array('conditions' => array('Fighter.name' => $enemyName)));
        $direction = array();

        if (($enemy_data['Fighter']['coordinate_x'] - $fighter_data['Fighter']['coordinate_x']) > 0 && $enemy_data['Fighter']['coordinate_y'] == $fighter_data['Fighter']['coordinate_y']) {
            $direction[1] = 'north';
            $direction[2] = ($enemy_data['Fighter']['coordinate_x'] - $fighter_data['Fighter']['coordinate_x']);
        } else if (($enemy_data['Fighter']['coordinate_x'] - $fighter_data['Fighter']['coordinate_x']) < 0 && $enemy_data['Fighter']['coordinate_y'] == $fighter_data['Fighter']['coordinate_y']) {
            $direction[1] = 'south';
            $direction[2] = ($enemy_data['Fighter']['coordinate_x'] - $fighter_data['Fighter']['coordinate_x']);
        } else if (($enemy_data['Fighter']['coordinate_y'] - $fighter_data['Fighter']['coordinate_y']) < 0 && $enemy_data['Fighter']['coordinate_x'] == $fighter_data['Fighter']['coordinate_x']) {
            $direction[1] = 'west';
            $direction[2] = ($enemy_data['Fighter']['coordinate_y'] - $fighter_data['Fighter']['coordinate_y']);
        } else if (($enemy_data['Fighter']['coordinate_y'] - $fighter_data['Fighter']['coordinate_y']) > 0 && $enemy_data['Fighter']['coordinate_x'] == $fighter_data['Fighter']['coordinate_x']) {
            $direction[1] = 'east';
            $direction[2] = ($enemy_data['Fighter']['coordinate_y'] - $fighter_data['Fighter']['coordinate_y']);
        }

        return $direction;
    }

    /* Fonction appelée lorsqu'on choisit l'adversaire ds le formulaire */
    /* C'est cette fonction qui gère la démarche d'attaque */

    public function doAttack($fighterName, $enemyName) {

        // Renvoie le tuple correspondant au nom $fighterName dans la BD
        $fighter_data = $this->find('first', array('conditions' => array('Fighter.name' => $fighterName)));
        $enemy_data = $this->find('first', array('conditions' => array('Fighter.name' => $enemyName)));

        // Tester si l'attaque est bien réussie
        if ($this->checkThreshold($enemy_data['Fighter']['level'], $fighter_data['Fighter']['level']) == TRUE) {
            // Stockage le résultat de l'appel executeAttack
            $options = $this->executeAttack($fighterName, $enemyName);
        } else {
            return array('attack' => 'failed');
        }


        //sauvegarder la modification
        $this->save();
        return $options;
    }

    /* Fonction permettant de faire passer à un autre niveau */

    public function moveTothenextLevel($fighterId, $next_level) {

        $data = $this->read(null, $fighterId);
        switch ($next_level) {
            case 'one':
                $this->set('level', $data['Fighter']['level'] + 1);
                break;
            case 'two':
                $this->set('level', $data['Fighter']['level'] + 2);
                break;
            case 'three':
                $this->set('level', $data['Fighter']['level'] + 3);
                break;
            case 'four':
                $this->set('level', $data['Fighter']['level'] + 4);
                break;
            case 'five':
                $this->set('level', $data['Fighter']['level'] + 5);
                break;
            case 'six':
                $this->set('level', $data['Fighter']['level'] + 6);
                break;
            default:
                return false;
        }
        //sauvegarder la modification
        $this->save();
        return true;
    }

    /* Fonction pour créer un combattant */

    public function createCharacter($character_name, $player_id) {

        /* On t'impose de commencer par create */
        $this->create();
        $data = array(
                    "Fighter" => array(
                        "name" => $character_name,
                        "player_id" => $player_id,
                        "coordinate_x" => rand(0, 14),
                        "coordinate_y" => rand(0, 9),
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

    /* Fonction pour charger l'image de l'avatar du joueur */

    public function uploadAvatarImage($avatar_name, $avatar_identifier, $avatar_image) {
        $filename = $avatar_name . $avatar_identifier . '.png';
        move_uploaded_file($avatar_image, WWW_ROOT . DS . 'img' . DS . $filename);
    }

    /* Fonction appelée pour appliquer les options selectionnées ds le formulaire par le joueur lorsque son combattant
      passe la barre des 4 points d'expériences */

    public function executeOptions($name, $option_lp, $option_forces, $option_views) {

        // Recupère le combattant
        $fighter_data = $this->find('first', array('conditions' => array('Fighter.name' => $name)));
        $this->updateAll(
                array('current_health' => ($fighter_data['Fighter']['current_health'] + $option_lp)), array('name' => $fighter_data['Fighter']['name'])
        );

        $this->updateAll(
                array('skill_sight' => ($fighter_data['Fighter']['skill_sight'] + $option_views)), array('name' => $fighter_data['Fighter']['name'])
        );

        $this->updateAll(
                array('skill_strength' => ($fighter_data['Fighter']['skill_strength'] + $option_forces)), array('name' => $fighter_data['Fighter']['name'])
        );

        $returned_var = array('current_health' => ($fighter_data['Fighter']['current_health'] + $option_lp), 'skill_sight' => ($fighter_data['Fighter']['skill_sight'] + $option_views), 'skill_strength' => ($fighter_data['Fighter']['skill_strength'] + $option_forces));

        return $returned_var;
    }

}

?>
