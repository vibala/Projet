<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
                echo $this->Html->css('cake.generic');
                //echo $this->Html->css('webarena');
                echo $this->Html->script('jquery.js'); // Inclut la librairie Jquery
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
    
    <nav>     
        <ul>
            <li class="home"><a href="accueil">Accueil</a></li>
            <li class="tutorials"><a href="#">Connexion</a></li>
            <li class="about"><a href="#">Combattants</a></li>
            <li class="about"><a href="sight">Vision</a></li>
            <li class="about"><a href="#">Journal</a></li>
            <li class="about"><a href="#">About</a></li>
            <li class="news"><a href="#">Newsletter</a></li>
            <li class="contact"><a href="#">Contact</a></li>
        </ul>
    </nav>
    
	<div id="container">
		<!--<div id="header">
			<h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
                        <h1> <?php echo $this->Html->link('Vision', array('controller' => 'Arenas', 'action' => 'sight')); ?> </h1>
                        <h1> <?php echo $this->Html->link('Accueil', '/'); ?> </h1>
		</div> -->
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);
			?>
			<p>
				<?php 
                                    echo $cakeVersion;
                                    echo "\nGr2-06-BG - BALA VIGNESH - ASRI ANAS - LIM VINCENT - TSCHILENGE DONATIEN";
                                
                                ?>
			</p>
                        
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
