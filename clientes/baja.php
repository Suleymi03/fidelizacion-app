<?php
include "../includes/db.php";
if (isset($_GET['telefono'])) {
    $telefono = $_GET['telefono'];
    $stmt = $conn->prepare("DELETE FROM clientes WHERE telefono=?");
    $stmt->bind_param("s", $telefono);
    $stmt->execute();
    echo "Cliente eliminado.";
}
?>
