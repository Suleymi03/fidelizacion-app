<?php
include "../includes/db.php";
$result = $conn->query("SELECT * FROM beneficios");
echo "<table border='1'><tr><th>Empresa</th><th>Descripción</th><th>Acciones</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['empresa']}</td><td>{$row['descripcion']}</td>
    <td><a href='editar.php?id={$row['id']}'>Editar</a> | <a href='baja.php?id={$row['id']}'>Eliminar</a></td></tr>";
}
echo "</table>";
?>
