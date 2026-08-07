<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "tareas";

// 1. CONEXIÓN VÍA PDO (Recomendada para producción)
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en conexión PDO: " . $e->getMessage());
}

// 2. CONEXIÓN VÍA MYSQLI (Orientado a Objetos)
$conexion = new mysqli($host, $user, $password, $database);
if ($conexion->connect_error) {
    die("Error en conexión MySQLi OO: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");

// 3. CONEXIÓN VÍA MYSQLI (Procedimental)
$conexion_proc = mysqli_connect($host, $user, $password, $database);
if (!$conexion_proc) {
    die("Error en conexión MySQLi Procedimental: " . mysqli_connect_error());
}
?>