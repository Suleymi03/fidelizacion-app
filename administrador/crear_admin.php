<?php
include "../includes/db.php";

$usuario = "admin";
$pass = password_hash("admin123", PASSWORD_DEFAULT);

$sql = "INSERT INTO administradores (usuario, contrasena) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $pass);
$stmt->execute();

echo "Administrador creado.";
?>
 