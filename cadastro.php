<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/cadastro.css">
        <title>Express Frete</title>
    </head>

    <body>

    <?php
        require_once 'db_connect.php';

        session_start();
        $_SESSION['logado'] = false;

        if (isset($_POST['enviar-formulario'])):
            $erros = array();
            $fsenha1 = $_POST['fsenha1'];
            $fsenha2 = $_POST['fsenha2'];
            $fnome = $_POST['fnome'];
            $fcpf = $_POST['fcpf'];

            if($fnome == ""){
                $erros[] = "Nome não pode estar vazio";
            }

            if(!$femail = filter_input(INPUT_POST, 'femail', FILTER_VALIDATE_EMAIL)){
                $erros[] = "Email inválido digitado";
            }

            $femail = filter_input(INPUT_POST, 'femail', FILTER_SANITIZE_EMAIL);

            if($fcpf == ""){
                $erros[] = "Cpf não pode estar vazio";
            }

            if(($fsenha1 == "") or (!$fsenha1 == $fsenha2)) {
                $erros[] = "Senha incorreta";
            }


            if(!empty($erros)):
                foreach($erros as $erro):
                    echo "<li> $erro </li>";
                endforeach;
            else:
                $sql = "SELECT dscemailusuario FROM mydb.usuario WHERE dscEmailUsuario = '$femail'";
                $res = pg_query($con, $sql);

                if(!pg_num_rows($res) == 0){
                    $erros[] = "Email já cadastrado no sistema";
                    echo "<li> $erros[0] </li>";
                }
                else{
                    $sql = "SELECT MAX(idusuario) FROM mydb.usuario";
                    $id = pg_query($con, $sql);
                    $id = pg_fetch_array($id);
                    $id = $id['max'] + 1;
                    
                    $sql = "INSERT INTO mydb.usuario (idUsuario, dscNomeUsuario, dscEmailUsuario, dscSenhaUsuario, dscIdentificacaoUsuario) VALUES ($id, '$fnome', '$femail', '$fsenha1', '$fcpf');";
                    pg_query($con, $sql);

                    $sql = "SELECT * FROM mydb.usuario WHERE idusuario = $id";
                    $res = pg_fetch_array($res);

                    $dados = pg_fetch_array($res);
                    $_SESSION['logado'] = true;
                    $_SESSION['id_usuario'] = $dados['idusuario'];
                    header("Location: motoristas.php");
                }

                //header("Location: motoristas.php");
            endif;

        endif;

        pg_close($con);

    ?>

        <header>
        <nav class="header_toolbar">
            <div class="topzinha">
            <a href="index.php"> Home </a> </li>
            <a href="cadastro.php"> Cadastro </a> </li>
            </div>
        </nav>
        </header>

        <div class="header_content">
            <figure class="header_img"><img src="imagem/caminhao4.jpg"></figure><br>
            <div class="header_slogan">Express Frete</div>
        </div>

        <center>
            <article>

                <h1>Cadastro</h1>
                
                <div class="login">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                    <div id="teste">
                            <label class="teste" for="fname">Digite o seu nome:</label>
                            <input type="text" name="fnome" id="fnome" value=""><br><br>
                            
                            <label class="teste" for="femail">Digite seu e-mail:</label>
                            <input type="text" id="femail" name="femail" value=""><br><br>
                            
                            <label class="teste" for="fcpf">Digite o seu CPF(Com pontuação):</label>
                            <input type="text" name="fcpf" id="fcpf" value=""><br><br>
                    </div>
        
                            <label for="fsenha">Digite a sua senha:</label><br>
                            <input type="password" id="fsenha1" name="fsenha1" value=""><br><br>

                            <label for="fsenha">Confirme a sua senha:</label><br>
                            <input type="password" id="fsenha2" name="fsenha2" value=""><br><br>
                        
                        <button type="submit" name="enviar-formulario">Entrar</button>
                      </form>
                </div>
                <footer id="rodape">Todos os direitos reservados.</footer>
            </article>
        </center>
    </body>
</html>