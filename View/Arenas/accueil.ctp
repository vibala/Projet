   
    <!-- Mise en place du titre -->
    <?php $this->assign('title','Connected Carousels - jCarousel Examples');?>
    <!-- Chargement des scripts et des feuilles de style-->
    <?php echo $this->HTML->script(array('jcarousel.connected-carousels', 'jquery.jcarousel.min'));?>
    <?php echo $this->HTML->css(array('style', 'jcarousel.connected-carousels'));?>
    
    
   
    
        <div class="wrapper">           
            
            <div class="connected-carousels">
                <div class="stage">
                    <div class="carousel carousel-stage">
                        <ul>                            
                            <li>                                
                                <?php echo $this->Html->image('images/img1.jpg', array('alt' => '','width' => '600', 'heigth' => '400'));?>                                
                                
                            </li>
                            <li>
                                <?php echo $this->Html->image('images/img2.jpg', array('alt' => '','width' => '600', 'heigth' => '400'));?>                                
                            </li>
                            <li>
                                <?php echo $this->Html->image('images/img3.jpg', array('alt' => '','width' => '600', 'heigth' => '400'));?>                                
                            </li>
                            <li>
                                <?php echo $this->Html->image('images/img4.jpg', array('alt' => '','width' => '600', 'heigth' => '400'));?>                                
                            </li>
                            <li>
                                <?php echo $this->Html->image('images/img5.jpg', array('alt' => '','width' => '600', 'heigth' => '400'));?>                                
                            </li>
                            <li>
                                <?php echo $this->Html->image('images/img6.pg', array('alt' => '','width' => '600', 'heigth' => '400'));?>                                
                            </li>
                        </ul>
                    </div>
                    <p class="photo-credits">
                        Photos by <a href="http://www.mw-fotografie.de">Marc Wiegelmann</a>
                    </p>
                    <a href="#" class="prev prev-stage"><span>&lsaquo;</span></a>
                    <a href="#" class="next next-stage"><span>&rsaquo;</span></a>
                </div>

                <div class="navigation">
                    <a href="#" class="prev prev-navigation">&lsaquo;</a>
                    <a href="#" class="next next-navigation">&rsaquo;</a>
                    <div class="carousel carousel-navigation">
                        <ul>
                            <li> <?php echo $this->Html->image('images/img1_thumb.jpg', array('alt' => '','width' => '50', 'heigth' => '50'));?> </li>                                                               
                            <li> <?php echo $this->Html->image('images/img2_thumb.jpg', array('alt' => '','width' => '50', 'heigth' => '50'));?> </li>
                            <li> <?php echo $this->Html->image('images/img3_thumb.jpg', array('alt' => '','width' => '50', 'heigth' => '50'));?></li>
                            <li> <?php echo $this->Html->image('images/img4_thumb.jpg', array('alt' => '','width' => '50', 'heigth' => '50'));?></li>
                            <li> <?php echo $this->Html->image('images/img5_thumb.jpg', array('alt' => '','width' => '50', 'heigth' => '50'));?></li>
                            <li> <?php echo $this->Html->image('images/img6_thumb.jpg', array('alt' => '','width' => '50', 'heigth' => '50'));?></li>
                        </ul>
                    </div>
                </div>
                
            </div>
        </div>
        
        <section id="intro">
            <iframe width="420" height="345"
                src="http://www.youtube.com/embed/XGSy3_Czz8k">
            </iframe>
        </section>
