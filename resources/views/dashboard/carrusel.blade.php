@extends('layout')

@section('breadcrumb', 'Galería de Imágenes')

@section('content')
    <div class="max-w-4xl mx-auto">
        
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-slate-800">Galería Dinámica</h2>
            <p class="text-slate-500 mt-2">Gestiona las imágenes de tu carrusel en la nube.</p>
        </div>

        {{-- 1. MENSAJES DE ESTADO --}}
        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm mb-6 flex items-center animate-fade-in-down">
                <i class="fa-solid fa-check-circle text-xl mr-3"></i>
                <div>
                    <p class="font-bold">¡Éxito!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm mb-6 flex items-center animate-fade-in-down">
                <i class="fa-solid fa-triangle-exclamation text-xl mr-3"></i>
                <div>
                    <p class="font-bold">Error</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- 2. EL CARRUSEL (VISUALIZACIÓN) --}}
        <div class="relative w-full overflow-hidden rounded-2xl shadow-2xl border border-slate-200 bg-slate-900 mb-10 group">
            
            <div id="carousel-images" class="relative h-72 sm:h-96 bg-slate-800 flex items-center justify-center">
                @if(isset($imagenes) && count($imagenes) > 0)
                    @foreach($imagenes as $index => $img)
                        <img src="{{ $img['secure_url'] }}" 
                             class="absolute inset-0 w-full h-full object-contain bg-black/20 backdrop-blur-sm transition-opacity duration-700 ease-in-out {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" 
                             data-index="{{ $index }}"
                             alt="Imagen del carrusel">
                    @endforeach
                @else
                    {{-- Estado Vacío --}}
                    <div class="text-center p-8">
                        <div class="inline-block p-4 rounded-full bg-slate-700/50 mb-4">
                            <i class="fa-regular fa-images text-4xl text-slate-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-slate-300">Sin imágenes</h3>
                        <p class="text-slate-500 text-sm">Sube tu primera foto abajo para comenzar.</p>
                    </div>
                @endif

                {{-- Gradiente para que se vean mejor las flechas --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>
            </div>

            {{-- Controles (Solo si hay fotos) --}}
            @if(isset($imagenes) && count($imagenes) > 0)
                <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 backdrop-blur-md text-white p-3 rounded-full transition transform hover:scale-110 focus:outline-none group-hover:opacity-100 opacity-0 duration-300">
                    <i class="fa-solid fa-chevron-left text-lg"></i>
                </button>
                <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 backdrop-blur-md text-white p-3 rounded-full transition transform hover:scale-110 focus:outline-none group-hover:opacity-100 opacity-0 duration-300">
                    <i class="fa-solid fa-chevron-right text-lg"></i>
                </button>
                
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
                    @foreach($imagenes as $index => $img)
                        <button onclick="goToSlide({{ $index }})" class="dot w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-white w-6' : 'bg-white/50 hover:bg-white/80' }}"></button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- 3. ZONA DE CARGA (DISEÑO DRAG & DROP) --}}
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-8">
            <div class="text-center mb-6">
                <h3 class="text-lg font-bold text-slate-700 flex items-center justify-center gap-2">
                    <span class="bg-indigo-100 text-indigo-600 p-2 rounded-lg"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                    Subir Nueva Imagen
                </h3>
            </div>

            <form id="uploadForm" action="{{ route('carrusel.subir') }}" method="POST" enctype="multipart/form-data" class="max-w-xl mx-auto">
                @csrf
                
                {{-- Input estilizado --}}
                <div class="flex items-center justify-center w-full mb-4">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-48 border-2 border-indigo-200 border-dashed rounded-xl cursor-pointer bg-indigo-50/30 hover:bg-indigo-50 transition-colors duration-300 group">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="fa-solid fa-cloud-arrow-up text-4xl text-indigo-300 mb-3 group-hover:text-indigo-500 transition-colors"></i>
                            <p class="mb-2 text-sm text-slate-500"><span class="font-semibold text-indigo-600">Haz clic para subir</span> o arrastra aquí</p>
                            <p class="text-xs text-slate-400">PNG, JPG o WEBP (MAX. 2MB)</p>
                        </div>
                        
                        {{-- Validamos en el front que solo acepte imágenes --}}
                        <input id="dropzone-file" name="imagen" type="file" class="hidden" accept="image/png, image/jpeg, image/jpg, image/webp" required onchange="updateFileName(this)" />
                    </label>
                </div>

                {{-- Nombre del archivo seleccionado (JS lo rellena) --}}
                <div id="file-name-display" class="hidden mb-4 text-sm text-center text-emerald-600 font-medium bg-emerald-50 py-2 px-4 rounded-lg animate-pulse">
                    <i class="fa-solid fa-image mr-2"></i> <span id="file-name-text"></span>
                </div>

                <button type="submit" id="submitBtn" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-6 rounded-xl transition-all shadow-lg hover:shadow-indigo-500/30 active:scale-95 flex items-center justify-center gap-2">
                    <span>Subir Imagen a la Nube</span> <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center text-slate-400 hover:text-slate-600 transition-colors font-medium text-sm">
                <i class="fa-solid fa-arrow-left mr-2"></i> Volver al menú principal
            </a>
        </div>
    </div>

    {{-- LÓGICA JAVASCRIPT --}}
    <script>
        // 1. Lógica Visual del Input File
        function updateFileName(input) {
            const display = document.getElementById('file-name-display');
            const text = document.getElementById('file-name-text');
            
            if (input.files && input.files[0]) {
                text.textContent = input.files[0].name; // Muestra el nombre
                display.classList.remove('hidden'); // Hace visible el cuadrito verde
            } else {
                display.classList.add('hidden');
            }
        }

        // 2. Feedback de Carga (Spinner)
        document.getElementById('uploadForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Subiendo...';
            btn.classList.add('opacity-75', 'cursor-not-allowed');
            // No deshabilitamos el botón inmediatamente para permitir el submit, 
            // pero visualmente parece bloqueado.
        });

        // 3. Lógica del Carrusel
        let currentIndex = 0;
        const images = document.querySelectorAll('#carousel-images img');
        const dots = document.querySelectorAll('.dot');
        const totalImages = images.length;

        function showSlide(index) {
            if (totalImages === 0) return;

            if (index >= totalImages) currentIndex = 0;
            else if (index < 0) currentIndex = totalImages - 1;
            else currentIndex = index;

            images.forEach((img, i) => {
                img.classList.toggle('opacity-100', i === currentIndex);
                img.classList.toggle('opacity-0', i !== currentIndex);
            });

            dots.forEach((dot, i) => {
                if(i === currentIndex) {
                    dot.classList.add('bg-white', 'w-6');
                    dot.classList.remove('bg-white/50');
                } else {
                    dot.classList.remove('bg-white', 'w-6');
                    dot.classList.add('bg-white/50');
                }
            });
        }

        function nextSlide() { showSlide(currentIndex + 1); }
        function prevSlide() { showSlide(currentIndex - 1); }
        function goToSlide(index) { showSlide(index); }

        if(totalImages > 1) {
            setInterval(nextSlide, 5000);
        }
    </script>
@endsection