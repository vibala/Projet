<!-- Definition du titre  -->
<?php $this->assign('title','HALL_OF_FAME'); ?>
<!-- Charge les scripts et les feuilles de style -->
<?php echo $this->HTML->css(array('jquery.jqplot.min','shCoreDefault.min','shThemejqPlot.min')); ?>
<?php echo $this->HTML->script(array('jquery.min.js','jquery.js')); ?>

       <!-- On se met dans la région content qui a été définie dans la vue parente-->        
        <p> Stastiques<p>
        <p> </p>
        

        <div><span>Information: </span><span id="info2">Nothing</span></div>

        <div id="chart2" style="margin-top:60px; margin-left:30px; width:600px; height:300px;"></div>

        
        
<!-- Don't touch this! -->        
<?php echo $this->HTML->script(array('jquery.jqplot.min','jqplot.barRenderer.min','jqplot.categoryAxisRenderer.min','jqplot.canvasTextRenderer','jqplot.canvasAxisLabelRenderer','jqplot.highlighter.min')); ?>    
    
    <script>
        
           $(document).ready(function(){
                $.get(
                     // on se sert d'un helperHTML cakephp                                                     
                        '<?php 
                                
                                // indique la page php qui se charge de récupérer les données et de les traiter                                                     
                                echo Router::url(array('controller' => 'arenas', 'action' => 'hall_of_fame_ajax_processing'));                                                                                     

                        ?>',                                    
                         // on n'envoie aucune donnée au serveur par contre on récupérera des données envoyées par le controller au format json
                        {},                         
                        
                        function(json){                                                                                                                                      
                               var i;
                               var names = [];
                               var current_healths = [];
                               var xp = [];
                               var skill_sights = [];
                               
                               for(i = 0; i < json['names'].length; i++){
                                   names.push(json['names'][i]['Fighter']['name']);                                   
                                   current_healths.push(json['current_healths'][i]['Fighter']['current_health']);                                   
                                   xp.push(json['experiences'][i]['Fighter']['xp']);                                   
                                   skill_sights.push(json['skill_sights'][i]['Fighter']['skill_sight']);
                               }
                               
                                plot2 = $.jqplot('chart2', [current_healths,xp,skill_sights], {                                    
                                    seriesDefaults: {
                                        renderer:$.jqplot.BarRenderer,
                                        pointLabels: { show: true }
                                    },
                                    
                                    legend: {
                                         show: true,
                                         location: 'e',
                                         placement: 'outside',
                                         
                                    },  
                                
                                    series:[                                        
                                        {label:'Current Health'},
                                        {label:'Experience'},
                                        {label:'Skill sight'}
                                    ],
                                    
                                    axes: {
                                        xaxis: {
                                        renderer: $.jqplot.CategoryAxisRenderer,
                                        ticks: names,
                                        label: "Fighters Name"
                                        },
                                        
                                        yaxis: {                                              
                                            labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                                            min: 0,
                                            max: 20,                                                                                                                                    
                                            angle: 90,
                                            label: "Values"
                                        }
                                    },
                                    
                                    highlighter: {
                                        show: false,
                                        tooltipLocation: 'n',                                        
                                        formatString: '%s' 
                                    }
                                    
                                });
                                
                                 $('#chart2').on('jqplotDataHighlight', 
                                        function (ev, seriesIndex, pointIndex, data) {
                                            $('#info2').html('' + plot2['series'][seriesIndex]['label'] + ' : ' + data[1]);
                                            //alert(plot2['series'][seriesIndex]['label']);
                                        }
                                );

                                $('#chart2').on('jqplotDataUnhighlight', 
                                                        function (ev) {
                                                            $('#info2').html('Nothing');
                                                        }
                                );
                                        },    

                                        'json'
                                );
            });        
            
        </script>

