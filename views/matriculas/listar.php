<?php 
include_once '../includes/header.php'; 
require_once '../../config/conexion.php';
require_once '../../models/Matricula.php';

$database = new Conexion();
$db = $database->getConnection();

// Consulta con JOINs para mostrar los nombres del estudiante y del curso
$query = "SELECT m.id, 
                 e.nombres, 
                 e.apellidos, 
                 c.nombre_curso, 
                 c.seccion, 
                 m.periodo_lectivo, 
                 m.fecha_matricula, 
                 m.estado 
          FROM matricula m
          INNER JOIN estudiantes e ON m.id_estudiante = e.id
          INNER JOIN cursos c ON m.id_curso = c.id
          ORDER BY m.id DESC";

$stmt = $db->prepare($query);
$stmt->execute();
?>

<div class="max-w-4xl mx-auto mt-6 p-4">
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold">Listado de Matrículas</h2>
        <a href="agregar.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nueva Matrícula</a>
    </div>

    <!-- Mensajes de alerta opcionales -->
    <?php if (isset($_GET['msj']) && $_GET['msj'] === 'eliminado'): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            Matrícula eliminada correctamente.
        </div>
    <?php endif; ?>

    <table class="w-full border-collapse border border-gray-200 shadow-sm">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="p-2 text-left">ID</th>
                <th class="p-2 text-left">Estudiante</th>
                <th class="p-2 text-left">Curso (Sección)</th>
                <th class="p-2 text-left">Periodo</th>
                <th class="p-2 text-left">Estado</th>
                <th class="p-2 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($stmt->rowCount() > 0): ?>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2"><?= $row['id'] ?></td>
                    <td class="p-2"><?= htmlspecialchars($row['nombres'] . ' ' . $row['apellidos']) ?></td>
                    <td class="p-2"><?= htmlspecialchars($row['nombre_curso'] . ' (' . $row['seccion'] . ')') ?></td>
                    <td class="p-2"><?= htmlspecialchars($row['periodo_lectivo']) ?></td>
                    <td class="p-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded <?= $row['estado'] === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                            <?= ucfirst($row['estado']) ?>
                        </span>
                    </td>
                    <td class="p-2 text-center space-x-2">
                        <a href="editar.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline">Editar</a>
                        <a href="../../controllers/eliminarMatricula.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar matrícula?')" class="text-red-600 hover:underline">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">No hay matrículas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include_once '../includes/footer.php'; ?>