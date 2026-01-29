<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Control')</title>
    
    {{-- 1. Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- 2. Iconos FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- 3. Fuente "Inter" (Más limpia y profesional) --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- 4. Uploadcare (Tu herramienta de fotos) --}}
    <script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.full.min.js"></script>

    {{-- Configuración de Estilo Global --}}
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Personalización del widget de Uploadcare para que combine */
        .uploadcare--widget__button_type_open {
            background-color: #4f46e5 !important; /* Indigo-600 */
            color: white !important;
            border-radius: 0.5rem !important;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    {{-- BARRA SUPERIOR (Header) --}}
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            {{-- Logo / Título --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-xl text-indigo-600 hover:text-indigo-700 transition">
                <i class="fa-solid fa-layer-group"></i>
                <span>Mi Dashboard</span>
            </a>

            {{-- Menú Rápido --}}
            <nav class="flex gap-4">
                <a href="{{ route('home') }}" class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition">
                    Inicio
                </a>
                </nav>
        </div>
    </header>

    {{-- CONTENEDOR PRINCIPAL --}}
    <main class="flex-grow w-full max-w-4xl mx-auto px-4 sm:px-6 py-8">
        
        {{-- Breadcrumb (Navegación de migas de pan) --}}
        @hasSection('breadcrumb')
            <nav class="flex mb-6 text-sm text-slate-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2 bg-white px-4 py-2 rounded-full shadow-sm border border-slate-100">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors flex items-center">
                            <i class="fa-solid fa-house text-xs mr-2"></i> Inicio
                        </a>
                    </li>
                    <li><i class="fa-solid fa-chevron-right text-slate-300 text-[10px]"></i></li>
                    <li class="font-semibold text-indigo-600 truncate" aria-current="page">
                        @yield('breadcrumb')
                    </li>
                </ol>
            </nav>
        @endif

        {{-- TARJETA DE CONTENIDO --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sm:p-8">
            @yield('content')
        </div>

    </main>

    {{-- FOOTER SIMPLE --}}
    <footer class="bg-white border-t border-slate-200 py-6 mt-auto">
        <div class="text-center text-slate-400 text-xs">
            &copy; {{ date('Y') }} Sistema de Gestión. Hecho simple.
        </div>
    </footer>

    {{-- SCRIPTS DE FUNCIONALIDAD --}}
    <script>
        // Spinner automático en botones Submit
        document.addEventListener('submit', function(e) {
            const btn = e.target.querySelector('button[type="submit"]');
            if(btn && !btn.classList.contains('no-loading')) {
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin mr-2"></i> Procesando...';
                btn.classList.add('opacity-75', 'cursor-not-allowed');
                // Evita doble click
                setTimeout(() => { btn.disabled = true; }, 10);
            }
        });
    </script>
</body>
</html>