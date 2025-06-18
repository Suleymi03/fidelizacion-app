<?php
include "../includes/db.php";
$result = $conn->query("SELECT * FROM premios");
echo "<table border='1'><tr><th>Nombre</th><th>Puntos</th><th>Acciones</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['nombre']}</td><td>{$row['puntos']}</td>
    <td><a href='editar.php?id={$row['id']}'>Editar</a> | <a href='baja.php?id={$row['id']}'>Eliminar</a></td></tr>";
}
echo "</table>";
?>
