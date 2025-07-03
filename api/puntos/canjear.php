<?php
header("Content-Type: application/json");
include "../../includes/db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['telefono']) && isset($data['premio_id'])) {
    $telefono = $data['telefono'];
    $premio_id = intval($data['premio_id']);

    // 1. Obtener puntos requeridos para el premio
    $stmt = $conn->prepare("SELECT puntos_requeridos FROM premios WHERE id = ?");
    $stmt->bind_param("i", $premio_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $puntos_requeridos = $row['puntos_requeridos'];

        // 2. Restar puntos si el cliente tiene suficientes
        $stmt = $conn->prepare("UPDATE clientes SET puntos = puntos - ? WHERE telefono = ? AND puntos >= ?");
        $stmt->bind_param("isi", $puntos_requeridos, $telefono, $puntos_requeridos);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            // 3. Registrar el canje en la tabla `canjes`
            $fecha = date("Y-m-d H:i:s");
            $stmt = $conn->prepare("INSERT INTO canjes (telefono_cliente, premio_id, fecha) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $telefono, $premio_id, $fecha);
            if ($stmt->execute()) {
                echo json_encode(["mensaje" => "Canje exitoso"]);
            } else {
                echo json_encode(["error" => "Canje realizado, pero no se guardó en historial"]);
            }
        } else {
            echo json_encode(["error" => "Puntos insuficientes"]);
        }
    } else {
        echo json_encode(["error" => "Premio no encontrado"]);
    }
} else {
    echo json_encode(["error" => "Faltan datos"]);
}
?>
