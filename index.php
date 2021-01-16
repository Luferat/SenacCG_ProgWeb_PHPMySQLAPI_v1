<?php

/**
 * Arquivo principal da API
 *      Depende de '.htaccess'
 */

// Configuração inicial
require_once('config.php');

// Inicializa o response
$json = '';

// Tipo de requisição
$req = strtoupper($_SERVER['REQUEST_METHOD']);

// Execute conforme tipo de requisição
switch ($req):

    case 'GET':

        // Processa 'GET' (Obter registros)
        require_once('./req_get.php');

        break;

    case 'POST':

        // Processa 'POST' (Inserir registro)
        require_once('./req_post.php');

        break;

    case 'PUT':

        // Processa 'PUT' (Atualizar registro)
        require_once('./req_put.php');

        break;

    case 'DELETE':

        // Processa 'DELETE' (Apaga registro)
        require_once('./req_del.php');

        break;

endswitch;

// Fecha conexão com o DB
$conn->close();

// Verifica se fez uma requisição válida
if ($json == '') {
    $json = array('status' => '0', 'error' => 'Erro de requisição. Use GET, POST, PUT ou DELETE.');
}

// Envia o JSON para o cliente
echo json_encode($json);
