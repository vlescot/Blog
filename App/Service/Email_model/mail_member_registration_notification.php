<?php ob_start(); ?>
<body style="background-color: #eaebef;">
	<h2 style="color: #255F85; text-align: center; padding: 10px 0 10px 0;margin:0,0,20px,0;">Bonjour <?= htmlspecialchars($_POST['login']); ?>,</h2>
	<div style="text-align: center;margin:0;">
		<p>Nous vons remercions de vouloir faire partie des membres de ce blog.</p>
		<p>Nos administrateurs valideront bientôt votre inscription pour vous donner accès aux modifications de son contenu.</p>
		<p style="margin:30px,0,30px,0;"><strong style="color: #255F85;">À bientôt !</strong></p>
	</div>
</body>
<?php $message = ob_get_clean();
$subject = 'Bienvenue sur notre site';
