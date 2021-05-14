<?php
require_once "config/config.php";
require_once "config/database.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covid News</title>

    <link href="https://fonts.googleapis.com/css2?family=Chango&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
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
                <h1>Notícias</h1>

                <div class="content">
                    <?php
                    $posts = DBRead("postagens", "ORDER BY data DESC");

                    if (!$posts) {
                      echo "<h2>Nenhuma notícia encontrada!</h2>";
                    } else {
                      foreach ($posts as $post): ?>

                <article>
                    <h2>
                        <a href="single.php?id=<?php echo $post[
                          "id"
                        ]; ?>"><?php echo $post["titulo"]; ?></a>
                    </h2>
                    <div class="info">
                        <span>Author: <?php echo $post["autor"]; ?></span>
                        <span>publicado em: <?php echo date(
                          "d/m/Y",
                          strtotime($post["data"])
                        ); ?></span>
                    </div>
                    <p>
                        <?php
                        $str = strip_tags($post["conteudo"]);
                        $len = strlen($str);
                        $max = 200;

                        if ($len <= $max) {
                          echo $str;
                        } else {
                          echo substr($str, 0, $max) . "...";
                        }
                        ?>
                    </p>
                </article>

                    <?php endforeach;;
                    }
                    ?>
                </div>
            </section>

            <span class="link"><a href="covid.php">Veja o mapa em tempo real de casos do covid</a></span>
        </div>
    </main>

    <footer>
        <p>Todos os direitos reservados.</p>
    </footer>
</body>
</html>

