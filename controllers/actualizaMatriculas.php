<?php
require_once '../config/conexion.php';
require_once '../models/Matricula.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Conexion();
    $db = $database->getConnection();
    $matricula = new Matricula($db);

    $matricula->id_estudiante = $_POST['id_estudiante'] ?? '';
    $matricula->id_curso = $_POST['id_curso'] ?? '';
    $matricula->periodo_lectivo = $_POST['periodo_lectivo'] ?? '';
    $matricula->fecha_matricula = $_POST['fecha_matricula'] ?? '';
    $matricula->estado = $_POST['estado'] ?? 'activo';

    if ($matricula->crear()) {
        header("Location: ../views/matriculas/index.php?msj=registrado");
    } else {
        header("Location: ../views/matriculas/agregar.php?msj=error");
    }
}
?>