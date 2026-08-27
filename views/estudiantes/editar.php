<?php 
include_once '../includes/header.php'; 
require_once '../../config/conexion.php';
require_once '../../models/Estudiante.php';

$database = new Conexion();
$db = $database->getConnection();
$estudianteModel = new Estudiante($db);

$data = $estudianteModel->obtenerPorId($_GET['id'] ?? 0);
?>

<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md mt-6">
    <h2 class="text-xl font-bold mb-4">Editar Estudiante</h2>
    
    <form action="../../controllers/actualizarEstudiantes.php" method="POST" class="space-y-4">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <div>
            <label class="block text-sm font-medium">Nombres:</label>
            <input type="text" name="nombres" value="<?= htmlspecialchars($data['nombres']) ?>" required class="w-full border rounded p-2">
        </div>
        
        <div>
            <label class="block text-sm font-medium">Apellidos:</label>
            <input type="text" name="apellidos" value="<?= htmlspecialchars($data['apellidos']) ?>" class="w-full border rounded p-2">
        </div>
        
        <div>
            <label class="block text-sm font-medium">Teléfono:</label>
            <input type="text" name="telefono" value="<?= htmlspecialchars($data['telefono']) ?>" class="w-full border rounded p-2">
        </div>

        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Actualizar</button>
    </form>
</div>

<?php include_once '../includes/footer.php'; ?>