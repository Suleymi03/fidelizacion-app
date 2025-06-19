<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Eliminar cliente si viene por GET
if (isset($_GET['eliminar'])) {
    $telefono = $_GET['eliminar'];
    $conn->query("DELETE FROM clientes WHERE telefono = '$telefono'");
    header("Location: admin_clientes.php");
}

// Obtener lista de clientes
$resultado = $conn->query("SELECT * FROM clientes ORDER BY nombre");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Clientes</title>
  <style>
    body { background: #000; color: #FFD700; font-family: Arial; padding: 20px; }
    table { width: 100%; background: #111; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #FFD700; padding: 8px; text-align: center; }
    a, button { background: #FFD700; color: #000; padding: 5px 10px; border: none; text-decoration: none; border-radius: 4px; }
    h2 { text-align: center; }
  </style>
</head>
<body>
  <h2>Gestión de Clientes</h2>
  <a href="admin_dashboard.php">← Volver al dashboard</a>
  <a href="admin_nuevo_cliente.php">+ Agregar Cliente</a>
  <table>
    <thead>
      <tr>
        <th>Teléfono</th><th>Nombre</th><th>Email</th><th>Ciudad</th><th>Puntos</th><th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $resultado->fetch_assoc()): ?>
        <tr>
          <td><?= $row['telefono'] ?></td>
          <td><?= $row['nombre'] . ' ' . $row['apellidos'] ?></td>
          <td><?= $row['correo'] ?></td>
          <td><?= $row['ciudad'] ?></td>
          <td><?= $row['puntos'] ?></td>
          <td>
            <a href="admin_editar_cliente.php?telefono=<?= $row['telefono'] ?>">✏️ Editar</a>
            <a href="admin_clientes.php?eliminar=<?= $row['telefono'] ?>" onclick="return confirm('¿Eliminar cliente?')">🗑️ Eliminar</a>
            <a href="admin_dar_puntos.php?telefono=<?= $row['telefono'] ?>">🎁 Bonificar</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
