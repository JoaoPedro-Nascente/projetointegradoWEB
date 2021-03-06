<?php
 
/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */
 
// connecting to db
require_once 'db_connect.php';
 
// array for JSON response
$response = array();
 
// check for required fields
if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['cpf']) && isset($_POST['senha'])) {
 
	$newEmail = trim($_POST['email']);
	$newNome = trim($_POST['nome']);
	$newCpf = trim($_POST['cpf']);
	$newSenha = trim($_POST['senha']);
		
	$usuario_existe = pg_query($con, "SELECT dscemailusuario FROM mydb.usuario WHERE dscemailusuario='$newEmail'");
	// check for empty result
	if (pg_num_rows($usuario_existe) > 0) {
		$response["success"] = 0;
		$response["error"] = "usuario ja cadastrado";
	}
	else {

		//pegando um id
		$sql = "SELECT MAX(idusuario) FROM mydb.usuario";
		$id = pg_query($con, $sql);
		$id = pg_fetch_array($id);
		$id = $id['max'] + 1;

		$newSenha = md5($newSenha);

		// mysql inserting a new row
		$result = pg_query($con, "INSERT INTO mydb.usuario(idusuario, dscemailusuario, dscsenhausuario, dscidentificacaousuario, dscnomeusuario, img) VALUES($id, '$newEmail', '$newSenha', '$newCpf', '$newNome', 'profpic.png')");
	 
		if ($result) {
			$response["success"] = 1;
		}
		else {
			$response["success"] = 0;
			$response["error"] = "Error BD: ".pg_last_error($con);
		}
	}
}
else {
    $response["success"] = 0;
	$response["error"] = "faltam parametros";
}

pg_close($con);
echo json_encode($response);
?>