<?php
 
/*
 * O codigo seguinte retorna os dados detalhados de um produto.
 * Essa e uma requisicao do tipo GET. Um produto e identificado 
 * pelo campo pid.
 */
 
// array que guarda a resposta da requisicao
$response = array();
 
// Verifica se o parametro pid foi enviado na requisicao
if (isset($_GET["id"])) {
	
	// Aqui sao obtidos os parametros
    $id = $_GET['id'];
	
	// Abre uma conexao com o BD.
	// DATABASE_URL e uma variavel de ambiente definida pelo Heroku, servico 
	// utilizado para fazer o deploy dessa aplicacao web. Ela 
	// contem a string de conexao necessaria para acessar o BD fornecido pelo 
	// Heroku. Caso voce nao utilize o servico Heroku, voce deve alterar a 
	// linha seguinte para realizar a conexao correta com o BD de sua escolha.
	require_once 'db_connect.php';
 
    // Obtem do BD os detalhes do produto com pid especificado na requisicao GET
    $result = pg_query($con, "SELECT * FROM mydb.usuario INNER JOIN mydb.veiculo ON(usuario.idusuario = veiculo.usuario_idusuario) INNER JOIN mydb.categoriaveiculo ON(veiculo.categoriaveiculo_idcategoriaveiculo = categoriaveiculo.idcategoriaveiculo) WHERE usuario.idusuario = $id");
 
    if (!empty($result)) {
        if (pg_num_rows($result) > 0) {
 
			// Se o produto existe, os dados de detalhe do produto 
			// sao adicionados no array de resposta.
            $result = pg_fetch_array($result);
 
            $motorista = array();
            $motorista["nome"] = $result["dscnomeusuario"];
            $motorista["dsc"] = $result["dscusuario"];
            $motorista["cpf"] = $result["dscidentificacaousuario"];
			$motorista["img"] = $result["img"];
            $motorista["tel"] = $result["dsctelusuario"];
            $motorista["Email"] = $result["dscemailusuario"];
            $motorista["veiculo"] = $result["dscveiculo"];
            $motorista["categoriaveiculo"] = $result["dsccategoriaveiculo"];
            
            // Caso o produto exista no BD, o cliente 
			// recebe a chave "success" com valor 1.
            $response["success"] = 1;
 
            $response["motorista"] = array();
 
			// Converte a resposta para o formato JSON.
            array_push($response["motorista"], $motorista);
			
			// Fecha a conexao com o BD
			pg_close($con);
 
            // Converte a resposta para o formato JSON.
            echo json_encode($response);
        } else {
            // Caso o produto nao exista no BD, o cliente 
			// recebe a chave "success" com valor 0. A chave "message" indica o 
			// motivo da falha.
            $response["success"] = 0;
            $response["message"] = "Produto não encontrado";
			
			// Fecha a conexao com o BD
			pg_close($con);
 
            // Converte a resposta para o formato JSON.
            echo json_encode($response);
        }
    } else {
        // Caso o produto nao exista no BD, o cliente 
		// recebe a chave "success" com valor 0. A chave "message" indica o 
		// motivo da falha.
        $response["success"] = 0;
        $response["message"] = "Produto não encontrado";
 
		// Fecha a conexao com o BD
		pg_close($con);
 
        // Converte a resposta para o formato JSON.
        echo json_encode($response);
    }
} else {
    // Se a requisicao foi feita incorretamente, ou seja, os parametros 
	// nao foram enviados corretamente para o servidor, o cliente 
	// recebe a chave "success" com valor 0. A chave "message" indica o 
	// motivo da falha.
    $response["success"] = 0;
    $response["message"] = "Campo requerido não preenchido";
 
    // Converte a resposta para o formato JSON.
    echo json_encode($response);
}
?>