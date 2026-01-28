<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Validación</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    {{-- UPLOADCARE --}}
    <script>
        UPLOADCARE_PUBLIC_KEY = "b3a3c1bece70d9761e6b";
    </script>
    <script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.full.min.js"></script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="bg-slate-100 h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full border border-slate-200">

    @hasSection('breadcrumb')
        <nav class="flex mb-6 text-sm text-slate-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2">
                <li>
                    <a href="{{ route('home') }}"
                       class="hover:text-indigo-600 flex items-center">
                        <i class="fa-solid fa-house text-xs mr-2"></i> Inicio
                    </a>
                </li>
                <li><i class="fa-solid fa-chevron-right text-slate-300 text-xs"></i></li>
                <li class="font-bold text-indigo-600">@yield('breadcrumb')</li>
            </ol>
        </nav>
    @endif

    @yield('content')
</div>

<script>
    document.addEventListener('submit', function (e) {
        const btn = e.target.querySelector('button[type="submit"]');
        if (btn) {
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Procesando...';
            btn.classList.add('opacity-75', 'cursor-not-allowed');
        }
    });
</script>

</body>
</html>
