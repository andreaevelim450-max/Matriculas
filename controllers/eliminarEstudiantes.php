<?php
require_once "../config/conexion.php";
require_once "../models/Empleado.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: " . BASE_URL . "views/empleados/agregar.php?status=error&msg=id_invalido");
    exit;
}

try {
    $empleadoModel = new Empleado($conexion);

    // Se busca la foto con la columna 'foto' para eliminar el archivo del servidor
    $empleado = $empleadoModel->obtenerPorId($id);

    if ($empleado && !empty($empleado['foto'])) {
        $rutaImagen = __DIR__ . '/../' . $empleado['foto'];
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }
    }

    $eliminado = $empleadoModel->eliminar($id);

    header("Location: " . BASE_URL . "views/empleados/agregar.php?status=" . ($eliminado ? 'deleted' : 'error'));
    exit;

} catch (PDOException $e) {
    header("Location: " . BASE_URL . "views/empleados/agregar.php?status=error&msg=" . urlencode($e->getMessage()));
    exit;
}