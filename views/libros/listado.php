<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de Libros</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<body>

  <?php

  error_reporting(E_ALL);
  ini_set('display_errors', 1); 

  include('../layout/header.php'); 
  ?>
  

  <div class="container" style="margin-left:270px; margin-top:20px;">
    <h3 class="text-primary mb-4">📘 Listado de Libros</h3>

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
        <tr>
          <td>1</td>
          <td>Cien años de soledad</td>
          <td>Gabriel García Márquez</td>
          <td>Novela</td>
          <td><span class="badge bg-success">Disponible</span></td>
          <td>
            <button class="btn btn-sm btn-warning">Editar</button>
            <button class="btn btn-sm btn-danger">Eliminar</button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>La ciudad y los perros</td>
          <td>Mario Vargas Llosa</td>
          <td>Novela</td>
          <td><span class="badge bg-danger">Prestado</span></td>
          <td>
            <button class="btn btn-sm btn-warning">Editar</button>
            <button class="btn btn-sm btn-danger">Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
