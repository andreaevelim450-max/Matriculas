<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "tareas"; // Nombre exacto de tu base de datos en phpMyAdmin

$conexion = mysqli_connect($host, $user, $password, $database);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>