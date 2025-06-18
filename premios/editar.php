<?php
include "../includes/db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $puntos = $_POST['puntos'];
    $sql = "UPDATE premios SET nombre=?, puntos=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $nombre, $puntos, $id);
    $stmt->execute();
    echo "Premio actualizado.";
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM premios WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $premio = $result->fetch_assoc();
?>
<form method="POST">
    <input type="hidden" name="id" value="<?= $premio['id'] ?>">
    <input name="nombre" value="<?= $premio['nombre'] ?>"><br>
    <input name="puntos" type="number" value="<?= $premio['puntos'] ?>"><br>
    <button type="submit">Actualizar</button>
</form>
<?php } ?>
