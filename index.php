<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Biblioteca</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #2b5876, #4e4376);
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
    }
    .container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .card {
      background-color: rgba(255, 255, 255, 0.1);
      border: none;
      border-radius: 15px;
      padding: 30px;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      transition: transform 0.3s ease, background 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
      background-color: rgba(255, 255, 255, 0.15);
    }
    .card h3 {
      color: #ffd700;
    }
    .btn-custom {
      border: none;
      color: #fff;
      font-weight: 600;
      transition: 0.3s ease;
    }
    .btn-custom:hover {
      opacity: 0.9;
      transform: scale(1.05);
    }
    footer {
      text-align: center;
      position: absolute;
      bottom: 10px;
      width: 100%;
      color: #ddd;
    }
  </style>
</head>
<body>

  <!-- Contenido principal -->
  <div class="container">
    <div class="text-center mb-4">
      <h1 class="fw-bold">📚 Sistema de Biblioteca</h1>
      <p class="lead">Administra libros, préstamos y usuarios de forma sencilla.</p>
    </div>

    <div class="row justify-content-center">
      <!-- Tarjeta Libros -->
      <div class="col-md-3 m-3">
        <div class="card">
          <h3>📘 Libros</h3>
          <p>Consulta y gestiona el catálogo de libros.</p>
          <a href="views/libros/listado.php" class="btn btn-primary btn-custom w-100">Entrar</a>
        </div>
      </div>

      <!-- Tarjeta Préstamos -->
      <div class="col-md-3 m-3">
        <div class="card">
          <h3>📦 Préstamos</h3>
          <p>Registra y controla préstamos y devoluciones.</p>
          <a href="views/prestamos/listado.php" class="btn btn-success btn-custom w-100">Entrar</a>
        </div>
      </div>

      <!-- Tarjeta Usuarios -->
      <div class="col-md-3 m-3">
        <div class="card">
          <h3>👥 Usuarios</h3>
          <p>Gestiona los usuarios del sistema y sus roles.</p>
          <a href="views/usuarios/listado.php" class="btn btn-warning btn-custom w-100">Entrar</a>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <small>© 2025 Sistema de Biblioteca — Desarrollado por Marlyn Edonel Pimentel Martínez</small>
  </footer>

</body>
</html>
