<?php
class Estudiante {
    private $conn;
    private $table_name = "estudiantes";

    public $id;
    public $nombres;
    public $apellidos;
    public $telefono;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . " (nombres, apellidos, telefono) VALUES (:nombres, :apellidos, :telefono)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombres", $this->nombres);
        $stmt->bindParam(":apellidos", $this->apellidos);
        $stmt->bindParam(":telefono", $this->telefono);

        return $stmt->execute();
    }

    public function listar() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " SET nombres = :nombres, apellidos = :apellidos, telefono = :telefono WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombres", $this->nombres);
        $stmt->bindParam(":apellidos", $this->apellidos);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    public function eliminar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>