<!DOCTYPE html>
<html>
  <head>
    <title>
      <?= isset($title) ? $title : 'Not a Blog' ?>
    </title>
 
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/Web/css/style.css" type="text/css" />
  </head>
 
  <body>
    <div id="wrap">
      <header>
			<h1><a href="/">Not a Blog</a><br />
			<span id="head">Administration</span></h1>
      </header>
      <nav>
        <ul>
          <li><a href="/">Home</a></li>
          <li><a href="/admin/news-insert.html">Add a news</a></li>
		      <li><a href="/logout.html">Logout</a></li>
        </ul>
      </nav>
 
      <div id="content-wrap">
        <section id="main">
          <?php if ($user->hasFlash()) echo '<p style="text-align: center; ">', $user->getFlash(), '</p>'; ?>
 
          <?= $content ?>
        </section>
      </div>
 
      <footer></footer>
    </div>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="/Web/js/bbcode.js"></script>
  </body>
</html>