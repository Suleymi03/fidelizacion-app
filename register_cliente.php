<?php
include "includes/db.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $estado = $_POST['estado'];
    $ciudad = $_POST['ciudad'];
    $puntos = 0;
    $pass = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO clientes (nombre, apellidos, telefono, direccion, correo, estado, ciudad, puntos, contrasena)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }
    $stmt->bind_param("sssssssis", $nombre, $apellidos, $telefono, $direccion, $correo, $estado, $ciudad, $puntos, $pass);

    if ($stmt->execute()) {
        $mensaje = "✅ Cliente registrado correctamente. <a href='login.php'>Iniciar sesión</a>";
    } else {
        $mensaje = "❌ Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Cliente</title>
  <style>
    body {
      background-color: #000;
      color: #FFD700;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
    }

    .form-box {
      background-color: #111;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px #FFD700;
      width: 360px;
    }

    .form-box h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    input {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
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
      margin-top: 15px;
      text-align: center;
      color: #FFD700;
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
  <h2>Registro de Cliente</h2>
  <form method="POST">
    <input name="nombre" required placeholder="Nombre">
    <input name="apellidos" required placeholder="Apellidos">
    <input name="telefono" required placeholder="Teléfono">
    <input name="direccion" required placeholder="Dirección">
    <input name="correo" required placeholder="Correo">
    <input name="estado" required placeholder="Estado">
    <input name="ciudad" required placeholder="Ciudad">
    <input name="contrasena" type="password" required placeholder="Contraseña">
    <button type="submit">Registrar cliente</button>
  </form>

  <?php if ($mensaje): ?>
    <div class="mensaje"><?= $mensaje ?></div>
  <?php endif; ?>

  <div class="registro-link">
    ¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a>
  </div>
</div>

</body>
</html>
