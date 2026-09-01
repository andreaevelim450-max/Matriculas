<?php
require_once '../config/conexion.php';
require_once '../models/Matricula.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Conexion();
    $db = $database->getConnection();
    
    // Instancia corregida en singular para coincidir con la clase de models/Matricula.php
    $matricula = new Matricula($db);

    $matricula->id_estudiante = $_POST['id_estudiante'] ?? '';
    $matricula->id_curso = $_POST['id_curso'] ?? '';
    $matricula->periodo_lectivo = $_POST['periodo_lectivo'] ?? '';
    $matricula->fecha_matricula = $_POST['fecha_matricula'] ?? date('Y-m-d');
    $matricula->estado = $_POST['estado'] ?? 'activo';

    try {
        if ($matricula->registrar()) {
            header("Location: ../views/matriculas/agregar.php?msj=registrado");
            exit();
        } else {
            header("Location: ../views/matriculas/agregar.php?msj=error");
            exit();
        }
    } catch (PDOException $e) {
        // Manejo del error de clave única matricula_unica (estudiante + curso + periodo)
        header("Location: ../views/matriculas/agregar.php?msj=duplicado");
        exit();
    }
}
?>