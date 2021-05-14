<?php
require "../config/config.php";
require "../config/database.php";

if (
  isset($_GET["action"]) &&
  isset($_GET["id"]) &&
  !empty($_GET["action"]) &&
  !empty($_GET["id"])
) {
  $id = DBEscape(strip_tags(trim($_GET["id"])));
  switch ($_GET["action"]) {
    case 1:
      DBDelete("postagens", "id = '{$id}'");
      break;
  }
  header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel | Covid News</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../styles/painel.css">
</head>
  <body>
    <header>
      <h1>Gerencias Postagens</h1>
      <nav>
          <a href="add-post.php" title="Adicionar">Adicionar notícia</a>
          <a href="../index.php" title="Voltar ao site">Voltar ao Site</a>
      </nav>
    </header>
    <div class="container">
        <section class="posts">
          <?php
          $posts = DBRead("postagens", "ORDER BY data DESC");

          if (!$posts) {
            echo "<h2>Nenhuma postagem encontrada!</h2>";
          } else {
            foreach ($posts as $post): ?>

          <article>
              <div class="about">
                <h2><?php echo $post["titulo"]; ?></h2>
                <div class="info">
                    <span>Author: <?php echo $post["autor"]; ?></span>
                    <span>publicado em: <?php echo date(
                      "d/m/Y",
                      strtotime($post["data"])
                    ); ?></span>
                </div>
              </div>
              <div class="actions">
                  <a href="edit-post.php?id=<?php echo $post[
                    "id"
                  ]; ?>" class="action editar" title="Editar">
                  <span class="material-icons">edit</span>
                </a>
                  <a href="?action=1&&id=<?php echo $post[
                    "id"
                  ]; ?>" class="action deletar" title="Deletar">
                  <span class="material-icons">delete</span>
                </a>
              </div>
          </article>

          <?php endforeach;
          }
          ?>
        </section>
    </div>
    
</body>
</html>