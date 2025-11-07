<?php
require "../../config/db.php";

if (!isset($_GET['id'])) {
    die("<div class='alert alert-danger'>ID no especificado.</div>");
}

$id_libro = $_GET['id'];

try {
    // Eliminar el libro
    $stmt = $pdo->prepare("DELETE FROM libro WHERE id_libro = ?");
    $stmt->execute([$id_libro]);

    echo "<div class='alert alert-success text-center'>✅ Libro eliminado correctamente.</div>";
    echo "<script>setTimeout(() => window.location.href='listado.php', 1000);</script>";
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error al eliminar: {$e->getMessage()}</div>";
}
?>
