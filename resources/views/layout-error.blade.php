<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Error' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://kit.fontawesome.com/your-kit.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="text-center px-4">
        <div class="text-red-500 text-8xl mb-6 animate-bounce">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>

        <h1 class="text-6xl font-black text-gray-800 mb-2">{{ $code ?? '500' }}</h1>
        <h2 class="text-3xl font-bold text-gray-700 mb-4">{{ $title ?? '¡Ups! Algo salió mal!' }}</h2>
        <p class="text-gray-500 mb-6 text-lg">{{ $message ?? 'Ha ocurrido un error inesperado en el sistema.' }}</p>

        @if(isset($exceptionMessage))
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-8 text-left text-sm font-mono text-red-700">
                <p><strong>Detalles:</strong> {{ $exceptionMessage }}</p>
            </div>
        @endif
    </div>

</body>
</html>
