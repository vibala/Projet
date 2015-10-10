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
                echo $this->Form->create('Fightermove', array('type' => 'get'));              
                echo $this->Form->input('direction_move',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
                echo $this->Form->end('Move');
            ?>
        </article>   
        
        
        <article>
            <!--<h2> Enter the name of your fighter to track all its ennemies</h2>-->
            <form>
                <fieldset>
                    <legend> Enter the name of your fighter to track all its ennemies </legend>
                    <p> <label for="Fighter_Name"> Fighter Name: </label> </p>
                    <p> <input type="text" id="Fighter_Name" name="Fighter_Name" />  </p>                  
                    <input type="hidden" value="" id="hidden_name" />
                    <p> <input type="submit" id="enter" value="Enter"/> </p>
                </fiedset>
            </form>
            
        </article>
        
        <article>
            <form>
                <fieldset>
                    <legend> Choose the ennemy to attack </legend>
                    <p> <label for="List_ennemies"> Ennemy name :  </label> </p>
                    <p> <select name="ennemies" id="ennemies"> </select> </p>
                    <p> <input type="submit" id="choose" value="Choose" /> </p>
                </fiedlset>                
            </form>    
        </article>
        
        <article>
            <h2> Choose your different options : </h2>
            <?php
                echo $this->Form->create('Listofoptions', array('type' => 'get'));                              
                echo $this->Form->input('number_of_views',array('options' => $options_view));
                echo $this->Form->input('value_of_force',array('options' => $options_force));
                echo $this->Form->input('number_of_life_points',array('options' => $options_lp));
                echo $this->Form->end('Validate');
            ?>
        </article>
        
        <article>
            <h2> Move to the Next Level  </h2>
            <?php                
                echo $this->Form->create('MovetotheNextLevel', array('type' => 'get'));                              
                echo $this->Form->input('next_level',array('options' => array('one'=>'one','two'=>'two','third'=>'third','fourth'=>'fourth','five'=>'five','six'=>'six'), 'default' => 'zero'));
                echo $this->Form->end('Change the level');
            ?>
        </article>
        
        <article>
            <h2> Design your character </h2>
            <?php
                 echo $this->Form->create('MovetotheNextLevel', array('type' => 'get'));                                               
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
        
        <script>
            
         $(function(){                                              
                
                $('#enter').on('click',function(){                    
                       
                    $('#hidden_name').val($('#Fighter_Name').val());
        
                    // ajout des handlers pour bien gérer les appels AJAX    
                    $.get(                         
                        // on se sert d'un helperHTML cakephp                                                     
                        '<?php 
                                // HtmlHelper::url(mixed $url = NULL, boolean $full = false) cd : cakephp doc                           
                                // remarque : action ; on retrouve svt cet attribut à l'intérieur de la balise form et 
                                // indique la page php qui se charge de récupérer les données et de les traiter                                                     
                                echo Router::url(array('controller' => 'arenas', 'action' => 'ajaxProcessing'));                                                                                     

                        ?>',                                    
                        
                        {fighter_name: $('#Fighter_Name').val()}, 
                        
                        function(json) {                                                        
                            $.each(json,function(i,item){
                                //alert(i +'=>' + item);
                                $('#ennemies').append("<option>"+ item+ "</option>");                                
                            });                                            
                                                
                      },                              
                        'json'
                    );
                    return false;
                }); 
               
                $('#choose').on('click', function(){                                        
                    $.get(
                      '<?php
                             echo Router::url(array('controller' => 'arenas', 'action' => 'ajaxProcessingVFLP'));                                                                                     
                        ?>',        
                            
                    {fighter_name: $('#hidden_name').val(),
                     ennemy_name: $('#ennemies').val()},
                     function(json){
                       //alert(json['attack']);
                       if(json['nb_times'] === 0){
                           $("#hidden_name").val("");
                       }
                     },   
                     'json'
                   );
                   return false;                   
                });
                     
        });
        
        </script>
    </body>

</html>


