<?php
require_once "../../config/db.php";
include "../layout/header.php";

// Procesar acciones de devolución o renovación
if (isset($_GET['accion']) && isset($_GET['id'])) {
    $accion = $_GET['accion'];
    $id = $_GET['id'];

    try {
        $pdo->beginTransaction();

        // Buscar préstamo y ejemplar relacionado
        $stmt = $pdo->prepare("SELECT id_ejemplar FROM prestamos WHERE id_prestamo = ?");
        $stmt->execute([$id]);
        $prestamo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($accion === 'devolver') {
            // Actualizar préstamo
            $pdo->prepare("UPDATE prestamos SET estado='Devuelto', fecha_devolucion_real=CURDATE() WHERE id_prestamo=?")
                ->execute([$id]);
            // Cambiar ejemplar a disponible
            $pdo->prepare("UPDATE ejemplares SET estado='Disponible' WHERE id_ejemplar=?")
                ->execute([$prestamo['id_ejemplar']]);
        } elseif ($accion === 'renovar') {
            // Extender fecha de devolución 7 días más
            $pdo->prepare("UPDATE prestamos 
                           SET estado='Renovado', 
                               fecha_devolucion_prevista = DATE_ADD(fecha_devolucion_prevista, INTERVAL 7 DAY) 
                           WHERE id_prestamo=?")
                ->execute([$id]);
            // Registrar la renovación en la tabla "renovacion"
            $pdo->prepare("INSERT INTO renovacion (id_prestamo, nueva_fecha_devolucion) 
                           VALUES (?, DATE_ADD(CURDATE(), INTERVAL 7 DAY))")
                ->execute([$id]);
        }

        $pdo->commit();
        echo "<script>alert('✅ Acción realizada correctamente.'); window.location='listado.php';</script>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script>alert('❌ Error: {$e->getMessage()}');</script>";
    }
}

// Consulta de préstamos
$stmt = $pdo->query("
    SELECT p.id_prestamo, u.nombre AS usuario, l.titulo AS libro, 
           p.fecha_prestamo, p.fecha_devolucion_prevista, p.estado
    FROM prestamos p
    JOIN usuarios u ON p.id_usuario = u.id_usuario
    JOIN ejemplares e ON p.id_ejemplar = e.id_ejemplar
    JOIN libro l ON e.id_libro = l.id_libro
    ORDER BY p.id_prestamo DESC
");
$prestamos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>📚 Listado de Préstamos</h2>
    <a href="registrar.php" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Nuevo préstamo</a>

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Libro</th>
                <th>Fecha préstamo</th>
                <th>Devolución prevista</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($prestamos)): ?>
                <tr><td colspan="7" class="text-center text-muted">No hay préstamos registrados.</td></tr>
            <?php else: ?>
                <?php foreach ($prestamos as $p): ?>
                    <tr>
                        <td><?= $p['id_prestamo'] ?></td>
                        <td><?= htmlspecialchars($p['usuario']) ?></td>
                        <td><?= htmlspecialchars($p['libro']) ?></td>
                        <td><?= $p['fecha_prestamo'] ?></td>
                        <td><?= $p['fecha_devolucion_prevista'] ?></td>
                        <td>
                            <?php if ($p['estado'] === 'Prestado'): ?>
                                <span class="badge bg-warning text-dark"><?= $p['estado'] ?></span>
                            <?php elseif ($p['estado'] === 'Devuelto'): ?>
                                <span class="badge bg-success"><?= $p['estado'] ?></span>
                            <?php elseif ($p['estado'] === 'Renovado'): ?>
                                <span class="badge bg-info text-dark"><?= $p['estado'] ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?= $p['estado'] ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($p['estado'] === 'Prestado' || $p['estado'] === 'Renovado'): ?>
                                <a href="?accion=devolver&id=<?= $p['id_prestamo'] ?>" class="btn btn-success btn-sm" onclick="return confirm('¿Marcar como devuelto?')">
                                    <i class="fa fa-rotate-left"></i> Devolver
                                </a>
                                <a href="?accion=renovar&id=<?= $p['id_prestamo'] ?>" class="btn btn-info btn-sm" onclick="return confirm('¿Renovar este préstamo por 7 días más?')">
                                    <i class="fa fa-sync"></i> Renovar
                                </a>
                            <?php else: ?>
                                <span class="text-muted">Sin acciones</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include "../layout/sidebar.php"; ?>
