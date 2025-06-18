CREATE DATABASE fidelizacion;
USE fidelizacion;

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    telefono VARCHAR(15) UNIQUE NOT NULL,
    nombre VARCHAR(100),
    apellidos VARCHAR(100),
    direccion TEXT,
    correo VARCHAR(100),
    estado VARCHAR(100),
    ciudad VARCHAR(100),
    puntos INT DEFAULT 0,
    contrasena VARCHAR(255)
);
