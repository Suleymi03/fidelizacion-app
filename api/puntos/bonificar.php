<?php
header("Content-Type: application/json");
include "../../includes/db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['telefono']) && isset($data['monto'])) {
    $telefono = $data['telefono'];
    $monto = floatval($data['monto']);
    $puntosExtra = floor($monto / 100) * 5;

    $stmt = $conn->prepare("UPDATE clientes SET puntos = puntos + ? WHERE telefono = ?");
    $stmt->bind_param("is", $puntosExtra, $telefono);

    if ($stmt->execute()) {
        echo json_encode(["mensaje" => "Puntos bonificados", "puntos_bonificados" => $puntosExtra]);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }
} else {
    echo json_encode(["error" => "Faltan campos"]);
}
?>
