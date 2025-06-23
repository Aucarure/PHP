@extends('layouts.app')

@section('content')
<div style="background-color: white; padding: 2rem 0; min-height: calc(100vh - 4rem);">
    <div class="page-container">
        <!-- Header -->
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;">Mi biblioteca</h1>
            <p style="color: #6b7280; font-size: 1rem;">Gestiona tu colección personal de libros digitales</p>
        </div>

        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <!-- Total Books -->
            <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; color: #6366f1; margin-bottom: 0.5rem;">{{ $totalBooks }}</div>
                <div style="color: #6b7280; font-weight: 500;">Total</div>
            </div>

            <!-- Books Read -->
            <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; color: #059669; margin-bottom: 0.5rem;">{{ $readBooks }}</div>
                <div style="color: #6b7280; font-weight: 500;">Leídos</div>
            </div>

            <!-- Pending Books -->
            <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; color: #f59e0b; margin-bottom: 0.5rem;">{{ $pendingBooks }}</div>
                <div style="color: #6b7280; font-weight: 500;">Pendientes</div>
            </div>

            <!-- Favorite Books -->
            <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.5rem; text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; color: #dc2626; margin-bottom: 0.5rem;">{{ $favoriteBooks }}</div>
                <div style="color: #6b7280; font-weight: 500;">Favoritos</div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div style="margin-bottom: 2rem;">
            <div style="display: flex; gap: 0.5rem; background-color: #f9fafb; padding: 0.25rem; border-radius: 0.5rem; width: fit-content;">
                <button onclick="filterBooks('all')" id="tab-all" style="padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; font-weight: 500; cursor: pointer; background-color: #6366f1; color: white;">
                    Todos los libros
                </button>
                <button onclick="filterBooks('read')" id="tab-read" style="padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; font-weight: 500; cursor: pointer; background-color: transparent; color: #6b7280;">
                    Leídos
                </button>
                <button onclick="filterBooks('pending')" id="tab-pending" style="padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; font-weight: 500; cursor: pointer; background-color: transparent; color: #6b7280;">
                    Pendientes
                </button>
                <button onclick="filterBooks('favorites')" id="tab-favorites" style="padding: 0.5rem 1rem; border-radius: 0.375rem; border: none; font-weight: 500; cursor: pointer; background-color: transparent; color: #6b7280;">
                    Favoritos
                </button>
            </div>
        </div>

        <!-- Results Info -->
        <div style="margin-bottom: 1.5rem;">
            <p style="color: #6b7280; font-size: 0.875rem;">
                <span id="result-text">Mostrando {{ $userBooks->count() }} de {{ $userBooks->count() }} libros</span>
            </p>
        </div>

        <!-- Books Grid -->
        @if($userBooks->count() > 0)
            <div id="books-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                @foreach($userBooks as $userBook)
                    <div class="library-book" data-status="{{ $userBook->status }}" data-favorite="{{ $userBook->is_favorite ? 'true' : 'false' }}" 
                         style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; overflow: hidden; transition: all 0.2s; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
                        
                        <!-- Book Image -->
                        <div style="height: 200px; background-color: #f3f4f6; display: flex; align-items: center; justify-content: center; position: relative;">
                            @if($userBook->book->image)
                                <img src="{{ $userBook->book->image }}" alt="{{ $userBook->book->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="color: #9ca3af; text-align: center;">
                                    <svg width="64" height="64" fill="currentColor" viewBox="0 0 20 20" style="margin: 0 auto;">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p style="font-size: 0.875rem; margin-top: 0.5rem;">Sin imagen</p>
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <div style="position: absolute; top: 0.5rem; left: 0.5rem;">
                                @if($userBook->status === 'read')
                                    <span style="background-color: #059669; color: white; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 9999px; font-weight: 500;">
                                        Leído
                                    </span>
                                @elseif($userBook->status === 'pending')
                                    <span style="background-color: #f59e0b; color: white; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 9999px; font-weight: 500;">
                                        Pendiente
                                    </span>
                                @endif
                            </div>

                            <!-- Favorite Heart -->
                            @if($userBook->is_favorite)
                                <div style="position: absolute; top: 0.5rem; right: 0.5rem;">
                                    <svg width="20" height="20" fill="#dc2626" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Book Content -->
                        <div style="padding: 1.25rem;">
                            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $userBook->book->title }}
                            </h3>
                            <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">
                                {{ $userBook->book->author }}
                            </p>

                            <!-- Action Buttons -->
                            <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                                <button onclick="toggleReadStatus({{ $userBook->id }})" 
                                        style="flex: 1; padding: 0.5rem; border-radius: 0.375rem; border: 1px solid #e5e7eb; background: white; font-size: 0.875rem; cursor: pointer;">
                                    {{ $userBook->status === 'read' ? 'Marcar pendiente' : 'Marcar como leído' }}
                                </button>
                                <button onclick="toggleFavorite({{ $userBook->id }})" 
                                        style="padding: 0.5rem; border-radius: 0.375rem; border: 1px solid #e5e7eb; background: {{ $userBook->is_favorite ? '#dc2626' : 'white' }}; color: {{ $userBook->is_favorite ? 'white' : '#6b7280' }}; cursor: pointer;">
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Download/Read Button -->
                            <a href="{{ route('reader.show', $userBook->book) }}"
                               style="width: 100%; display: block; text-align: center; background-color: #111827; color: white; padding: 0.75rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; text-decoration: none;">
                                Leer
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty Library -->
            <div style="text-align: center; padding: 4rem 0;">
                <div style="color: #9ca3af; margin-bottom: 1.5rem;">
                    <svg width="96" height="96" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 style="font-size: 1.5rem; color: #6b7280; font-weight: 600; margin-bottom: 0.5rem;">Tu biblioteca está vacía</h3>
                <p style="color: #9ca3af; margin-bottom: 2rem;">Compra algunos libros para comenzar tu biblioteca personal</p>
                <a href="{{ route('books.index') }}" 
                   style="background-color: #6366f1; color: white; padding: 0.875rem 2rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none; display: inline-block;">
                    Explorar libros
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function filterBooks(status) {
    const books = document.querySelectorAll('.library-book');
    const tabs = document.querySelectorAll('[id^="tab-"]');
    
    // Reset tab styles
    tabs.forEach(tab => {
        tab.style.backgroundColor = 'transparent';
        tab.style.color = '#6b7280';
    });
    
    // Active tab style
    document.getElementById('tab-' + status).style.backgroundColor = '#6366f1';
    document.getElementById('tab-' + status).style.color = 'white';
    
    let visibleCount = 0;
    
    books.forEach(book => {
        const bookStatus = book.dataset.status;
        const isFavorite = book.dataset.favorite === 'true';
        
        let shouldShow = false;
        
        if (status === 'all') {
            shouldShow = true;
        } else if (status === 'favorites') {
            shouldShow = isFavorite;
        } else {
            shouldShow = bookStatus === status;
        }
        
        if (shouldShow) {
            book.style.display = 'block';
            visibleCount++;
        } else {
            book.style.display = 'none';
        }
    });
    
    // Update result text
    document.getElementById('result-text').textContent = `Mostrando ${visibleCount} de {{ $userBooks->count() }} libros`;
}

function toggleReadStatus(userBookId) {
    // AJAX call to toggle read status
    fetch(`/library/${userBookId}/toggle-status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function toggleFavorite(userBookId) {
    // AJAX call to toggle favorite
    fetch(`/library/${userBookId}/toggle-favorite`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
@endsection