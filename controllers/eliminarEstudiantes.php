<?php
require_once '../config/conexion.php';
require_once '../models/Estudiante.php';

if (isset($_GET['id'])) {
    $database = new Conexion();
    $db = $database->getConnection();
    $estudiante = new Estudiante($db);

    if ($estudiante->eliminar($_GET['id'])) {
        header("Location: ../views/estudiantes/listar.php?msj=eliminado");
    } else {
        header("Location: ../views/estudiantes/listar.php?msj=error");
    }
}
?>