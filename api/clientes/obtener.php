<?php
header("Content-Type: application/json");
include "../../includes/db.php";

$sql = "SELECT telefono, nombre, apellidos, correo, ciudad, estado, puntos FROM clientes";
$result = $conn->query($sql);

$clientes = [];

while ($row = $result->fetch_assoc()) {
    $clientes[] = $row;
}

echo json_encode($clientes);
?>
