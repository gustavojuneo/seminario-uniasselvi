<?php
require "../config/config.php";
require "../config/database.php";

if (!isset($_GET["id"]) || empty($_GET["id"])) {
  header("Location: index.php");
} else {
  $id = DBEscape(strip_tags(trim($_GET["id"])));
  $post = DBRead("postagens", "WHERE id = '{$id}' LIMIT 1");

  if (!$post) {
    header("Location: index.php");
  } else {
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
    <title>Adicionar Notícia | Covid News</title>

    <link href="https://fonts.googleapis.com/css2?family=Chango&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/a7czedzfqdym4tcg6x5ai9umewp31hfkb6vepu23ctrd2al8/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({selector: '#conteudo'});</script>
    <link rel="stylesheet" href="../styles/painel.css">
</head>
<body>
    <header class="panel-header">
      <h1>Editar Postagem</h1>
      
      <nav>
        <a href="../single.php?id=<?php echo $post[
          "id"
        ]; ?>" target="_blank">Visualizar</a>
        <a href="index.php">Voltar</a>
      </nav>
    </header>
    <div class="container">
        <?php if (isset($_POST["salvar"])) {
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
              "WHERE titulo = '" . $form["titulo"] . "' AND id != '{$id}'"
            );
            if ($dbCheck) {
              echo '<span class="message failure">Desculpe mas já existe uma postagem com este título.</span>';
            } else {
              if (DBUpdate("postagens", $form, " id = '{$id}'")) {
                echo '<span class="message success">Sua postagem foi editada com sucesso!</span>';
                $post = DBRead("postagens", "WHERE id = '{$id}' LIMIT 1");
                $post = $post[0];
              } else {
                echo '<span class="message failure">Desculpe, ocorreu um erro...</span>';
              }
            }
          }
        } ?>

        <form method="post">
            <div class="input-block">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" value="<?php echo $post[
                  "titulo"
                ]; ?>">
            </div>

            <div class="input-block">
                <label for="autor">Autor</label>
                <input type="text" name="autor" id="autor" value="<?php echo $post[
                  "autor"
                ]; ?>">
            </div>
            
            <div class="input-block textarea">
                <label for="conteudo">Conteúdo</label>
                <textarea name="conteudo" id="conteudo"><?php echo $post[
                  "conteudo"
                ]; ?></textarea>
            </div>
            <input type="submit" name="salvar" value="Salvar">
        </form>

    </div>
</body>
</html>