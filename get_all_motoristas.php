<?php
 
/*
 * O seguinte codigo retorna para o cliente a lista de produtos 
 * armazenados no servidor. Essa e uma requisicao do tipo GET. 
 * Nao sao necessarios nenhum tipo de parametro.
 * A resposta e no formato JSON.
 */
 
// array que guarda a resposta da requisicao
$response = array();
 
// Abre uma conexao com o BD.
// DATABASE_URL e uma variavel de ambiente definida pelo Heroku, servico 
// utilizado para fazer o deploy dessa aplicacao web. Ela 
// contem a string de conexao necessaria para acessar o BD fornecido pelo 
// Heroku. Caso voce nao utilize o servico Heroku, voce deve alterar a 
// linha seguinte para realizar a conexao correta com o BD de sua escolha.
require_once 'db_connect.php';
 
// Realiza uma consulta ao BD e obtem todos os produtos.
//dados dos motoristas
$sql = "SELECT * FROM mydb.usuario INNER JOIN mydb.veiculo ON(usuario.idusuario = veiculo.usuario_idusuario) INNER JOIN mydb.categoriaveiculo ON(veiculo.categoriaveiculo_idcategoriaveiculo = categoriaveiculo.idcategoriaveiculo)";
$result = pg_query($con, $sql);
 

if (pg_num_rows($result) > 0) {
    // Caso existam produtos no BD, eles sao armazenados na 
	// chave "products". O valor dessa chave e formado por um 
	// array onde cada elemento e um produto.
    $response["motoristas"] = array();
 
    while ($row = pg_fetch_array($result)) {
        // Para cada produto, sao retornados somente o 
		// pid (id do produto) e o nome do produto. Nao ha necessidade 
		// de retornar nesse momento todos os campos de todos os produtos 
		// pois a app cliente, inicialmente, so precisa do nome do mesmo para 
		// exibir na lista de produtos. O campo pid e usado pela app cliente 
		// para buscar os detalhes de um produto especifico quando o usuario 
		// o seleciona. Esse tipo de estrategia poupa banda de rede, uma vez 
		// os detalhes de um produto somente serao transferidos ao cliente 
		// em caso de real interesse.
        $motorista = array();
        $motorista["id"] = $row["idusuario"];
        $motorista["name"] = $row["dscnomeusuario"];
		$motorista["img"] = $row["img"];
		$motorista["veiculo"] = $row["dscveiculo"];
		$motorista["categoria"] = $row["dsccategoriaveiculo"];
 
        // Adiciona o produto no array de produtos.
        array_push($response["motoristas"], $motorista);
    }
    // Caso haja produtos no BD, o cliente 
	// recebe a chave "success" com valor 1.
    $response["success"] = 1;
	
	pg_close($con);
 
    // Converte a resposta para o formato JSON.
    echo json_encode($response);
	
} else {
    // Caso nao haja produtos no BD, o cliente 
	// recebe a chave "success" com valor 0. A chave "message" indica o 
	// motivo da falha.
    $response["success"] = 0;
    $response["message"] = "Nao ha motoristas";
	
	// Fecha a conexao com o BD
	pg_close($con);
 
    // Converte a resposta para o formato JSON.
    echo json_encode($response);
}
?>