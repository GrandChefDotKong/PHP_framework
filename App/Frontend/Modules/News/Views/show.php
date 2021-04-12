<div id="news">
<p>Par <em><?= $news['auteur'] ?></em>, le <?= $news['dateAjout']->format('d/m/Y à H\hi') ?></p>
<h2><?= $news['titre'] ?></h2>
<div id="contenu"><?= nl2br($news['contenu']) ?></div>

<?php if ($news['dateAjout'] != $news['dateModif']) { ?>
  <p style="text-align: right;"><small><em>Modifiée le <?= $news['dateModif']->format('d/m/Y à H\hi') ?></em></small></p>
<?php } 

if($user->isAuthenticated()) {
?>

<p style="text-align: center;"><a href="commenter-<?= $news['id'] ?>.html">Ajouter un commentaire</a></p>

<?php } else { ?>
	<p style="text-align: center;"><a href="login.html">Se connecter pour laisser un commentaire</a></p>
<?php }

if (empty($comments)) { ?>
<p style="text-align: center;">Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
<?php
}

foreach ($comments as $comment) {
?>
<fieldset>
  <legend>
    Posté par <strong><?= htmlspecialchars($comment['auteur']) ?></strong> le <?= $comment['date']->format('d/m/Y à H\hi') ?>
    <?php if (isset($_SESSION['pseudo']) && ($_SESSION['pseudo'] === $comment['auteur'])) { ?> -
      <a href="comment-update-<?= $comment['id'] ?>.html">Modifier</a> |
	   <a href="comment-delete-<?= $comment['id'] ?>.html">Supprimer</a>
    <?php } ?>
  </legend>
  <p><?= nl2br(htmlspecialchars($comment['contenu'])) ?></p>
  <?php }
  if($user->isAuthenticated()) { ?>
    <p style="text-align: center;"><a href="commenter-<?= $news['id'] ?>.html">Ajouter un commentaire</a></p> <?php 
  } else { ?>
    <p style="text-align: center;"><a href="login.html">Se connecter pour laisser un commentaire</a></p> 
    </fieldset > <?php 
  } ?>
</div>


