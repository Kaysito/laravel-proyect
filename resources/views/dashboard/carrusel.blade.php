@extends('layout')

@section('breadcrumb', 'Dashboard / Galería de Imágenes')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">

    {{-- ================== HEADER ================== --}}
    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-slate-800">Galería Dinámica</h1>
        <p class="text-slate-500 mt-2">Administra y visualiza tus imágenes del carrusel de forma sencilla.</p>
    </div>

    {{-- ================== MENSAJES ================== --}}
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded mb-8">
            <strong>Éxito:</strong> {{ session('success') }}
        </div>
    @endif

    {{-- ================== CARRUSEL ================== --}}
    <div class="relative w-full overflow-hidden rounded-3xl shadow-xl bg-slate-900 mb-8 group">
        <div id="carousel-images" class="relative h-80 sm:h-96 flex items-center justify-center bg-slate-800">

            @if($imagenes->count())
                @foreach($imagenes as $index => $img)
                    <div class="absolute inset-0 w-full h-full transition-opacity duration-700 {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}">
                        <img src="{{ $img->url }}" class="w-full h-full object-cover rounded-3xl shadow-lg">

                        {{-- BOTÓN BORRAR --}}
                        <form action="{{ route('carrusel.eliminar', $img->id) }}" method="POST" 
                              class="absolute top-3 right-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Seguro que quieres eliminar esta imagen?')" 
                                    class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full shadow-md transition">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            @else
                <div class="flex flex-col items-center justify-center h-full text-slate-400 space-y-2">
                    <i class="fa-solid fa-image text-4xl"></i>
                    <span>No hay imágenes en el carrusel</span>
                </div>
            @endif
        </div>

        @if($imagenes->count() > 1)
            <button onclick="prevSlide()" class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/30 p-2 rounded-full text-white hover:bg-black/50 transition">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button onclick="nextSlide()" class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/30 p-2 rounded-full text-white hover:bg-black/50 transition">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        @endif
    </div>

    {{-- ================== UPLOADCARE ================== --}}
    <div class="bg-white p-6 rounded-3xl shadow-md mb-8">
        <h2 class="text-center text-xl font-semibold mb-4">Subir nueva imagen</h2>

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

            <button class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-medium transition">
                Guardar imagen
            </button>
        </form>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-slate-600 font-medium inline-flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i> Volver al dashboard
        </a>
    </div>
</div>

{{-- ================== JS ================== --}}
@if($imagenes->count())
<script>
    let index = 0;
    const images = document.querySelectorAll('#carousel-images > div');
    const total = images.length;

    function show(i) {
        index = (i + total) % total;
        images.forEach((img, idx) => {
            img.classList.toggle('opacity-100', idx === index);
            img.classList.toggle('opacity-0', idx !== index);
            img.classList.toggle('z-10', idx === index);
            img.classList.toggle('z-0', idx !== index);
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
