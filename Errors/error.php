<!DOCTYPE html>
<html>
  <head>
    <title>
      <?= isset($title) ? $title : 'un Site quelconque' ?>
    </title>
 
    <meta charset="utf-8" />
 
    <link rel="stylesheet" href="../Web/css/Envision.css" type="text/css" />
  </head>
 
  <body>
    <div id="wrap">
      <header>
			<h1><a href="/monsupersite/Web/">un Site quelconque</a></h1>
			<p>Comment ca, il n'y a presque rien ?</p>
      </header>
      <nav>
        <ul>
          <li><a href="/monsupersite/Web/">Accueil</a></li>
          <?php if ($user->isAuthenticated()) { ?>
          <li><a href="/monsupersite/Web/mapage.html">Ma page</a></li>
		  <li><a href="/monsupersite/Web/logout.html">Se déconnecter</a></li>
		  <?php if ($user->isAdministrator()) { ?>
		  <li><a href="/monsupersite/Web/admin">Admin</a></li>
          <li><a href="/monsupersite/Web/admin/news-insert.html">Ajouter une news</a></li>
          <?php } } else { ?>
		  <li><a href="/monsupersite/Web/login.html">Se connecter</a></li>
		  <?php } ?>
        </ul>
      </nav>
 
      <div id="content-wrap">
        <?php echo $errorMessage; ?>
      </div>
 
      <footer></footer>
    </div>
  </body>
</html>