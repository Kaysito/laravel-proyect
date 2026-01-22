@extends('layout')

@section('breadcrumb', 'Zona Clicker')

@section('content')
    <div class="mb-6">
        <div class="inline-block p-3 rounded-full bg-indigo-100 text-indigo-600 mb-4">
            <i class="fa-solid fa-database text-2xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-slate-800">Zona de Pruebas</h2>
        <p class="text-slate-500">Clicks totales registrados: <span class="font-bold text-indigo-600">{{ $total }}</span></p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('guardar.click') }}" method="POST">
        @csrf
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg transform active:scale-95 transition-all text-xl">
            ¡GUARDAR CLICK! 🚀
        </button>
    </form>

    <a href="{{ route('home') }}" class="mt-6 inline-block text-slate-500 hover:text-slate-800">
        <i class="fa-solid fa-arrow-left"></i> Volver al menú
    </a>
@endsection