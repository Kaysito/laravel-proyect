@extends('layout')

@section('title', 'Inicio')

@section('content')

{{-- Inline styles for custom design tokens --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap');

    :root {
        --clr-ink:    #1a1a2e;
        --clr-muted:  #6b7280;
        --clr-surface:#f8f7f4;
        --clr-card:   #ffffff;
        --clr-border: #e5e2d9;
    }

    /* Override layout body background for this page */
    body { background-color: var(--clr-surface) !important; font-family: 'DM Sans', sans-serif; }

    .home-wrapper { font-family: 'DM Sans', sans-serif; color: var(--clr-ink); }

    /* ── HERO ── */
    .hero-title {
        font-family: 'DM Serif Display', Georgia, serif;
        font-size: clamp(2rem, 5vw, 3.25rem);
        line-height: 1.15;
        letter-spacing: -0.02em;
        color: var(--clr-ink);
    }
    .hero-title em { font-style: italic; color: #4f46e5; }

    /* ── TOOL CARDS ── */
    .tool-card {
        background: var(--clr-card);
        border: 1.5px solid var(--clr-border);
        border-radius: 1rem;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: .75rem;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        text-decoration: none;
        color: inherit;
        position: relative;
        overflow: hidden;
    }
    .tool-card::before {
        content: '';
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity .25s ease;
        border-radius: inherit;
    }
    .tool-card:hover, .tool-card:focus-visible {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px -8px rgba(26,26,46,.12);
        border-color: transparent;
        outline: none;
    }
    .tool-card:focus-visible { outline: 3px solid #4f46e5; outline-offset: 3px; }

    /* Accent colors per card */
    .card-indigo  { --accent: #4f46e5; --accent-bg: #eef2ff; }
    .card-emerald { --accent: #059669; --accent-bg: #ecfdf5; }
    .card-amber   { --accent: #d97706; --accent-bg: #fffbeb; }
    .card-violet  { --accent: #7c3aed; --accent-bg: #f5f3ff; }
    .card-red     { --accent: #dc2626; --accent-bg: #fef2f2; }
    .card-blue    { --accent: #2563eb; --accent-bg: #eff6ff; }

    .tool-card:hover { border-color: var(--accent); }
    .tool-card:hover .icon-wrap { background: var(--accent); color: #fff; }

    .icon-wrap {
        width: 2.75rem;
        height: 2.75rem;
        border-radius: .625rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
        background: var(--accent-bg);
        color: var(--accent);
        transition: background .2s ease, color .2s ease;
        flex-shrink: 0;
    }

    .card-title { font-weight: 600; font-size: 1rem; color: var(--clr-ink); }
    .card-desc  { font-size: .8125rem; color: var(--clr-muted); line-height: 1.5; }

    .card-arrow {
        margin-top: auto;
        align-self: flex-end;
        color: var(--clr-border);
        font-size: .875rem;
        transition: color .2s ease, transform .2s ease;
    }
    .tool-card:hover .card-arrow { color: var(--accent); transform: translateX(4px); }

    /* ── FEATURED CARD ── */
    .card-featured {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border-color: transparent;
        color: #fff;
    }
    .card-featured .card-title { color: #fff; }
    .card-featured .card-desc  { color: rgba(255,255,255,.65); }
    .card-featured .card-arrow { color: rgba(255,255,255,.3); }
    .card-featured:hover .card-arrow { color: #818cf8; }
    .card-featured .icon-wrap  { background: rgba(129,140,248,.15); color: #818cf8; }
    .card-featured:hover .icon-wrap { background: #4f46e5; color: #fff; }
    .card-featured:hover { border-color: #4f46e5; box-shadow: 0 20px 60px -12px rgba(79,70,229,.35); }

    /* ── LOGOUT BUTTON ── */
    .btn-logout {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .5rem 1.25rem;
        border: 1.5px solid var(--clr-border);
        border-radius: .625rem;
        font-size: .875rem;
        font-weight: 500;
        color: var(--clr-muted);
        background: transparent;
        cursor: pointer;
        transition: all .2s ease;
    }
    .btn-logout:hover, .btn-logout:focus-visible {
        border-color: #ef4444;
        color: #ef4444;
        background: #fef2f2;
        outline: none;
    }
    .btn-logout:focus-visible { outline: 3px solid #ef4444; outline-offset: 3px; }

    /* ── DIVIDER LABEL ── */
    .section-label {
        font-size: .6875rem;
        font-weight: 600;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--clr-muted);
    }

    /* ── STAGGER ANIMATION ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { opacity: 0; animation: fadeUp .5s ease forwards; }
    .delay-1 { animation-delay: .05s; }
    .delay-2 { animation-delay: .10s; }
    .delay-3 { animation-delay: .15s; }
    .delay-4 { animation-delay: .20s; }
    .delay-5 { animation-delay: .25s; }
    .delay-6 { animation-delay: .30s; }
    .delay-7 { animation-delay: .38s; }

    /* Skip link for a11y */
    .skip-link {
        position: absolute;
        top: -100px;
        left: 1rem;
        padding: .5rem 1rem;
        background: #4f46e5;
        color: #fff;
        border-radius: .5rem;
        font-size: .875rem;
        font-weight: 600;
        z-index: 999;
        transition: top .2s;
    }
    .skip-link:focus { top: 1rem; }
</style>

{{-- Skip navigation for WCAG 2.4.1 --}}
<a href="#main-content" class="skip-link">Saltar al contenido principal</a>

<div class="home-wrapper" style="max-width: 860px; margin: 0 auto; padding: 2.5rem 1.25rem;">

    {{-- ── HEADER ── --}}
    <header class="fade-up delay-1" style="margin-bottom: 2.5rem;">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">

            <div>
                {{-- Decorative eyebrow --}}
                <div style="display: flex; align-items: center; gap: .5rem; margin-bottom: .75rem;">
                    <span style="width: 1.5rem; height: 2px; background: #4f46e5; display: inline-block; border-radius: 2px;"></span>
                    <span class="section-label">Panel de herramientas</span>
                </div>

                <h1 class="hero-title">
                    Bienvenido de <em>vuelta</em>
                </h1>
                <p style="margin-top: .625rem; font-size: .9375rem; color: #6b7280; max-width: 38ch; line-height: 1.65;">
                    Selecciona una herramienta para comenzar. Todo lo que necesitas, en un solo lugar.
                </p>
            </div>

            {{-- Logout --}}
            <form action="{{ route('logout') }}" method="POST" style="flex-shrink: 0; margin-top: .25rem;">
                @csrf
                <button type="submit" class="btn-logout" aria-label="Cerrar sesión">
                    <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </header>

    {{-- ── MAIN GRID ── --}}
    <main id="main-content">

        {{-- Row 1: 3 cols --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 1rem;">

            {{-- Clicker --}}
            <a href="{{ route('clicker') }}" class="tool-card card-indigo fade-up delay-2"
               aria-label="Ir a Clicker: registrar datos">
                <div class="icon-wrap" aria-hidden="true">
                    <i class="fa-solid fa-hand-pointer"></i>
                </div>
                <div>
                    <div class="card-title">Clicker</div>
                    <div class="card-desc">Registra y acumula datos al instante.</div>
                </div>
                <i class="fa-solid fa-arrow-right card-arrow" aria-hidden="true"></i>
            </a>

            {{-- Calculadora --}}
            <a href="{{ route('calculadora') }}" class="tool-card card-emerald fade-up delay-3"
               aria-label="Ir a Calculadora: operaciones básicas">
                <div class="icon-wrap" aria-hidden="true">
                    <i class="fa-solid fa-calculator"></i>
                </div>
                <div>
                    <div class="card-title">Calculadora</div>
                    <div class="card-desc">Operaciones aritméticas rápidas y precisas.</div>
                </div>
                <i class="fa-solid fa-arrow-right card-arrow" aria-hidden="true"></i>
            </a>

            {{-- Galería --}}
            <a href="{{ route('carrusel') }}" class="tool-card card-amber fade-up delay-4"
               aria-label="Ir a Galería: carrusel de fotos">
                <div class="icon-wrap" aria-hidden="true">
                    <i class="fa-regular fa-images"></i>
                </div>
                <div>
                    <div class="card-title">Galería</div>
                    <div class="card-desc">Explora imágenes en un carrusel fluido.</div>
                </div>
                <i class="fa-solid fa-arrow-right card-arrow" aria-hidden="true"></i>
            </a>

        </div>

        {{-- Row 2: 2 cols --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 1rem;">

            {{-- Empleados --}}
            <a href="{{ route('empleados') }}" class="tool-card card-violet fade-up delay-5"
               aria-label="Ir a Empleados: gestión CRUD">
                <div class="icon-wrap" aria-hidden="true">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <div class="card-title">Empleados</div>
                    <div class="card-desc">Gestión completa con Fetch y manipulación del DOM.</div>
                </div>
                <i class="fa-solid fa-arrow-right card-arrow" aria-hidden="true"></i>
            </a>

            {{-- Error Page --}}
            <a href="{{ route('error.demo') }}" class="tool-card card-red fade-up delay-6"
               aria-label="Ir a Error Page: simulación de errores HTTP">
                <div class="icon-wrap" aria-hidden="true">
                    <i class="fa-solid fa-bug"></i>
                </div>
                <div>
                    <div class="card-title">Error Page</div>
                    <div class="card-desc">Simula respuestas 404 y 500 en segundos.</div>
                </div>
                <i class="fa-solid fa-arrow-right card-arrow" aria-hidden="true"></i>
            </a>

        </div>

        {{-- Featured: Formulario Pro --}}
        <a href="{{ route('formulario') }}" class="tool-card card-featured fade-up delay-7"
           aria-label="Ir a Formulario Pro: validación avanzada y UX mejorada"
           style="flex-direction: row; align-items: center; gap: 1.25rem; padding: 1.75rem 2rem;">

            <div class="icon-wrap" style="width: 3.25rem; height: 3.25rem; font-size: 1.375rem; flex-shrink: 0;" aria-hidden="true">
                <i class="fa-solid fa-clipboard-check"></i>
            </div>

            <div style="flex: 1; text-align: left;">
                <div style="display: flex; align-items: center; gap: .625rem; margin-bottom: .25rem;">
                    <div class="card-title" style="font-size: 1.0625rem;">Formulario Pro</div>
                    <span style="font-size: .6875rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase;
                                 background: rgba(129,140,248,.2); color: #818cf8;
                                 padding: .125rem .5rem; border-radius: 99px;">Destacado</span>
                </div>
                <div class="card-desc" style="max-width: 46ch;">
                    Validación estricta, dominios modernos y experiencia de usuario avanzada.
                </div>
            </div>

            <i class="fa-solid fa-arrow-right card-arrow" style="font-size: 1rem; align-self: center;" aria-hidden="true"></i>
        </a>

    </main>

    {{-- ── FOOTER ── --}}
    <footer style="margin-top: 2.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
                   padding-top: 1.5rem; border-top: 1px solid var(--clr-border);" class="fade-up" style="animation-delay:.45s">

        <p style="font-size: .8125rem; color: #9ca3af; margin: 0;">
            &copy; {{ date('Y') }} · Sistema de herramientas internas
        </p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout" style="padding: .375rem 1rem; font-size: .8125rem;"
                    aria-label="Cerrar sesión desde el pie de página">
                <i class="fa-solid fa-power-off" aria-hidden="true"></i>
                Salir
            </button>
        </form>
    </footer>

</div>
@endsection