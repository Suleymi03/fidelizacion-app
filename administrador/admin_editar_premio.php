<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: admin_premios.php");
    exit();
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $puntos_requeridos = $_POST['puntos_requeridos'];
    $activo = isset($_POST['activo']) ? 1 : 0;

    $sql = "UPDATE premios SET nombre=?, descripcion=?, puntos_requeridos=?, activo=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiii", $nombre, $descripcion, $puntos_requeridos, $activo, $id);

    if ($stmt->execute()) {
        $mensaje = "✅ Premio actualizado.";
    } else {
        $mensaje = "❌ Error: " . $stmt->error;
    }
}

$stmt = $conn->prepare("SELECT * FROM premios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$premio = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Premio</title>
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

<h2>Editar Premio</h2>
<a href="admin_premios.php">← Volver</a>

<form method="POST">
  <input name="nombre" value="<?= $premio['nombre'] ?>" required placeholder="Nombre del premio">
  <textarea name="descripcion" required><?= $premio['descripcion'] ?></textarea>
  <input name="puntos_requeridos" type="number" value="<?= $premio['puntos_requeridos'] ?>" required>
  <label><input type="checkbox" name="activo" <?= $premio['activo'] ? "checked" : "" ?>> Activo</label>
  <button type="submit">Actualizar Premio</button>
</form>

<?php if ($mensaje): ?>
  <div class="mensaje"><?= $mensaje ?></div>
<?php endif; ?>

</body>
</html>
