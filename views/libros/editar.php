<?php
require "../../config/db.php";

// Verificar si se envió un ID
if (!isset($_GET['id'])) {
    die("<div class='alert alert-danger'>ID de libro no proporcionado.</div>");
}

$id_libro = $_GET['id'];

try {
    // Obtener los datos del libro
    $stmt = $pdo->prepare("SELECT * FROM libro WHERE id_libro = ?");
    $stmt->execute([$id_libro]);
    $libro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$libro) {
        die("<div class='alert alert-warning'>Libro no encontrado.</div>");
    }

    // Si el formulario fue enviado
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];
        $categoria = $_POST['categoria'];
        $estado = $_POST['estado'];

        $update = $pdo->prepare("UPDATE libro SET titulo = ?, autor = ?, categoria = ?, estado = ? WHERE id_libro = ?");
        $update->execute([$titulo, $autor, $categoria, $estado, $id_libro]);

        echo "<div class='alert alert-success text-center'>✅ Libro actualizado correctamente.</div>";
        echo "<script>setTimeout(() => window.location.href='listado.php', 1500);</script>";
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error: {$e->getMessage()}</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Libro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px;">
  <h3 class="text-center mb-4 text-primary">✏️ Editar Libro</h3>
  <form method="POST" class="card p-4 shadow-sm">
    <div class="mb-3">
      <label class="form-label">Título</label>
      <input type="text" name="titulo" value="<?= htmlspecialchars($libro['titulo']) ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Autor</label>
      <input type="text" name="autor" value="<?= htmlspecialchars($libro['autor']) ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Categoría</label>
      <input type="text" name="categoria" value="<?= htmlspecialchars($libro['categoria']) ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Estado</label>
      <select name="estado" class="form-select" required>
        <option value="Disponible" <?= $libro['estado'] === 'Disponible' ? 'selected' : '' ?>>Disponible</option>
        <option value="Prestado" <?= $libro['estado'] === 'Prestado' ? 'selected' : '' ?>>Prestado</option>
        <option value="Mantenimiento" <?= $libro['estado'] === 'Mantenimiento' ? 'selected' : '' ?>>Mantenimiento</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary w-100">💾 Guardar Cambios</button>
    <a href="listado.php" class="btn btn-secondary w-100 mt-2">🔙 Volver</a>
  </form>
</div>

</body>
</html>
