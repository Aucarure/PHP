@extends('layouts.app')

@section('title', 'Compra Exitosa')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <div class="max-w-4xl mx-auto px-4 py-12">
        
        <!-- Animación de éxito -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-6 animate-bounce">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h1 class="text-4xl font-bold text-gray-900 mb-3">
                ¡Compra realizada exitosamente! 🎉
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Los libros han sido agregados a tu biblioteca personal y están listos para disfrutar.
            </p>
        </div>

        <!-- Tarjeta principal -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-8">
            
            <!-- Header de la tarjeta con gradiente -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                <div class="flex items-center justify-between text-white">
                    <div>
                        <h2 class="text-2xl font-bold">Orden #{{ $order->id }}</h2>
                        <p class="text-indigo-100">{{ $order->created_at->format('d/m/Y - H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold">${{ number_format($order->total, 2) }}</p>
                        <span class="inline-block bg-green-500 text-white text-sm px-3 py-1 rounded-full">
                            ✓ {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Contenido de la tarjeta -->
            <div class="p-8">
                
                <!-- Libros adquiridos -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <span class="bg-indigo-100 text-indigo-600 p-2 rounded-lg mr-3">📚</span>
                        Tus nuevos libros digitales
                    </h3>
                    
                    <div class="grid gap-4">
                        @foreach($order->orderItems as $item)
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-200 hover:shadow-md transition-shadow">
                            <div class="flex-shrink-0 w-12 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 text-lg">{{ $item->book->title }}</h4>
                                <p class="text-gray-600">por {{ $item->book->author }}</p>
                                <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full mt-2">
                                    ✓ Disponible ahora
                                </span>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-xl text-gray-900">${{ number_format($item->price, 2) }}</p>
                                @if($item->quantity > 1)
                                <p class="text-sm text-gray-500">Cantidad: {{ $item->quantity }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Información adicional con iconos -->
                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="text-center p-6 bg-blue-50 rounded-xl">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-blue-800 mb-1">100% Seguro</h4>
                        <p class="text-sm text-blue-600">Pago encriptado y protegido</p>
                    </div>
                    
                    <div class="text-center p-6 bg-green-50 rounded-xl">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-green-800 mb-1">Acceso Inmediato</h4>
                        <p class="text-sm text-green-600">Disponible en tu biblioteca</p>
                    </div>
                    
                    <div class="text-center p-6 bg-purple-50 rounded-xl">
                        <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-purple-800 mb-1">En la Nube</h4>
                        <p class="text-sm text-purple-600">Accede desde cualquier lugar</p>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('library.index') }}" 
                       class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-200 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path>
                        </svg>
                        Ir a Mi Biblioteca
                    </a>
                    
                    <a href="{{ route('books.index') }}" 
                       class="flex-1 bg-white hover:bg-gray-50 text-gray-700 font-semibold py-4 px-8 rounded-xl border-2 border-gray-200 hover:border-gray-300 transition-all duration-200 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Continuar Comprando
                    </a>
                </div>
            </div>
        </div>

        <!-- Información final -->
        <div class="text-center text-gray-600">
            <p class="mb-2">📧 Recibirás un correo de confirmación con todos los detalles</p>
            <p class="text-sm">¿Necesitas ayuda? <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium">Contáctanos</a></p>
        </div>
    </div>
</div>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}
</style>

<script>
// Añadir animación a los elementos cuando se cargan
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.bg-white, .bg-gray-50');
    elements.forEach((el, index) => {
        setTimeout(() => {
            el.classList.add('animate-fade-in-up');
        }, index * 100);
    });
});
</script>
@endsection