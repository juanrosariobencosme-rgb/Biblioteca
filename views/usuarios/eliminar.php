<?php
// eliminar.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../config/db.php";

if (!isset($_GET['id'])) {
    die("<div class='alert alert-danger'>ID no especificado.</div>");
}
$id = intval($_GET['id']);

try {
    // Opcional: chequear dependencias (prestamos) antes de eliminar
    // $check = $pdo->prepare("SELECT COUNT(*) FROM prestamo WHERE id_usuario = ?");
    // $check->execute([$id]);
    // if ($check->fetchColumn() > 0) { ... }

    $del = $pdo->prepare("DELETE FROM usuario WHERE id_usuario = ?");
    $del->execute([$id]);

    echo "<div class='alert alert-success'>✅ Usuario eliminado.</div>";
    echo "<script>setTimeout(()=>window.location='listado.php',900);</script>";
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error al eliminar: " . htmlspecialchars($e->getMessage()) . "</div>";
}
