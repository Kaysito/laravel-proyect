@extends('layout')

@section('breadcrumb', 'Galería de Imágenes')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- ================== HEADER ================== --}}
    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-slate-800">Galería Dinámica</h2>
        <p class="text-slate-500 mt-2">Gestiona las imágenes de tu carrusel.</p>
    </div>

    {{-- ================== MENSAJES ================== --}}
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded mb-6">
            <strong>Éxito:</strong> {{ session('success') }}
        </div>
    @endif

    {{-- ================== CARRUSEL ================== --}}
    <div class="relative w-full overflow-hidden rounded-2xl shadow-xl bg-slate-900 mb-10 group">
        <div id="carousel-images" class="relative h-72 sm:h-96">

            @if($imagenes->count())
                @foreach($imagenes as $index => $img)
                    <img
                        src="{{ $img->url }}"
                        class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700
                        {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                    >
                @endforeach
            @else
                <div class="flex items-center justify-center h-full text-slate-400">
                    No hay imágenes aún
                </div>
            @endif
        </div>

        @if($imagenes->count() > 1)
            <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 text-white">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 text-white">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        @endif
    </div>

    {{-- ================== UPLOADCARE ================== --}}
    <div class="bg-white p-6 rounded-2xl shadow">
        <h3 class="text-center font-bold mb-4">Subir nueva imagen</h3>

        <form method="POST" action="{{ route('carrusel.subir') }}">
            @csrf

            {{-- Uploadcare widget --}}
            <input
                type="hidden"
                role="uploadcare-uploader"
                name="image_url"
                data-public-key="b3a3c1bece70d9761e6b"
                data-images-only
                data-clearable
            >

            <button
                class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl">
                Guardar imagen
            </button>
        </form>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-slate-600">
            ← Volver
        </a>
    </div>
</div>

{{-- ================== JS ================== --}}
@if($imagenes->count())
<script>
    let index = 0;
    const images = document.querySelectorAll('#carousel-images img');
    const total = images.length;

    function show(i) {
        index = (i + total) % total;
        images.forEach((img, idx) => {
            img.classList.toggle('opacity-100', idx === index);
            img.classList.toggle('opacity-0', idx !== index);
        });
    }

    function nextSlide() { show(index + 1); }
    function prevSlide() { show(index - 1); }

    if (total > 1) {
        setInterval(nextSlide, 5000);
    }
</script>
@endif
@endsection
