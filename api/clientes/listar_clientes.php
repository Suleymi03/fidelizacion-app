<?php
header("Content-Type: application/json");
include "../../includes/db.php";

// Consulta todos los clientes
$sql = "SELECT id, nombre, apellidos, telefono, correo, puntos FROM clientes";
$result = $conn->query($sql);

$clientes = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
    echo json_encode(["clientes" => $clientes]);
} else {
    echo json_encode(["mensaje" => "No hay clientes registrados"]);
}
?>
