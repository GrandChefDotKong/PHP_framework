<h2>Ajouter une news</h2>
<form action="" method="post">
	<p>
		<div id="bouton_bbcode">
			<button type="button" class="bbcode_button" onclick="addBalises('#contenu', '[sous_titre]', '[/sous_titre]');">Sous-titre</button>
			<button type="button" class="bbcode_button" onclick="addBalises('#contenu', '[p]', '[/p]');">Paragraphe</button>
			<button type="button" class="bbcode_button" onclick="addBalises('#contenu', '[br]', null);">Retour à la ligne</button>
			<button type="button" class="bbcode_button" onclick="addBalises('#contenu', '[i]', '[/i]');">Italique</button>
			<button type="button" class="bbcode_button" onclick="addBalises('#contenu', '[b]', '[/b]');">Gras</button>
			<button type="button" class="bbcode_button" onclick="addBalises('#contenu', '[liste]', '[/liste]');">Liste</button>
			<button type="button" class="bbcode_button" onclick="addBalises('#contenu', '[liste_element]', '[/liste_element]');">Elément de la liste</button>
			<button type="button" class="bbcode_button" onclick="addBalises('#contenu', '[url=www.exemple.com]', 'descriptif_du_lien[/url]');">Lien</button>
			<button type="button" class="bbcode_button" onclick="addBalises('#contenu', '[img=url_image alt=descriptif_image]', null);">Image</button>
		</div>			
		<?= $form ?>
    
		<input type="submit" value="Ajouter" />
	</p>
</form>