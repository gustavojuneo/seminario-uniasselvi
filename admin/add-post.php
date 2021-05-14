<?php
require "../config/config.php";
require "../config/database.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Notícia | Covid News</title>

    <link href="https://fonts.googleapis.com/css2?family=Chango&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/a7czedzfqdym4tcg6x5ai9umewp31hfkb6vepu23ctrd2al8/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({selector: '#conteudo'});</script>
    <link rel="stylesheet" href="../styles/painel.css">
</head>
<body>
  <header class="panel-header">
    <h1>Publicar Notícia</h1>
    
    <nav>
      <a href="index.php">Voltar</a>
    </nav>
  </header>
  <div class="container">
    <?php if (isset($_POST["publicar"])) {
      $form["titulo"] = DBEscape(strip_tags(trim($_POST["titulo"])));
      $form["autor"] = DBEscape(strip_tags(trim($_POST["autor"])));
      $form["data"] = date("Y-m-d H:i:s");
      $form["conteudo"] = str_replace(
        '\r\n',
        "\n",
        DBEscape(trim($_POST["conteudo"]))
      );
      $form = DBEscape($form);

      if (empty($form["titulo"])) {
        echo '<span class="message failure">Preencha o campo Título.</span>';
      } elseif (empty($form["conteudo"])) {
        echo '<span class="message failure">Preencha o campo Conteúdo.</span>';
      } elseif (empty($form["autor"])) {
        echo '<span class="message failure">Preencha o campo Autor.</span>';
      } else {
        $dbCheck = DBRead(
          "postagens",
          "WHERE titulo = '" . $form["titulo"] . "'"
        );
        if ($dbCheck) {
          echo '<span class="message failure">Desculpe mas já existe uma postagem com este título.</span>';
        } else {
          if (DBCreate("postagens", $form)) {
            echo '<span class="message success">Sua postagem foi criada com sucesso!</span>';
          } else {
            echo '<span class="message failure">Desculpe, ocorreu um erro na hora de criar a sua postagem...</span>';
          }
        }
      }
    } ?>


    <form method="post">
        <div class="input-block">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo">
        </div>

        <div class="input-block">
            <label for="autor">Autor</label>
            <input type="text" name="autor" id="autor">
        </div>

        <div class="input-block textarea">
            <label for="conteudo">Conteúdo</label>
            <textarea name="conteudo" id="conteudo"></textarea>
        </div>
        
        <input type="submit" name="publicar" value="Publicar">
    </form>
  </div>
</body>
</html>