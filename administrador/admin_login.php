<?php
session_start();
include "../includes/db.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $pass = $_POST['contrasena'];

    $sql = "SELECT * FROM administradores WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($pass, $admin['contrasena'])) {
        $_SESSION['admin'] = $usuario;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $mensaje = "❌ Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login Administrador</title>
  <style>
    body {
      background-color: #000;
      color: #FFD700;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      height: 100vh;
      align-items: center;
      justify-content: center;
      margin: 0;
    }

    .form-box {
      background-color: #111;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px #FFD700;
      width: 320px;
    }

    .form-box h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 2px solid #FFD700;
      border-radius: 5px;
      background-color: #000;
      color: #FFD700;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #FFD700;
      color: #000;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }

    button:hover {
      background-color: #e6c200;
    }

    .mensaje {
      text-align: center;
      margin-top: 10px;
      color: #f44;
    }
  </style>
</head>
<body>

<div class="form-box">
  <h2>Acceso Administrador</h2>
  <form method="POST">
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <button type="submit">Ingresar</button>
  </form>
  <?php if ($mensaje): ?>
    <div class="mensaje"><?= $mensaje ?></div>
  <?php endif; ?>
</div>

</body>
</html>
