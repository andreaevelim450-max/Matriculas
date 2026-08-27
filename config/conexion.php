<?php
// Usar el nombre exacto de la carpeta del proyecto en htdocs
define('BASE_URL', 'http://localhost/Proyecto Tercer Parcial/');

$dsn = "mysql:host=localhost;dbname=tareas;charset=utf8mb4";
$username = "root";
$password = "";

try {
    $conexion = new PDO($dsn, $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}