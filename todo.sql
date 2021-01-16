DROP DATABASE IF EXISTS todo;

CREATE DATABASE todo CHARACTER SET utf8 COLLATE utf8_general_ci;

USE todo;

CREATE TABLE todo_list (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    date DATETIME NOT NULL,
    description TEXT NOT NULL,
    priority VARCHAR(127),
    status ENUM('ativo', 'inativo') DEFAULT 'ativo'
);