<?php 
    require '../config/config.php';
    require '../config/database.php';

    if(isset($_GET['action']) && isset($_GET['id']) && !empty($_GET['action']) && !empty($_GET['id'])) {
        $id = DBEscape(strip_tags(trim($_GET['id'])));
        switch ($_GET['action']) {
            case 1:
                DBDelete('postagens', "id = '{$id}'");
                break;
        }
        header('Location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel | Covid News</title>
</head>
<body>

    <div class="container">
        <header>
            <h2>Gerencias Postagens</h2>
            <nav>
                <a href="add-post.php" title="Adicionar">Adicionar</a>
                <a href="../index.php" title="Voltar ao site">Voltar ao Site</a>
            </nav>
        </header>

        <?php
            $posts = DBRead('postagens', 'ORDER BY data DESC');

            if (!$posts)
                echo '<h2>Nenhuma postagem encontrada!</h2>';
            else 
                foreach ($posts as $post):
	    ?>

        <article>
            <h2><?php echo $post['titulo']; ?></h2>
            <div class="info">
                <span>Author: <?php echo $post['autor']; ?></span>
                <span>publicado <em></em>: <?php echo date('d/m/Y', strtotime($post['data'])); ?></span>
            </div>
            <div class="actions">
                <a href="edit-post.php?id=<?php echo $post['id']; ?>" title="Editar">Editar</a>
                <a href="?action=1&&id=<?php echo $post['id'];?>" title="Deletar">Deletar</a>
            </div>
        </article>

        <?php
            endforeach;
        ?>
    </div>
    
</body>
</html>