<?php 
    require '../config/config.php';
    require '../config/database.php';
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
    <link rel="stylesheet" href="../styles/painel.css">
</head>
<body>
    <div class="container">
        <h2>Adicionar Postagem</h2>

        <?php 
        
            if(isset($_POST['publicar'])) {
                $form ['titulo'] = DBEscape(strip_tags( trim($_POST['titulo'])));
                $form ['conteudo'] = DBEscape(strip_tags( trim($_POST['conteudo'])));
                $form ['autor'] = DBEscape(strip_tags( trim($_POST['autor'])));
                $form = DBEscape ($form);

                if (empty($form['titulo'])){
                    echo "Preencha o campo Título.";
                } else if(empty($form['conteudo'])) {
                    echo "Preencha o campo Conteúdo.";
                } else if(empty($form['autor'])) {
                    echo "Preencha o campo Autor.";
                } else {
                    
                    $dbCheck = DBRead( 'postagens', "WHERE titulo = '". $form['titulo'] ."'");
                    if ($dbCheck) {
                        echo "Desculpe mas já existe uma postagem com este título.";
                    } else {

                        if (DBCreate('postagens', $form)) {
                            echo "Sua postagem foi enviado com sucesso!";
                        } else {
                            echo "Desculpe, ocorreu um erro...";
                        }
                    }
                }
            }

        ?>


        <form action="" method="post">

            <div class="input-block">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo">
            </div>

            <div class="input-block">
                <label for="conteudo">Conteúdo</label>
                <input type="text" name="conteudo" id="conteudo">
            </div>

            <div class="input-block">
                <label for="autor">Autor</label>
                <input type="text"name="autor" id="autor">
            </div>
            
            <input type="submit" name="publicar" value="Adicionar">

        </form>

    </div>
</body>
</html>