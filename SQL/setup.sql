create database happypet;
use happypet;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);

INSERT INTO users(id,name,email,password) VALUES(1,'Samuel','samuel@gmail.com','123456')