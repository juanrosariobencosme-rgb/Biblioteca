<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
require_once "../../config/db.php";
include "../layout/header.php";
?>

<div class="container mt-4">
    <h2>➕ Registrar nuevo usuario</h2>

    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input name="id_usuario" class="form-control" required>
                
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo de Usuario</label>
            <select name="id_ejemplar" class="form-select" required>
                
                <option >Estudiante</option>
                <option >Maestro</option>
               
            </select>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Registrar Usuario</button>
            <a href="listado.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php include "../layout/sidebar.php"; ?>
