<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $telefono = $_POST['telefono'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $estado = $_POST['estado'];
    $ciudad = $_POST['ciudad'];
    $puntos = $_POST['puntos'];
    $pass = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO clientes (telefono, nombre, apellidos, direccion, correo, estado, ciudad, puntos, contrasena)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssis", $telefono, $nombre, $apellidos, $direccion, $correo, $estado, $ciudad, $puntos, $pass);

    if ($stmt->execute()) {
        $mensaje = "✅ Cliente agregado correctamente.";
    } else {
        $mensaje = "❌ Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Nuevo Cliente</title>
  <style>
    body { background: #000; color: #FFD700; font-family: Arial; padding: 40px; }
    input, button { display: block; width: 100%; margin: 10px 0; padding: 10px; border: none; border-radius: 5px; }
    input { background: #111; color: #FFD700; border: 2px solid #FFD700; }
    button { background: #FFD700; color: #000; font-weight: bold; cursor: pointer; }
    .mensaje { margin-top: 10px; }
    a { color: #FFD700; text-decoration: none; }
  </style>
</head>
<body>

<h2>Registrar Nuevo Cliente</h2>
<a href="admin_clientes.php">← Volver</a>

<form method="POST">
  <input name="telefono" required placeholder="Teléfono">
  <input name="nombre" required placeholder="Nombre">
  <input name="apellidos" required placeholder="Apellidos">
  <input name="direccion" required placeholder="Dirección">
  <input name="correo" required placeholder="Correo">
  <input name="estado" required placeholder="Estado">
  <input name="ciudad" required placeholder="Ciudad">
  <input name="puntos" required type="number" placeholder="Puntos Iniciales" value="0">
  <input name="contrasena" required type="password" placeholder="Contraseña">
  <button type="submit">Registrar</button>
</form>

<?php if ($mensaje): ?>
  <div class="mensaje"><?= $mensaje ?></div>
<?php endif; ?>

</body>
</html>
