<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['telefono'])) {
    header("Location: login.php");
    exit();
}

$telefono = $_SESSION['telefono'];
$cliente = $conn->query("SELECT * FROM clientes WHERE telefono = '$telefono'")->fetch_assoc();

if (!isset($_GET['id'])) {
    die("Premio no válido");
}

$idPremio = intval($_GET['id']);
$premio = $conn->query("SELECT * FROM premios WHERE id = $idPremio")->fetch_assoc();

if (!$premio) {
    die("Premio no encontrado.");
}

if ($cliente['puntos'] < $premio['puntos_requeridos']) {
    die("❌ No tienes puntos suficientes.");
}

// Descontar puntos
$nuevosPuntos = $cliente['puntos'] - $premio['puntos_requeridos'];
$conn->query("UPDATE clientes SET puntos = $nuevosPuntos WHERE telefono = '$telefono'");

// Registro de canje (opcional si tienes tabla de historial)
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Premio Canjeado</title>
  <style>
    body {
      background-color: #000;
      color: #FFD700;
      font-family: 'Segoe UI', sans-serif;
      text-align: center;
      padding: 50px;
    }

    .box {
      border: 2px solid #FFD700;
      padding: 30px;
      border-radius: 12px;
      display: inline-block;
      background-color: #111;
      box-shadow: 0 0 15px #FFD700;
    }

    .btn {
      margin-top: 20px;
      padding: 10px 20px;
      background: #FFD700;
      color: #000;
      font-weight: bold;
      text-decoration: none;
      border-radius: 6px;
    }

    .btn:hover {
      background-color: #e6c200;
    }
  </style>
</head>
<body>

  <div class="box">
    <h1>🎉 Canje exitoso</h1>
    <p>Has canjeado <strong><?= htmlspecialchars($premio['nombre']) ?></strong>.</p>
    <p>Te quedan <strong><?= $nuevosPuntos ?></strong> puntos.</p>
    <a href="premios.php" class="btn">← Volver a Premios</a>
  </div>

</body>
</html>
