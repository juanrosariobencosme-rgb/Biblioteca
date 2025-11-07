<?php 
include('../layout/header.php'); 
require "../../config/db.php";

try {
    if (isset($_GET['id'])) {
        // Obtener un solo usuario (por ID)
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
        $stmt->execute([$_GET['id']]);
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Obtener todos los usuarios
        $stmt = $pdo->query("SELECT * FROM usuario");
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (Exception $e) {
    echo "<script>alert('❌ Error al obtener usuarios: {$e->getMessage()}');</script>";
}
?>

<div class="container mt-4">
    <h2>📚 Listado de usuarios</h2>
    <a href="registrar.php" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Nuevo usuario</a>
    <a href="registrar.php" class="btn btn-secondary mb-3"><i class="fa fa-user-cog"></i> Administrar usuarios</a>

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>ID Usuario</th>
                <th>Nombre</th>
                <th>Tipo de Usuario</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Fecha de Registro</th>
                <th>Estado</th>
                <th>Deuda</th>
                <th>Máx. Libros</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($usuarios)): ?>
                <tr><td colspan="9" class="text-center text-muted">No hay usuarios registrados.</td></tr>
            <?php else: ?>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['id_usuario']) ?></td>
                        <td><?= htmlspecialchars($u['nombre']) ?></td>
                        <td><?= htmlspecialchars($u['tipo_usuario']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($u['telefono']) ?></td>
                        <td><?= htmlspecialchars($u['fecha_registro']) ?></td>
                        <td><?= htmlspecialchars($u['estado']) ?></td>
                        <td><?= htmlspecialchars($u['deuda']) ?></td>
                        <td><?= htmlspecialchars($u['max_libros']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
