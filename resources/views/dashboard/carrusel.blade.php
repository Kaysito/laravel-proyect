@extends('layout')

@section('breadcrumb', 'Galería de Imágenes')

@section('content')
    <h2 class="text-2xl font-bold text-slate-800 mb-4">Galería Dinámica</h2>

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative mb-4">
            <i class="fa-solid fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="relative w-full max-w-lg mx-auto overflow-hidden rounded-xl shadow-lg border border-slate-200 bg-slate-900 mb-8">
        
        <div id="carousel-images" class="relative h-64">
            @if(isset($imagenes) && count($imagenes) > 0)
                {{-- CASO A: Hay fotos en Cloudinary --}}
                @foreach($imagenes as $index => $img)
                    <img src="{{ $img['secure_url'] }}" 
                         class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" 
                         data-index="{{ $index }}"
                         alt="Foto de galería">
                @endforeach
            @else
                {{-- CASO B: No hay fotos, mostramos ejemplo --}}
                <img src="https://picsum.photos/800/400?random=1" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 opacity-100" data-index="0">
                <img src="https://picsum.photos/800/400?random=2" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 opacity-0" data-index="1">
                <img src="https://picsum.photos/800/400?random=3" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 opacity-0" data-index="2">
            @endif
        </div>

        <button onclick="prevSlide()" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70 transition z-10">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button onclick="nextSlide()" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70 transition z-10">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
        
        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
            @if(isset($imagenes) && count($imagenes) > 0)
                @foreach($imagenes as $index => $img)
                    <span class="dot w-3 h-3 rounded-full cursor-pointer {{ $index === 0 ? 'bg-white opacity-100' : 'bg-white/50' }}" onclick="goToSlide({{ $index }})"></span>
                @endforeach
            @else
                <span class="dot w-3 h-3 bg-white rounded-full opacity-100 cursor-pointer" onclick="goToSlide(0)"></span>
                <span class="dot w-3 h-3 bg-white/50 rounded-full cursor-pointer" onclick="goToSlide(1)"></span>
                <span class="dot w-3 h-3 bg-white/50 rounded-full cursor-pointer" onclick="goToSlide(2)"></span>
            @endif
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-dashed border-slate-300 text-center max-w-lg mx-auto">
        <h3 class="font-bold text-slate-700 mb-2">
            <i class="fa-solid fa-cloud-arrow-up text-indigo-500 mr-2"></i> Subir Nueva Foto
        </h3>
        <p class="text-xs text-slate-500 mb-4">La imagen se guardará en Cloudinary y aparecerá arriba.</p>

        <form action="{{ route('carrusel.subir') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center gap-4">
            @csrf
            
            <input type="file" name="imagen" required accept="image/*" 
                   class="block w-full text-sm text-slate-500 
                          file:mr-4 file:py-2 file:px-4 
                          file:rounded-full file:border-0 
                          file:text-sm file:font-semibold 
                          file:bg-indigo-50 file:text-indigo-700 
                          hover:file:bg-indigo-100 cursor-pointer">
            
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-indigo-700 transition shadow-md w-full sm:w-auto">
                <i class="fa-solid fa-upload mr-2"></i> Subir Imagen
            </button>
        </form>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('home') }}" class="inline-block text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-arrow-left"></i> Volver al menú
        </a>
    </div>

    <script>
        let currentIndex = 0;
        const images = document.querySelectorAll('#carousel-images img');
        const dots = document.querySelectorAll('.dot');
        const totalImages = images.length;

        function showSlide(index) {
            if (totalImages === 0) return;

            // Lógica cíclica (Infinito)
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

        // Cambio automático solo si hay más de 1 imagen
        if(totalImages > 1) {
            setInterval(nextSlide, 5000);
        }
    </script>
@endsection