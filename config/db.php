<?php
// Archivo: config/db.php
// Conexión a la base de datos "biblioteca"

$host = "localhost";
$user = "root"; // usuario por defecto de Laragon
$pass = "";     // contraseña vacía por defecto
$dbname = "biblioteca";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "✅ Conectado correctamente a la base de datos.";
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}
?>
