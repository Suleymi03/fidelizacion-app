<?php
header("Content-Type: application/json");
include "../../includes/db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['telefono']) && isset($data['contrasena'])) {
    $telefono = $data['telefono'];
    $pass = $data['contrasena'];

    $stmt = $conn->prepare("SELECT * FROM clientes WHERE telefono=?");
    $stmt->bind_param("s", $telefono);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($cliente = $result->fetch_assoc()) {
        if (password_verify($pass, $cliente['contrasena'])) {
            echo json_encode(["mensaje" => "Login exitoso", "cliente" => $cliente]);
        } else {
            echo json_encode(["error" => "Contraseña incorrecta"]);
        }
    } else {
        echo json_encode(["error" => "Usuario no encontrado"]);
    }
} else {
    echo json_encode(["error" => "Faltan campos"]);
}
?>
