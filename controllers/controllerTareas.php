<?php
require_once __DIR__ . '/../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_guardar_tarea'])) {
    $titulo       = trim($_POST['titulo']);
    $descripcion  = trim($_POST['descripcion']);
    $fecha_limite = $_POST['fecha_limite'];
    $id_empleado  = $_POST['id_empleado'];
    $estado       = $_POST['estado'];

    if (!empty($titulo) && !empty($fecha_limite) && !empty($id_empleado)) {
        try {
            $sql = "INSERT INTO tareas (titulo, descripcion, fecha_limite, id_empleado, estado) 
                    VALUES (:titulo, :descripcion, :fecha_limite, :id_empleado, :estado)";
            
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':titulo'       => $titulo,
                ':descripcion'  => $descripcion,
                ':fecha_limite' => $fecha_limite,
                ':id_empleado'  => $id_empleado,
                ':estado'       => $estado
            ]);

            header("Location: " . BASE_URL . "/index.php?status=success");
            exit();
        } catch (PDOException $e) {
            die("Error al guardar la tarea: " . $e->getMessage());
        }
    } else {
        header("Location: " . BASE_URL . "/index.php?status=empty");
        exit();
    }
}