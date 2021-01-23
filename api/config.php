<?php

// Cabeçalho do documento HTTP em JSON
header('Content-type: application/json; charset=utf-8');

// Obtém configurações estáticas (arquivo .ini)
$config = parse_ini_file('todo.ini');

// Conexão com o banco de dados MySQL
$conn = new mysqli($config['dbhost'], $config['username'], $config['password'], $config['db']);
if ($conn->connect_error) {
    die('Falha de conexão com o DB: ' . $conn->connect_error);
}

// Transações MySQL em UTF-8
$conn->query("SET NAMES 'utf8'");
$conn->query('SET character_set_connection=utf8');
$conn->query('SET character_set_client=utf8');
$conn->query('SET character_set_results=utf8');
