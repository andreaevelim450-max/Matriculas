<?php
require_once "config/conexion.php";
require_once "models/Tarea.php";
require_once "models/Empleado.php";

$tareaModel    = new Tarea($conexion);
$empleadoModel = new Empleado  ($conexion);

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
                    <?php elseif ($_GET['status'] === 'error'): ?>
                        <div class="bg-red-100 text-red-800 text-center p-3 rounded-md mb-4">
                            Error: <?= htmlspecialchars($_GET['msg'] ?? 'No se pudo agregar la tarea') ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <form action="controllers/controllerTareas.php" method="POST" class="flex flex-col gap-4 max-w-sm mx-auto">
                    <input type="text" name="titulo" placeholder="Título de la tarea" class="border border-gray-300 rounded-md p-2">
                    <textarea name="descripcion" placeholder="Descripción" rows="3" class="border border-gray-300 rounded-md p-2"></textarea>
                    <input type="date" name="fecha_limite" class="border border-gray-300 rounded-md p-2">

               <!-- Select alimentado con los empleados ya registrados -->
<select name="id_empleado" id="id_empleado" required class="w-full border border-gray-300 rounded-md p-2 bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500">
    <option value="" disabled selected>-- Asignar a --</option>
    <?php if (!empty($empleados)): ?>
        <?php foreach ($empleados as $emp): ?>
            <option value="<?= (int) $emp['id'] ?>">
                <?= htmlspecialchars($emp['nombres'] . ' ' . $emp['apellidos']) ?>
            </option>
        <?php endforeach; ?>
    <?php else: ?>
        <option value="" disabled>No hay empleados cargados</option>
    <?php endif; ?>
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
                    <div class="bg-zinc-200 backdrop-blur-xl shadow-lg p-4 w-full">
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
                                    <a href="controllers/eliminarTarea.php?id=<?= (int) $tarea['id'] ?>"
                                       class="flex-1 bg-red-500 hover:bg-red-600 text-white text-sm font-bold py-1 px-3 rounded-md text-center">
                                        Eliminar
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </main>

    <?php include_once "views/includes/footer.php"; ?>
</body>
</html>