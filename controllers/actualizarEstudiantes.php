<?php
require_once '../config/conexion.php';
require_once '../models/Estudiante.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Conexion();
    $db = $database->getConnection();
    $estudiante = new Estudiante($db);

    $estudiante->id = $_POST['id'] ?? '';
    $estudiante->nombres = $_POST['nombres'] ?? '';
    $estudiante->apellidos = $_POST['apellidos'] ?? '';
    $estudiante->telefono = $_POST['telefono'] ?? '';

    if ($estudiante->actualizar()) {
        header("Location: ../views/estudiantes/listar.php?msj=actualizado");
    } else {
        header("Location: ../views/estudiantes/editar.php?id={$estudiante->id}&msj=error");
    }
}
?>