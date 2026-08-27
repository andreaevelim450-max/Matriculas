<?php

class Tarea
{
    private PDO $conexion;

    public function __construct(PDO $conexion)
    {
        $this->conexion = $conexion;
    }

    public function agregar(array $datos): bool
    {
        $sql = "INSERT INTO tareas (titulo, descripcion, fecha_limite, id_empleado, estado)
                VALUES (:titulo, :descripcion, :fecha_limite, :id_empleado, :estado)";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':titulo'       => $datos['titulo'],
            ':descripcion'  => $datos['descripcion'],
            ':fecha_limite' => $datos['fecha_limite'],
            ':id_empleado'  => $datos['id_empleado'],
            ':estado'       => $datos['estado'],
        ]);
    }

    // JOIN: trae cada tarea junto con el nombre del empleado dueño de esa tarea
    public function obtenerTodas(): array
    {
        $sql = "SELECT tareas.*, empleados.nombres, empleados.apellidos
                FROM tareas
                INNER JOIN empleados ON tareas.id_empleado = empleados.id
                ORDER BY tareas.fecha_limite ASC";

        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Preparado para el editar.php que construiremos después
    public function obtenerPorId(int $id): array|false
    {
        $sql = "SELECT * FROM tareas WHERE id = :id LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar(int $id, array $datos): bool
    {
        $sql = "UPDATE tareas
                SET titulo = :titulo, descripcion = :descripcion,
                    fecha_limite = :fecha_limite, id_empleado = :id_empleado, estado = :estado
                WHERE id = :id";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':titulo'       => $datos['titulo'],
            ':descripcion'  => $datos['descripcion'],
            ':fecha_limite' => $datos['fecha_limite'],
            ':id_empleado'  => $datos['id_empleado'],
            ':estado'       => $datos['estado'],
            ':id'           => $id,
        ]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM tareas WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}