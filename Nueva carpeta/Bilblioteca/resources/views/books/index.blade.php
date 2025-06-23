@extends('layouts.app')

@section('content')
<div style="background-color: white; padding: 2rem 0; min-height: calc(100vh - 4rem);">
    <div class="page-container">
        <!-- Header -->
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;">Catálogo de Libros</h1>
            <p style="color: #6b7280; font-size: 1rem;">Descubre nuestra colección de libros digitales</p>
        </div>

        <!-- Filters -->
        <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.75rem; margin-bottom: 2rem; border: 1px solid #e5e7eb;">
            <form method="GET" action="{{ route('books.index') }}" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: end;">
                <!-- Search -->
                <div style="flex: 1; min-width: 250px;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Buscar por Título o Autor</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Buscar por Título o Autor..." 
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; background-color: white; color: #111827;">
                </div>

                <!-- Category Filter -->
                <div style="min-width: 200px;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Categoría</label>
                    <select name="category" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; background-color: white; color: #111827;">
                        <option value="">Todas las Categorías</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" style="background-color: #6366f1; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; border: none; font-weight: 500; cursor: pointer; font-size: 0.875rem; height: fit-content;">
                    Buscar
                </button>

                <!-- Clear Filters -->
                @if(request('search') || request('category'))
                    <a href="{{ route('books.index') }}" style="background-color: #6b7280; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 500; font-size: 0.875rem;">
                        Limpiar
                    </a>
                @endif
            </form>
        </div>

        <!-- Results Count -->
        <div style="margin-bottom: 1.5rem;">
            <p style="color: #6b7280; font-size: 0.875rem;">
                Mostrando {{ $books->firstItem() ?? 0 }} de {{ $books->total() }} libros
                @if(request('search'))
                    para "<span style="font-weight: 600; color: #111827;">{{ request('search') }}</span>"
                @endif
                @if(request('category'))
                    en la categoría "<span style="font-weight: 600; color: #111827;">{{ request('category') }}</span>"
                @endif
            </p>
        </div>

        <!-- Books Grid -->
        @if($books->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                @foreach($books as $book)
                    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; overflow: hidden; transition: all 0.2s; height: 100%; display: flex; flex-direction: column; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);" 
                         onmouseover="this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1)'; this.style.transform='translateY(-2px)'" 
                         onmouseout="this.style.boxShadow='0 1px 3px 0 rgba(0, 0, 0, 0.1)'; this.style.transform='translateY(0)'">
                        
                        <!-- Book Image -->
                        <div style="height: 220px; background-color: #f3f4f6; display: flex; align-items: center; justify-content: center; position: relative;">
                            @if($book->image)
                                <img src="{{ $book->image }}" alt="{{ $book->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="color: #9ca3af; text-align: center;">
                                    <svg width="64" height="64" fill="currentColor" viewBox="0 0 20 20" style="margin: 0 auto;">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p style="font-size: 0.875rem; margin-top: 0.5rem; font-weight: 500;">Sin imagen</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Book Content -->
                        <div style="padding: 1.25rem; flex: 1; display: flex; flex-direction: column;">
                            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.8rem;">
                                {{ $book->title }}
                            </h3>
                            <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.75rem;">
                                {{ $book->author }}
                            </p>
                            
                            <!-- Category Badge -->
                            <div style="margin-bottom: 1rem;">
                                <span style="background-color: #e0e7ff; color: #3730a3; font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 9999px; font-weight: 500; display: inline-block;">
                                    {{ $book->category }}
                                </span>
                            </div>
                            
                            <!-- Price and Stock -->
                            <div style="margin-top: auto;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                    <span style="color: #6366f1; font-size: 1.25rem; font-weight: 700;">
                                        ${{ number_format($book->price, 2) }}
                                    </span>
                                    @if($book->stock > 0)
                                        <span style="color: #059669; font-size: 0.75rem; font-weight: 500;">{{ $book->stock }} disponibles</span>
                                    @else
                                        <span style="color: #dc2626; font-size: 0.75rem; font-weight: 500;">Agotado</span>
                                    @endif
                                </div>
                                
                                <a href="{{ route('books.show', $book) }}" 
                                   style="width: 100%; display: block; text-align: center; background-color: #111827; color: white; padding: 0.75rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: background-color 0.2s;"
                                   onmouseover="this.style.backgroundColor='#374151'" 
                                   onmouseout="this.style.backgroundColor='#111827'">
                                    Ver más
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div style="text-align: center; padding: 4rem 0;">
                <div style="color: #9ca3af; margin-bottom: 1.5rem;">
                    <svg width="96" height="96" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 style="font-size: 1.5rem; color: #6b7280; font-weight: 600; margin-bottom: 0.5rem;">No se encontraron libros</h3>
                <p style="color: #9ca3af; margin-bottom: 2rem; font-size: 1rem;">
                    @if(request('search') || request('category'))
                        Intenta ajustar tus filtros de búsqueda
                    @else
                        No hay libros disponibles en este momento
                    @endif
                </p>
                @if(request('search') || request('category'))
                    <a href="{{ route('books.index') }}" 
                       style="background-color: #6366f1; color: white; padding: 0.875rem 2rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none; display: inline-block;">
                        Ver todos los libros
                    </a>
                @else
                    <a href="{{ route('home') }}" 
                       style="background-color: #6366f1; color: white; padding: 0.875rem 2rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none; display: inline-block;">
                        Volver al inicio
                    </a>
                @endif
            </div>
        @endif

        <!-- Pagination -->
        @if($books->hasPages())
            <div style="display: flex; justify-content: center; margin-top: 2rem;">
                <div style="display: flex; gap: 0.5rem; align-items: center;">
                    {{ $books->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<style>
@media (max-width: 768px) {
    .page-container > div:nth-child(3) form {
        flex-direction: column !important;
        align-items: stretch !important;
    }
    
    .page-container > div:nth-child(3) form > div {
        min-width: auto !important;
    }
}
</style>
@endsection