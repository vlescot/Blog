<?php ob_start(); ?>
<body style="font-family: 'Merriweather', 'Helvetica Neue', Arial, sans-serif;">
	<div style="width: 100%; background-color: #e5e8ea">
		<h2 style="color: #255F85; text-align: center; padding: 10px 0 10px 0;margin:0;">Bonjour $login</h2>
	</div>
	<div>
		<p style="text-align: center;background-color: #878787; margin:0;">Pour valider votre compte cliquez sur le lien suivant : <a href="http://localhost/P5/Blog/">Confirmation</a></p>
	</div>
</body>
<?php $message = ob_get_clean();
$subject = 'Allo Wonston';
echo $message;