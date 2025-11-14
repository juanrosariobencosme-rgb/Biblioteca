<?php
// editar.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../config/db.php";
include "../layout/header.php";


if (!isset($_GET['id'])) {
    die("<div class='alert alert-danger'>ID no especificado.</div>");
}
$id = intval($_GET['id']);
$errors = [];

try {
    // obtener usuario
    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
    $stmt->execute([$id]);
    $u = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$u) die("<div class='alert alert-warning'>Usuario no encontrado.</div>");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim($_POST['nombre'] ?? '');
        $tipo = trim($_POST['tipo_usuario'] ?? '');
        $correo = trim($_POST['email'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $estado = trim($_POST['estado'] ?? 'Activo');
        $deuda = $_POST['deuda'] === '' ? 0 : floatval($_POST['deuda']);
        $max_libros = intval($_POST['max_libros'] ?? 3);

        if ($nombre === '') $errors[] = "Nombre obligatorio.";
        if ($tipo === '') $errors[] = "Tipo obligatorio.";
        if ($correo !== '' && !filter_var($correo, FILTER_VALIDATE_EMAIL)) $errors[] = "Correo inválido.";

        if (empty($errors)) {
            $upd = $pdo->prepare("UPDATE usuario SET nombre=?, tipo_usuario=?, email=?, telefono=?, estado=?, deuda=?, max_libros=? WHERE id_usuario=?");
            $upd->execute([$nombre, $tipo, $correo, $telefono, $estado, $deuda, $max_libros, $id]);

            echo "<div class='alert alert-success'>✅ Usuario actualizado.</div>";
            echo "<script>setTimeout(()=>window.location='listado.php',1200);</script>";
            exit;
        }
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>
<?php
$valor_correo = '';
if (isset($_POST['correo']) && $_POST['correo'] !== '') {
    $valor_correo = $_POST['correo'];
} elseif (isset($u['correo']) && $u['correo'] !== null) {
    $valor_correo = $u['correo'];
}
?>

<div class="container mt-4">
    <h2>✏️ Editar Usuario #<?= htmlspecialchars($id) ?></h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger"><ul><?php foreach ($errors as $er) echo "<li>".htmlspecialchars($er)."</li>"; ?></ul></div>
    <?php endif; ?>

    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input name="nombre" class="form-control" value="<?= htmlspecialchars($_POST['nombre'] ?? $u['nombre']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo de Usuario</label>
            <select name="tipo_usuario" class="form-select" required>
                <?php $sel = $_POST['tipo_usuario'] ?? $u['tipo_usuario']; ?>
                <option value="Estudiante" <?= ($sel === 'Estudiante') ? 'selected' : '' ?>>Estudiante</option>
                <option value="Maestro" <?= ($sel === 'Maestro') ? 'selected' : '' ?>>Maestro</option>
                <option value="Otro" <?= ($sel === 'Otro') ? 'selected' : '' ?>>Otro</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input name="correo" type="email" class="form-control" value="<?= htmlspecialchars($_POST['correo'] ?? ($valor_correo ?? ''))?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input name="telefono" class="form-control" value="<?= htmlspecialchars($_POST['telefono'] ?? $u['telefono']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <?php $st = $_POST['estado'] ?? $u['estado']; ?>
                <option value="Activo" <?= ($st === 'Activo') ? 'selected' : '' ?>>Activo</option>
                <option value="Suspendido" <?= ($st === 'Suspendido') ? 'selected' : '' ?>>Suspendido</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Deuda (RD$)</label>
            <input name="deuda" type="number" step="0.01" class="form-control" value="<?= htmlspecialchars($_POST['deuda'] ?? $u['deuda']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Máx. libros</label>
            <input name="max_libros" type="number" class="form-control" value="<?= htmlspecialchars($_POST['max_libros'] ?? $u['max_libros']) ?>">
        </div>

        <div class="mb-3">
            <button class="btn btn-success">💾 Guardar cambios</button>
            <a href="listado.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php include "../layout/sidebar.php"; ?>
