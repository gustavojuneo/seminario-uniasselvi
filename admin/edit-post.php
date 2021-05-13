<?php 
    require '../config/config.php';
    require '../config/database.php';

    if (!isset($_GET['id']) || empty($_GET['id']))
		header('Location: index.php');
	else {
		$id 	= DBEscape(strip_tags(trim($_GET['id'])));
		$post 	= DBRead('postagens', "WHERE id = '{$id}' LIMIT 1");

		if (!$post)
			header('Location: index.php');
		else
			$post = $post[0];
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
    <link rel="stylesheet" href="../styles/painel.css">
</head>
<body>
    <div class="container">
        <h2>
            Editar Postagem | <a href="index.php" title="Voltar">Voltar</a>
        </h2>

        <?php 
            if(isset($_POST['salvar'])) {
                $form ['titulo'] = DBEscape(strip_tags( trim($_POST['titulo'])));
                $form ['autor'] = DBEscape(strip_tags( trim($_POST['autor'])));
                $form ['data'] = date('Y-m-d H:i:s');
                $form ['conteudo'] = str_replace('\r\n', "\n", DBEscape(trim($_POST['conteudo'])));
                $form = DBEscape($form);

                if (empty($form['titulo'])){
                    echo "Preencha o campo Título.";
                } else if(empty($form['conteudo'])) {
                    echo "Preencha o campo Conteúdo.";
                } else if(empty($form['autor'])) {
                    echo "Preencha o campo Autor.";
                } else {
                    
                    $dbCheck = DBRead( 'postagens', "WHERE titulo = '". $form['titulo'] ."' AND id != '{$id}'");
                    if ($dbCheck) {
                        echo "Desculpe mas já existe uma postagem com este título.";
                    } else {
                        if (DBUpdate('postagens', $form, " id = '{$id}'")) {
                            echo "Sua postagem foi editada com sucesso!";
                            $post 	= DBRead('postagens', "WHERE id = '{$id}' LIMIT 1");
					        $post 	= $post[0];
                        } else {
                            echo "Desculpe, ocorreu um erro...";
                        }
                    }
                }
            }
        ?>

        <form method="post">
            <div class="input-block">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" value="<?php echo $post['titulo']; ?>">
            </div>

            <div class="input-block">
                <label for="autor">Autor</label>
                <input type="text" name="autor" id="autor" value="<?php echo $post['autor']; ?>">
            </div>
            
            <div class="input-block">
                <label for="conteudo">Conteúdo</label>
                <textarea name="conteudo" id="conteudo"><?php echo $post['conteudo']; ?></textarea>
            </div>
            <input type="submit" name="salvar" value="Salvar">
        </form>

    </div>
</body>
</html>