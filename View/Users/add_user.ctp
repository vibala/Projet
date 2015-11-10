<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="Content-Language" content="fr" />
 <title>
Inscription
 </title>
</head>
<body>
     <h2>Inscription</h2>
<?= $this->Form->create('Player');?>
    <?= $this->Form->input('email', array('label'=> 'Adresse email'));?>
    <?= $this->Form->input('password', array('label'=> 'Mot de passe'));?>
<?= $this->Form->end('Nouveau');?>
</body>
</html>