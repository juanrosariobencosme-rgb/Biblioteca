<?php
require_once "../../config/db.php";
include "../layout/header.php";

// Obtener listas de usuarios activos y ejemplares disponibles
$usuarios = $pdo->query("SELECT id_usuario, nombre FROM usuarios WHERE estado = 'Activo'")->fetchAll(PDO::FETCH_ASSOC);
$ejemplares = $pdo->query("
    SELECT e.id_ejemplar, l.titulo 
    FROM ejemplares e 
    JOIN libro l ON e.id_libro = l.id_libro 
    WHERE e.estado = 'Disponible'
")->fetchAll(PDO::FETCH_ASSOC);

// Si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $id_ejemplar = $_POST['id_ejemplar'];
    $fecha_prestamo = date('Y-m-d');
    $fecha_devolucion_prevista = date('Y-m-d', strtotime('+7 days')); // 7 días después

    try {
        $pdo->beginTransaction();

        // Insertar préstamo
        $stmt = $pdo->prepare("
            INSERT INTO prestamos (id_usuario, id_ejemplar, fecha_prestamo, fecha_devolucion_prevista, estado)
            VALUES (?, ?, ?, ?, 'Prestado')
        ");
        $stmt->execute([$id_usuario, $id_ejemplar, $fecha_prestamo, $fecha_devolucion_prevista]);

        // Cambiar estado del ejemplar
        $update = $pdo->prepare("UPDATE ejemplares SET estado = 'Prestado' WHERE id_ejemplar = ?");
        $update->execute([$id_ejemplar]);

        $pdo->commit();

        echo "<script>alert('✅ Préstamo registrado correctamente'); window.location='listado.php';</script>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script>alert('❌ Error al registrar préstamo: {$e->getMessage()}');</script>";
    }
}
?>

<div class="container mt-4">
    <h2>➕ Registrar nuevo préstamo</h2>

    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Usuario:</label>
            <select name="id_usuario" class="form-select" required>
                <option value="">Seleccione un usuario...</option>
                <?php foreach ($usuarios as $u): ?>
                    <option value="<?= $u['id_usuario'] ?>"><?= htmlspecialchars($u['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Libro (ejemplar disponible):</label>
            <select name="id_ejemplar" class="form-select" required>
                <option value="">Seleccione un libro...</option>
                <?php foreach ($ejemplares as $e): ?>
                    <option value="<?= $e['id_ejemplar'] ?>"><?= htmlspecialchars($e['titulo']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Registrar préstamo</button>
            <a href="listado.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php include "../layout/sidebar.php"; ?>
