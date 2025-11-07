<?php
require "../../config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = trim($_POST['titulo']);
    $autor = trim($_POST['autor']);
    $categoria = trim($_POST['categoria']);
    $estado = trim($_POST['estado']);

    if (empty($titulo) || empty($autor) || empty($categoria) || empty($estado)) {
        echo "<div class='alert alert-danger text-center'>⚠️ Todos los campos son obligatorios.</div>";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO libro (titulo, autor, categoria, estado) VALUES (?, ?, ?, ?)");
            $stmt->execute([$titulo, $autor, $categoria, $estado]);
            
            echo "<div class='alert alert-success text-center'>✅ Libro registrado exitosamente.</div>";
            echo "<script>setTimeout(() => window.location.href='listado.php', 1500);</script>";
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Error al registrar el libro: {$e->getMessage()}</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Libro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px;">
  <h3 class="text-center mb-4 text-primary">📚 Registrar Nuevo Libro</h3>

  <form method="POST" class="card p-4 shadow-sm">
    <div class="mb-3">
      <label class="form-label">Título</label>
      <input type="text" name="titulo" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Autor</label>
      <input type="text" name="autor" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Categoría</label>
      <input type="text" name="categoria" class="form-control" placeholder="Ej. Novela, Ciencia, Historia..." required>
    </div>
    <div class="mb-3">
      <label class="form-label">Estado</label>
      <select name="estado" class="form-select" required>
        <option value="">Seleccione el estado...</option>
        <option value="Disponible">Disponible</option>
        <option value="Prestado">Prestado</option>
        <option value="Mantenimiento">Mantenimiento</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary w-100">💾 Registrar Libro</button>
    <a href="listado.php" class="btn btn-secondary w-100 mt-2">🔙 Volver</a>
  </form>
</div>

</body>
</html>
