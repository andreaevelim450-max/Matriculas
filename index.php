<?php
require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/models/Producto.php';

// Cargar lista de proveedores para el formulario de la izquierda
if (file_exists(__DIR__ . '/models/proveedor.php')) {
    require_once __DIR__ . '/models/proveedor.php';
} elseif (file_exists(__DIR__ . '/models/Proveedor.php')) {
    require_once __DIR__ . '/models/Proveedor.php';
}

$database = new Conexion();
$db = $database->getConexion();

$productoModel = new Producto($db);
$productos = $productoModel->obtenerTodos();

// Obtener proveedores para el select
$proveedores = [];
if (class_exists('Proveedor')) {
    $proveedorModel = new Proveedor($db);
    $proveedores = $proveedorModel->obtenerTodos();
} else {
    $stmtProv = $db->query("SELECT * FROM proveedores ORDER BY id DESC");
    $proveedores = $stmtProv->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Productos</title>
    <!-- Tailwind CSS CDN para garantizar el diseño gráfico -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Navbar superior -->
    <nav class="bg-amber-500 p-4 shadow-md w-full">
        <div class="container mx-auto flex space-x-4">
            <a href="index.php" class="bg-slate-800 text-white px-4 py-2 rounded-md font-semibold text-sm">Productos</a>
            <a href="views/proveedores.php" class="bg-slate-700 text-white px-4 py-2 rounded-md font-semibold text-sm hover:bg-slate-800 transition">Proveedores</a>
        </div>
    </nav>

    <!-- Header central -->
    <header class="bg-gray-200 text-center py-8 shadow-inner my-6 container mx-auto rounded-lg border-b-4 border-amber-500">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-wide">CONTROL DE PRODUCTOS EN PHP</h1>
        <p class="text-gray-600 mt-2">Gestión de inventario de productos</p>
    </header>

    <!-- Contenido principal -->
    <main class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 px-4 mb-10 flex-grow">
        
        <!-- Columna Izquierda: Formulario Agregar Producto -->
        <section class="bg-gray-200 p-6 rounded-lg shadow-sm">
            <h2 class="text-xl font-bold text-center mb-6 text-gray-800">AGREGAR PRODUCTO</h2>
            <form action="controllers/controllerProductos.php" method="POST" class="space-y-4">
                <input type="text" name="sku" placeholder="SKU / Código" required class="w-full p-3 rounded-md border border-gray-300 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500">
                
                <input type="text" name="nombre" placeholder="Nombre del producto" required class="w-full p-3 rounded-md border border-gray-300 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500">
                
                <input type="number" step="0.01" name="precio" placeholder="Precio ($)" required class="w-full p-3 rounded-md border border-gray-300 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500">
                
                <!-- Desplegable dinámico de Proveedores -->
                <select name="proveedor_id" required class="w-full p-3 rounded-md border border-gray-300 bg-gray-100 text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="">Seleccione un Proveedor</option>
                    <?php if(!empty($proveedores)): ?>
                        <?php foreach($proveedores as $prov): ?>
                            <option value="<?= $prov['id'] ?>">
                                <?= htmlspecialchars($prov['nombre_empresa'] ?? $prov['nombre'] ?? 'Proveedor #' . $prov['id']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">No hay proveedores guardados</option>
                    <?php endif; ?>
                </select>

                <input type="number" name="stock" placeholder="Stock disponible" required class="w-full p-3 rounded-md border border-gray-300 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500">

                <button type="submit" class="w-full bg-amber-500 text-white font-bold py-3 rounded-md hover:bg-amber-600 transition">Guardar Producto</button>
            </form>
        </section>

        <!-- Columna Derecha: Tarjetas de Productos -->
        <section class="bg-gray-200 p-6 rounded-lg shadow-sm">
            <h2 class="text-xl font-bold text-center mb-6 text-gray-800">PRODUCTOS REGISTRADOS</h2>
            <div class="space-y-4">
                <?php if(!empty($productos)): ?>
                    <?php foreach($productos as $prod): ?>
                        <div class="bg-white p-5 rounded-xl shadow-md relative">
                            <!-- Badge de Estado / Stock -->
                            <span class="absolute top-4 right-4 bg-amber-100 text-amber-800 text-xs font-semibold px-3 py-1 rounded-full">
                                Stock: <?= $prod['stock'] ?>
                            </span>

                            <h3 class="text-lg font-bold text-gray-800"><?= htmlspecialchars($prod['nombre']) ?></h3>
                            <p class="text-sm text-gray-500">SKU: <?= htmlspecialchars($prod['sku']) ?></p>
                            <p class="text-sm text-gray-600 mt-2">Proveedor: <span class="font-medium text-gray-800"><?= htmlspecialchars($prod['proveedor_nombre'] ?? $prod['proveedor'] ?? 'N/A') ?></span></p>
                            <p class="text-md font-semibold text-gray-900 mt-1">Precio: $<?= number_format($prod['precio'], 2) ?></p>

                            <!-- Botones de Acción -->
                            <div class="flex space-x-3 mt-4">
                                <a href="views/Productos/editar.php?id=<?= $prod['id'] ?>" class="w-1/2 bg-amber-500 text-white text-center font-bold py-2 rounded-md hover:bg-amber-600 text-sm transition">Editar</a>
                                <a href="controllers/eliminarProducto.php?id=<?= $prod['id'] ?>" onclick="return confirm('¿Eliminar producto?')" class="w-1/2 bg-red-600 text-white text-center font-bold py-2 rounded-md hover:bg-red-700 text-sm transition">Eliminar</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-gray-500">No hay productos registrados.</p>
                <?php endif; ?>
            </div>
        </section>

    </main>

    <footer class="bg-gray-100 text-center py-4 text-sm text-gray-600 border-t border-gray-200 mt-auto">
        <p>&copy; 2026 Control de Productos y Proveedores</p>
    </footer>
</body>
</html>