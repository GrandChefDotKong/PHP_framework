<section class="column is-4" id="tchat">
	<h2>Mini Chat</h2>
		<div id="messages">
			<!-- les messages du tchat -->
		</div>
		  <form method="POST" action="">
			<p>
			  <label for="pseudo" name="pseudo" >Pseudo : </label><input type="text" name="pseudo" id="pseudo" maxlength="20" placeholder="20 car. max." required /><br />
			  <label for="message" name="message" >Message : </label><textarea name="message" id="message" rows="3" maxlength="255" placeholder="255 carac. max." required /></textarea><br /><br />
			  <input type="submit" name="submit" value="Envoyez votre message !" id="envoi" />
			</p>
		  </form>
</section>