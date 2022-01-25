<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/perfil.css">
        <title>Express Frete</title>
    </head>

    <body>


        <?php
            //Conexao com o bd
            require_once 'db_connect.php';

            //inicio da sessao
            session_start();
                   
        ?>

        <script>
            function alterna() {
                var x = document.getElementById("botao");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }
        </script>

        <header>
        <nav class="header_toolbar">
            <div class="topzinha">
                <a href="logout.php"> Home </a>
                <a href="motoristas.php"> Motoristas </a>
                <a class="profile" href="perfil.php"> <img class="profpic" src="imagem/profpic.png" style="width: auto; height: auto; max-width: 17px; max-height: 100px; margin: 0px; padding: 0px"> </a>
            </div>
        </nav>
        </header>

        <div class="header_content">
            <figure class="header_img"><img src="imagem/caminhao4.jpg"></figure><br>
            <div class="header_slogan">Express Frete</div>
        </div>

        <center>
            <article style="height=100vh">
                <figure class="profpic1">
                    <img src="imagem/profpic.png" style="width: auto; height: auto; max-width: 200px; max-height: 200px; margin: 0px; padding: 0px">
                    <p id="botao">Teste</p><button onclick="alterna()">teste</button>
                </figure>

                <div id="dados">
                    <div id="dados-esquerda">
                        <p>Esquerda</p>

                    </div>

                    <div id="dados-direita">
                        <p>Direita</p>
                    </div>

                </div>

                

                <footer id="rodape">Todos os direitos reservados.</footer>
            </article>
        </center>

    </body>
</html>