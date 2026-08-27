<?php 
include_once '../includes/header.php'; 
require_once '../../config/conexion.php';
require_once '../../models/Estudiante.php';

$database = new Conexion();
$db = $database->getConnection();
$estudianteModel = new Estudiante($db);
$stmt = $estudianteModel->listar();
?>

<div class="max-w-4xl mx-auto mt-6 p-4">
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold">Listado de Estudiantes</h2>
        <a href="agregar.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nuevo Estudiante</a>
    </div>

    <table class="w-full border-collapse border border-gray-200 shadow-sm">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="p-2 text-left">ID</th>
                <th class="p-2 text-left">Nombres</th>
                <th class="p-2 text-left">Apellidos</th>
                <th class="p-2 text-left">Teléfono</th>
                <th class="p-2 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr class="border-b hover:bg-gray-50">
                <td class="p-2"><?= $row['id'] ?></td>
                <td class="p-2"><?= htmlspecialchars($row['nombres']) ?></td>
                <td class="p-2"><?= htmlspecialchars($row['apellidos']) ?></td>
                <td class="p-2"><?= htmlspecialchars($row['telefono']) ?></td>
                <td class="p-2 text-center space-x-2">
                    <a href="editar.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline">Editar</a>
                    <a href="../../controllers/eliminarEstudiantes.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar estudiante?')" class="text-red-600 hover:underline">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include_once '../includes/footer.php'; ?>