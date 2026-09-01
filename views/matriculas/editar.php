<?php 
include_once '../includes/header.php'; 
require_once '../../config/conexion.php';
require_once '../../models/Estudiante.php';
require_once '../../models/Curso.php';

$database = new Conexion();
$db = $database->getConnection();

// Cargar listas para los select
$estudianteModel = new Estudiante($db);
$listadoEstudiantes = $estudianteModel->listar();

$cursoModel = new Curso($db);
$listadoCursos = $cursoModel->listar();

// Obtener datos de la matrícula actual mediante ID
$id_matricula = $_GET['id'] ?? null;

if ($id_matricula) {
    $stmt = $db->prepare("SELECT * FROM matricula WHERE id = :id");
    $stmt->bindParam(':id', $id_matricula);
    $stmt->execute();
    $matriculaActual = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="flex justify-center items-center py-8">
    <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-100 w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-900">Editar Matrícula</h2>

        <?php if (!$matriculaActual): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm text-center">
                Matrícula no encontrada.
            </div>
        <?php else: ?>

            <form action="../../controllers/controllerMatriculas.php" method="POST" class="space-y-4">
                <input type="hidden" name="accion" value="actualizar">
                <input type="hidden" name="id" value="<?= $matriculaActual['id'] ?>">

                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-1">Estudiante:</label>
                    <select name="id_estudiante" required class="w-full border border-gray-400 rounded-md p-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php while ($e = $listadoEstudiantes->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?= $e['id'] ?>" <?= ($e['id'] == $matriculaActual['id_estudiante']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($e['nombres'] . ' ' . $e['apellidos']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-1">Curso:</label>
                    <select name="id_curso" required class="w-full border border-gray-400 rounded-md p-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php while ($c = $listadoCursos->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?= $c['id'] ?>" <?= ($c['id'] == $matriculaActual['id_curso']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['nombre_curso'] . ' (' . $c['seccion'] . ')') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-1">Periodo Lectivo:</label>
                    <input type="text" name="periodo_lectivo" value="<?= htmlspecialchars($matriculaActual['periodo_lectivo']) ?>" maxlength="9" required class="w-full border border-gray-400 rounded-md p-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-1">Fecha de Matrícula:</label>
                    <input type="date" name="fecha_matricula" value="<?= $matriculaActual['fecha_matricula'] ?>" required class="w-full border border-gray-400 rounded-md p-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-1">Estado:</label>
                    <select name="estado" class="w-full border border-gray-400 rounded-md p-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="activo" <?= ($matriculaActual['estado'] === 'activo') ? 'selected' : '' ?>>Activo</option>
                        <option value="retirado" <?= ($matriculaActual['estado'] === 'retirado') ? 'selected' : '' ?>>Retirado</option>
                    </select>
                </div>

                <div class="flex space-x-3 pt-2">
                    <a href="../index.php" class="w-1/2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-center py-2.5 rounded-md font-semibold text-sm transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-md transition-colors text-sm">
                        Actualizar
                    </button>
                </div>
            </form>

        <?php endif; ?>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>