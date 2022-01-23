<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/index.css">
        <title>Express Frete</title>
    </head>

    <body>

    <?php

        require_once 'db_connect.php';

        session_start();

        if (isset($_POST['enviar-formulario'])):
            $erros = array();
            $fsenha = $_POST['fsenha'];

            if(!$femail = filter_input(INPUT_POST, 'femail', FILTER_VALIDATE_EMAIL)){
                $erros[] = "Email inválido digitado";
            }

            $femail = filter_input(INPUT_POST, 'femail', FILTER_SANITIZE_EMAIL);

            if($fsenha == ""){
                $erros[] = "Campo senha nao pode estar vazio";
            }



            if(!empty($erros)):
                foreach($erros as $erro):
                    echo "<li> $erro </li>";
                endforeach;
            else:
                $login = pg_escape_string($con, $femail);
                $senha = pg_escape_string($con, $fsenha);
                
                $sql = "SELECT dscEmailUsuario FROM mydb.usuario WHERE dscEmailUsuario = '$login'";
                $res = pg_query($con, $sql);
                
                if(pg_num_rows($res) > 0):
                    $sql = "SELECT * FROM mydb.usuario WHERE dscEmailUsuario = '$login' AND dscSenhaUsuario = '$senha'";
                    $res = pg_query($con, $sql);

                    if(pg_num_rows($res) == 1):
                        $dados = pg_fetch_array($res);
                        $_SESSION['logado'] = true;
                        $_SESSION['id_usuario'] = $dados['idUsuario'];
                        header("Location: motoristas.php");
                        exit();

                    else:
                        $erros[] = "Senha incorreta";
                        echo "<li> $erros[0] </li>";
                    endif;

                else:
                    $erros[] = "Usuario nao encontrado";
                    echo "<li> $erros[0] </li>";
                endif;

            endif;

        endif;
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
                <h1>Login</h1>
                
                <div class="login">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <label for="femail">E-mail:</label><br>
                        <input type="text" id="femail" name="femail"><br>
                        <label for="fsenha">Senha:</label><br>
                        <input type="password" id="fsenha" name="fsenha"><br><br>
                        <button type="submit" name="enviar-formulario">Entrar</button>
                      </form>

                      <a href="cadastro.php">Não tem cadastro?</a>
                </div>
                <footer id="rodape">Todos os direitos reservados.</footer>
            </article>
        </center>
    </body>
</html>