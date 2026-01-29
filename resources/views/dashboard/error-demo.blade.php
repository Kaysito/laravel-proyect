@extends('layout-error')

@section('content')
@php
    $code = 500;
    $title = '¡Ups! Algo salió mal';
    $message = 'Ha ocurrido un error inesperado en el sistema.';
    $exceptionMessage = 'Simulation_Exception: Este es un mensaje de prueba.';
@endphp
@endsection
