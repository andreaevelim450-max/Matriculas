<?php include_once '../includes/header.php'; ?>

<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md mt-6">
    <h2 class="text-xl font-bold mb-4">Registrar Curso</h2>
    
    <form action="../../controllers/controllerCursos.php" method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Nombre del Curso:</label>
            <input type="text" name="nombre_curso" required class="w-full border rounded p-2 focus:ring focus:ring-blue-300">
        </div>
        
        <div>
            <label class="block text-sm font-medium">Sección:</label>
            <input type="text" name="seccion" class="w-full border rounded p-2 focus:ring focus:ring-blue-300">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Guardar Curso</button>
    </form>
</div>

<?php include_once '../includes/footer.php'; ?>