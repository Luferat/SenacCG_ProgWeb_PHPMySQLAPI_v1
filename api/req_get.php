<?php

/***** Processa 'GET' (Obter registro(s)) *****/

// Obtém dados do cliente
$parts = explode('/', $_SERVER['REQUEST_URI']);

// Remove o que não interessa
array_shift($parts);
array_shift($parts);

/* Testes unitários
print_r($parts);
*/

// Obtém nome do campo de ordenação ou o ID do registro
if ($parts[0] != '') {
    $field = $parts[0];
    $id = intval($parts[0]);
} else {
    $field = 'date';
    $id = 0;
}

// Obtém a direção da ordenação
$direction = (isset($parts[1])) ? strtoupper($parts[1]) : 'ASC';

/* Testes unitários 
print_r("\nCampo: " . $field);
print_r("\nID: " . $id);
print_r("\nDireção: " . $direction);
print_r("\n\n");
*/

// Se enviou um ID, pesquisa pelo ID
if ($id > 0) {

    // Obtém um registro pelo ID
    $sql = "SELECT * FROM todo_list WHERE id = '{$id}' AND status = 'ativo';";
    $res = $conn->query($sql);
    if ($res->num_rows == 1) {

        // Variável com os dados do registro
        $result = array();

        // Lista dados como JSON
        extract($res->fetch_assoc());
        $result[] = array(
            "id" => $id,
            "date" => $date,
            "description" => $description,
            "priority" => $priority
        );

        // Formata o JSON de saída
        $json = array("status" => "1", "data" => $result);

        // Se não encontrar o registro solicitado
    } else {
        $json = array("status" => "0", "error" => "Tarefa não encontrada!");
    }

    // Se não enviou um ID, pesquisa todos os registros
} else {

    // Obtém todos os registros
    $sql = "SELECT * FROM todo_list WHERE status = 'ativo' ORDER BY {$field} {$direction};";
    // print_r($sql);
    $res = $conn->query($sql);
    $total = $res->num_rows;
    if ($total > 0) {

        // Variável com os dados do registro
        $result = array();

        // Obtém cada registro para listar
        while ($r = $res->fetch_assoc()) {

            // Lista dados como JSON
            extract($r);
            $result[] = array(
                "id" => $id,
                "date" => $date,
                "description" => $description,
                "priority" => $priority
            );
        }

        // Formata o JSON de saída
        $json = array('status' => '1', 'length' => "{$total}", 'data' => $result);
        
        // Se não encontrar registros
    } else {
        $json = array("status" => "0", "error" => "Não existem tarefas agendadas!");

    }
}
