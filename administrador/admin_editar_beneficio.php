<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: admin_beneficios.php");
    exit();
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empresa = $_POST['empresa'];
    $descripcion = $_POST['descripcion'];
    $vigencia = $_POST['vigencia'];
    $activo = isset($_POST['activo']) ? 1 : 0;

    $sql = "UPDATE beneficios SET empresa=?, descripcion=?, vigencia=?, activo=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $empresa, $descripcion, $vigencia, $activo, $id);

    if ($stmt->execute()) {
        $mensaje = "✅ Beneficio actualizado.";
    } else {
        $mensaje = "❌ Error: " . $stmt->error;
    }
}

$stmt = $conn->prepare("SELECT * FROM beneficios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$beneficio = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Beneficio</title>
  <style>
    body { background-color: #000; color: #FFD700; font-family: Arial; padding: 30px; }
    input, textarea, button { display: block; width: 100%; margin: 10px 0; padding: 10px; border: none; border-radius: 5px; }
    input, textarea { background-color: #111; color: #FFD700; border: 2px solid #FFD700; }
    button { background-color: #FFD700; color: #000; font-weight: bold; cursor: pointer; }
    .mensaje { margin-top: 10px; }
  </style>
</head>
<body>

<h2>Editar Beneficio</h2>
<a href="admin_beneficios.php">← Volver</a>

<form method="POST">
  <input name="empresa" value="<?= $beneficio['empresa'] ?>" required>
  <textarea name="descripcion" required><?= $beneficio['descripcion'] ?></textarea>
  <input name="vigencia" type="date" value="<?= $beneficio['vigencia'] ?>" required>
  <label><input type="checkbox" name="activo" <?= $beneficio['activo'] ? "checked" : "" ?>> Activo</label>
  <button type="submit">Actualizar Beneficio</button>
</form>

<?php if ($mensaje): ?>
  <div class="mensaje"><?= $mensaje ?></div>
<?php endif; ?>

</body>
</html>
