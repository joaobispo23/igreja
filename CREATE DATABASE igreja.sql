CREATE DATABASE igreja;

USE igreja;

CREATE TABLE visitantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(15),
    email VARCHAR(100),
    data_visita DATE NOT NULL,
    rua VARCHAR(100),
    numero VARCHAR(10),
    cep VARCHAR(10),
    bairro VARCHAR(50),
    cidade VARCHAR(50),
    observacoes TEXT
);
