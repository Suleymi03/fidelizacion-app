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
    }

    .btn {
      background: #FFD700;
      color: #000;
      padding: 10px 20px;
      display: inline-block;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      margin-top: 10px;
    }

    .btn:hover {
      background: #e6c200;
    }

    .no-puntos {
      color: #aaa;
      font-style: italic;
      margin-top: 10px;
    }
  </style>
</head>
<body>

<a href="../dashboard_user.php" class="volver">← Volver</a>

<h1>🎁 Premios Disponibles</h1>

<?php while ($p = $premios->fetch_assoc()): ?>
  <div class="card">
    <h3><?= htmlspecialchars($p['nombre']) ?></h3>
    <p>Requiere: <strong><?= $p['puntos_requeridos'] ?> pts</strong></p>
    <?php if ($cliente['puntos'] >= $p['puntos_requeridos']): ?>
      <a class="btn" href="canjear_premio.php?id=<?= $p['id'] ?>">Canjear</a>
    <?php else: ?>
      <p class="no-puntos">No tienes suficientes puntos</p>
    <?php endif; ?>
  </div>
<?php endwhile; ?>

</body>
</html>
