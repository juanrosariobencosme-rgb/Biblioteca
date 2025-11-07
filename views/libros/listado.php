<?php
require "../../config/db.php";
include "../layout/header.php";

try {
    // Obtener las categorías únicas de los libros
    $stmt = $pdo->query("SELECT DISTINCT categoria FROM libro ORDER BY categoria ASC");
    $categorias = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Verificar si se seleccionó una categoría
    if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
        $stmt = $pdo->prepare("SELECT id_libro, titulo, autor, categoria, estado FROM libro WHERE categoria = ?");
        $stmt->execute([$_GET['categoria']]);
    } else {
        $stmt = $pdo->query("SELECT id_libro, titulo, autor, categoria, estado FROM libro");
    }

    $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error al cargar datos: {$e->getMessage()}</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de Libros</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4" style="margin-left:270px;">
  <h3 class="text-primary mb-4">📘 Listado de Libros</h3>

  <!-- Selector de Categoría -->
  <form method="GET" class="mb-3">
    <label for="categoria" class="form-label">Seleccione la Categoría:</label>
    <select name="categoria" class="form-select" onchange="this.form.submit()">
      <option value="">Todas las categorías</option>
      <?php foreach ($categorias as $cat): ?>
        <option value="<?= htmlspecialchars($cat) ?>" 
          <?= (isset($_GET['categoria']) && $_GET['categoria'] == $cat) ? 'selected' : '' ?>>
          <?= htmlspecialchars($cat) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </form>

  <!-- Tabla de Libros -->
   <a href="registro.php" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Nuevo libro</a>
  <table class="table table-striped table-hover">
    <thead class="table-primary">
      <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Autor</th>
        <th>Categoría</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($libros)): ?>
        <tr><td colspan="6" class="text-center text-muted">No hay libros registrados.</td></tr>
      <?php else: ?>
        <?php foreach ($libros as $libro): ?>
          <tr>
            <td><?= htmlspecialchars($libro['id_libro']) ?></td>
            <td><?= htmlspecialchars($libro['titulo']) ?></td>
            <td><?= htmlspecialchars($libro['autor']) ?></td>
            <td><?= htmlspecialchars($libro['categoria']) ?></td>
            <td>
              <?php if ($libro['estado'] === 'Disponible'): ?>
                <span class="badge bg-success"><?= $libro['estado'] ?></span>
              <?php elseif ($libro['estado'] === 'Prestado'): ?>
                <span class="badge bg-danger"><?= $libro['estado'] ?></span>
              <?php else: ?>
                <span class="badge bg-secondary"><?= $libro['estado'] ?></span>
              <?php endif; ?>
            </td>
            <td>
              <a href="editar.php?id=<?= $libro['id_libro'] ?>" class="btn btn-sm btn-warning">Editar</a>
              <a href="eliminar.php?id=<?= $libro['id_libro'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que desea eliminar este libro?')">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>
