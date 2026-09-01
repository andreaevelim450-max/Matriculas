<?php
require_once '../config/conexion.php';
require_once '../models/Matricula.php';

if (isset($_GET['id'])) {
    $database = new Conexion();
    $db = $database->getConnection();
    $matricula = new Matricula($db);

    if ($matricula->eliminar($_GET['id'])) {
        header("Location: ../views/matriculas/index.php?msj=eliminado");
    } else {
        header("Location: ../views/matriculas/index.php?msj=error");
    }
}
?>