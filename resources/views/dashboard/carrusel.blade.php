@extends('layout')

@section('breadcrumb', 'Galería de Imágenes')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- ================== HEADER ================== --}}
    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800">Galería Dinámica</h2>
        <p class="text-slate-500 mt-2">Gestiona las imágenes de tu carrusel en la nube.</p>
    </div>

    {{-- ================== MENSAJES ================== --}}
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm mb-6 flex items-center">
            <i class="fa-solid fa-check-circle text-xl mr-3"></i>
            <div>
                <p class="font-bold">¡Éxito!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm mb-6 flex items-center">
            <i class="fa-solid fa-triangle-exclamation text-xl mr-3"></i>
            <div>
                <p class="font-bold">Error</p>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    {{-- ================== CARRUSEL ================== --}}
    <div class="relative w-full overflow-hidden rounded-2xl shadow-2xl border border-slate-200 bg-slate-900 mb-10 group">
        <div id="carousel-images" class="relative h-72 sm:h-96 bg-slate-800 flex items-center justify-center">

            @if(isset($imagenes) && count($imagenes) > 0)
                @foreach($imagenes as $index => $img)
                    <img
                        src="{{ $img['secure_url'] }}"
                        loading="lazy"
                        decoding="async"
                        data-index="{{ $index }}"
                        class="absolute inset-0 w-full h-full object-contain bg-black/20 backdrop-blur-sm transition-opacity duration-700 ease-in-out {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                        alt="Imagen del carrusel">
                @endforeach
            @else
                <div class="text-center p-8">
                    <div class="inline-block p-4 rounded-full bg-slate-700/50 mb-4">
                        <i class="fa-regular fa-images text-4xl text-slate-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-slate-300">Sin imágenes</h3>
                    <p class="text-slate-500 text-sm">Sube tu primera foto abajo para comenzar.</p>
                </div>
            @endif

            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>
        </div>

        {{-- CONTROLES --}}
        @if(isset($imagenes) && count($imagenes) > 1)
            <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 backdrop-blur-md text-white p-3 rounded-full transition transform hover:scale-110 opacity-0 group-hover:opacity-100">
                <i class="fa-solid fa-chevron-left"></i>
            </button>

            <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 backdrop-blur-md text-white p-3 rounded-full transition transform hover:scale-110 opacity-0 group-hover:opacity-100">
                <i class="fa-solid fa-chevron-right"></i>
            </button>

            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
                @foreach($imagenes as $index => $img)
                    <button onclick="goToSlide({{ $index }})"
                        class="dot w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-white w-6' : 'bg-white/50 hover:bg-white/80' }}">
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ================== UPLOAD ================== --}}
    <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-8">
        <div class="text-center mb-6">
            <h3 class="text-lg font-bold text-slate-700 flex items-center justify-center gap-2">
                <span class="bg-indigo-100 text-indigo-600 p-2 rounded-lg">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                </span>
                Subir Nueva Imagen
            </h3>
        </div>

        <form id="uploadForm" action="{{ route('carrusel.subir') }}" method="POST" enctype="multipart/form-data" class="max-w-xl mx-auto">
            @csrf

            <label class="flex flex-col items-center justify-center h-48 border-2 border-dashed border-indigo-200 rounded-xl cursor-pointer bg-indigo-50/30 hover:bg-indigo-50 transition mb-4">
                <i class="fa-solid fa-cloud-arrow-up text-4xl text-indigo-400 mb-2"></i>
                <p class="text-sm text-slate-500">
                    <span class="font-semibold text-indigo-600">Haz clic</span> o arrastra aquí
                </p>
                <p class="text-xs text-slate-400">PNG, JPG o WEBP (MAX. 5MB)</p>
                <input type="file" name="imagen" accept="image/png,image/jpeg,image/webp" required hidden onchange="updateFileName(this)">
            </label>

            <div id="file-name-display" class="hidden mb-4 text-sm text-center text-emerald-600 font-medium bg-emerald-50 py-2 px-4 rounded">
                <i class="fa-solid fa-image mr-2"></i>
                <span id="file-name-text"></span>
            </div>

            <button id="submitBtn" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl shadow-lg transition active:scale-95">
                <i class="fa-solid fa-paper-plane mr-2"></i> Subir Imagen
            </button>
        </form>
    </div>

    <div class="mt-10 text-center">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-slate-600 text-sm font-medium">
            <i class="fa-solid fa-arrow-left mr-2"></i> Volver al menú
        </a>
    </div>
</div>

{{-- ================== JS ================== --}}
<script>
    function updateFileName(input) {
        const box = document.getElementById('file-name-display');
        const text = document.getElementById('file-name-text');

        if (input.files.length) {
            if (input.files[0].size > 5 * 1024 * 1024) {
                alert('La imagen supera los 5MB');
                input.value = '';
                return;
            }
            text.textContent = input.files[0].name;
            box.classList.remove('hidden');
        }
    }

    document.getElementById('uploadForm').addEventListener('submit', () => {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin mr-2"></i> Subiendo...';
    });

    @if(isset($imagenes) && count($imagenes) > 0)
        let currentIndex = 0;
        const images = document.querySelectorAll('#carousel-images img');
        const dots = document.querySelectorAll('.dot');
        const total = images.length;

        function showSlide(i) {
            currentIndex = (i + total) % total;
            images.forEach((img, idx) => {
                img.classList.toggle('opacity-100', idx === currentIndex);
                img.classList.toggle('opacity-0', idx !== currentIndex);
            });
            dots.forEach((dot, idx) => {
                dot.classList.toggle('w-6', idx === currentIndex);
                dot.classList.toggle('bg-white', idx === currentIndex);
                dot.classList.toggle('bg-white/50', idx !== currentIndex);
            });
        }

        function nextSlide() { showSlide(currentIndex + 1); }
        function prevSlide() { showSlide(currentIndex - 1); }
        function goToSlide(i) { showSlide(i); }

        if (total > 1) setInterval(nextSlide, 5000);
    @endif
</script>
@endsection
