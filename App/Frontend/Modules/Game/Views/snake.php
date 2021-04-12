
<h2>Snake Game</h2>
<p>
	<ul id="game"><li>Player : <?php if ($user->isAuthenticated()) { echo $_SESSION['pseudo']; } else { echo 'visitor'; }?></li>
		<li id="score">Score : 0</li>
		<li id="speed">Speed : 1</li>
	</ul>
</p>
<canvas id="gameCanvas" width="530" height="400" >
	Désolé, votre navigateur (ou sa version) ne prend pas en charge les "canvas".
</canvas>

<script src="/Web/js/snake.js"></script>