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
            <section class="map">
                <h1>Mapa em Tempo Real</h1>

                <div class="content">
                    <div class="covid-map">
                      <iframe src="https://covid19br.wcota.me/map/index.htm" width="100%" height="600px" marginheight="0" marginwidth="0" frameborder="0"></iframe>
                      <span class="covid-fonte">Fonte: <a href="https://covid19br.wcota.me/" target="_blank">https://covid19br.wcota.me/</a></span>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <footer>
        <p>Todos os direitos reservados.</p>
    </footer>
</body>
</html>
