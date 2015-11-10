<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="Content-Language" content="fr" />
 <title>
Connexion
 </title>
</head>
<body>
    <div>    
        <h2>Connexion</h2>
<?= $this->Form->create('Player');?>
    <?= $this->Form->input('email', array('label'=> 'Adresse Mail'));?>
    <?= $this->Form->input('password', array('label'=> 'Mot de passe'));?>
<?= $this->Form->end('Se Connecter');?>
<?= $this->html->link('Nouveau', array('controller' => 'users', 'action'=> 'addUser')); ?>
    </div>
    <div>
        <h2>Connexion avec Facebook</h2>
        
    </div>
</body>
</html>