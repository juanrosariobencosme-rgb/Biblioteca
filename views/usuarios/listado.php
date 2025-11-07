<?php 
include('../layout/header.php'); 
require "../../config/db.php";



?>

<div class="container mt-4">
    <h2>📚 Listado de usuarios</h2>
    <a href="registrar.php" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Nuevo Usuario</a>

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>Id-usuario</th>
                <th>nombre</th>
                <th>tipo de usuario</th>
                <th>email</th>
                <th>telefono</th>
                <th>fecha de registro</th>
                <th>estado</th>
                <th>deuda</th>
                <th>maximo de libros</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($usuarios)): ?>
                <tr><td colspan="9" class="text-center text-muted">No hay usuarios registrados.</td></tr>
            <?php else: ?>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= $u['id_usuario'] ?></td>
                        <td><?= htmlspecialchars($u['usuario']) ?></td>
                        <td><?= htmlspecialchars($u['libro']) ?></td>
                        <td><?= $u['fecha_prestamo'] ?></td>
                        <td><?= $u['fecha_devolucion_prevista'] ?></td>
                        <td>
                            <?php if ($u['estado'] === 'Prestado'): ?>
                                <span class="badge bg-warning text-dark"><?= $u['estado'] ?></span>
                            <?php elseif ($u['estado'] === 'Devuelto'): ?>
                                <span class="badge bg-success"><?= $u['estado'] ?></span>
                            <?php elseif ($u['estado'] === 'Renovado'): ?>
                                <span class="badge bg-info text-dark"><?= $u['estado'] ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?= $u['estado'] ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($u['estado'] === 'Prestado' || $u['estado'] === 'Renovado'): ?>
                                <a href="?accion=devolver&id=<?= $u['id_prestamo'] ?>" class="btn btn-success btn-sm" onclick="return confirm('¿Marcar como devuelto?')">
                                    <i class="fa fa-rotate-left"></i> Devolver
                                </a>
                                <a href="?accion=renovar&id=<?= $u['id_prestamo'] ?>" class="btn btn-info btn-sm" onclick="return confirm('¿Renovar este préstamo por 7 días más?')">
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