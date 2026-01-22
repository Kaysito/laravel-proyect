@extends('layout')

@section('breadcrumb', 'Galería de Imágenes')

@section('content')
    <h2 class="text-2xl font-bold text-slate-800 mb-4">Galería Dinámica</h2>

    <div class="relative w-full max-w-lg mx-auto overflow-hidden rounded-xl shadow-lg border border-slate-200 bg-slate-100 mb-6">
        
        <div id="carousel-images" class="relative h-64">
            <img src="https://picsum.photos/800/400?random=1" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 opacity-100" data-index="0">
            <img src="https://picsum.photos/800/400?random=2" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 opacity-0" data-index="1">
            <img src="https://picsum.photos/800/400?random=3" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 opacity-0" data-index="2">
        </div>

        <button onclick="prevSlide()" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70 transition">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button onclick="nextSlide()" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70 transition">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
        
        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex space-x-2">
            <span class="dot w-3 h-3 bg-white rounded-full opacity-100 cursor-pointer" onclick="goToSlide(0)"></span>
            <span class="dot w-3 h-3 bg-white/50 rounded-full cursor-pointer" onclick="goToSlide(1)"></span>
            <span class="dot w-3 h-3 bg-white/50 rounded-full cursor-pointer" onclick="goToSlide(2)"></span>
        </div>
    </div>

    <a href="{{ route('home') }}" class="inline-block text-slate-500 hover:text-slate-800">
        <i class="fa-solid fa-arrow-left"></i> Volver al menú
    </a>

    <script>
        let currentIndex = 0;
        const images = document.querySelectorAll('#carousel-images img');
        const dots = document.querySelectorAll('.dot');
        const totalImages = images.length;

        function showSlide(index) {
            // Ajustar índices cíclicos
            if (index >= totalImages) currentIndex = 0;
            else if (index < 0) currentIndex = totalImages - 1;
            else currentIndex = index;

            // Actualizar imágenes
            images.forEach((img, i) => {
                img.classList.toggle('opacity-100', i === currentIndex);
                img.classList.toggle('opacity-0', i !== currentIndex);
            });

            // Actualizar puntitos
            dots.forEach((dot, i) => {
                dot.classList.toggle('opacity-100', i === currentIndex);
                dot.classList.toggle('bg-white', i === currentIndex);
                dot.classList.toggle('bg-white/50', i !== currentIndex);
            });
        }

        function nextSlide() { showSlide(currentIndex + 1); }
        function prevSlide() { showSlide(currentIndex - 1); }
        function goToSlide(index) { showSlide(index); }

        // Cambio automático cada 5 segundos
        setInterval(nextSlide, 5000);
    </script>
@endsection