<?php foreach ($listeMessage as $message) { ?>
	<div id="<?= $message['id'] ?>">
		<p><strong><?= $message['auteur'] ?></strong> :<br />
		<?= nl2br($message['contenu']) ?></p>
	</div>
<?php } ?>