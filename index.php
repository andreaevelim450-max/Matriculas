<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Asegúrate de que las rutas relativas apunten correctamente a tu estructura
include_once 'views/includes/header.php'; 
require_once 'config/conexion.php';

$database = new Conexion();
$db = $database->getConnection();

// Conteo de registros con manejo defensivo por si la BD aún no tiene datos
$totalEstudiantes = 0;
$totalCursos = 0;
$totalMatriculas = 0;

try {
    $totalEstudiantes = $db->query("SELECT COUNT(*) FROM estudiantes")->fetchColumn() ?: 0;
    $totalCursos = $db->query("SELECT COUNT(*) FROM cursos")->fetchColumn() ?: 0;
    $totalMatriculas = $db->query("SELECT COUNT(*) FROM matricula WHERE estado = 'activo'")->fetchColumn() ?: 0;
} catch (PDOException $e) {
    // Evita que la página colapse si alguna tabla aún no ha sido creada en phpMyAdmin
}
?>

<div class="max-w-6xl mx-auto mt-8 p-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Sistema de Control de Matrículas</h1>

    <!-- Tarjetas de Resumen -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-600 text-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium">Estudiantes Registrados</h3>
            <p class="text-4xl font-bold mt-2"><?= $totalEstudiantes ?></p>
            <a href="views/estudiantes/listar.php" class="inline-block mt-4 text-blue-100 hover:underline">Ver listado &rarr;</a>
        </div>

        <div class="bg-emerald-600 text-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium">Cursos Activos</h3>
            <p class="text-4xl font-bold mt-2"><?= $totalCursos ?></p>
            <a href="views/cursos/agregar.php" class="inline-block mt-4 text-emerald-100 hover:underline">Gestionar cursos &rarr;</a>
        </div>

        <div class="bg-purple-600 text-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium">Matrículas Activas</h3>
            <p class="text-4xl font-bold mt-2"><?= $totalMatriculas ?></p>
            <a href="views/matriculas/agregar.php" class="inline-block mt-4 text-purple-100 hover:underline">Nueva matrícula &rarr;</a>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h2 class="text-xl font-bold mb-4 text-gray-700">Acciones Rápidas</h2>
        <div class="flex flex-wrap gap-4">
            <a href="views/estudiantes/agregar.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                + Registrar Estudiante
            </a>
            <a href="views/cursos/agregar.php" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded">
                + Registrar Curso
            </a>
            <a href="views/matriculas/agregar.php" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded">
                + Matricular Estudiante
            </a>
        </div>
    </div>
</div>

<?php include_once 'views/includes/footer.php'; ?>