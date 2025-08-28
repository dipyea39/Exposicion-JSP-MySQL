<?php
$host = "localhost";      // Servidor
$user = "root";           // Usuario de MySQL por defecto
$pass = "";               // Contraseña (vacía en XAMPP por defecto)
$db   = "medsports";         // Nombre de tu BD

$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
