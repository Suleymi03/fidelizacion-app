<?php
header("Content-Type: application/json");
include "../../includes/db.php";

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $telefono = $data['telefono']; // identificador
    $nombre = $data['nombre'];
    $apellidos = $data['apellidos'];
    $direccion = $data['direccion'];
    $correo = $data['correo'];
    $estado = $data['estado'];
    $ciudad = $data['ciudad'];

    $stmt = $conn->prepare("UPDATE clientes SET nombre=?, apellidos=?, direccion=?, correo=?, estado=?, ciudad=? WHERE telefono=?");
    $stmt->bind_param("sssssss", $nombre, $apellidos, $direccion, $correo, $estado, $ciudad, $telefono);

    if ($stmt->execute()) {
        echo json_encode(["mensaje" => "Cliente actualizado"]);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }
} else {
    echo json_encode(["error" => "Datos incompletos"]);
}
?>
