<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../config/db.php";
include "../layout/header.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST['nombre']);
    $tipo = trim($_POST['tipo_usuario']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $estado = trim($_POST['estado']);
    $deuda = trim($_POST['deuda']);
    $max_libros = trim($_POST['max_libros']);

    if (empty($nombre) || empty($tipo) || empty($correo)) {
        echo "<div class='alert alert-danger'>⚠️ Debes completar los campos obligatorios.</div>";
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO usuario 
                (nombre, tipo_usuario, correo, telefono, estado, deuda, max_libros, fecha_registro)
                VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE())
            ");

            $stmt->execute([$nombre, $tipo, $correo, $telefono, $estado, $deuda, $max_libros]);

            echo "<div class='alert alert-success'>✅ Usuario registrado correctamente.</div>";
            echo "<script>setTimeout(()=>window.location='listado.php', 1200);</script>";

        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Error: {$e->getMessage()}</div>";
        }
    }
}
?>

<div class="container mt-4">
    <h2>➕ Registrar nuevo usuario</h2>

    <form method="POST" class="mt-3">

        <!-- Nombre -->
        <div class="mb-3">
            <label class="form-label">Nombre del usuario:</label>
            <input name="nombre" class="form-control" required>
        </div>

        <!-- Tipo -->
        <div class="mb-3">
            <label class="form-label">Tipo de Usuario:</label>
            <select name="tipo_usuario" class="form-select" required>
                <option value="Estudiante">Estudiante</option>
                <option value="Maestro">Maestro</option>
            </select>
        </div>

        <!-- Correo -->
        <div class="mb-3">
            <label class="form-label">Correo:</label>
            <input type="email" name="correo" class="form-control" required>
        </div>

        <!-- Teléfono -->
        <div class="mb-3">
            <label class="form-label">Teléfono:</label>
            <input type="text" name="telefono" class="form-control">
        </div>

        <!-- Estado -->
        <div class="mb-3">
            <label class="form-label">Estado:</label>
            <select name="estado" class="form-select" required>
                <option value="Activo">Activo</option>
                <option value="Suspendido">Suspendido</option>
            </select>
        </div>

        <!-- Deuda -->
        <div class="mb-3">
            <label class="form-label">Deuda (RD$):</label>
            <input type="number" name="deuda" class="form-control" value="0" required>
        </div>

        <!-- Máximo de libros -->
        <div class="mb-3">
            <label class="form-label">Máximo de libros permitidos:</label>
            <input type="number" name="max_libros" class="form-control" value="3" required>
        </div>

        <!-- Botones -->
        <div class="mb-3">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Registrar Usuario</button>
            <a href="listado.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php include "../layout/sidebar.php"; ?>
