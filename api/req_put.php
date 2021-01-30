<?php

/***** Processa 'PUT' (Atualizar registro) *****/

// Inicializa variáveis
$setters = '';

// Obtém dados do cliente
parse_str(file_get_contents('php://input'), $_PUT);

// Obtém o ID do registro
$id = isset($_PUT['id']) ? intval($_PUT['id']) : 0;

if ($id > 0) {

    // Testa se o registro existe
    $sql = "SELECT id FROM `todo_list` WHERE id = '{$id}' AND status = 'ativo'";
    $res = $conn->query($sql);
    if ($res->num_rows == 1) {

        // Filtra dados do cliente
        $date = isset($_PUT['date']) ? $conn->real_escape_string(trim($_PUT['date'])) : '';
        $description = isset($_PUT['description']) ? $conn->real_escape_string(trim($_PUT['description'])) : '';
        $priority = isset($_PUT['priority']) ? $conn->real_escape_string(trim($_PUT['priority'])) : '';

        // Preparando dados do cliente
        $setters .= ($date != '') ? " date = '{$date}'," : '';
        $setters .= ($description != '') ? " description = '{$description}'," : '';
        $setters .= ($priority != '') ? " priority = '{$priority}'," : '';

        // Remove a última vírgula
        $setters = substr($setters, 0, -1);

        // Se tem o que editar
        if ($setters != '') {

            // Atualiza no database
            $sql = "UPDATE todo_list SET {$setters} WHERE id = '{$id}'";
            $res = $conn->query($sql);

            // Feedback
            if ($res) {
                $json = array('status' => '1', 'success' => 'Tarefa editada com sucesso!');
            } else {
                $json = array('status' => '0', 'error' => 'Falha ao editar tarefa!');
            }

            // Se não tem o que editar
        } else {
            $json = array('status' => '0', 'error' => 'Nada para ser editado!');
        }

        // Caso não exista registro para editar
    } else {
        $json = array('status' => '0', 'error' => 'Registro não encontrado!');
    }

    // Se não informou um ID
} else {
    $json = array('status' => '0', 'error' => 'Registro não encontrado!');
}
