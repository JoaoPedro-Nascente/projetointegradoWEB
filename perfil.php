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

            if($_SESSION['logado'] == 0){
                header("Location: index.php");
            }

            //dados do usuario
            $id = $_SESSION['id_usuario'];
            $sql = "SELECT * FROM mydb.usuario WHERE idusuario = '$id'";
            $res = pg_query($con, $sql);
            $dados = pg_fetch_array($res);


            pg_close($con);           
                   
        ?>

        <script>
            function alterna(x) {

                var linha = x.slice(1, 2);

                var i0 = document.getElementById("i" + linha + "0");
                var i1 = document.getElementById("i" + linha + "1");
                var i2 = document.getElementById("i" + linha + "2");
                var i3 = document.getElementById("i" + linha + "3");
                var i4 = document.getElementById("i" + linha + "4");

                //var x = document.getElementById("botao");
                if(!(x.slice(2, 3).localeCompare("1"))){
                    
                    i0.style.display = "none";
                    i1.style.display = "none";
                    i2.style.display = "block";
                    i3.style.display = "block";
                    i4.style.display = "inline";


                } else {

                    i0.style.display = "inline";
                    i1.style.display = "block";
                    i2.style.display = "none";
                    i3.style.display = "none";
                    i4.style.display = "none";

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
                        <div class="esquerda">
                            <p>Nome: </p><br><br>
                            <p>CPF: </p><br><br>
                            <p>Email: </p><br><br>
                        </div>
                        <div class="direita">
                            <p id="i10"><?php echo $dados['dscnomeusuario']; ?></p>
                            <img class="editar" id="i11" src="imagem/edit.png" onclick="alterna(this.id)">
                            <img class="editar" id="i12" src="imagem/deny.png" onclick="alterna(this.id)">
                            <img class="editar" id="i13" src="imagem/accept.png">
                            <input type="text" id="i14" name="fnome" value="">
                            <br><br>

                            <p id="i20"><?php echo $dados['dscidentificacaousuario']; ?></p>
                            <img class="editar" id="i21" src="imagem/edit.png" onclick="alterna(this.id)">
                            <img class="editar" id="i22" src="imagem/deny.png" onclick="alterna(this.id)">
                            <img class="editar" id="i23" src="imagem/accept.png">
                            <input type="text" id="i24" name="fnome" value="">
                            <br><br>

                            <p id="i30"><?php echo $dados['dscemailusuario']; ?></p>
                            <img class="editar" id="i31" src="imagem/edit.png" onclick="alterna(this.id)">
                            <img class="editar" id="i32" src="imagem/deny.png" onclick="alterna(this.id)">
                            <img class="editar" id="i33" src="imagem/accept.png">
                            <input type="text" id="i34" name="fnome" value="">
                            <br><br>

                        </div>
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