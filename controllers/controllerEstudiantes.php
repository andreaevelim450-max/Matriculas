<?php
require_once '../config/conexion.php';
require_once '../models/Estudiante.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Conexion();
    $db = $database->getConnection();
    $estudiante = new Estudiante($db);

    $estudiante->nombres = $_POST['nombres'] ?? '';
    $estudiante->apellidos = $_POST['apellidos'] ?? '';
    $estudiante->telefono = $_POST['telefono'] ?? '';

    if ($estudiante->registrar()) {
        header("Location: ../views/estudiantes/listar.php?msj=registrado");
    } else {
        header("Location: ../views/estudiantes/agregar.php?msj=error");
    }
}
?>