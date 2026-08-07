<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow Pro - Gestión de Tareas</title>
    <link rel="stylesheet" href="./assets/css/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        .gradient-border {
            position: relative;
            border-radius: 1rem;
            background: rgba(30, 41, 59, 0.6);
        }
        .gradient-border::before {
            content: '';
            position: absolute;
            top: -1px; left: -1px; right: -1px; bottom: -1px;
            border-radius: 1rem;
            padding: 1px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.5), rgba(168, 85, 247, 0.3), rgba(251, 191, 36, 0.2));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: destination-out;
            mask-composite: exclude;
            pointer-events: none;
        }
        .glow-hover:hover {
            box-shadow: 0 0 20px 2px rgba(99, 102, 241, 0.3);
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col justify-between font-sans">

    <!-- Modal de Proyectos -->
    <div id="modal-proyectos" class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4">
        <div class="gradient-border max-w-lg w-full p-6 shadow-2xl space-y-5">
            <div class="flex justify-between items-center border-b border-slate-700/60 pb-3">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="ph-bold ph-folder-open text-indigo-400"></i> Gestión de Proyectos
                </h3>
                <button onclick="cerrarModal('modal-proyectos')" class="text-slate-400 hover:text-white text-xl">
                    <i class="ph-bold ph-x"></i>
                </button>
            </div>
            <p class="text-sm text-slate-300">Selecciona un módulo de trabajo para filtrar la vista actual:</p>
            <div class="grid grid-cols-1 gap-3">
                <button onclick="cerrarModal('modal-proyectos')" class="p-3 bg-slate-800/80 hover:bg-indigo-600/20 border border-slate-700 hover:border-indigo-500/50 rounded-xl text-left flex items-center justify-between group transition-all">
                    <div>
                        <p class="font-semibold text-white text-sm">Desarrollo Web Pro</p>
                        <p class="text-xs text-slate-400">Panel principal de desarrollo</p>
                    </div>
                    <span class="text-xs bg-indigo-500/20 text-indigo-300 px-2.5 py-1 rounded-md font-bold">Activo</span>
                </button>
                <button onclick="cerrarModal('modal-proyectos')" class="p-3 bg-slate-800/80 hover:bg-indigo-600/20 border border-slate-700 hover:border-indigo-500/50 rounded-xl text-left flex items-center justify-between group transition-all">
                    <div>
                        <p class="font-semibold text-white text-sm">Diseño de Interfaces UI/UX</p>
                        <p class="text-xs text-slate-400">Maquetación y componentes</p>
                    </div>
                    <span class="text-xs bg-slate-700 text-slate-300 px-2.5 py-1 rounded-md font-bold">General</span>
                </button>
            </div>
            <div class="flex justify-end pt-2">
                <button onclick="cerrarModal('modal-proyectos')" class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition-all">
                    Aceptar
                </button>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-slate-900/70 backdrop-blur-lg border-b border-slate-700/50 sticky top-0 z-40 shadow-lg shadow-black/20">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            
            <a href="index.php" class="flex items-center gap-3.5 group">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-amber-400 flex items-center justify-center text-white shadow-xl shadow-indigo-600/30 group-hover:scale-105 transition-all duration-300">
                    <i class="ph-bold ph-check-square-offset text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold bg-gradient-to-r from-white via-slate-200 to-slate-400 bg-clip-text text-transparent tracking-tight">
                        TaskFlow<span class="text-indigo-400">Pro</span>
                    </h1>
                    <span class="text-xs text-indigo-300 font-medium tracking-wide">Panel de Gestión</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-7 text-sm font-semibold tracking-wide">
                <a href="index.php" class="text-white hover:text-indigo-300 transition-all flex items-center gap-2 glow-hover px-3 py-1.5 rounded-lg">
                    <i class="ph-bold ph-house text-base"></i> Inicio
                </a>
                <a href="#listado-tareas" class="text-slate-300 hover:text-white transition-all flex items-center gap-2 px-3 py-1.5 rounded-lg">
                    <i class="ph-bold ph-list-checks text-base"></i> Tareas
                </a>
                <button onclick="abrirModal('modal-proyectos')" class="text-slate-300 hover:text-white transition-all flex items-center gap-2 px-3 py-1.5 rounded-lg">
                    <i class="ph-bold ph-folder text-base"></i> Proyectos
                </button>
            </nav>

            <button onclick="document.getElementById('form-registro').scrollIntoView({ behavior: 'smooth' }); document.getElementsByName('titulo')[0].focus();" 
                    class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold px-6 py-2.5 rounded-xl transition-all shadow-xl shadow-indigo-600/30 hover:shadow-indigo-600/50 active:scale-95 flex items-center gap-2.5">
                <i class="ph-bold ph-plus text-base"></i> Nueva Tarea
            </button>
        </div>
    </header>

    <script>
        function abrirModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }
        function cerrarModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>

    <main class="max-w-7xl mx-auto px-6 py-10 w-full grow">