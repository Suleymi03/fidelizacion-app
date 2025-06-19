<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $puntos_requeridos = $_POST['puntos_requeridos'];
    $activo = isset($_POST['activo']) ? 1 : 0;

    $sql = "INSERT INTO premios (nombre, descripcion, puntos_requeridos, activo) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $nombre, $descripcion, $puntos_requeridos, $activo);

    if ($stmt->execute()) {
        $mensaje = "✅ Premio registrado correctamente.";
    } else {
        $mensaje = "❌ Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Nuevo Premio</title>
  <style>
    body { background: #000; color: #FFD700; font-family: Arial; padding: 40px; }
    input, textarea, button { display: block; width: 100%; margin: 10px 0; padding: 10px; border: none; border-radius: 5px; }
    input, textarea { background: #111; color: #FFD700; border: 2px solid #FFD700; }
    button { background: #FFD700; color: #000; font-weight: bold; cursor: pointer; }
    .mensaje { margin-top: 10px; }
    a { color: #FFD700; text-decoration: none; }
  </style>
</head>
<body>

<h2>Registrar Nuevo Premio</h2>
<a href="admin_premios.php">← Volver</a>

<form method="POST">
  <input name="nombre" required placeholder="Nombre del premio">
  <textarea name="descripcion" required placeholder="Descripción"></textarea>
  <input name="puntos_requeridos" type="number" required placeholder="Puntos requeridos">
  <label><input type="checkbox" name="activo" checked> Activo</label>
  <button type="submit">Registrar Premio</button>
</form>

<?php if ($mensaje): ?>
  <div class="mensaje"><?= $mensaje ?></div>
<?php endif; ?>

</body>
</html>
