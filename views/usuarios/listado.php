<?php
// listado.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../config/db.php";
include "../layout/header.php";

try {
    $stmt = $pdo->query("SELECT * FROM usuario ORDER BY id_usuario DESC");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error al cargar usuarios: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>

<div class="container mt-4">
    <h2>📋 Listado de Usuarios</h2>
    <div class="mb-3">
        <a href="registro.php" class="btn btn-primary">➕ Nuevo usuario</a>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Deuda</th>
                <th>Máx. Libros</th>
                <th>Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($usuarios)): ?>
                <tr><td colspan="10" class="text-center text-muted">No hay usuarios registrados.</td></tr>
            <?php else: ?>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['id_usuario']) ?></td>
                        <td><?= htmlspecialchars($u['nombre']) ?></td>
                        <td><?= htmlspecialchars($u['tipo_usuario']) ?></td>
                        <td><?= htmlspecialchars($u['correo'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['telefono'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['estado']) ?></td>
                        <td><?= htmlspecialchars(number_format($u['deuda'],2)) ?></td>
                        <td><?= htmlspecialchars($u['max_libros']) ?></td>
                        <td><?= htmlspecialchars($u['fecha_registro']) ?></td>
                        <td>
                            <a href="administrar.php?id=<?= urlencode($u['id_usuario']) ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="eliminar.php?id=<?= urlencode($u['id_usuario']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar usuario #<?= htmlspecialchars($u['id_usuario']) ?>?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include "../layout/sidebar.php"; ?>
