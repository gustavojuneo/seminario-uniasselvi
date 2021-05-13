<?php
	require_once 'config/config.php';
	require_once 'config/database.php';

	if (!isset($_GET['id']) || empty($_GET['id']))
		header('Location: index.php');
	else {
		$id 	= DBEscape (strip_tags(trim($_GET['id'])));
		$post 	= DBRead('postagens', "WHERE id = '{$id}' LIMIT 1");

    if ($post) {
      $post = $post[0];
    }
	}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (!$post) ? 'Erro 404!' : $post['titulo'] ?> | Covid News</title>

    <link href="https://fonts.googleapis.com/css2?family=Chango&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="index.php">
                    <img src="./assets/logo.png" alt="Logo Covid News">
                </a>
            </div>
            
            <nav>
                <ul>
                    <li><a href="noticias.php">Noticias</a></li>
                    <li><a href="sobre.php">Sobre</a></li>
                    <li><a href="admin">Painel</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <section class="news">
              <div class="content">
                <article class="single">
                  <?php if ($post): ?>
                  <h1>
                    <?php echo $post['titulo']; ?>
                  </h1>

                  <div class="info">
                      <span>Author: <?php echo $post['autor']; ?></span>
                      <span>publicado <em></em>: <?php echo date('d/m/Y', strtotime($post['data'])); ?></span>
                  </div>
                  <p>
                    <?php echo $post['conteudo']; ?>
                  </p>

                  <?php else: ?>
                    <h1>
                      Erro 404!
                    </h1>
                  <?php endif; ?>
                </article>
              </div>
            </section>

            <span class="link"><a href="noticias.php">Ver outras notícias</a></span>
        </div>
    </main>

    <footer>
        <p>Todos os direitos reservados.</p>
    </footer>
</body>
</html>

