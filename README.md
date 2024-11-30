# Projeto-T1-ProgramaWeb

Para o projeto rodar no computador, é necessário criar o seguinte database:

Nome:  "db_projeto1_php1"  

(mas pode ser outro se quiser, só teria que ser alterado no db.php)

Tabelas necessárias dentro o database:

Execute os seguintes comandos na query do mysql workbench(em ordem!!):

PRIMEIRO:

USE db_projeto1_php

SEGUNDO:

CREATE TABLE login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    data_nascimento DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

TERCEIRO:

CREATE TABLE catalogofilmes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    release_date DATE NOT NULL,
    image VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


QUARTO:

CREATE TABLE comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filme_id INT NOT NULL,
    autor VARCHAR(255) NOT NULL,
    comentario TEXT NOT NULL,
    data_comentario DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (filme_id) REFERENCES catalogofilmes(id) ON DELETE CASCADE
);
