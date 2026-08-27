<?php
// Incluir la conexión a la base de datos y la constante BASE_URL
require_once __DIR__ . '/config/conexion.php';

// Consultar los empleados para cargar el menú desplegable (Select)
try {
    $stmtEmpleados = $conexion->query("SELECT id, nombres, apellidos FROM empleados ORDER BY nombres ASC");
    $listaEmpleados = $stmtEmpleados->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $listaEmpleados = [];
}
?>

<!-- Formulario para agregar tarea -->
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md border border-gray-200 mt-6">
    <h2 class="text-xl font-bold text-center text-gray-800 uppercase mb-6">Agregar Tarea</h2>

    <form action="<?= BASE_URL ?>/controllers/controllerTareas.php" method="POST" class="space-y-4">
        
        <!-- Título -->
        <div>
            <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título de la tarea</label>
            <input type="text" id="titulo" name="titulo" required
                   placeholder="Título de la tarea"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
        </div>

        <!-- Descripción -->
        <div>
            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="3"
                      placeholder="Descripción"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>
        </div>

        <!-- Fecha Límite -->
        <div>
            <label for="fecha_limite" class="block text-sm font-medium text-gray-700 mb-1">Fecha Límite</label>
            <input type="date" id="fecha_limite" name="fecha_limite" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
        </div>

        <!-- Asignar Empleado (id_empleado) -->
        <div>
            <label for="id_empleado" class="block text-sm font-medium text-gray-700 mb-1">Asignar a</label>
            <select id="id_empleado" name="id_empleado" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                <option value="" disabled selected>-- Asignar a --</option>
                <?php foreach ($listaEmpleados as $emp): ?>
                    <option value="<?= $emp['id'] ?>">
                        <?= htmlspecialchars($emp['nombres'] . ' ' . $emp['apellidos']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Estado (Enum: pendiente, en_progreso, completada) -->
        <div>
            <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
            <select id="estado" name="estado" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                <option value="pendiente" selected>Pendiente</option>
                <option value="en_progreso">En Progreso</option>
                <option value="completada">Completada</option>
            </select>
        </div>

        <!-- Botón Enviar -->
        <div>
            <button type="submit" name="btn_guardar_tarea"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-2.5 px-4 rounded-md transition duration-200 shadow">
                Agregar Tarea
            </button>
        </div>
    </form>
</div>