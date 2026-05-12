CREATE DATABASE IF NOT EXISTS todo_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE todo_db;

CREATE TABLE IF NOT EXISTS tarefas (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    texto     TEXT NOT NULL,
    feita     TINYINT(1) NOT NULL DEFAULT 0,
    criada_em DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
