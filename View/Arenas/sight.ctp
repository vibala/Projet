<!DOCTYPE html>
<html>
    <head>
         <meta charset="utf-8" />
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         <meta http-equiv="Content-Language" content="fr" />
         <title>Test PHP</title>
         <?php $this->assign('title', 'SIGHT');?>
    <head>
        
    <body>        
        <h1> Formulaires: </h1>
        <article> 
            <h2>Move Form</h2>
            <?php
                echo $this->Form->create('Fightermove');
                echo $this->Form->input('direction_move',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
                echo $this->Form->end('Move');
            ?>
        </article>
        
        <article>
            <h2>Attack Form</h2>
            <?php
                echo $this->Form->create('Fighterattack');
                echo $this->Form->input('direction_attack',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
                echo $this->Form->end('Attack');
            ?>
         </article>
        
        <article>
            <h2> Move to the Next Level  </h2>
            <?php
                echo $this->Form->create('MovetotheNextLevel');
                echo $this->Form->input('next_level',array('options' => array('one'=>'one','two'=>'two','third'=>'third','fourth'=>'fourth','five'=>'five','six'=>'six'), 'default' => 'zero'));
                echo $this->Form->end('Change the level');
            ?>
        </article>
        
        <article>
            <h2> Design your character </h2>
            <?php
                 echo $this->Form->create('Designyourcharacter');                        
                 echo $this->Form->inputs(array('legend' => 'Design your character','character_name' => array('type'=>'text'), 'player_id' => array('type'=>'text')));
                 //echo $this->Form->input('character_name', array('type'=>'text'));
                 //echo $this->Form->input('player_id', array('type'=>'text'));            
                 echo $this->Form->end('Create');
            ?>
        </article>
        
        <article>
            <h2> Create your avatar </h2>
            <?php
                echo $this->Form->create('Createyouravatar',array('type' => 'file'));            
                echo $this->Form->inputs(array('legend' => 'Make your own avatar', 'avatar_name' => array('type'=>'text'),'avatar_identifier' => array('type'=>'text'),'avatar_image' => array('type' => 'file')));                
                echo $this->Form->end('Create');
            ?>            
        </article>
    </body>

</html>


