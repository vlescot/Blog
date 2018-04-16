<?php 
ob_start(); ?>
<body style="background-color: #eaebef;">
	<h2 style="color: #255F85; text-align: center; padding: 10px 0 10px 0;margin:0,0,20px,0;">Bonjour Vincent,</h2>
	<div style="text-align: center;margin:0;">
		<p><strong><?= htmlspecialchars($_POST['name']) ?></strong> vient de vous envoyer un message depuis le blog.</p>
		<div style="background-color: #efefef;border: 1px solid black">
			<p style="font-style: italic;"><span style="text-decoration: underline;">Sujet</span> : <?= htmlspecialchars($_POST['subject']) ?></p>
			<p><?= htmlspecialchars($_POST['message']) ?></p>
			<small>Répond lui : <a href="mailto:<?= htmlspecialchars($_POST['email']) ?>" target="_top"><?= htmlspecialchars($_POST['email']) ?></a>
			</small>
		</div>
		<p style="margin:30px,0,30px,0;"><strong style="color: #255F85;">À bientôt !</strong></p>
	</div>
</body>
<?php 
$message = ob_get_clean();
$subject = '[Un message depuis le blog] Sujet : ' . htmlspecialchars($_POST['subject']);