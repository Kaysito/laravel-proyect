@extends('layout-error')

@section('content')
@php
    $code = 404;
    $title = 'Página no encontrada';
    $message = 'Lo sentimos, la página que buscas no existe.';
@endphp
@endsection
