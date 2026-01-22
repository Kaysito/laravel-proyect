@extends('layout')

@section('breadcrumb', 'Calculadora')

@section('content')
    <h2 class="text-2xl font-bold text-slate-800 mb-4">Calculadora</h2>
    
    <div class="bg-slate-800 p-4 rounded-lg mb-4 text-right">
        <div id="display" class="text-white text-3xl font-mono overflow-hidden tracking-widest h-10">0</div>
    </div>

    <div class="grid grid-cols-4 gap-2">
        <button onclick="clearDisplay()" class="col-span-3 bg-red-100 text-red-600 p-4 rounded font-bold hover:bg-red-200">AC</button>
        <button onclick="appendOperator('/')" class="bg-amber-100 text-amber-600 p-4 rounded font-bold hover:bg-amber-200">÷</button>
        
        <button onclick="appendNumber('7')" class="bg-slate-100 p-4 rounded font-bold hover:bg-slate-200">7</button>
        <button onclick="appendNumber('8')" class="bg-slate-100 p-4 rounded font-bold hover:bg-slate-200">8</button>
        <button onclick="appendNumber('9')" class="bg-slate-100 p-4 rounded font-bold hover:bg-slate-200">9</button>
        <button onclick="appendOperator('*')" class="bg-amber-100 text-amber-600 p-4 rounded font-bold hover:bg-amber-200">×</button>

        <button onclick="appendNumber('4')" class="bg-slate-100 p-4 rounded font-bold hover:bg-slate-200">4</button>
        <button onclick="appendNumber('5')" class="bg-slate-100 p-4 rounded font-bold hover:bg-slate-200">5</button>
        <button onclick="appendNumber('6')" class="bg-slate-100 p-4 rounded font-bold hover:bg-slate-200">6</button>
        <button onclick="appendOperator('-')" class="bg-amber-100 text-amber-600 p-4 rounded font-bold hover:bg-amber-200">-</button>

        <button onclick="appendNumber('1')" class="bg-slate-100 p-4 rounded font-bold hover:bg-slate-200">1</button>
        <button onclick="appendNumber('2')" class="bg-slate-100 p-4 rounded font-bold hover:bg-slate-200">2</button>
        <button onclick="appendNumber('3')" class="bg-slate-100 p-4 rounded font-bold hover:bg-slate-200">3</button>
        <button onclick="appendOperator('+')" class="bg-amber-100 text-amber-600 p-4 rounded font-bold hover:bg-amber-200">+</button>

        <button onclick="appendNumber('0')" class="col-span-2 bg-slate-100 p-4 rounded font-bold hover:bg-slate-200">0</button>
        <button onclick="calculate()" class="col-span-2 bg-emerald-500 text-white p-4 rounded font-bold hover:bg-emerald-600">=</button>
    </div>

    <a href="{{ route('home') }}" class="mt-6 inline-block text-slate-500 hover:text-slate-800">
        <i class="fa-solid fa-arrow-left"></i> Volver al menú
    </a>

    <script>
        let currentDisplay = '0';
        const MAX_CHARS = 12; // 2. LÍMITE DE CARACTERES

        function updateDisplay() {
            document.getElementById('display').innerText = currentDisplay;
        }

        function appendNumber(num) {
            // Validación: Si llegamos al límite, no hacemos nada
            if (currentDisplay.length >= MAX_CHARS) return;

            if (currentDisplay === '0') currentDisplay = num;
            else currentDisplay += num;
            updateDisplay();
        }

        function appendOperator(op) {
            // Validación: Dejar espacio para operador y al menos un número más
            if (currentDisplay.length >= MAX_CHARS - 2) return;
            
            currentDisplay += ' ' + op + ' ';
            updateDisplay();
        }

        function clearDisplay() {
            currentDisplay = '0';
            updateDisplay();
        }

        function calculate() {
            try {
                // Evaluamos y cortamos si el resultado es muy largo (ej: decimales infinitos)
                let result = eval(currentDisplay).toString();
                
                if (result.length > MAX_CHARS) {
                    result = result.substring(0, MAX_CHARS);
                }
                
                currentDisplay = result;
            } catch (e) {
                currentDisplay = 'Error';
            }
            updateDisplay();
        }
    </script>
@endsection