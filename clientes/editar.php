<?php
include "../includes/db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $telefono = $_POST['telefono'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $sql = "UPDATE clientes SET nombre=?, apellidos=? WHERE telefono=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $apellidos, $telefono);
    $stmt->execute();
    echo "Cliente actualizado.";
}
if (isset($_GET['telefono'])) {
    $telefono = $_GET['telefono'];
    $stmt = $conn->prepare("SELECT * FROM clientes WHERE telefono=?");
    $stmt->bind_param("s", $telefono);
    $stmt->execute();
    $result = $stmt->get_result();
    $cliente = $result->fetch_assoc();
?>
<form method="POST">
    <input type="hidden" name="telefono" value="<?= $cliente['telefono'] ?>">
    <input name="nombre" value="<?= $cliente['nombre'] ?>"><br>
    <input name="apellidos" value="<?= $cliente['apellidos'] ?>"><br>
    <button type="submit">Actualizar</button>
</form>
<?php } ?>
