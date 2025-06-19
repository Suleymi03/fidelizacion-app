<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$mensaje = "";

// Validar que venga un número de teléfono por GET
if (!isset($_GET['telefono'])) {
    die("Cliente no especificado.");
}

$telefono = $_GET['telefono'];

// Obtener datos del cliente
$stmt = $conn->prepare("SELECT nombre, apellidos, puntos FROM clientes WHERE telefono = ?");
$stmt->bind_param("s", $telefono);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

if (!$cliente) {
    die("Cliente no encontrado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $monto = floatval($_POST['monto']);

    if ($monto < 100) {
        $mensaje = "⚠️ El monto debe ser mayor o igual a $100 para bonificar puntos.";
    } else {
        // Calcular puntos
        $puntos_nuevos = floor($monto / 100) * 5;

        // Actualizar puntos en la base de datos
        $stmt = $conn->prepare("UPDATE clientes SET puntos = puntos + ? WHERE telefono = ?");
        $stmt->bind_param("is", $puntos_nuevos, $telefono);
        if ($stmt->execute()) {
            $mensaje = "✅ Se bonificaron $puntos_nuevos puntos correctamente.";
            $cliente['puntos'] += $puntos_nuevos;
        } else {
            $mensaje = "❌ Error al bonificar puntos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Bonificar Puntos</title>
  <style>
    body { background-color: #000; color: #FFD700; font-family: Arial; padding: 30px; }
    .formulario { max-width: 400px; margin: auto; background: #111; padding: 20px; border-radius: 10px; box-shadow: 0 0 15px #FFD700; }
    input, button { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: none; }
    input { background: #000; color: #FFD700; border: 2px solid #FFD700; }
    button { background-color: #FFD700; color: #000; font-weight: bold; cursor: pointer; }
    .mensaje { text-align: center; margin-top: 10px; }
    a { color: #FFD700; text-decoration: none; }
  </style>
</head>
<body>

<div class="formulario">
  <h2>Bonificar puntos a <?= $cliente['nombre'] . " " . $cliente['apellidos'] ?></h2>
  <p><strong>Teléfono:</strong> <?= $telefono ?></p>
  <p><strong>Puntos actuales:</strong> <?= $cliente['puntos'] ?> pts</p>

  <form method="POST">
    <label>Monto de compra ($)</label>
    <input type="number" name="monto" min="0" step="0.01" required>
    <button type="submit">Bonificar</button>
  </form>

  <?php if ($mensaje): ?>
    <div class="mensaje"><?= $mensaje ?></div>
  <?php endif; ?>

  <div style="text-align: center; margin-top: 15px;">
    <a href="admin_clientes.php">← Volver a clientes</a>
  </div>
</div>

</body>
</html>
