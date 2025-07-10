<?php
session_start();
include "includes/db.php";

if (!isset($_SESSION['telefono'])) {
    header("Location: login.php");
    exit();
}

$telefono = $_SESSION['telefono'];

$sqlCliente = "SELECT * FROM clientes WHERE telefono = ?";
$stmt = $conn->prepare($sqlCliente);
$stmt->bind_param("s", $telefono);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();
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

    .header h1 {
      margin: 0;
    }

    .logout {
      position: absolute;
      top: 20px;
      right: 20px;
    }

    .content {
      padding: 30px;
      display: flex;
      flex-direction: column;
      gap: 30px;
      align-items: center;
    }

    .box {
      width: 90%;
      max-width: 600px;
      padding: 30px;
      background-color: #1a1a1a;
      border: 2px solid #FFD700;
      border-radius: 15px;
      text-align: center;
      cursor: pointer;
      box-shadow: 0 0 15px #FFD700;
      transition: transform 0.3s;
    }

    .box:hover {
      transform: scale(1.03);
      background-color: #222;
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

  </style>
</head>
<body>

<div class="header">
  <h1>¡Hola, <?= htmlspecialchars($cliente['nombre']) ?>!</h1>
  <p>Tus puntos acumulados: <strong><?= $cliente['puntos'] ?> pts</strong></p>
  <a href="logout.php" class="btn logout">Cerrar sesión</a>
</div>

<div class="content">
  <div class="box" onclick="location.href='premios/premios.php'">
    <h2>🎁 Premios Disponibles</h2>
    <p>Revisa los premios que puedes canjear con tus puntos.</p>
  </div>

  <div class="box" onclick="location.href='beneficios/beneficios.php'">
    <h2>🤝 Beneficios con Empresas</h2>
    <p>Descubre los beneficios que tienes por ser parte del club.</p>
  </div>

  <a href="tarjeta_digital.php" class="btn">Ver Mi Tarjeta Digital</a>
</div>

</body>
</html>
