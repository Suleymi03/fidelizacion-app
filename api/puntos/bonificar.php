<?php
header("Content-Type: application/json");
include "../../includes/db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['telefono']) && isset($data['monto'])) {
    $telefono = $data['telefono'];
    $monto = floatval($data['monto']);
    $puntosExtra = floor($monto / 100) * 5;

    // Comenzamos una transacción
    $conn->begin_transaction();

    try {
        // 1. Actualizar puntos en la tabla clientes
        $stmt = $conn->prepare("UPDATE clientes SET puntos = puntos + ? WHERE telefono = ?");
        $stmt->bind_param("is", $puntosExtra, $telefono);
        $stmt->execute();

        // 2. Insertar registro en historial_puntos
        $fecha = date("Y-m-d H:i:s");
        $stmtHistorial = $conn->prepare("INSERT INTO historial_puntos (telefono, monto, puntos_bonificados, fecha) VALUES (?, ?, ?, ?)");
        $stmtHistorial->bind_param("sdis", $telefono, $monto, $puntosExtra, $fecha);
        $stmtHistorial->execute();

        // 3. Confirmar transacción
        $conn->commit();

        echo json_encode([
            "mensaje" => "Puntos bonificados y guardados en historial",
            "telefono" => $telefono,
            "monto" => $monto,
            "puntos_bonificados" => $puntosExtra,
            "fecha" => $fecha
        ]);

    } catch (Exception $e) {
        // En caso de error, se revierte todo
        $conn->rollback();
        echo json_encode(["error" => "Error al bonificar puntos: " . $e->getMessage()]);
    }

} else {
    echo json_encode(["error" => "Faltan campos"]);
}
?>
