<h2>Infinite Runner Game</h2>
<p>
	<ul id="game"><li>Player : <?php if ($user->isAuthenticated()) { echo $_SESSION['pseudo']; } else { echo 'visitor'; }?></li>
		<li id="chronotime">0:00:00</li>
	</ul>
</p>
<canvas id="gameCanvas" width="530" height="400" >
	Désolé, votre navigateur (ou sa version) ne prend pas en charge les "canvas".
</canvas>

<script src="/Web/js/jump.js"></script>