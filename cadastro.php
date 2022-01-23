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

        if (isset($_POST['enviar-formulario'])):
            $erros = array();
            $fsenha1 = $_POST['fsenha1'];
            $fsenha2 = $_POST['fsenha2'];

            if(!$femail = filter_input(INPUT_POST, 'femail', FILTER_VALIDATE_EMAIL)){
                $erros[] = "Email inválido digitado";
            }

            $femail = filter_input(INPUT_POST, 'femail', FILTER_SANITIZE_EMAIL);

            if(($fsenha1 == "") or (!$fsenha1 == $fsenha2)) {
                $erros[] = "Senha incorreta";
            }

            if(!empty($erros)):
                foreach($erros as $erro):
                    echo "<li> $erro </li>";
                endforeach;
            else:
                header("Location: motoristas.php");
                exit();
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

                <h1>Cadastro</h1>
                
                <div class="login">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <label for="femail">Digite seu e-mail:</label><br>
                        <input type="text" id="femail" name="femail" value=""><br>
                        <label for="fsenha">Digite a sua senha:</label><br>
                        <input type="password" id="fsenha1" name="fsenha1" value=""><br>
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