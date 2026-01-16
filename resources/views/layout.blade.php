<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Validación</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="bg-slate-100 h-screen flex items-center justify-center">
    
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full text-center border border-slate-200">
        @yield('content')
    </div>

</body>
</html>