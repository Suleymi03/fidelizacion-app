<?php
session_start();
include "includes/db.php";

if (!isset($_SESSION['telefono'])) {
    header("Location: login.php");
    exit();
}

$telefono = $_SESSION['telefono'];
$sql = "SELECT nombre, apellidos, puntos FROM clientes WHERE telefono = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $telefono);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

$nombre = $cliente['nombre'] . " " . $cliente['apellidos'];
$puntos = $cliente['puntos'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Tarjeta Digital</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #000;
      color: #fff;
    }

    .header {
      background: linear-gradient(to bottom, #FFD700, #f5c300);
      padding: 20px;
      text-align: center;
      border-bottom-left-radius: 30px;
      border-bottom-right-radius: 30px;
    }

    .header h2 {
      margin: 0;
      font-size: 20px;
      color: #000;
    }

    .tarjeta-box {
      background-color: #1a1a1a;
      margin: 20px auto;
      padding: 20px;
      border-radius: 16px;
      width: 90%;
      max-width: 400px;
      box-shadow: 0 0 20px #FFD700;
      text-align: center;
    }

    .tarjeta-visual {
      background: linear-gradient(to bottom right, #333, #111);
      color: #fff;
      padding: 25px;
      border-radius: 10px;
      margin-bottom: 10px;
      background-size: cover;
      position: relative;
    }

    .tarjeta-visual h3 {
      margin: 0;
      font-size: 24px;
      letter-spacing: 2px;
    }

    .tarjeta-visual small {
      display: block;
      margin-top: 5px;
      color: #aaa;
    }

    .detalle {
      color: #FFD700;
      margin-top: 10px;
      text-decoration: underline;
      cursor: pointer;
    }

    .puntos-box {
      background-color: rgba(255, 255, 255, 0.05);
      border: 1px solid #FFD700;
      margin-top: 20px;
      padding: 15px;
      border-radius: 10px;
      display: flex;
      justify-content: space-around;
      text-align: center;
    }

    .puntos-box div {
      flex: 1;
    }

    .puntos-box span {
      display: block;
      font-size: 24px;
      font-weight: bold;
      color: #FFD700;
    }

    .qr {
      margin-top: 30px;
      text-align: center;
    }

    .qr img {
      width: 100px;
      height: 100px;
    }

    .volver {
      margin-top: 20px;
      display: inline-block;
      padding: 10px 20px;
      background-color: #FFD700;
      color: #000;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
    }

    .volver:hover {
      background-color: #e6c200;
    }

    .imagen-tarjeta {
    width: 100%;
    max-width: 320px;
    border-radius: 12px;
    box-shadow: 0 0 10px #FFD700;
    margin-bottom: 10px;
    }

  </style>
</head>
<body>

<div class="header">
  <h2>Mi cuenta</h2>
  <div style="margin-top: 10px;">
    <small>Tarjeta</small>
    <div style="font-size: 22px; font-weight: bold;"><?= $telefono ?></div>
  </div>
</div>

<div class="tarjeta-box">
  <div class="tarjeta-visual">
    <img src="imagenes/megacard_club.jpg" alt="Tarjeta" class="imagen-tarjeta">
    <small><?= $nombre ?></small>
  </div>


  <div class="detalle">Detalle de tarjeta →</div>

  <div class="puntos-box">
    <div>
      <small>Bonificados</small>
      <span><?= $puntos ?> pts</span>
    </div>
    <div>
      <small>Encuesta</small>
      <span>0.0</span>
    </div>
  </div>

  <div class="qr">
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?= $telefono ?>" alt="QR Tarjeta">
  </div>

  <div style="text-align: center; margin-top: 20px;">
    <a href="dashboard_user.php" class="volver">← Volver</a>
  </div>
</div>

</body>
</html>
