<?php
header("Content-Type: application/json");
include "../../includes/db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['telefono'])) {
    $telefono = $data['telefono'];

    $stmt = $conn->prepare("DELETE FROM clientes WHERE telefono=?");
    $stmt->bind_param("s", $telefono);

    if ($stmt->execute()) {
        echo json_encode(["mensaje" => "Cliente eliminado"]);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }
} else {
    echo json_encode(["error" => "Teléfono no proporcionado"]);
}
?>
