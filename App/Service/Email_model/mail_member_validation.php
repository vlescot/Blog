<?php ob_start(); ?>
<body style="background-color: #eaebef;">
	<h2 style="color: #255F85; text-align: center; padding-top: 10px;margin:0,0,20px,0;">Bonjour <?= htmlspecialchars($member['login']) ?>,</h2>
	<div style="text-align: center;margin:0;">
		<p>Un administrateur vient de valider votre inscription sur le blog, vous pouvez à présent <a href="<?= URL ?>authentification/">vous connecter.</a></p>
		<p style="margin:30px,0,30px,0;"><strong style="color: #255F85;">À bientôt !</strong></p>
	</div>
</body>
<?php
$message = ob_get_clean();
$subject = "Votre inscription au blog vient d'être validée";
