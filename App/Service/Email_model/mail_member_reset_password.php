<?php ob_start(); ?>
<body style="background-color: #eaebef;">
	<h2 style="color: #255F85; text-align: center; padding-top: 10px;margin:0,0,20px,0;">Bonjour <?= htmlspecialchars($member['login']) ?>,</h2>
	<div style="text-align: center;margin:0;">
		<p>Vous avez demandé à réinitialiser votre mot de passe.</p><p>Veuillez confirmer votre demande en cliquant sur le lien suivant: <a href="<?= URL ?>authentification/resetpassword?p=<?= $hashedlink ?>">Cliquez ici</a></p>
		<p style="margin:30px,0,30px,0;"><strong style="color: #255F85;">À bientôt !</strong></p>
	</div>
</body>
<?php 
$message = ob_get_clean();
$subject = "Réinitialiser votre mot de passe";
