<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Eliminar premio
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conn->query("DELETE FROM premios WHERE id = $id");
    header("Location: admin_premios.php");
}

// Obtener premios
$resultado = $conn->query("SELECT * FROM premios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Premios</title>
  <style>
    body { background: #000; color: #FFD700; font-family: Arial; padding: 20px; }
    table { width: 100%; background: #111; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #FFD700; padding: 8px; text-align: center; }
    a { background: #FFD700; color: #000; padding: 5px 10px; border-radius: 4px; text-decoration: none; }
  </style>
</head>
<body>
  <h2>Gestión de Premios</h2>
  <a href="admin_dashboard.php">← Volver al dashboard</a>
  <a href="admin_nuevo_premio.php">+ Agregar Premio</a>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Nombre</th><th>Puntos</th><th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $resultado->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['nombre'] ?></td>
          <td><?= $row['puntos_requeridos'] ?></td>
          <td>
            <a href="admin_editar_premio.php?id=<?= $row['id'] ?>">✏️ Editar</a>
            <a href="admin_premios.php?eliminar=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar premio?')">🗑️ Eliminar</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
