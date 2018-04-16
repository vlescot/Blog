<?php ob_start(); ?>
<body style="background-color: #eaebef;">
	<h2 style="color: #255F85; text-align: center; padding: 10px 0 10px 0;margin:0,0,20px,0;">Cher administrateur, bonjour !</h2>
	<div style="text-align: center;margin:0;">
		<p>Un nouveau membre c'est inscript et requiert votre validation...</p>
		<p>Afin de valider son inscription, connectez vous au blog en suivant le lien : <a href="http://localhost/P5/Blog/authentification">Valider le membre</a></p>
		<p style="margin:30px,0,30px,0;"><strong style="color: #255F85;">À bientôt !</strong></p>
	</div>
</body>
<?php 
$message = ob_get_clean();
$subject = 'Un nouveau membre est en attente de validation';
