<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud de Tareas</title>
    <!-- Vinculación del CSS compilado -->
    <link rel="stylesheet" href="./assets/css/output.css">
    <!-- Carga de Tailwind CSS inmediata -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Iconos Phosphor -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col justify-between font-sans">

    <!-- Header / Encabezado -->
    <header class="bg-slate-800/80 backdrop-blur-md border-b border-slate-700/50 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            
            <!-- Logo / Título -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-blue-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30">
                    <i class="ph-bold ph-check-square-offset text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold bg-gradient-to-r from-white via-slate-200 to-slate-400 bg-clip-text text-transparent">
                        TaskFlow
                    </h1>
                    <span class="text-xs text-indigo-400 font-medium">Panel de Gestión</span>
                </div>
            </div>

            <!-- Navegación -->
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="#" class="text-indigo-400 transition-colors">Inicio</a>
                <a href="#" class="text-slate-400 hover:text-white transition-colors">Tareas</a>
                <a href="#" class="text-slate-400 hover:text-white transition-colors">Proyectos</a>
            </nav>

            <!-- Botón de Acción -->
            <button class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-all shadow-md hover:shadow-indigo-500/20 active:scale-95">
                + Nueva Tarea
            </button>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="max-w-7xl mx-auto px-6 py-8 w-full flex-grow">