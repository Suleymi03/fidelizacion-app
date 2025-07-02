<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['telefono'])) {
    header("Location: login.php");
    exit();
}

$telefono = $_SESSION['telefono'];
$cliente = $conn->query("SELECT * FROM clientes WHERE telefono = '$telefono'")->fetch_assoc();
$premios = $conn->query("SELECT * FROM premios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Premios Disponibles</title>
  <style>
    body {
      background: #000;
      color: #FFD700;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 20px;
    }
    .card {
      background: #111;
      border: 1px solid #FFD700;
      border-radius: 10px;
      padding: 20px;
      margin: 15px auto;
      max-width: 500px;
      box-shadow: 0 0 10px #FFD700;
    }
    .card h3 {
      margin: 0;
    }
    .btn {
      background: #FFD700;
      color: #000;
      padding: 10px;
      display: inline-block;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      margin-top: 10px;
    }
    .btn:hover {
      background: #e6c200;
    }
  </style>
</head>
<body>
  <h1>🎁 Premios Disponibles</h1>
  <?php while ($p = $premios->fetch_assoc()): ?>
    <div class="card">
      <h3><?= htmlspecialchars($p['nombre']) ?></h3>
      <p>Requiere: <?= $p['puntos_requeridos'] ?> pts</p>
      <?php if ($cliente['puntos'] >= $p['puntos_requeridos']): ?>
        <a class="btn" href="canjear_premio.php?id=<?= $p['id'] ?>">Canjear</a>
      <?php else: ?>
        <p><em>No tienes suficientes puntos</em></p>
      <?php endif; ?>
    </div>
  <?php endwhile; ?>
  <a href="../dashboard_user.php" class="btn">← Volver</a>
</body>
</html>
