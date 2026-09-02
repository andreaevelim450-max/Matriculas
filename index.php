<?php
require_once 'config/conexion.php';
require_once 'models/Producto.php';

$database = new Conexion();
$db = $database->getConexion();

$productoModel = new Producto($db);
$productos = $productoModel->obtenerTodos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Productos</title>
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Navbar superior (Naranja) -->
    <nav class="bg-amber-500 p-4 shadow-md">
        <div class="container mx-auto flex space-x-4">
            <a href="index.php" class="bg-slate-800 text-white px-4 py-2 rounded-md font-semibold text-sm">Productos</a>
        </div>
    </nav>

    <!-- Header central -->
    <header class="bg-gray-200 text-center py-8 shadow-inner my-6 container mx-auto rounded-lg">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-wide">CONTROL DE PRODUCTOS EN PHP</h1>
        <p class="text-gray-600 mt-2">Gestión de inventario de productos</p>
    </header>

    <!-- Contenido principal: Grid de 2 columnas -->
    <main class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 px-4 mb-10">
        
        <!-- Columna Izquierda: Formulario Agregar Producto -->
        <section class="bg-gray-200 p-6 rounded-lg shadow-sm">
            <h2 class="text-xl font-bold text-center mb-6 text-gray-800">AGREGAR PRODUCTO</h2>
            <form action="controllers/controllerProductos.php" method="POST" class="space-y-4">
                <input type="text" name="sku" placeholder="SKU / Código" required class="w-full p-3 rounded-md border border-gray-300 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500">
                
                <input type="text" name="nombre" placeholder="Nombre del producto" required class="w-full p-3 rounded-md border border-gray-300 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500">
                
                <input type="number" step="0.01" name="precio" placeholder="Precio ($)" required class="w-full p-3 rounded-md border border-gray-300 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500">
                
                <input type="text" name="proveedor" placeholder="Nombre del Proveedor" required class="w-full p-3 rounded-md border border-gray-300 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500">

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
                            <p class="text-sm text-gray-600 mt-2">Proveedor: <span class="font-medium text-gray-800"><?= htmlspecialchars($prod['proveedor'] ?? 'N/A') ?></span></p>
                            <p class="text-md font-semibold text-gray-900 mt-1">Precio: $<?= number_format($prod['precio'], 2) ?></p>

                            <!-- Botones de Acción -->
                            <div class="flex space-x-3 mt-4">
                                <a href="views/productos/editar.php?id=<?= $prod['id'] ?>" class="w-1/2 bg-amber-500 text-white text-center font-bold py-2 rounded-md hover:bg-amber-600 text-sm transition">Editar</a>
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

</body>
</html>