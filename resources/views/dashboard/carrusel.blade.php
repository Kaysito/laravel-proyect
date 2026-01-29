@extends('layout')

@section('breadcrumb', 'Galería de Imágenes')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- ================== HEADER ================== --}}
    <div class="text-center">
        <h2 class="text-3xl font-extrabold text-slate-800">Galería Dinámica</h2>
        <p class="text-slate-500 mt-2">Gestiona las imágenes de tu carrusel.</p>
    </div>

    {{-- ================== MENSAJES ================== --}}
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-lg shadow-sm flex items-center animate-fade-in-down">
            <i class="fa-solid fa-circle-check mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- ================== VISTA PREVIA (CARRUSEL) ================== --}}
    <div class="relative w-full overflow-hidden rounded-2xl shadow-xl bg-slate-900 group border border-slate-700">
        <div class="absolute top-4 left-4 z-10 bg-black/50 text-white text-xs px-2 py-1 rounded backdrop-blur-sm">
            Vista Previa
        </div>
        
        <div id="carousel-images" class="relative h-64 sm:h-80 md:h-96 flex items-center justify-center">
            @if(count($imagenes) > 0)
                @foreach($imagenes as $index => $img)
                    <img
                        src="{{ $img['url'] }}-/preview/1000x600/"
                        class="absolute inset-0 w-full h-full object-contain bg-slate-900 transition-opacity duration-700
                        {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                        alt="Slide {{ $index }}"
                    >
                @endforeach
            @else
                <div class="text-slate-500 flex flex-col items-center">
                    <i class="fa-regular fa-image text-4xl mb-2 opacity-50"></i>
                    <p>No hay imágenes para mostrar</p>
                </div>
            @endif
        </div>

        {{-- Flechas (Solo si hay más de 1 foto) --}}
        @if(count($imagenes) > 1)
            <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/30 text-white p-3 rounded-full backdrop-blur-md transition hover:scale-110">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/30 text-white p-3 rounded-full backdrop-blur-md transition hover:scale-110">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        @endif
    </div>

    {{-- ================== SUBIR NUEVA (UPLOADCARE) ================== --}}
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200 text-center">
        <div class="mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 mb-3">
                <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
            </div>
            <h3 class="font-bold text-lg text-slate-800">Agregar Nueva Imagen</h3>
            <p class="text-sm text-slate-400">Solo se permiten archivos de imagen (JPG, PNG, WEBP)</p>
        </div>

        <form method="POST" action="{{ route('carrusel.subir') }}" class="flex flex-col items-center">
            @csrf

            {{-- Widget de Uploadcare --}}
            <input
                type="hidden"
                role="uploadcare-uploader"
                name="imagen_url"
                data-public-key="b3a3c1bece70d9761e6b" 
                data-images-only="true"
                data-preview-step="true"
                data-clearable="true"
                class="mb-4"
            >

            <button class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-6 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                <span>Guardar en Galería</span>
                <i class="fa-solid fa-save"></i>
            </button>
        </form>
    </div>

    {{-- ================== ADMINISTRAR FOTOS (GRID DE BORRADO) ================== --}}
    @if(count($imagenes) > 0)
    <div class="border-t border-slate-200 pt-8">
        <h3 class="font-bold text-lg text-slate-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-grid-2 text-indigo-500"></i> Administrar Fotos
        </h3>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach($imagenes as $img)
                <div class="group relative aspect-square bg-slate-100 rounded-xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-md transition">
                    {{-- Imagen Miniatura --}}
                    <img src="{{ $img['url'] }}-/resize/300x/" class="w-full h-full object-cover" alt="Miniatura">
                    
                    {{-- Botón Borrar (Aparece al hacer hover en Desktop, siempre visible en móvil) --}}
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <form action="{{ route('carrusel.borrar') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres borrar esta foto?');">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="url" value="{{ $img['url'] }}">
                            
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-bold shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-all flex items-center gap-2">
                                <i class="fa-solid fa-trash-can"></i> Borrar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="text-center pt-4">
        <a href="{{ route('home') }}" class="inline-flex items-center text-slate-400 hover:text-indigo-600 transition font-medium">
            <i class="fa-solid fa-arrow-left mr-2"></i> Volver al menú
        </a>
    </div>
</div>

{{-- ================== JS CARRUSEL ================== --}}
<script>
    let index = 0;
    const images = document.querySelectorAll('#carousel-images img');
    const total = images.length;

    function show(i) {
        if(total === 0) return;
        index = (i + total) % total; // Matemáticas para ciclo infinito
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

{{-- Estilo extra para el botón de Uploadcare --}}
<style>
    .uploadcare--widget__button_type_open {
        background-color: #f1f5f9 !important; /* Slate-100 */
        color: #475569 !important; /* Slate-600 */
        border: 1px solid #cbd5e1 !important; /* Slate-300 */
        border-radius: 0.5rem !important;
        padding: 10px 20px !important;
        font-family: inherit !important;
        font-weight: 600 !important;
    }
    .uploadcare--widget__button_type_open:hover {
        background-color: #e2e8f0 !important;
    }
</style>
@endsection