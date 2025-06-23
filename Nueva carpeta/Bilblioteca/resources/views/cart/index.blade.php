@extends('layouts.app')

@section('content')
<div style="background-color: white; padding: 2rem 0;">
    <div class="page-container">
        <h1 style="font-size: 1.875rem; font-weight: 700; color: #111827; margin-bottom: 2rem;">Carrito de Compras</h1>

        @if($cartItems->count() > 0)
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
                <!-- Cart Items -->
                <div>
                    @foreach($cartItems as $item)
                        <div style="background-color: white; border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1.5rem; margin-bottom: 1rem; display: flex; gap: 1rem;">
                            <!-- Book Image -->
                            <div style="width: 80px; height: 100px; background-color: #f3f4f6; border-radius: 0.375rem; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                                @if($item->book->image)
                                    <img src="{{ $item->book->image }}" alt="{{ $item->book->title }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.375rem;">
                                @else
                                    <svg width="32" height="32" fill="#9ca3af" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </div>

                            <!-- Book Info -->
                            <div style="flex: 1;">
                                <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">{{ $item->book->title }}</h3>
                                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.5rem;">{{ $item->book->author }}</p>
                                
                                <!-- Digital Book Badge -->
                                <div style="margin-bottom: 1rem;">
                                    <span style="background-color: #dcfce7; color: #166534; font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 9999px; font-weight: 500;">
                                        📱 Libro Digital
                                    </span>
                                </div>
                                
                                <div style="display: flex; align-items: center; justify-content: space-between;">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <!-- Remove Button -->
                                        <form action="{{ route('cart.remove', $item) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    style="color: #dc2626; background-color: #fee2e2; border: 1px solid #fecaca; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; cursor: pointer; font-weight: 500;"
                                                    onmouseover="this.style.backgroundColor='#fecaca'" 
                                                    onmouseout="this.style.backgroundColor='#fee2e2'"
                                                    onclick="return confirm('¿Estás seguro de que quieres eliminar este libro del carrito?')">
                                                🗑️ Eliminar del carrito
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Price -->
                                    <div style="text-align: right;">
                                        <p style="font-size: 1.125rem; font-weight: 700; color: #6366f1;">
                                            ${{ number_format($item->book->price, 2) }}
                                        </p>
                                        <p style="font-size: 0.75rem; color: #6b7280;">
                                            Descarga inmediata
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div>
                    <div style="background-color: white; border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1.5rem; position: sticky; top: 1rem;">
                        <h2 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">Resumen del Pedido</h2>
                        
                        <!-- Items count -->
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                            <span style="color: #6b7280;">
                                {{ $cartItems->count() }} {{ $cartItems->count() == 1 ? 'libro' : 'libros' }}
                            </span>
                            <span style="font-weight: 500;">${{ number_format($total, 2) }}</span>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                            <span style="color: #6b7280;">Sub-total</span>
                            <span style="font-weight: 500;">${{ number_format($total, 2) }}</span>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e5e7eb;">
                            <span style="color: #6b7280;">IVA (20%)</span>
                            <span style="font-weight: 500;">${{ number_format($total * 0.20, 2) }}</span>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem;">
                            <span style="font-size: 1.125rem; font-weight: 600; color: #111827;">Total</span>
                            <span style="font-size: 1.125rem; font-weight: 700; color: #111827;">${{ number_format($total * 1.20, 2) }}</span>
                        </div>

                        <!-- Digital Download Info -->
                        <div style="background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.375rem; padding: 1rem; margin-bottom: 1.5rem;">
                            <div style="display: flex; align-items: start; gap: 0.5rem;">
                                <span style="color: #3b82f6; font-size: 1rem;">ℹ️</span>
                                <div>
                                    <p style="color: #1e40af; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem;">Descarga inmediata</p>
                                    <p style="color: #3b82f6; font-size: 0.75rem;">Recibirás los enlaces de descarga al completar tu compra</p>
                                </div>
                            </div>
                        </div>
                        
                        <button onclick="window.location.href='{{ route('checkout.index') }}'" 
                                style="width: 100%; background-color: #111827; color: white; padding: 0.875rem; border-radius: 0.375rem; font-weight: 600; border: none; cursor: pointer; margin-bottom: 0.75rem;"
                                onmouseover="this.style.backgroundColor='#374151'" 
                                onmouseout="this.style.backgroundColor='#111827'">
                            Proceder al Pago
                        </button>
                        
                        <a href="{{ route('books.index') }}" 
                           style="width: 100%; display: block; text-align: center; color: #6366f1; padding: 0.875rem; border: 1px solid #6366f1; border-radius: 0.375rem; font-weight: 500; text-decoration: none;"
                           onmouseover="this.style.backgroundColor='#f0f9ff'" 
                           onmouseout="this.style.backgroundColor='transparent'">
                            Continuar Comprando
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div style="text-align: center; padding: 4rem 0;">
                <div style="color: #9ca3af; margin-bottom: 1rem;">
                    <svg width="96" height="96" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L6 19h12"></path>
                    </svg>
                </div>
                <h2 style="font-size: 1.5rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem;">Tu carrito está vacío</h2>
                <p style="color: #9ca3af; margin-bottom: 2rem;">Agrega algunos libros digitales para comenzar tu compra</p>
                <a href="{{ route('books.index') }}" 
                   style="background-color: #6366f1; color: white; padding: 0.875rem 2rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none;"
                   onmouseover="this.style.backgroundColor='#4f46e5'" 
                   onmouseout="this.style.backgroundColor='#6366f1'">
                    Explorar libros
                </a>
            </div>
        @endif
    </div>
</div>

<style>
@media (max-width: 768px) {
    .page-container > div:first-of-type {
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
    }
    
    .page-container > div:first-of-type > div:first-child > div {
        flex-direction: column !important;
        gap: 1rem !important;
    }
}
</style>
@endsection