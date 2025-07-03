<?php
header("Content-Type: application/json");
include "../../includes/db.php";

if (isset($_GET['telefono'])) {
    $telefono = $_GET['telefono'];

    $sql = "
        SELECT c.fecha, p.nombre AS premio, p.puntos_requeridos 
        FROM canjes c
        INNER JOIN premios p ON c.premio_id = p.id
        WHERE c.telefono_cliente = ?
        ORDER BY c.fecha DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $telefono);
    $stmt->execute();
    $result = $stmt->get_result();

    $canjes = [];

    while ($row = $result->fetch_assoc()) {
        $canjes[] = $row;
    }

    echo json_encode($canjes);
} else {
    echo json_encode(["error" => "Teléfono no proporcionado"]);
}
?>
