<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/motoristas.css">
        <title>Express Frete</title>
    </head>

    <body>


        <?php
            //Conexao com o bd
            require_once 'db_connect.php';

            //inicio da sessao
            session_start();

            if(!$_SESSION['logado']){
                header("Location: index.php");
            }

        
            //dados dos motoristas
            $sql = "SELECT * FROM mydb.usuario WHERE idusuario IN(SELECT usuario_idusuario FROM mydb.veiculo)";
            $res = pg_query($con, $sql);
            $linhas = pg_fetch_all($res);

            /*foreach ($linhas as $linha):
                echo pg_fetch_row($linha)[0];
                array_push($resultado, $linha);
            endforeach;*/
            //echo $linha[1];
        
        
            pg_close($con);
        
        ?>

        <script>
        
        //declaracao de funcao
        function desenha_perfis(item, resultado){
                //Pegando os dados
                var nome = resultado[item]['dscnomeusuario'];
                var descricao = resultado[item]['dscusuario'];
                var contato = resultado[item]['dsctelusuario'];
                var img = nome.replace(/\s+/g, '');
                var veiculo = '';

                //Criando a saida
                perfis = '<tr><th><figure align="left" class="fig"><img class="img" src="imagem/'+ img +'.png"></figure></th><td><h1 align="left">' + nome +'</h1><br>' + descricao + '<br>Veículo: ' + veiculo + '<br>Contato: ' + contato + '</td></tr>';
                //tabela.innerHTML = '<tr><th><figure align="left" class="fig"><img class="img" src="imagem/claudio.png"></figure></th><td><h1 align="left">Bárbara e Claudio</h1><br>Realizamos tranporte de cargas leves, com peso até 5 toneladas, e distância até 13 Km.<br>Veículo: VW delivery 8160<br>Contato: (27) 66767-0098</td></tr>';
                var th = document.createElement("th");
                return perfis;
            }


        function exibe_perfis(){

        
            //Resultado da query
            var resultado = <?php echo json_encode($linhas); ?>;

            

            var perfis = '';

            for(item in resultado){
                perfis += desenha_perfis(item, resultado);
            }
            console.log(perfis)
            tabela = document.getElementById('motoristas');
            tabela.innerHTML = perfis;

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
            <article>
                <table id="motoristas">

                </table>
                <footer id="rodape">Todos os direitos reservados.</footer>
            </article>
        </center>

        <script>
            window.onload = exibe_perfis();
        </script>
    </body>
</html>