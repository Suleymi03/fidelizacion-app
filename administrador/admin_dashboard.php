<?php
session_start();

// Proteger el acceso
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel del Administrador</title>
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

    .container {
      max-width: 600px;
      margin: 40px auto;
      padding: 20px;
      background-color: #1a1a1a;
      border-radius: 10px;
      box-shadow: 0 0 20px #FFD700;
      text-align: center;
    }

    .btn {
      display: block;
      width: 100%;
      padding: 15px;
      margin: 15px 0;
      background-color: #FFD700;
      color: #000;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      text-decoration: none;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #e6c200;
    }

    .logout {
      margin-top: 30px;
    }

  </style>
</head>
<body>

  <div class="header">
    <h1>Panel del Administrador</h1>
    <p>Bienvenido, <?= $_SESSION['admin'] ?></p>
  </div>

  <div class="container">
    <a href="admin_clientes.php" class="btn">📇 Gestión de Clientes</a>
    <a href="admin_premios.php" class="btn">🎁 Gestión de Premios</a>
    <a href="admin_beneficios.php" class="btn">🏢 Gestión de Beneficios</a>

    <div class="logout">
      <a href="admin_login.php" class="btn">Cerrar sesión</a>
    </div>
  </div>

</body>
</html>
