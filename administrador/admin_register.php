<?php
include "../includes/db.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO administradores (usuario, contrasena) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $mensaje = "❌ Error al preparar la consulta: " . $conn->error;
    } else {
        $stmt->bind_param("ss", $usuario, $contrasena);
        if ($stmt->execute()) {
            $mensaje = "✅ Administrador registrado correctamente.";
        } else {
            $mensaje = "❌ Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Administrador</title>
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
      width: 350px;
    }

    h2 {
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
    }
  </style>
</head>
<body>

<div class="form-box">
  <h2>Registrar Administrador</h2>
  <form method="POST">
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <button type="submit">Registrar</button>
  </form>
  <div class="mensaje"><?= $mensaje ?></div>
</div>

</body>
</html>
