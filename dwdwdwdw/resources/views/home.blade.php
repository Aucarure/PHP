@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="page-container">
        <h1 class="hero-title">TU BIBLIOTECA DIGITAL</h1>
        <p class="hero-subtitle">Descubre, compra y lee miles de libros digitales al instante</p>
        <a href="{{ route('books.index') }}" class="explore-btn">Explorar catálogo</a>
    </div>
</div>

<!-- Featured Books Section -->
<div style="background-color: white; padding: 4rem 0;">
    <div class="page-container">
        <h2 class="section-title">Libros Destacados</h2>
        
        <div class="books-grid">
            @forelse($books->take(4) as $book)
                <div class="book-card">
                    <!-- Book Image -->
                    <div class="book-image">
                        @if($book->image)
                            <img src="{{ $book->image }}" alt="{{ $book->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="color: #9ca3af; text-align: center;">
                                <svg width="48" height="48" fill="currentColor" viewBox="0 0 20 20" style="margin: 0 auto;">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                </svg>
                                <p style="font-size: 0.75rem; margin-top: 0.5rem;">Sin imagen</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Book Content -->
                    <div class="book-content">
                        <h3 class="book-title">{{ $book->title }}</h3>
                        <p class="book-author">{{ $book->author }}</p>
                        <div class="book-price">${{ number_format($book->price, 2) }}</div>
                        <a href="{{ route('books.show', $book) }}" class="ver-mas-btn">Ver más</a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem 0;">
                    <p style="color: #6b7280; font-size: 1.125rem;">No hay libros disponibles</p>
                    <p style="color: #9ca3af; font-size: 0.875rem; margin-top: 0.5rem;">Ejecuta el seeder para agregar libros de prueba</p>
                </div>
            @endforelse
        </div>
        
        @if($books->count() > 4)
            <div style="text-align: center; margin-top: 3rem;">
                <a href="{{ route('books.index') }}" class="explore-btn">
                    Ver todos los libros
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Features Section -->
<div style="background-color: #f9fafb; padding: 4rem 0;">
    <div class="page-container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div style="text-align: center;">
                <div style="width: 4rem; height: 4rem; background-color: #ddd6fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <svg width="32" height="32" fill="none" stroke="#6366f1" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">Miles de Libros</h3>
                <p style="color: #6b7280;">Explora nuestra amplia colección de libros digitales de todos los géneros</p>
            </div>
            
            <div style="text-align: center;">
                <div style="width: 4rem; height: 4rem; background-color: #ddd6fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <svg width="32" height="32" fill="none" stroke="#6366f1" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">Acceso Instantáneo</h3>
                <p style="color: #6b7280;">Compra y descarga tus libros al instante, disponibles 24/7</p>
            </div>
            
            <div style="text-align: center;">
                <div style="width: 4rem; height: 4rem; background-color: #ddd6fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <svg width="32" height="32" fill="none" stroke="#6366f1" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">Compra Segura</h3>
                <p style="color: #6b7280;">Tus pagos están protegidos con los más altos estándares de seguridad</p>
            </div>
        </div>
    </div>
</div>
@endsection