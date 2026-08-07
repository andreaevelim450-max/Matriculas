<?php
include_once "config/conexion.php";
include_once "views/header.php";

// Lógica para ELIMINAR UNA TAREA INDIVIDUAL
if (isset($_GET['eliminar_id'])) {
    $id_eliminar = intval($_GET['eliminar_id']);
    $stmt = $conexion->prepare("DELETE FROM tareas WHERE id = ?");
    $stmt->bind_param("i", $id_eliminar);
    $stmt->execute();
    $stmt->close();

    echo "<script>window.location.href='index.php';</script>";
    exit;
}

// Lógica para VACIAR / BORRAR TODAS LAS TAREAS
if (isset($_POST['vaciar_todas'])) {
    $conexion->query("TRUNCATE TABLE tareas");
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

// Lógica para REGISTRAR TAREA
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar_tarea'])) {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $prioridad = $_POST['prioridad'];
    $fecha_limite = !empty($_POST['fecha_limite']) ? $_POST['fecha_limite'] : NULL;

    if (!empty($titulo)) {
        $stmt = $conexion->prepare("INSERT INTO tareas (titulo, descripcion, prioridad, fecha_limite) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $titulo, $descripcion, $prioridad, $fecha_limite);
        $stmt->execute();
        $stmt->close();
        
        echo "<script>window.location.href='index.php';</script>";
        exit;
    }
}

// Obtener registros
$resultado = $conexion->query("SELECT * FROM tareas ORDER BY id DESC");
?>

<div class="space-y-10">
    <!-- Formulario de Registro -->
    <div id="form-registro" class="gradient-border p-8 shadow-2xl backdrop-blur-sm">
        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
            <i class="ph-bold ph-plus-circle text-indigo-400 text-3xl"></i> Registrar Nueva Tarea
        </h2>
        <form action="index.php" method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">Título de la Tarea *</label>
                    <input type="text" name="titulo" required placeholder="Ej. Diseñar prototipo de la app" 
                           class="w-full bg-slate-900/80 border border-slate-700/80 rounded-xl px-5 py-3 text-sm text-slate-100 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all placeholder:text-slate-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">Fecha Límite</label>
                    <input type="date" name="fecha_limite" 
                           class="w-full bg-slate-900/80 border border-slate-700/80 rounded-xl px-5 py-3 text-sm text-slate-100 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">Prioridad</label>
                    <select name="prioridad" class="w-full bg-slate-900/80 border border-slate-700/80 rounded-xl px-5 py-3 text-sm text-slate-100 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all appearance-none">
                        <option value="baja" class="bg-slate-900">Baja</option>
                        <option value="media" selected class="bg-slate-900">Media</option>
                        <option value="alta" class="bg-slate-900">Alta</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wider">Descripción</label>
                    <input type="text" name="descripcion" placeholder="Detalles o contexto de la tarea..." 
                           class="w-full bg-slate-900/80 border border-slate-700/80 rounded-xl px-5 py-3 text-sm text-slate-100 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all placeholder:text-slate-600">
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" name="guardar_tarea" 
                        class="bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-500 hover:to-indigo-400 text-white font-bold text-sm px-8 py-3 rounded-xl transition-all shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/50 active:scale-95 flex items-center gap-2">
                    <i class="ph-bold ph-floppy-disk text-base"></i> Guardar Tarea
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de Tareas -->
    <div id="listado-tareas" class="gradient-border p-8 shadow-2xl backdrop-blur-sm">
        
        <!-- Encabezado con Botón de Borrar Todas -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                <i class="ph-bold ph-list-checks text-indigo-400 text-3xl"></i> Listado de Tareas
            </h2>
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <form action="index.php" method="POST" onsubmit="return confirm('¿⚠️ Estás seguro de BORRAR TODAS las tareas? Esta acción no se puede deshacer.');">
                    <button type="submit" name="vaciar_todas" class="bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white border border-red-500/30 font-bold text-xs px-4 py-2 rounded-xl transition-all flex items-center gap-2">
                        <i class="ph-bold ph-trash-simple text-sm"></i> Borrar Todas
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-100">
                <thead class="text-xs uppercase text-slate-400 border-b border-slate-700/80">
                    <tr>
                        <th class="p-4 font-bold tracking-wider">ID</th>
                        <th class="p-4 font-bold tracking-wider">Título</th>
                        <th class="p-4 font-bold tracking-wider">Descripción</th>
                        <th class="p-4 font-bold tracking-wider">Prioridad</th>
                        <th class="p-4 font-bold tracking-wider">Estado</th>
                        <th class="p-4 font-bold tracking-wider">Fecha Límite</th>
                        <th class="p-4 font-bold tracking-wider text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    <?php if ($resultado && $resultado->num_rows > 0): ?>
                        <?php while ($row = $resultado->fetch_assoc()): ?>
                            <tr class="hover:bg-slate-700/20 transition-colors duration-200">
                                <td class="p-4 font-mono text-xs text-indigo-300">#<?= $row['id'] ?></td>
                                <td class="p-4 font-semibold text-white"><?= htmlspecialchars($row['titulo']) ?></td>
                                <td class="p-4 text-slate-400"><?= htmlspecialchars($row['descripcion'] ?? 'Sin descripción') ?></td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 text-xs rounded-lg font-bold uppercase tracking-wider 
                                        <?= $row['prioridad'] == 'alta' ? 'bg-red-500/15 text-red-400 border border-red-500/30' : ($row['prioridad'] == 'media' ? 'bg-amber-500/15 text-amber-400 border border-amber-500/30' : 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30') ?>">
                                        <?= ucfirst($row['prioridad']) ?>
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 text-xs rounded-lg font-bold uppercase tracking-wider bg-slate-700/50 text-slate-300 border border-slate-600/50">
                                        <?= ucfirst($row['estado']) ?>
                                    </span>
                                </td>
                                <td class="p-4 text-xs font-medium text-slate-300"><?= $row['fecha_limite'] ?? 'N/A' ?></td>
                                <td class="p-4 text-center">
                                    <a href="index.php?eliminar_id=<?= $row['id'] ?>" 
                                       onclick="return confirm('¿Estás seguro de que deseas borrar esta tarea?');" 
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all duration-200"
                                       title="Eliminar tarea">
                                        <i class="ph-bold ph-trash text-base"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="p-10 text-center text-slate-500 font-medium">No hay tareas registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once "views/footer.php"; ?>