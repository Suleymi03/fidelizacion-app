<?php
include "includes/db.php";
session_start();

$mensaje = "";

if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $telefono = $_POST['telefono'];
    $pass = $_POST['contrasena'];

    $sql = "SELECT * FROM clientes WHERE telefono = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $telefono);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $cliente = $result->fetch_assoc();
        if (password_verify($pass, $cliente['contrasena'])) {
            $_SESSION['telefono'] = $telefono;
            header("Location: dashboard_user.php");
            exit();
        } else {
            $_SESSION['mensaje'] = "❌ Contraseña incorrecta.";
        }
    } else {
        $_SESSION['mensaje'] = "❌ Usuario no encontrado.";
    }

    // Redirecciona para limpiar el POST
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login - Fidelización</title>
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
      margin-top: 15px;
      color: #f44;
    }

    .mensaje a {
      color: #FFD700;
      text-decoration: underline;
    }

    .registro-link {
      text-align: center;
      margin-top: 20px;
    }

    .registro-link a {
      color: #FFD700;
      text-decoration: none;
    }

    .registro-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="form-box">
  <h2>Iniciar Sesión</h2>
  <form method="POST">
    <input type="text" name="telefono" placeholder="Teléfono" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <button type="submit">Ingresar</button>
  </form>

  <?php if ($mensaje): ?>
    <div class="mensaje"><?= $mensaje ?></div>
  <?php endif; ?>

  <div class="registro-link">
    ¿No tienes una cuenta? <a href="register_cliente.php">Regístrarse</a>
  </div>
</div>

</body>
</html>
