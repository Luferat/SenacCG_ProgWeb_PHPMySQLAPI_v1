<?php

/***** Processa 'GET' (Obter registro(s)) *****/

// Inicializa variável com os dados JSON
$result = array();

// Obtém dados do cliente pela URI
$parts = explode('/', $_SERVER['REQUEST_URI']);

// Remove o que não interessa na URI
array_shift($parts);
array_shift($parts);

// Obtém nome do campo de ordenação ou o ID do registro
if ($parts[0] != '') {

    // Remove espaços extra e converte nome do campo para minúsculas
    $field = trim(strtolower($parts[0]));

    // Se for um ID, obtemos ele
    $id = intval($field);

    // Se não passou dados, usa valores "default"
} else {
    $field = 'date';
    $id = 0;
}

// Obtém a direção da ordenação ou usa o "default" se não informou
if (isset($parts[1])) {
    $direction = trim(strtoupper($parts[1]));
} else {
    $direction = 'ASC';
}

// Se enviou um ID, pesquisa por ele
if ($id > 0) {

    // Obtém um registro pelo ID
    $sql = "SELECT * FROM todo_list WHERE id = '{$id}' AND status = 'ativo';";
    $res = $conn->query($sql);

    // Encontrou?
    if ($res->num_rows == 1) {

        // Lista dados como JSON
        extract($res->fetch_assoc());
        $result[] = array(
            'id' => $id,
            'date' => $date,
            'description' => $description,
            'priority' => $priority
        );

        // Formata o JSON de saída
        $json = array('status' => '1', 'data' => $result);

        // Se não encontrar o registro solicitado
    } else {
        $json = array('status' => '0', 'error' => 'Tarefa não encontrada!');
    }

    // Se não enviou um ID, pesquisa todos os registros
} else {

    // Lista de nomes de campos válidos para ordenação
    $fieldArray = array('id', 'date', 'descrition', 'priority');

    // Se não informou um nome de campo inválido
    if (!in_array($field, $fieldArray)) {

        // Usa o nome de campo "default"
        $field = 'date';
    }

    // Lista direções válidas
    $directionArray = array('ASC', 'DESC');

    // Se não informou uma direção inválida
    if (!in_array($direction, $directionArray)) {

        // Usa direção "default"
        $direction = 'ASC';
    }

    // Obtém todos os registros
    $sql = "SELECT * FROM todo_list WHERE status = 'ativo' ORDER BY {$field} {$direction};";
    $res = $conn->query($sql);

    // Conta registros encontrados
    $total = $res->num_rows;

    // Se achou registros
    if ($total > 0) {

        // Obtém cada registro para listar
        while ($r = $res->fetch_assoc()) {

            // Lista dados como JSON
            extract($r);
            $result[] = array(
                'id' => $id,
                'date' => $date,
                'description' => $description,
                'priority' => $priority
            );
        }

        // Formata o JSON de saída
        $json = array('status' => '1', 'length' => "{$total}", 'data' => $result);

        // Se não encontrar registros
    } else {
        $json = array('status' => '0', 'error' => 'Não existem tarefas agendadas!');
    }
}
