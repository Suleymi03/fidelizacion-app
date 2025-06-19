<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$resultado = $conn->query("SELECT * FROM beneficios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Beneficios</title>
  <style>
    body { background-color: #000; color: #FFD700; font-family: Arial; padding: 30px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 10px; border: 1px solid #FFD700; text-align: left; }
    a { color: #FFD700; text-decoration: none; margin-right: 10px; }
    .boton { background: #FFD700; color: #000; padding: 10px; display: inline-block; border-radius: 5px; margin-bottom: 15px; font-weight: bold; }
    .boton:hover { background: #e6c200; }
  </style>
</head>
<body>

<h2>Gestión de Beneficios</h2>
<a href="admin_dashboard.php" class="boton">← Volver</a>
<a href="admin_nuevo_beneficio.php" class="boton">➕ Nuevo Beneficio</a>

<table>
  <thead>
    <tr>
      <th>Empresa</th>
      <th>Descripción</th>
      <th>Vigencia</th>
      <th>Activo</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $resultado->fetch_assoc()): ?>
      <tr>
        <td><?= $row['empresa'] ?></td>
        <td><?= $row['descripcion'] ?></td>
        <td><?= $row['vigencia'] ?></td>
        <td><?= $row['activo'] ? 'Sí' : 'No' ?></td>
        <td>
          <a href="admin_editar_beneficio.php?id=<?= $row['id'] ?>">✏️ Editar</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

</body>
</html>
