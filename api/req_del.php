<?php

/***** Processa 'DELETE' (Apaga registro) *****/

// Obtém o ID do registro a ser apagado
$parts = $_SERVER['REQUEST_URI'];
$part = explode('/', $parts);
$id = intval($part[2]);

if ($id > 0) {

    // Testa se a tarefa existe
    $sql = "SELECT id FROM todo_list WHERE id = '{$id}' AND status = 'ativo';";
    $res = $conn->query($sql);
    if ($res->num_rows == 1) {

        // Atualiza 'status' da tarefa
        $sql = "UPDATE `todo_list` SET `status` = 'inativo' WHERE `id` = '{$id}';";
        $res = $conn->query($sql);

        // Feedback
        if ($res) {
            $json = array('status' => '1', 'success' => 'Tarefa apagada com sucesso!');
        } else {
            $json = array('status' => '0', 'error' => 'Não foi posssível apagar a tarefa.');
        }
    } else {
        $json = array('status' => '0', 'error' => 'Registro não encontrado.');
    }
} else {
    $json = array('status' => '0', 'error' => 'Requisição incorreta.');
}
