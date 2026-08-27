<?php
require_once "../config/conexion.php";
require_once "../models/Tarea.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . BASE_URL . "index.php");
    exit;
}

$titulo      = trim($_POST['titulo'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$fechaLimite = trim($_POST['fecha_limite'] ?? '');
$idEmpleado  = isset($_POST['id_empleado']) ? (int) $_POST['id_empleado'] : 0;
$estado      = trim($_POST['estado'] ?? 'pendiente');

// Sin título o sin empleado asignado, la tarea no tiene sentido: rechazamos
if ($titulo === '' || $idEmpleado <= 0) {
    header("Location: " . BASE_URL . "index.php?status=error&msg=campos_incompletos");
    exit;
}

try {
    $tareaModel = new Tarea($conexion);

    $insertado = $tareaModel->agregar([
        'titulo'       => $titulo,
        'descripcion'  => $descripcion,
        // El operador ?: convierte "" en null, para no guardar fechas vacías como texto
        'fecha_limite' => $fechaLimite ?: null,
        'id_empleado'  => $idEmpleado,
        'estado'       => $estado,
    ]);

    header("Location: " . BASE_URL . "index.php?status=" . ($insertado ? 'success' : 'error'));
    exit;

} catch (PDOException $e) {
    header("Location: " . BASE_URL . "index.php?status=error&msg=" . urlencode($e->getMessage()));
    exit;
}