<?php
header("Content-Type: application/json");
include "../../includes/db.php";

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $telefono = $data['telefono'];
    $nombre = $data['nombre'];
    $apellidos = $data['apellidos'];
    $direccion = $data['direccion'];
    $correo = $data['correo'];
    $estado = $data['estado'];
    $ciudad = $data['ciudad'];
    $puntos = 0;
    $pass = password_hash($data['contrasena'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO clientes (telefono, nombre, apellidos, direccion, correo, estado, ciudad, puntos, contrasena) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssis", $telefono, $nombre, $apellidos, $direccion, $correo, $estado, $ciudad, $puntos, $pass);

    if ($stmt->execute()) {
        echo json_encode(["mensaje" => "Cliente creado correctamente"]);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }
} else {
    echo json_encode(["error" => "Datos no válidos"]);
}
?>
