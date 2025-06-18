<?php
include "../includes/db.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM beneficios WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "Beneficio eliminado.";
}
?>
