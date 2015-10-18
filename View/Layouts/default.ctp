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
         <!-- Description des méta-données -->
         <meta charset="utf-8">
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         <meta http-equiv="Content-Language" content="fr" />
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
         
	<?php
		echo $this->Html->meta('icon');                
                echo $this->Html->css('jquery-ui');
                echo $this->Html->css('webarena');
                echo $this->Html->css('cake.generic'); // feuille de style du framework cakephp                
                echo $this->Html->script('jquery.js'); // Inclut implicitement la librairie Jquery dans l'en-tête de chaque page                
		echo $this->Html->script('jquery-ui.js');
                echo $this->fetch('meta'); 
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
    
    <nav>     
        <ul>
            <li class="home"><a href="accueil">Home</a></li>
            <li class="tutorials"><a href="connexion">Connexion</a></li>
            <li class="about"><a href="fighter">Fighters</a></li>
            <li class="about"><a href="sight">Vision</a></li>
            <li class="about"><a href="news">News</a></li>
            <li class="about"><a href="hall_of_fame">Hall of Fame</a></li>
            <li class="news"><a href="forum">Forum</a></li>
            <li class="contact"><a href="contact">Contact</a></li>
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
                        
                        <!-- Voilà l'endroit ou je souhaite que mes vues soient affichées -->
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
