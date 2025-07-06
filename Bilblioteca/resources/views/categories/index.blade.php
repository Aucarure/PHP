@extends('layouts.app')

@section('content')
<div style="background-color: white; padding: 2rem 0; min-height: calc(100vh - 4rem);">
    <div class="page-container">
        <h1 style="font-size: 1.875rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;">Categorías</h1>
        <p style="color: #6b7280; font-size: 1rem; margin-bottom: 2rem;">Explora nuestros libros por categoría</p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            @foreach($categories as $category)
                @php
                    $bookCount = App\Models\Book::where('category', $category)->count();
                    $categoryIcons = [
                        'Programación' => '<svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>',
                        'Base de Datos' => '<svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path></svg>',
                        'Desarrollo Web' => '<svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>',
                        'Literatura' => '<svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>',
                        'Clásicos' => '<svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>',
                        'Infantil' => '<svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                        'Algoritmos' => '<svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>',
                    ];
                    $icon = $categoryIcons[$category] ?? '<svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>';
                @endphp
                
                <a href="{{ route('books.index', ['category' => $category]) }}" 
                   style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 2rem; text-decoration: none; transition: all 0.2s; display: block; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);"
                   onmouseover="this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1)'; this.style.transform='translateY(-2px)'" 
                   onmouseout="this.style.boxShadow='0 1px 3px 0 rgba(0, 0, 0, 0.1)'; this.style.transform='translateY(0)'">
                    <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                        <div style="width: 4rem; height: 4rem; background-color: #e0e7ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                            <div style="color: #6366f1;">
                                {!! $icon !!}
                            </div>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">
                            {{ $category }}
                        </h3>
                        <p style="color: #6b7280; font-size: 0.875rem;">
                            {{ $bookCount }} {{ $bookCount == 1 ? 'libro' : 'libros' }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Books by Category Preview -->
        <div style="margin-top: 4rem;">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 2rem; text-align: center;">Libros destacados por categoría</h2>
            
            @foreach($categories->take(3) as $category)
                @php
                    $categoryBooks = App\Models\Book::where('category', $category)->take(4)->get();
                @endphp
                
                @if($categoryBooks->count() > 0)
                    <div style="margin-bottom: 3rem;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                            <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827;">{{ $category }}</h3>
                            <a href="{{ route('books.index', ['category' => $category]) }}" 
                               style="color: #6366f1; font-weight: 500; font-size: 0.875rem; text-decoration: none;">
                                Ver todos →
                            </a>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                            @foreach($categoryBooks as $book)
                                <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; overflow: hidden; transition: all 0.2s; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);"
                                     onmouseover="this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1)'; this.style.transform='translateY(-2px)'" 
                                     onmouseout="this.style.boxShadow='0 1px 3px 0 rgba(0, 0, 0, 0.1)'; this.style.transform='translateY(0)'">
                                    <div style="height: 180px; background-color: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                                        @if($book->cover_image)
                                            <img src="{{ $book->cover_image }}" 
                                                 alt="{{ $book->title }}" 
                                                 style="width: 100%; height: 100%; object-fit: cover;"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                            <!-- Fallback si la imagen no carga -->
                                            <div style="color: #9ca3af; text-align: center; display: none;">
                                                <svg width="48" height="48" fill="currentColor" viewBox="0 0 20 20" style="margin: 0 auto;">
                                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                                </svg>
                                                <p style="font-size: 0.75rem; margin-top: 0.5rem;">Sin imagen</p>
                                            </div>
                                        @else
                                            <div style="color: #9ca3af; text-align: center;">
                                                <svg width="48" height="48" fill="currentColor" viewBox="0 0 20 20" style="margin: 0 auto;">
                                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                                </svg>
                                                <p style="font-size: 0.75rem; margin-top: 0.5rem;">Sin imagen</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div style="padding: 1rem;">
                                        <h4 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 0.25rem; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ $book->title }}
                                        </h4>
                                        <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.75rem;">{{ $book->author }}</p>
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span style="color: #6366f1; font-size: 1.125rem; font-weight: 700;">
                                                ${{ number_format($book->price, 2) }}
                                            </span>
                                            <a href="{{ route('books.show', $book) }}" 
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
            @endforeach
        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .page-container > div:first-of-type {
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
    }
}
</style>
@endsection