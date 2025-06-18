<?php
include "../includes/db.php";
$result = $conn->query("SELECT * FROM clientes");
echo "<table border='1'><tr><th>Teléfono</th><th>Nombre</th><th>Apellidos</th><th>Puntos</th><th>Acciones</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['telefono']}</td><td>{$row['nombre']}</td><td>{$row['apellidos']}</td><td>{$row['puntos']}</td>
    <td><a href='editar.php?telefono={$row['telefono']}'>Editar</a> | <a href='baja.php?telefono={$row['telefono']}'>Eliminar</a></td></tr>";
}
echo "</table>";
?>
