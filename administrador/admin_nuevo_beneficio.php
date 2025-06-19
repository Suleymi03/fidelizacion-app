<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empresa = $_POST['empresa'];
    $descripcion = $_POST['descripcion'];
    $vigencia = $_POST['vigencia'];
    $activo = isset($_POST['activo']) ? 1 : 0;

    $sql = "INSERT INTO beneficios (empresa, descripcion, vigencia, activo) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $empresa, $descripcion, $vigencia, $activo);

    if ($stmt->execute()) {
        $mensaje = "✅ Beneficio registrado.";
    } else {
        $mensaje = "❌ Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Nuevo Beneficio</title>
  <style>
    body { background-color: #000; color: #FFD700; font-family: Arial; padding: 30px; }
    input, textarea, button { display: block; width: 100%; margin: 10px 0; padding: 10px; border: none; border-radius: 5px; }
    input, textarea { background-color: #111; color: #FFD700; border: 2px solid #FFD700; }
    button { background-color: #FFD700; color: #000; font-weight: bold; cursor: pointer; }
    .mensaje { margin-top: 10px; }
  </style>
</head>
<body>

<h2>Registrar Nuevo Beneficio</h2>
<a href="admin_beneficios.php">← Volver</a>

<form method="POST">
  <input name="empresa" required placeholder="Empresa">
  <textarea name="descripcion" required placeholder="Descripción del beneficio"></textarea>
  <input name="vigencia" type="date" required placeholder="Vigencia">
  <label><input type="checkbox" name="activo" checked> Activo</label>
  <button type="submit">Guardar Beneficio</button>
</form>

<?php if ($mensaje): ?>
  <div class="mensaje"><?= $mensaje ?></div>
<?php endif; ?>

</body>
</html>
