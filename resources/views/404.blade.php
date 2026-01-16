@extends('layout')

@section('content')
    <div class="text-amber-500 mb-4 animate-pulse">
        <i class="fa-solid fa-triangle-exclamation text-7xl"></i>
    </div>
    <h1 class="text-6xl font-black text-slate-800 mb-2">404</h1>
    <h2 class="text-2xl font-bold text-slate-700 mb-4">Página no encontrada</h2>
    <a href="/" class="inline-block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 shadow-lg">
        <i class="fa-solid fa-house mr-2"></i> Regresar a Casa
    </a>
@endsection