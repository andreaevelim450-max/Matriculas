<?php
// Detecta la página actual para marcar el botón activo en el menú
$paginaActual = basename($_SERVER['PHP_SELF']);

// Definimos BASE_URL de forma segura si no existe
if (!defined('BASE_URL')) {
    define('BASE_URL', '/Matriculas/');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Matrículas</title>
    <!-- Estilos compilados de Tailwind CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/src/output.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col justify-between">

<header class="mx-auto w-full px-2 sm:px-6 lg:px-8 py-4">
    <nav class="bg-blue-600 rounded-lg shadow-md">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                
                <!-- Logo y Navegación -->
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex items-center">
                        <a href="<?= BASE_URL ?>index.php" class="text-white font-bold text-xl flex items-center gap-2">
                            🎓 <span class="hidden sm:inline">Sistema Matrículas</span>
                        </a>
                    </div>
                    
                    <div class="hidden sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <!-- Enlace Inicio / Panel -->
                            <a href="<?= BASE_URL ?>index.php"
                               class="px-3 py-2 rounded-md text-sm font-medium transition-colors <?= $paginaActual === 'index.php' ? 'bg-blue-800 text-white' : 'text-white hover:bg-blue-700' ?>">
                                Inicio
                            </a>

                            <!-- Enlace Estudiantes -->
                            <a href="<?= BASE_URL ?>views/estudiantes/listar.php"
                               class="px-3 py-2 rounded-md text-sm font-medium transition-colors <?= strpos($_SERVER['PHP_SELF'], 'estudiantes') !== false ? 'bg-blue-800 text-white' : 'text-white hover:bg-blue-700' ?>">
                                Estudiantes
                            </a>

                            <!-- Enlace Cursos -->
                            <a href="<?= BASE_URL ?>views/cursos/agregar.php"
                               class="px-3 py-2 rounded-md text-sm font-medium transition-colors <?= strpos($_SERVER['PHP_SELF'], 'cursos') !== false ? 'bg-blue-800 text-white' : 'text-white hover:bg-blue-700' ?>">
                                Cursos
                            </a>

                            <!-- Enlace Matrículas -->
                            <a href="<?= BASE_URL ?>views/matriculas/agregar.php"
                               class="px-3 py-2 rounded-md text-sm font-medium transition-colors <?= strpos($_SERVER['PHP_SELF'], 'matriculas') !== false ? 'bg-blue-800 text-white' : 'text-white hover:bg-blue-700' ?>">
                                Matrículas
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </nav>

    <!-- Banner Principal -->
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-4 bg-white rounded-lg shadow-md mt-4 border border-gray-200">
        <h1 class="uppercase text-2xl font-bold text-center text-gray-800">Sistema de Control de Matrículas</h1>
        <p class="text-center text-gray-600 mt-1">Gestión académica de estudiantes, cursos y asignaciones</p>
    </div>
</header>