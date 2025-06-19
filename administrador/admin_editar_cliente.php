<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$telefono = $_GET['telefono'] ?? null;

if (!$telefono) {
    header("Location: admin_clientes.php");
    exit();
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $estado = $_POST['estado'];
    $ciudad = $_POST['ciudad'];
    $puntos = $_POST['puntos'];

    $sql = "UPDATE clientes SET nombre=?, apellidos=?, direccion=?, correo=?, estado=?, ciudad=?, puntos=? WHERE telefono=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssis", $nombre, $apellidos, $direccion, $correo, $estado, $ciudad, $puntos, $telefono);

    if ($stmt->execute()) {
        $mensaje = "✅ Cliente actualizado.";
    } else {
        $mensaje = "❌ Error: " . $stmt->error;
    }
}

$stmt = $conn->prepare("SELECT * FROM clientes WHERE telefono = ?");
$stmt->bind_param("s", $telefono);
$stmt->execute();
$resultado = $stmt->get_result();
$cliente = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Cliente</title>
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

<h2>Editar Cliente</h2>
<a href="admin_clientes.php">← Volver</a>

<form method="POST">
  <input name="nombre" value="<?= $cliente['nombre'] ?>" required placeholder="Nombre">
  <input name="apellidos" value="<?= $cliente['apellidos'] ?>" required placeholder="Apellidos">
  <input name="direccion" value="<?= $cliente['direccion'] ?>" required placeholder="Dirección">
  <input name="correo" value="<?= $cliente['correo'] ?>" required placeholder="Correo">
  <input name="estado" value="<?= $cliente['estado'] ?>" required placeholder="Estado">
  <input name="ciudad" value="<?= $cliente['ciudad'] ?>" required placeholder="Ciudad">
  <input name="puntos" value="<?= $cliente['puntos'] ?>" required type="number" placeholder="Puntos">
  <button type="submit">Actualizar</button>
</form>

<?php if ($mensaje): ?>
  <div class="mensaje"><?= $mensaje ?></div>
<?php endif; ?>

</body>
</html>
