<?php
include "includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $telefono = $_POST['telefono'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $estado = $_POST['estado'];
    $ciudad = $_POST['ciudad'];
    $puntos = 0;
    $pass = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO clientes (telefono, nombre, apellidos, direccion, correo, estado, ciudad, puntos, contrasena)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssis", $telefono, $nombre, $apellidos, $direccion, $correo, $estado, $ciudad, $puntos, $pass);

    if ($stmt->execute()) {
        echo "Cliente registrado";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<form method="POST">
    <input name="telefono" required placeholder="Teléfono"><br>
    <input name="nombre" required placeholder="Nombre"><br>
    <input name="apellidos" required placeholder="Apellidos"><br>
    <input name="direccion" required placeholder="Dirección"><br>
    <input name="correo" required placeholder="Correo"><br>
    <input name="estado" required placeholder="Estado"><br>
    <input name="ciudad" required placeholder="Ciudad"><br>
    <input name="contrasena" type="password" required placeholder="Contraseña"><br>
    <button type="submit">Registrar cliente</button>
</form>
