<?php
include "includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $telefono = $_POST['telefono'];
    $pass = $_POST['contrasena'];

    $sql = "SELECT * FROM clientes WHERE telefono = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $telefono);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $cliente = $result->fetch_assoc();
        if (password_verify($pass, $cliente['contrasena'])) {
            $_SESSION['telefono'] = $telefono;
            header("Location: dashboard_user.php");
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
}
?>

<form method="POST">
    <input type="text" name="telefono" placeholder="Teléfono" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <button type="submit">Iniciar sesión</button>
</form>
