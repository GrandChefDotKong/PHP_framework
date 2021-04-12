
<div id="index">
<?php
foreach ($listeNews as $news) {
?>
	<h2><a href="news-<?= $news['id'] ?>.html"><?= $news['titre'] ?></a></h2>
	<div id="contenu"><?= nl2br($news['contenu']) ?></div>
<?php
} ?><P style="text-align: center;">
<?php 
for ($i = 1;  $i <= $nombrePage; $i++) {
?>
	<a href="page-<?= $i ?>.html"><?= $i ?></a>
<?php
}
?></p>
</div>
