-- Usar somente enquanto desenvolve o app

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

INSERT INTO todo_list 
    (date, description, priority) 
VALUES
    ('2021-01-21 07:25:00', 'Fazer café da manhã.', 'alta'),
    ('2021-01-22 12:30:00', 'Servir almoço da família.', 'alta'),
    ('2021-01-22 20:45:00', 'Lavar os pratos do jantar.', 'média'),
    ('2021-01-23 07:00:00', 'Acordar para um novo dia.', 'alta'),
    ('2021-01-23 09:15:00', 'Comprar gibi da Turma da Mônica.', 'baixa'),
    ('2021-01-23 09:00:00', 'Dar aula para progrmamador Web.', 'alta')
;