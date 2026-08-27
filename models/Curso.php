<?php
class Curso {
    private $conn;
    private $table_name = "cursos";

    public $id;
    public $nombre_curso;
    public $seccion;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . " (nombre_curso, seccion) VALUES (:nombre_curso, :seccion)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nombre_curso", $this->nombre_curso);
        $stmt->bindParam(":seccion", $this->seccion);
        return $stmt->execute();
    }

    public function listar() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nombre_curso ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>