@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="min-h-screen bg-white">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-black mb-8">Finalizar Compra</h1>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Columna izquierda - Formularios -->
                <div class="space-y-6">
                    <!-- Información de Facturación -->
                    <div class="border border-gray-300 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-black mb-4">Información de Facturación</h2>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">Nombre</label>
                                <input type="text" name="first_name" required
                                       pattern="[A-Za-záéíóúñÁÉÍÓÚÑ\s]+"
                                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">Apellidos</label>
                                <input type="text" name="last_name" required
                                       pattern="[A-Za-záéíóúñÁÉÍÓÚÑ\s]+"
                                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" required value="{{ Auth::user()->email }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-50"
                                   readonly>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-700 mb-1">País</label>
                            <select name="country" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                                <option value="">Selecciona tu país</option>
                                <option value="PE">Perú</option>
                                <option value="AR">Argentina</option>
                                <option value="CO">Colombia</option>
                                <option value="MX">México</option>
                                <option value="ES">España</option>
                                <option value="US">Estados Unidos</option>
                            </select>
                        </div>
                    </div>

                    <!-- Método de Pago -->
                    <div class="border border-gray-300 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-black mb-4">Método de Pago</h2>
                        
                        <div class="mb-4">
                            <input type="text" value="Tarjeta de Crédito" readonly
                                   class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-50">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-700 mb-1">Número de tarjeta</label>
                            <input type="text" id="card_number" name="card_number" required
                                   pattern="[0-9\s]{13,19}"
                                   maxlength="19"
                                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">Fecha de vencimiento</label>
                                <input type="text" id="expiry_date" name="expiry_date" required
                                       pattern="(0[1-9]|1[0-2])\/([0-9]{2})"
                                       maxlength="5"
                                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">CVV</label>
                                <input type="text" id="cvv" name="cvv" required
                                       pattern="[0-9]{3,4}"
                                       maxlength="4"
                                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Botón de compra -->
                    <button type="submit" 
                            class="w-full bg-gray-800 hover:bg-gray-700 text-white font-medium py-3 px-4 rounded transition-colors">
                        Confirmar compra
                    </button>
                </div>

                <!-- Columna derecha - Resumen del pedido -->
                <div class="border border-gray-300 rounded-lg p-6 h-fit">
                    <h2 class="text-lg font-semibold text-black mb-4">Resumen del Pedido</h2>
                    
                    <!-- Lista de productos -->
                    @foreach($cartItems as $item)
                    <div class="flex justify-between items-center mb-3">
                        <div>
                            <h3 class="font-medium text-sm">{{ $item->book->title }}</h3>
                            <p class="text-xs text-gray-600">{{ $item->book->author }}</p>
                        </div>
                        <span class="font-semibold">${{ number_format($item->book->price, 2) }}</span>
                    </div>
                    @endforeach

                    <hr class="my-4 border-gray-300">

                    <!-- Cálculos -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span>Sub total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span>IVA (0%)</span>
                            <span>$0.00</span>
                        </div>
                        
                        <hr class="border-gray-300">
                        
                        <div class="flex justify-between font-semibold text-lg">
                            <span>Total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="mt-6 text-center">
                        <div class="text-sm text-gray-600">
                            <span class="inline-block mr-1">📚</span>
                            <span class="font-medium">Libros Digitales</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            Después de completar tu compra, los libros estarán disponibles instantáneamente en tu biblioteca personal.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Formatear número de tarjeta
document.getElementById('card_number').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
    if (formattedValue.length <= 19) {
        e.target.value = formattedValue;
    }
});

// Formatear fecha de vencimiento
document.getElementById('expiry_date').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
    }
    e.target.value = value;
});

// Solo números en CVV
document.getElementById('cvv').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/[^0-9]/g, '');
});
</script>
@endsection