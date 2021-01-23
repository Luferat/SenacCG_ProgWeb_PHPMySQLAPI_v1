<?php

/***** Processa 'POST' (Inserir registro) *****/

// Obtém os dados do cliente
$date = isset($_POST['date']) ? $conn->real_escape_string($_POST['date']) : '';
$description = isset($_POST['description']) ? $conn->real_escape_string($_POST['description']) : '';
$priority = isset($_POST['priority']) ? $conn->real_escape_string($_POST['priority']) : '';

// Se estão faltando dados, emite erro
if ($date == '' OR $description == '' OR $priority == '') {
    $json = array("status" => "0", "error" => "Dados incompletos. Favor reenviar.");

    // Se os dados são consistentes
} else {

    // Formata SQL
    $sql = "
    INSERT INTO todo_list 
        (date, description, priority) 
    VALUES 
        ('{$date}', '{$description}', '{$priority}');
    ";

    // Executa o SQL
    $res = $conn->query($sql);

    // Feedback
    if ($res) {
        $json = array("status" => "1", "success" => "Tarefa adicionada com sucesso!");
    } else {
        $json = array("status" => "0", "error" => "Erro ao adicionar nova tarefa. Tente novamente!");
    }
}