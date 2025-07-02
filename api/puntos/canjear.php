<?php
header("Content-Type: application/json");
include "../../includes/db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['telefono']) && isset($data['puntos'])) {
    $telefono = $data['telefono'];
    $puntos = intval($data['puntos']);

    $stmt = $conn->prepare("UPDATE clientes SET puntos = puntos - ? WHERE telefono = ? AND puntos >= ?");
    $stmt->bind_param("isi", $puntos, $telefono, $puntos);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["mensaje" => "Puntos canjeados"]);
        } else {
            echo json_encode(["error" => "Puntos insuficientes"]);
        }
    } else {
        echo json_encode(["error" => $stmt->error]);
    }
} else {
    echo json_encode(["error" => "Faltan datos"]);
}
?>
