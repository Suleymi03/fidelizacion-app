<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['telefono'])) {
    header("Location: login.php");
    exit();
}

$beneficios = $conn->query("SELECT * FROM beneficios WHERE activo = 1");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Beneficios</title>
  <style>
    body {
      background: #000;
      color: #FFD700;
      font-family: 'Segoe UI', sans-serif;
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
  <h1>🤝 Beneficios</h1>
  <?php while ($b = $beneficios->fetch_assoc()): ?>
    <div class="card">
      <h3><?= htmlspecialchars($b['empresa']) ?></h3>
      <p><?= htmlspecialchars($b['descripcion']) ?></p>
      <p>Vigente hasta: <?= htmlspecialchars($b['vigencia']) ?></p>
    </div>
  <?php endwhile; ?>
  <a href="../dashboard_user.php" class="btn">← Volver</a>
</body>
</html>
