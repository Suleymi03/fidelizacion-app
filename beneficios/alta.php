<?php
include "../includes/db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empresa = $_POST['empresa'];
    $descripcion = $_POST['descripcion'];
    $sql = "INSERT INTO beneficios (empresa, descripcion) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $empresa, $descripcion);
    $stmt->execute();
    echo "Beneficio registrado.";
}
?>
<form method="POST">
    <input name="empresa" required placeholder="Nombre de la empresa"><br>
    <textarea name="descripcion" required placeholder="Descripción del beneficio"></textarea><br>
    <button type="submit">Registrar beneficio</button>
</form>
