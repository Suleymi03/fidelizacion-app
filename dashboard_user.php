<?php
session_start();
include "includes/db.php";

// Si no ha iniciado sesión, redirige al login
if (!isset($_SESSION['telefono'])) {
    header("Location: login.php");
    exit();
}

$telefono = $_SESSION['telefono'];

// Obtener datos del cliente
$sqlCliente = "SELECT * FROM clientes WHERE telefono = ?";
$stmt = $conn->prepare($sqlCliente);
$stmt->bind_param("s", $telefono);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

// Obtener premios
$premios = $conn->query("SELECT nombre, puntos_requeridos FROM premios");

// Obtener beneficios
$beneficios = $conn->query("SELECT empresa, descripcion FROM beneficios");

if (!$beneficios) {
    die("Error en la consulta de beneficios: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mi Panel - Fidelización</title>
  <style>
    body {
      background-color: #000;
      color: #FFD700;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
    }

    .header {
      background-color: #111;
      padding: 20px;
      text-align: center;
      box-shadow: 0 0 10px #FFD700;
    }

    .content {
      padding: 30px;
    }

    h1, h2 {
      color: #FFD700;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }

    table th, table td {
      border: 1px solid #FFD700;
      padding: 10px;
      text-align: left;
    }

    .btn {
      background-color: #FFD700;
      color: #000;
      padding: 10px 20px;
      border: none;
      font-weight: bold;
      cursor: pointer;
      border-radius: 5px;
      text-decoration: none;
    }

    .btn:hover {
      background-color: #e6c200;
    }

    .logout {
      position: absolute;
      top: 20px;
      right: 20px;
    }
  </style>
</head>
<body>

<div class="header">
  <h1>¡Hola, <?= htmlspecialchars($cliente['nombre']) ?>!</h1>
  <p>Tus puntos acumulados: <strong><?= $cliente['puntos'] ?> pts</strong></p>
  <a href="logout.php" class="btn logout">Cerrar sesión</a>
</div>

<div class="content">
  <h2>🎁 Premios Disponibles</h2>
  <table>
    <tr>
      <th>Premio</th>
      <th>Puntos necesarios</th>
    </tr>
    <?php while ($row = $premios->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['nombre']) ?></td>
        <td><?= $row['puntos_necesarios'] ?></td>
      </tr>
    <?php endwhile; ?>
  </table>

  <h2>🤝 Beneficios con Empresas</h2>
  <table>
    <tr>
      <th>Empresa</th>
      <th>Descripción</th>
    </tr>
    <?php while ($row = $beneficios->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['nombre_empresa']) ?></td>
        <td><?= htmlspecialchars($row['descripcion']) ?></td>
      </tr>
    <?php endwhile; ?>
  </table>

  <a href="tarjeta_digital.php" class="btn">Ver Mi Tarjeta Digital</a>
</div>

</body>
</html>
