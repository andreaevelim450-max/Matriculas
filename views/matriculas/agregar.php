<?php 
include_once '../includes/header.php'; 
require_once '../../config/conexion.php';
require_once '../../models/Estudiante.php';
require_once '../../models/Curso.php';

$database = new Conexion();
$db = $database->getConnection();

$estudianteModel = new Estudiante($db);
$listadoEstudiantes = $estudianteModel->listar();

$cursoModel = new Curso($db);
$listadoCursos = $cursoModel->listar();
?>

<div class="flex justify-center items-center py-8">
    <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-100 w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-900">Registrar Matrícula</h2>

        <?php if (isset($_GET['msj']) && $_GET['msj'] === 'duplicado'): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                El estudiante ya está matriculado en este curso para el periodo seleccionado.
            </div>
        <?php elseif (isset($_GET['msj']) && $_GET['msj'] === 'registrado'): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                ¡Matrícula registrada exitosamente!
            </div>
        <?php endif; ?>

        <form action="../../controllers/controllerMatriculas.php" method="POST" class="space-y-4">
            <input type="hidden" name="accion" value="guardar">

            <div>
                <label class="block text-sm font-bold text-gray-800 mb-1">Estudiante:</label>
                <select name="id_estudiante" required class="w-full border border-gray-400 rounded-md p-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccione un estudiante</option>
                    <?php while ($e = $listadoEstudiantes->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nombres'] . ' ' . $e['apellidos']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-800 mb-1">Curso:</label>
                <select name="id_curso" required class="w-full border border-gray-400 rounded-md p-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccione un curso</option>
                    <?php while ($c = $listadoCursos->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre_curso'] . ' (' . $c['seccion'] . ')') ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-800 mb-1">Periodo Lectivo:</label>
                <input type="text" name="periodo_lectivo" placeholder="Ej. 2026-1" value="2026-1" maxlength="9" required class="w-full border border-gray-400 rounded-md p-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-800 mb-1">Fecha de Matrícula:</label>
                <input type="date" name="fecha_matricula" value="<?= date('Y-m-d') ?>" required class="w-full border border-gray-400 rounded-md p-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-800 mb-1">Estado:</label>
                <select name="estado" class="w-full border border-gray-400 rounded-md p-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="activo">Activo</option>
                    <option value="retirado">Retirado</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-md transition-colors mt-2">
                Guardar Matrícula
            </button>
        </form>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>