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

            //altera email
            if (isset($_POST['formulario_email'])):
                $erros = array();
                $id = $_SESSION['id_usuario'];
                if(!$femail = filter_input(INPUT_POST, 'femail', FILTER_VALIDATE_EMAIL)){
                    $erros[] = "Email inválido digitado";
                }
            
                if(!empty($erros)):
                    foreach($erros as $erro):
                        echo "<li> $erro </li>";
                    endforeach;
                else:
                    $sql = "UPDATE mydb.usuario SET dscemailusuario = '$femail' WHERE idusuario = $id";
                    $res = pg_query($con, $sql);
                    echo "Email alterado com sucesso";
                
                endif;
            endif;

            //altera celular
            if (isset($_POST['formulario_tel'])):
                $erros = array();
                $id = $_SESSION['id_usuario'];
                $tel = $_POST['ftel'];
            
                if($tel == ""){
                    $erros[] = "Todos os campos devem ser preenchidos";
                }
            
                if(!empty($erros)):
                    foreach($erros as $erro):
                        echo "<li> $erro </li>";
                    endforeach;
                else:
                    $sql = "UPDATE mydb.usuario SET dsctelusuario = '$tel' WHERE idusuario = $id";
                    $res = pg_query($con, $sql);
                    echo "Celular alterado com sucesso";
                endif;
            endif;

            //altera atuacao
            if (isset($_POST['formulario_atuacao'])):
                $erros = array();
                $id = $_SESSION['id_usuario'];
                $area = $_POST['farea'];
            
                if($area == ""){
                    $erros[] = "Todos os campos devem ser preenchidos";
                }
            
                if(!empty($erros)):
                    foreach($erros as $erro):
                        echo "<li> $erro </li>";
                    endforeach;
                else:
                    $sql = "UPDATE mydb.usuario SET dscareaatuacao = '$area' WHERE idusuario = $id";
                    $res = pg_query($con, $sql);
                    echo "Area de atuaçao alterada com sucesso";
                endif;
            endif;

            //alteradsc
            if (isset($_POST['formulario_descricao'])):
                $erros = array();
                $id = $_SESSION['id_usuario'];
                $descricao = $_POST['fdescricao'];
            
                if($descricao == ""){
                    $erros[] = "Todos os campos devem ser preenchidos";
                }
            
                if(!empty($erros)):
                    foreach($erros as $erro):
                        echo "<li> $erro </li>";
                    endforeach;
                else:
                    $sql = "UPDATE mydb.usuario SET dscusuario = '$descricao' WHERE idusuario = $id";
                    $res = pg_query($con, $sql);
                    echo "Descricao de usuario alterada com sucesso";
                endif;
            endif;

            //Altera senha
            if (isset($_POST['formulario_senha'])):
                $erros = array();
                $id = $_SESSION['id_usuario'];
                $senha1 = $_POST['fsenha1'];
                $senha2 = $_POST['fsenha2'];
            
                if(($senha1 == "") OR (!$senha1 == $senha2)){
                    $erros[] = "Senha incorreta";
                }
            
                if(!empty($erros)):
                    foreach($erros as $erro):
                        echo "<li> $erro </li>";
                    endforeach;
                else:
                    $senha = md5($senha1);
                    $sql = "UPDATE mydb.usuario SET dscsenhausuario = '$senha' WHERE idusuario = $id";
                    $res = pg_query($con, $sql);
                    echo "Senha alterada com sucesso";
                endif;
            endif;


            //adiciona veiculo
            if (isset($_POST['formulario_veiculo'])):
                $erros = array();
                $id = $_SESSION['id_usuario'];
                $veiculo = $_POST['fveiculo'];
                $categoria = filter_input(INPUT_POST, 'fcategoria', FILTER_SANITIZE_NUMBER_INT);
            
                if(($veiculo == "") or ($categoria == "")){
                    $erros[] = "Todos os campos devem ser preenchidos";
                }
            
                if(!empty($erros)):
                    foreach($erros as $erro):
                        echo "<li> $erro </li>";
                    endforeach;
                else:
                    $sql = "SELECT * FROM mydb.veiculo INNER JOIN mydb.usuario ON(usuario.idusuario = veiculo.usuario_idusuario) WHERE usuario.idusuario = $id";
                    $res = pg_query($con, $sql);
            
                    if(pg_num_rows($res) == 0){
                        //criar novo id
                        $sql = "SELECT MAX(idveiculo) FROM mydb.veiculo";
                        $idveiculo = pg_query($con, $sql);
                        $idveiculo = pg_fetch_array($idveiculo);
                        $idveiculo = $idveiculo['max'] + 1;
            
                        //criar novo veículo
                        $sql = "INSERT INTO mydb.veiculo (idveiculo, dscveiculo, usuario_idusuario, categoriaveiculo_idcategoriaveiculo) VALUES ($idveiculo, '$veiculo', $id, $categoria)";
                        $res = pg_query($con, $sql);
                    }
                    else{
                        //alterar veiculo existente
                        echo "estamos aqui";
                        $sql = "UPDATE mydb.veiculo SET dscveiculo = '$veiculo', categoriaveiculo_idcategoriaveiculo = $categoria WHERE usuario_idusuario = $id";
                        $res = pg_query($con, $sql);
                    }
                    

                endif;
            endif;


            //dados do usuario
            $id = $_SESSION['id_usuario'];
            $sql = "SELECT * FROM mydb.usuario WHERE idusuario = '$id'";
            $res = pg_query($con, $sql);
            $dados = pg_fetch_array($res);

            $sql = "SELECT * FROM mydb.veiculo INNER JOIN mydb.categoriaveiculo ON(categoriaveiculo.idcategoriaveiculo = veiculo.categoriaveiculo_idcategoriaveiculo) INNER JOIN mydb.usuario ON(usuario.idusuario = veiculo.usuario_idusuario) WHERE usuario.idusuario= '$id'";
            $res = pg_query($con, $sql);
            $veiculo = pg_fetch_array($res);

            if($veiculo['dscveiculo'] == ""){
                $veiculo['dscveiculo'] = "Erro";
                $veiculo['dsccategoriaveiculo'] = "sem veículo cadastrado";
            }

            if($dados['dsctelusuario'] == ""){
                $dados['dsctelusuario'] = "Sem celular cadastrado";
            }

            if($dados['dscareaatuacao'] == ""){
                $dados['dscareaatuacao'] = "Sem área de atuação";
            }

            //Altera foto
            if (isset($_FILES['arquivo'])){

                $id = $_SESSION['id_usuario'];

                $extensao = strtolower(substr($_FILES['arquivo']['name'], -4));
                $novo_nome = md5(time()) . $extensao;
                $diretorio = "imagem/";

                move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.$novo_nome);

                $sql = "UPDATE mydb.usuario SET img = '$novo_nome' WHERE idusuario = $id";
                $res = pg_query($con, $sql);
                
            }

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

                if(linha == "6" || linha == "8"){
                    var i5 = document.getElementById("i" + linha + "5");
                    if(!(x.slice(2, 3).localeCompare("1"))){
                    
                        i0.style.display = "none";
                        i1.style.display = "none";
                        i2.style.display = "block";
                        i3.style.display = "block";
                        i4.style.display = "block";
                        i5.style.display = "block";

                    } else {

                        i0.style.display = "inline";
                        i1.style.display = "block";
                        i2.style.display = "none";
                        i3.style.display = "none";
                        i4.style.display = "none";
                        i5.style.display = "none"

                    }
                }

                //var x = document.getElementById("botao");
                if(!(x.slice(2, 3).localeCompare("1"))){
                    
                    i0.style.display = "none";
                    i1.style.display = "none";
                    i2.style.display = "block";
                    i3.style.display = "block";
                    i4.style.display = "block";


                } else {

                    i0.style.display = "inline";
                    i1.style.display = "block";
                    i2.style.display = "none";
                    i3.style.display = "none";
                    i4.style.display = "none";

                }
            }
        </script>

        <?php include 'header-logado.php'; ?>

        <center>
            <article style="height:100vh">
                <figure class="profpic1">
                    <img src="imagem/<?php echo $dados['img']; ?>" alt="imagem/profpic.png" style="width: auto; height: auto; max-width: 200px; max-height: 200px; margin: 0px; padding: 0px">
                    <p id="botao">Alterar imagem de perfil</p>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                        Arquivo: <input type="file" required name="arquivo" class="foto" style="display: block"><br>
                        <input type="submit" value="Enviar" class="foto" style="display: block">
                    </form>
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
                            <img class="editar-none" id="i12" src="imagem/deny.png" onclick="alterna(this.id)">
                            <img class="editar-none"editar" id="i13" src="imagem/accept.png">
                            <input type="text" class="editar-none" id="i14" name="fnome" value="">
                            <br><br>

                            <p id="i20"><?php echo $dados['dscidentificacaousuario']; ?></p>
                            <img class="editar-none" id="i22" src="imagem/deny.png" onclick="alterna(this.id)">
                            <img class="editar-none" id="i23" src="imagem/accept.png">
                            <input type="text" class="editar-none" id="i24" name="cpf" value="">
                            <br><br>

                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <p id="i30"><?php echo $dados['dscemailusuario']; ?></p>
                                <img class="editar" id="i31" src="imagem/edit.png" onclick="alterna(this.id)">
                                <img class="editar-none" id="i32" src="imagem/deny.png" onclick="alterna(this.id)">
                                <button type="submit" class="editar-none" id="i33" name="formulario_email">
                                    <img class="editar" src="imagem/accept.png">    
                                </button>
                                <input type="text" class="editar-none" id="i34" name="femail" value="">
                            </form>
                            <br><br>

                        </div>
                    </div>
                    
                    <div id="dados-direita">
                        <div class="esquerda">
                            <p>Celular: </p><br><br>
                            <p>Atuação: </p><br><br>
                            <p>Senha: </p><br><br>
                        </div>
                        <div class="direita">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <p id="i40"><?php echo $dados['dsctelusuario']; ?></p>
                                <img class="editar" id="i41" src="imagem/edit.png" onclick="alterna(this.id)">
                                <img class="editar-none" id="i42" src="imagem/deny.png" onclick="alterna(this.id)">
                                <button type="submit" class="editar-none" id="i43" name="formulario_tel">
                                    <img class="editar" src="imagem/accept.png">    
                                </button>
                                <input type="text" class="editar-none" id="i44" name="ftel" value="">
                            </form>
                            <br>

                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <p id="i50"><?php echo $dados['dscareaatuacao']; ?></p>
                                <img class="editar" id="i51" src="imagem/edit.png" onclick="alterna(this.id)">
                                <img class="editar-none" id="i52" src="imagem/deny.png" onclick="alterna(this.id)">
                                <button type="submit" class="editar-none" id="i53" name="formulario_atuacao">
                                    <img class="editar" src="imagem/accept.png">    
                                </button>
                                <select class="editar-none" id="i54" name="farea">
                                    <option value="Vitória">Vitória</option>
                                    <option value="Serra">Serra</option>
                                    <option value="Vila Velha">Vila Velha</option>
                                    <option value="Cariacica">Cariacica</option>
                                    <option value="Fundão">Fundão</option>
                                    <option value="Guarapari">Guarapari</option>
                                    <option value="Viana">Viana</option>
                                    <option value="Grande Vitória">Grande Vitória</option>
                                </select>
                            </form>
                            <br>

                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <p id="i60"><?php echo $_SESSION['senha']; ?></p>
                                <img class="editar" id="i61" src="imagem/edit.png" onclick="alterna(this.id)">
                                <img class="editar-none" id="i62" src="imagem/deny.png" onclick="alterna(this.id)">
                                <button type="submit" class="editar-none" id="i63" name="formulario_senha">
                                    <img class="editar" src="imagem/accept.png">    
                                </button>
                                <input type="text" class="editar-none" id="i64" name="fsenha1" value=""><br>
                                <input type="text" class="editar-none" id="i65" name="fsenha2" value="">
                            </form>
                            <br><br><br>
                        </div>
                    </div>

                    <div id="dados-embaixo">
                        <div class="esquerda">
                            <br>
                            <p>Descrição do perfil:</p><br><br><br><br><br><br><br><br><br><br><br><br>
                            <p>Veículo</p>
                        </div>
                        <div class="direita">
                            
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <p id="i70"><?php echo $dados['dscusuario']; ?></p>
                                <img class="editar" id="i71" src="imagem/edit.png" onclick="alterna(this.id)">
                                <img class="editar-none" id="i72" src="imagem/deny.png" onclick="alterna(this.id)">
                                <button type="submit" class="editar-none" id="i73" name="formulario_descricao">
                                    <img class="editar" src="imagem/accept.png">
                                </button>
                                <input type="text" class="editar-none" id="i74" name="fdescricao">
                            </form>
                            <br><br><br><br><br><br><br><br><br><br><br>

                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form">
                                <p id="i80"><?php echo $veiculo['dscveiculo']; ?>, <?php echo $veiculo['dsccategoriaveiculo'] ?></p>
                                <img class="editar" id="i81" src="imagem/add.png" onclick="alterna(this.id)">
                                <img class="editar-none" id="i82" src="imagem/deny.png" onclick="alterna(this.id)">
                                <button type="submit" class="editar-none" id="i83" name="formulario_veiculo">
                                    <img class="editar" src="imagem/accept.png">    
                                </button>
                                <select class="editar-none" id="i85" name="fcategoria">
                                    <option value="1">Frete Doméstico</option>
                                    <option value="2">Carga Leve</option>
                                    <option value="3">Carga Média</option>
                                    <option value="4">Carga Pesada</option>
                                </select>
                                <input type="text" class="editar-none" id="i84" name="fveiculo">
                            </form>

                            </select>
                        </div>
                    </div>

                </div>

                

                <?php include 'footer.php'; ?>
            </article>
        </center>

    </body>
</html>