@extends('layouts.app')

@section('content')
<div style="background-color: white; padding: 2rem 0; min-height: calc(100vh - 4rem);">
    <div class="page-container">
        <!-- Breadcrumb -->
        <nav style="margin-bottom: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #6b7280;">
                <a href="{{ route('home') }}" style="color: #6366f1; text-decoration: none;">Inicio</a>
                <span>></span>
                <a href="{{ route('books.index') }}" style="color: #6366f1; text-decoration: none;">Catálogo</a>
                <span>></span>
                <span style="color: #111827;">{{ $book->title }}</span>
            </div>
        </nav>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 3rem;">
            <!-- Book Image -->
            <div>
                <div style="background-color: #f3f4f6; border-radius: 0.75rem; height: 500px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                    @if($book->cover_image)
                        <img src="{{ $book->cover_image }}" 
                             alt="{{ $book->title }}" 
                             style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.75rem;"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <!-- Fallback si la imagen no carga -->
                        <div style="color: #9ca3af; text-align: center; display: none; width: 100%; height: 100%; align-items: center; justify-content: center; flex-direction: column;">
                            <svg width="96" height="96" fill="currentColor" viewBox="0 0 20 20" style="margin: 0 auto;">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                            </svg>
                            <p style="font-size: 1rem; margin-top: 1rem; font-weight: 500;">Sin imagen disponible</p>
                        </div>
                    @else
                        <div style="color: #9ca3af; text-align: center;">
                            <svg width="96" height="96" fill="currentColor" viewBox="0 0 20 20" style="margin: 0 auto;">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                            </svg>
                            <p style="font-size: 1rem; margin-top: 1rem; font-weight: 500;">Sin imagen disponible</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Book Details -->
            <div>
                <div style="margin-bottom: 1rem;">
                    <span style="background-color: #e0e7ff; color: #3730a3; font-size: 0.875rem; padding: 0.5rem 1rem; border-radius: 9999px; font-weight: 500;">
                        {{ $book->category }}
                    </span>
                </div>

                <h1 style="font-size: 2.25rem; font-weight: 700; color: #111827; margin-bottom: 1rem; line-height: 1.2;">
                    {{ $book->title }}
                </h1>

                <p style="font-size: 1.25rem; color: #6b7280; margin-bottom: 1.5rem;">
                    por <span style="font-weight: 600; color: #111827;">{{ $book->author }}</span>
                </p>

                <!-- Price -->
                <div style="margin-bottom: 2rem;">
                    <span style="font-size: 2.5rem; font-weight: 700; color: #6366f1;">
                        ${{ number_format($book->price, 2) }}
                    </span>
                </div>

                <!-- Description -->
                @if($book->description)
                    <div style="margin-bottom: 2rem;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">Descripción</h3>
                        <p style="color: #6b7280; line-height: 1.6;">{{ $book->description }}</p>
                    </div>
                @endif

                <!-- Add to Cart Form -->
                @auth
                    @if(Auth::user()->isUser())
                        <form action="{{ route('cart.add', $book) }}" method="POST" style="margin-bottom: 2rem;">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" 
                                    style="background-color: #6366f1; color: white; padding: 1rem 2.5rem; border-radius: 0.5rem; font-weight: 600; border: none; cursor: pointer; font-size: 1rem; width: 100%; max-width: 300px;"
                                    onmouseover="this.style.backgroundColor='#4f46e5'" 
                                    onmouseout="this.style.backgroundColor='#6366f1'">
                                🛒 Agregar al carrito
                            </button>
                        </form>
                    @endif
                @else
                    <div style="background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.5rem; padding: 1.5rem; margin-bottom: 2rem;">
                        <p style="color: #1e40af; margin-bottom: 1rem;">Inicia sesión para comprar este libro</p>
                        <a href="{{ route('login') }}" 
                           style="background-color: #6366f1; color: white; padding: 0.875rem 2rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none; display: inline-block;">
                            Iniciar sesión
                        </a>
                    </div>
                @endauth

                <!-- Book Information -->
                <div style="border-top: 1px solid #e5e7eb; padding-top: 2rem;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">Información del libro</h3>
                    <div style="display: grid; gap: 0.75rem;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #6b7280;">Categoría:</span>
                            <span style="font-weight: 500; color: #111827;">{{ $book->category }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #6b7280;">Autor:</span>
                            <span style="font-weight: 500; color: #111827;">{{ $book->author }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #6b7280;">Precio:</span>
                            <span style="font-weight: 500; color: #111827;">${{ number_format($book->price, 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #6b7280;">Formato:</span>
                            <span style="font-weight: 500; color: #059669;">Digital</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Books -->
        @php
            $relatedBooks = App\Models\Book::where('category', $book->category)
                                         ->where('id', '!=', $book->id)
                                         ->take(4)
                                         ->get();
        @endphp

        @if($relatedBooks->count() > 0)
            <div style="margin-top: 4rem;">
                <h2 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 2rem;">Libros relacionados</h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                    @foreach($relatedBooks as $relatedBook)
                        <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; overflow: hidden; transition: all 0.2s; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);"
                             onmouseover="this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1)'; this.style.transform='translateY(-2px)'" 
                             onmouseout="this.style.boxShadow='0 1px 3px 0 rgba(0, 0, 0, 0.1)'; this.style.transform='translateY(0)'">
                            <div style="height: 180px; background-color: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                                @if($relatedBook->cover_image)
                                    <img src="{{ $relatedBook->cover_image }}" 
                                         alt="{{ $relatedBook->title }}" 
                                         style="width: 100%; height: 100%; object-fit: cover;"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <!-- Fallback si la imagen no carga -->
                                    <div style="color: #9ca3af; text-align: center; display: none;">
                                        <svg width="48" height="48" fill="currentColor" viewBox="0 0 20 20" style="margin: 0 auto;">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div style="color: #9ca3af; text-align: center;">
                                        <svg width="48" height="48" fill="currentColor" viewBox="0 0 20 20" style="margin: 0 auto;">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div style="padding: 1rem;">
                                <h4 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $relatedBook->title }}
                                </h4>
                                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">{{ $relatedBook->author }}</p>
                                <div style="display: flex; align-items: center; justify-content: space-between;">
                                    <span style="color: #6366f1; font-size: 1.125rem; font-weight: 700;">
                                        ${{ number_format($relatedBook->price, 2) }}
                                    </span>
                                    <a href="{{ route('books.show', $relatedBook) }}" 
                                       style="background-color: #111827; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-decoration: none;"
                                       onmouseover="this.style.backgroundColor='#374151'" 
                                       onmouseout="this.style.backgroundColor='#111827'">
                                        Ver
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<style>
@media (max-width: 768px) {
    .page-container > div:first-of-type {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }
}
</style>

@if(session('success'))
    <script>
        alert('{{ session('success') }}');
    </script>
@endif
@endsection