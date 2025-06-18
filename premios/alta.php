<?php
include "../includes/db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $puntos = $_POST['puntos'];
    $sql = "INSERT INTO premios (nombre, puntos) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nombre, $puntos);
    $stmt->execute();
    echo "Premio registrado.";
}
?>
<form method="POST">
    <input name="nombre" required placeholder="Nombre del premio"><br>
    <input name="puntos" type="number" required placeholder="Puntos necesarios"><br>
    <button type="submit">Registrar premio</button>
</form>
