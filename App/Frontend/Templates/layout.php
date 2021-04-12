<!DOCTYPE html>
<html>
	<head>
		<title>
			<?= isset($title) ? $title : 'Not a Blog' ?>
		</title>
 
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--<link rel="stylesheet" href="/Web/css/style.css" type="text/css" />-->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
	</head>
 
	<body>
		<div class="container">
			<header class="mb-2">
				<h1 class="title is-size-1 has-text-centered"><a href="/">Just a Blog</a><br />
				<span class="pl-6 is-size-3">by grandchef ...</span></h1>
			</header>
			<nav class="navbar is-warning">
			  <div class="navbar-brand">
			      <a class="navbar-burger" id="burger">
			          <span></span>
			          <span></span>
			          <span></span>
			      </a>
			  </div>
			  <div class="navbar-menu" id="nav-links">
			    <div class="navbar-end">
				    <a class="navbar-item" href="/">Home</a>
				    <a class="navbar-item" href="/game-list.html">Game</a>
				<?php if ($user->isAuthenticated()) { ?>
				    <a class="navbar-item" href="/mapage.html">My page</a>
				    <a class="navbar-item" href="/logout.html">Logout</a>
				<?php if ($user->isAdministrator()) { ?>
				    <a class="navbar-item" href="/admin/">Admin</a>
				<?php }} else { ?>
				    <a class="navbar-item" href="/login.html">Login</a>
				<?php } ?>
			  </div>
			  </div>
			</nav>
            <div class="columns mx-2">
			  <section id="main" class="column is-8">
				<?php if ($user->hasFlash()) echo '<p style="text-align: center; ">', $user->getFlash(), '</p>'; ?>
				<?= $content ?>
			  </section>
			    <?php require("chat.php"); ?>
			</div>
			<footer>
			  <ul>
				<li><a href="">Coming next ...</a></li>
				<li><a href="">About me ...</a></li>
			  </ul>
			</footer>
		</div>
		<script src="/Web/js/chat.js"></script>
		<script src="/Web/js/script.js"></script>
		<script src="/Web/js/index.js"></script>
	</body>
</html>