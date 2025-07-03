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
      margin: 0;
      padding: 60px 20px 20px 20px;
      position: relative;
    }

    .volver {
      position: absolute;
      top: 15px;
      left: 15px;
      background-color: transparent;
      border: 2px solid #FFD700;
      color: #FFD700;
      padding: 8px 16px;
      border-radius: 30px;
      text-decoration: none;
      font-weight: bold;
      transition: background-color 0.3s, color 0.3s;
    }

    .volver:hover {
      background-color: #FFD700;
      color: #000;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 28px;
    }

    .card {
      background: #111;
      border: 1px solid #FFD700;
      border-radius: 12px;
      padding: 20px;
      margin: 15px auto;
      max-width: 500px;
      box-shadow: 0 0 15px #FFD70033;
      transition: transform 0.2s;
    }

    .card:hover {
      transform: scale(1.02);
    }

    .card h3 {
      margin-top: 0;
      font-size: 22px;
      color: #FFD700;
    }

    .card p {
      color: #ccc;
      margin: 8px 0;
    }

    .vigencia {
      font-size: 14px;
      color: #aaa;
    }
  </style>
</head>
<body>

<a href="../dashboard_user.php" class="volver">← Volver</a>

<h1>🤝 Beneficios</h1>

<?php while ($b = $beneficios->fetch_assoc()): ?>
  <div class="card">
    <h3><?= htmlspecialchars($b['empresa']) ?></h3>
    <p><?= htmlspecialchars($b['descripcion']) ?></p>
    <p class="vigencia">Vigente hasta: <?= htmlspecialchars($b['vigencia']) ?></p>
  </div>
<?php endwhile; ?>

</body>
</html>
