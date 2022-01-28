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
            $sql = "SELECT * FROM mydb.usuario INNER JOIN mydb.veiculo ON(usuario.idusuario = veiculo.usuario_idusuario) INNER JOIN mydb.categoriaveiculo ON(veiculo.categoriaveiculo_idcategoriaveiculo = categoriaveiculo.idcategoriaveiculo)";
            $res = pg_query($con, $sql);
            $linhas = pg_fetch_all($res);


            //filtros
            if (isset($_POST['filtrar'])):
                $area = $_POST['area'];
                $carga = $_POST['carga'];
                if(!($area == '0') AND !($carga == '0')) {
                    $sql = "SELECT * FROM mydb.usuario INNER JOIN mydb.veiculo ON(usuario.idusuario = veiculo.usuario_idusuario) INNER JOIN mydb.categoriaveiculo ON(veiculo.categoriaveiculo_idcategoriaveiculo = categoriaveiculo.idcategoriaveiculo) WHERE usuario.dscareaatuacao = '$area' AND veiculo.categoriaveiculo_idcategoriaveiculo = $carga";
                    $res = pg_query($con, $sql);
                    $linhas = pg_fetch_all($res);

                } elseif(($area == '0') AND !($carga == '0')){
                    $sql = "SELECT * FROM mydb.usuario INNER JOIN mydb.veiculo ON(usuario.idusuario = veiculo.usuario_idusuario) INNER JOIN mydb.categoriaveiculo ON(veiculo.categoriaveiculo_idcategoriaveiculo = categoriaveiculo.idcategoriaveiculo) WHERE veiculo.categoriaveiculo_idcategoriaveiculo = $carga";
                    $res = pg_query($con, $sql);
                    $linhas = pg_fetch_all($res);

                } elseif(!($area == '0') AND ($carga == '0')) {
                    $sql = "SELECT * FROM mydb.usuario INNER JOIN mydb.veiculo ON(usuario.idusuario = veiculo.usuario_idusuario) INNER JOIN mydb.categoriaveiculo ON(veiculo.categoriaveiculo_idcategoriaveiculo = categoriaveiculo.idcategoriaveiculo) WHERE usuario.dscareaatuacao = '$area'";
                    $res = pg_query($con, $sql);
                    $linhas = pg_fetch_all($res);
                }

            endif;
        
        
            pg_close($con);
        
        ?>

        <script>
        
        //declaracao de funcao
        function desenha_perfis(item, resultado, id){
                //Pegando os dados
                id = 'i' + id;

                var nome = resultado[item]['dscnomeusuario'];

                var email = resultado[item]['dscemailusuario'];

                var descricao = resultado[item]['dscusuario']
                if (descricao == null){
                    descricao = "Usuario sem descrição"
                }

                var contato = resultado[item]['dsctelusuario'];
                if (contato == null){
                    contato = "Usuario sem contato"
                }

                var img = resultado[item]['img'];

                var veiculo = resultado[item]['dscveiculo'];

                var categoriaveiculo = resultado[item]['dsccategoriaveiculo'];

                //Criando a saida
                perfis = '<tr><th><figure align="left" class="fig"><img class="img" id="' + id +'" src="imagem/' + img + '" onerror="standby(element)"></figure></th><td><h1 align="left">' + nome +'</h1><br>' + descricao + '<br>Veículo: ' + veiculo + ', ' + categoriaveiculo + '<br>Contato: ' + contato + '<br>Email: ' + email + '</td></tr>';
                //tabela.innerHTML = '<tr><th><figure align="left" class="fig"><img class="img" src="imagem/claudio.png"></figure></th><td><h1 align="left">Bárbara e Claudio</h1><br>Realizamos tranporte de cargas leves, com peso até 5 toneladas, e distância até 13 Km.<br>Veículo: VW delivery 8160<br>Contato: (27) 66767-0098</td></tr>';
                //var th = document.createElement("th");
                return perfis;
            }

            function standby(element) {
                document.getElementById(element).src = 'imagem/profpic.png'
            }


        function exibe_perfis(){

        
            //Resultado da query
            var resultado = <?php echo json_encode($linhas); ?>;

            

            var perfis = '';
            var id = 0;

            for(item in resultado){
                id += 1;
                perfis += desenha_perfis(item, resultado, id);
            }
            console.log(perfis)
            tabela = document.getElementById('motoristas');
            tabela.innerHTML = perfis;

        }

        function alterna(x){

            var elem = document.getElementById(x);
            if (elem == document.getElementById('filter')){
                var alterar = document.getElementById('filtro-form');

                elem.style.visibility = "hidden";
                alterar.style.visibility = "visible"
            }
            else {
                var alterar = document.getElementById('filter');

                elem.style.visibility = "hidden"
                alterar.style.visibility = "visible"
            }
        }
            
        </script>

        <?php include 'header-logado.php'; ?>

        <button id="filter" style="position: fixed; visibility: show" onclick="alterna(this.id)">
            <img src="imagem/filter.png" style="width: auto; height: auto; max-width: 17px; max-height: 100px; margin: 0px; padding: 0px;">
        </button>
        <div style="position: fixed; margin-left: 8px; visibility: hidden" id="filtro-form">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <p style="display: inline">Filtro:</p><img src="imagem/deny.png" onclick="alterna('filtro-form')" style="width: auto; height: auto; max-width: 200px; max-height: 20px; margin: 0px; padding: 0px; margin-top: 2px; margin-left: 20px"><br><br>
                <p style="display: inline;">Area de atuação</p><br>
                <select name="area" id="">
                    <option value="0">Qualquer</option>
                    <option value="Vitória">Vitória</option>
                    <option value="Serra">Serra</option>
                    <option value="Vila Velha">Vila Velha</option>
                    <option value="Cariacica">Cariacica</option>
                    <option value="Fundão">Fundão</option>
                    <option value="Guarapari">Guarapari</option>
                    <option value="Viana">Viana</option>
                    <option value="Grande Vitória">Grande Vitória</option>
                </select><br>

                <p style="display: inline;">Tamanho da carga:</p><br>
                <select name="carga" id="">
                    <option value="0">Qualquer</option>
                    <option value="1">Frete Doméstico</option>
                    <option value="2">Carga Leve</option>
                    <option value="3">Carga Média</option>
                    <option value="4">Carga Pesada</option>
                </select>
                <br><br>
                <button type="submit" name="filtrar">Aceitar</button>
            </form>

        </div>
        <center>
            <article>
                <table id="motoristas">

                </table>
                <?php include 'footer.php'; ?>
            </article>
        </center>

        <script>
            window.onload = exibe_perfis();
        </script>
    </body>
</html>