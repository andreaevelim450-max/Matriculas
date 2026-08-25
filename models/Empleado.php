<?php

class Empleado
{
    private PDO $conexion;

    public function __construct(PDO $conexion)
    {
        $this->conexion = $conexion;
    }

    public function agregar(array $datos): bool
    {
        $sql = "INSERT INTO empleados (nombres, apellidos, fecha_nac, salario, puesto, imagen)
                VALUES (:nombres, :apellidos, :fecha_nac, :salario, :puesto, :imagen)";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':nombres'   => $datos['nombres'],
            ':apellidos' => $datos['apellidos'],
            ':fecha_nac' => $datos['fecha_nac'],
            ':salario'   => $datos['salario'],
            ':puesto'    => $datos['puesto'],
            ':imagen'    => $datos['imagen'],
        ]);
    }

    public function obtenerTodos(): array
    {
        $stmt = $this->conexion->query("SELECT * FROM empleados ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca un solo empleado. Se usa para precargar el formulario de edición.
    public function obtenerPorId(int $id): array|false
    {
        $sql = "SELECT * FROM empleados WHERE id = :id LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualiza un empleado existente por su id.
    public function actualizar(int $id, array $datos): bool
    {
        $sql = "UPDATE empleados
                SET nombres = :nombres,
                    apellidos = :apellidos,
                    fecha_nac = :fecha_nac,
                    salario = :salario,
                    puesto = :puesto,
                    imagen = :imagen
                WHERE id = :id";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':nombres'   => $datos['nombres'],
            ':apellidos' => $datos['apellidos'],
            ':fecha_nac' => $datos['fecha_nac'],
            ':salario'   => $datos['salario'],
            ':puesto'    => $datos['puesto'],
            ':imagen'    => $datos['imagen'],
            ':id'        => $id,
        ]);
    }

    // Elimina un empleado por su id.
    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM empleados WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
}