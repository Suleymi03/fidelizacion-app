<?php
session_start();
if (!isset($_SESSION['telefono'])) {
    header("Location: login.php");
    exit();
}
?>
