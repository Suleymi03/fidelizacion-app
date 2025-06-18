<?php
include "../includes/db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $empresa = $_POST['empresa'];
    $descripcion = $_POST['descripcion'];
    $sql = "UPDATE beneficios SET empresa=?, descripcion=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $empresa, $descripcion, $id);
    $stmt->execute();
    echo "Beneficio actualizado.";
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM beneficios WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $beneficio = $result->fetch_assoc();
?>
<form method="POST">
    <input type="hidden" name="id" value="<?= $beneficio['id'] ?>">
    <input name="empresa" value="<?= $beneficio['empresa'] ?>"><br>
    <textarea name="descripcion"><?= $beneficio['descripcion'] ?></textarea><br>
    <button type="submit">Actualizar</button>
</form>
<?php } ?>
