<?php
class Matricula {
    private $conn;
    private $table_name = "matricula";

    public $id;
    public $id_estudiante;
    public $id_curso;
    public $periodo_lectivo;
    public $fecha_matricula;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . " (id_estudiante, id_curso, periodo_lectivo, fecha_matricula, estado) 
                  VALUES (:id_estudiante, :id_curso, :periodo_lectivo, :fecha_matricula, :estado)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_estudiante", $this->id_estudiante);
        $stmt->bindParam(":id_curso", $this->id_curso);
        $stmt->bindParam(":periodo_lectivo", $this->periodo_lectivo);
        $stmt->bindParam(":fecha_matricula", $this->fecha_matricula);
        $stmt->bindParam(":estado", $this->estado);

        return $stmt->execute();
    }
}
?>