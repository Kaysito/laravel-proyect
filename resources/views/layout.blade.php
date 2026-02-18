<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSRF TOKEN (OBLIGATORIO PARA FETCH) --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard')</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    {{-- Google reCAPTCHA --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-4xl w-full text-center border border-slate-200 relative">

        {{-- Breadcrumb --}}
        @hasSection('breadcrumb')
            <nav class="flex mb-6 text-sm text-slate-500 justify-start" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}"
                           class="hover:text-indigo-600 transition-colors flex items-center">
                            <i class="fa-solid fa-house text-xs mr-2"></i>
                            Inicio
                        </a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right text-slate-300 text-xs"></i>
                    </li>
                    <li class="font-bold text-indigo-600" aria-current="page">
                        @yield('breadcrumb')
                    </li>
                </ol>
            </nav>
        @endif

        {{-- Contenido principal --}}
        @yield('content')
    </div>

    {{-- Spinner para submits --}}
    <script>
        document.addEventListener('submit', function (e) {
            const btn = e.target.querySelector('button[type="submit"]');
            if (btn) {
                btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Procesando...';
                btn.classList.add('opacity-75', 'cursor-not-allowed');
            }
        });
    </script>

    {{-- Uploadcare --}}
    <script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.full.min.js" charset="utf-8"></script>

    {{-- Scripts específicos de cada vista (DOM, Fetch, etc.) --}}
    @yield('scripts')

</body>
</html>
