<?php
require_once '../config/conexion.php';
require_once '../models/Curso.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Conexion();
    $db = $database->getConnection();
    $curso = new Curso($db);

    $curso->nombre_curso = $_POST['nombre_curso'] ?? '';
    $curso->seccion = $_POST['seccion'] ?? '';

    if ($curso->registrar()) {
        header("Location: ../views/cursos/agregar.php?msj=registrado");
    } else {
        header("Location: ../views/cursos/agregar.php?msj=error");
    }
}
?>