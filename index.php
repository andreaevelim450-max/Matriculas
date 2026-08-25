<?php
require_once "config/conexion.php";
require_once "models/Tarea.php";
require_once "models/Empleado.php";

$tareaModel    = new Tarea($conexion);
$empleadoModel = new Empleado($conexion);

$tareas    = $tareaModel->obtenerTodas();
$empleados = $empleadoModel->obtenerTodos();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crud de Tareas</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/src/output.css">
</head>
<body>
    <?php include_once "views/includes/header.php"; ?>

    <main class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-4 hws">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">

            <!-- Columna izquierda: formulario -->
            <div class="bg-zinc-200 backdrop:blur-xl shadow-lg p-4 w-full">
                <h2 class="uppercase text-xl font-bold text-center py-4">Agregar Tarea</h2>

                <!-- mensajes de éxito / error -->
                <?php if (isset($_GET['status'])): ?>
                    <?php if ($_GET['status'] === 'success'): ?>
                        <div class="bg-green-100 text-green-800 text-center p-3 rounded-md mb-4">Tarea agregada correctamente.</div>
                    <?php elseif ($_GET['status'] === 'updated'): ?>
                        <div class="bg-green-100 text-green-800 text-center p-3 rounded-md mb-4">Tarea actualizada correctamente.</div>
                    <?php elseif ($_GET['status'] === 'deleted'): ?>
                        <div class="bg-green-100 text-green-800 text-center p-3 rounded-md mb-4">Tarea eliminada correctamente.</div>
                    <?php elseif ($_GET['status'] === 'error'): ?>
                        <div class="bg-red-100 text-red-800 text-center p-3 rounded-md mb-4">
                            Error: <?= htmlspecialchars($_GET['msg'] ?? 'No se pudo procesar la solicitud') ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <form action="controllers/controllerTareas.php" method="POST" class="flex flex-col gap-4 max-w-sm mx-auto">
                    <input type="text" name="titulo" placeholder="Título de la tarea" class="border border-gray-300 rounded-md p-2">
                    <textarea name="descripcion" placeholder="Descripción" rows="3" class="border border-gray-300 rounded-md p-2"></textarea>
                    <input type="date" name="fecha_limite" class="border border-gray-300 rounded-md p-2">

                    <!-- Select alimentado con los empleados ya registrados -->
                    <select name="id_empleado" class="border border-gray-300 rounded-md p-2">
                        <option value="">-- Asignar a --</option>
                        <?php foreach ($empleados as $emp): ?>
                            <option value="<?= (int) $emp['id'] ?>">
                                <?= htmlspecialchars($emp['nombres'] . ' ' . $emp['apellidos']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <select name="estado" class="border border-gray-300 rounded-md p-2">
                        <option value="pendiente">Pendiente</option>
                        <option value="en_progreso">En progreso</option>
                        <option value="completada">Completada</option>
                    </select>

                    <button type="submit" class="bg-amber-500 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded-xl">
                        Agregar Tarea
                    </button>
                </form>
            </div>

            <!-- Columna derecha: listado -->
            <div class="bg-zinc-200 backdrop:blur-xl shadow-lg p-4 w-full">
                <h2 class="uppercase text-xl font-bold text-center py-4">Tareas registradas</h2>

                <?php if (empty($tareas)): ?>
                    <p class="text-center text-gray-500 py-6">Aún no hay tareas registradas.</p>
                <?php else: ?>
                    <div class="flex flex-col gap-3 max-h-[700px] overflow-y-auto pr-1">
                        <?php foreach ($tareas as $tarea): ?>
                            <?php
                                // match elige un set de clases de color según el estado de la tarea
                                $colorEstado = match ($tarea['estado']) {
                                    'completada'  => 'bg-green-100 text-green-800',
                                    'en_progreso' => 'bg-blue-100 text-blue-800',
                                    default       => 'bg-yellow-100 text-yellow-800',
                                };
                            ?>
                            <div class="bg-white rounded-xl shadow p-3">
                                <div class="flex items-start justify-between gap-2">
                                    <p class="font-bold"><?= htmlspecialchars($tarea['titulo']) ?></p>
                                    <span class="text-xs font-medium px-2 py-1 rounded-full <?= $colorEstado ?>">
                                        <?= htmlspecialchars(str_replace('_', ' ', $tarea['estado'])) ?>
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($tarea['descripcion'] ?? '') ?></p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Asignada a: <?= htmlspecialchars($tarea['nombres'] . ' ' . $tarea['apellidos']) ?>
                                </p>
                                <?php if (!empty($tarea['fecha_limite'])): ?>
                                    <p class="text-sm text-gray-500">Fecha límite: <?= htmlspecialchars($tarea['fecha_limite']) ?></p>
                                <?php endif; ?>

                                <div class="flex gap-2 mt-3">
                                    <a href="views/tareas/editar.php?id=<?= (int) $tarea['id'] ?>"
                                       class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-bold py-1 px-3 rounded-md text-center">
                                        Editar
                                    </a>
                                    <button type="button"
                                            onclick="abrirModalEliminarTarea(<?= (int) $tarea['id'] ?>, '<?= htmlspecialchars($tarea['titulo'], ENT_QUOTES) ?>')"
                                            class="flex-1 bg-red-500 hover:bg-red-600 text-white text-sm font-bold py-1 px-3 rounded-md text-center cursor-pointer">
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </main>

    <!-- Modal para confirmar eliminación -->
    <div id="modalEliminarTarea" class="hidden fixed inset-0 bg-black/50 items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg p-6 max-w-sm w-full mx-4">
            <h3 class="text-lg font-bold text-center mb-2">¿Eliminar tarea?</h3>
            <p class="text-center text-gray-600 mb-6">
                Estás a punto de eliminar <span id="tituloTareaEliminar" class="font-bold"></span>.
                Esta acción no se puede deshacer.
            </p>
            <div class="flex gap-3">
                <button type="button" onclick="cerrarModalEliminarTarea()"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-xl cursor-pointer">
                    Cancelar
                </button>
                <a id="linkConfirmarEliminarTarea" href="#"
                   class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-xl text-center">
                    Sí, eliminar
                </a>
            </div>
        </div>
    </div>

    <script>
        function abrirModalEliminarTarea(id, titulo) {
            document.getElementById('tituloTareaEliminar').textContent = titulo;
            document.getElementById('linkConfirmarEliminarTarea').href =
                'controllers/eliminarTarea.php?id=' + id;

            const modal = document.getElementById('modalEliminarTarea');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function cerrarModalEliminarTarea() {
            const modal = document.getElementById('modalEliminarTarea');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.getElementById('modalEliminarTarea').addEventListener('click', function (e) {
            if (e.target === this) cerrarModalEliminarTarea();
        });
    </script>

    <?php include_once "views/includes/footer.php"; ?>
</body>
</html>