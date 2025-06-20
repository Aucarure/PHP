@extends('layouts.app')

@section('title', 'Leyendo: ' . $book->title)

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header del lector -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <!-- Información del libro -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('library.index') }}" 
                       class="text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="font-semibold text-gray-900">{{ $book->title }}</h1>
                        <p class="text-sm text-gray-600">{{ $book->author }}</p>
                    </div>
                </div>

                <!-- Controles del lector -->
                <div class="flex items-center space-x-4">
                    <!-- Progreso -->
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Progreso:</span>
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div id="progress-bar" 
                                 class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                                 style="width: {{ $userBook->progress_percentage }}%"></div>
                        </div>
                        <span id="progress-text" class="text-sm font-medium text-gray-900">
                            {{ round($userBook->progress_percentage) }}%
                        </span>
                    </div>

                    <!-- Botón de marcador -->
                    <button onclick="addBookmark()" 
                            class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                        </svg>
                    </button>

                    <!-- Configuraciones -->
                    <div class="flex items-center space-x-2">
                        <button onclick="decreaseFontSize()" class="p-1 text-gray-600 hover:text-gray-900">A-</button>
                        <button onclick="increaseFontSize()" class="p-1 text-gray-600 hover:text-gray-900">A+</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido del libro -->
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div id="book-content" class="bg-white rounded-lg shadow-sm border border-gray-200 p-8" style="font-size: 16px; line-height: 1.7;">
            
            <!-- Navegación de páginas -->
            <div class="flex justify-between items-center mb-6">
                <button onclick="previousPage()" 
                        id="prev-btn"
                        class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Anterior
                </button>

                <span id="page-info" class="text-sm text-gray-600">
                    Página <span id="current-page">{{ $userBook->current_page ?: 1 }}</span> de <span id="total-pages">{{ count($bookContent) }}</span>
                </span>

                <button onclick="nextPage()" 
                        id="next-btn"
                        class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 disabled:opacity-50 disabled:cursor-not-allowed">
                    Siguiente
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <!-- Contenido de la página actual -->
            <div id="page-content">
                <!-- Se llenará con JavaScript -->
            </div>

            <!-- Navegación inferior -->
            <div class="flex justify-center mt-8 pt-6 border-t border-gray-200">
                <div class="flex space-x-2">
                    @for($i = 1; $i <= count($bookContent); $i++)
                        <button onclick="goToPage({{ $i }})" 
                                class="page-nav-btn w-8 h-8 text-sm rounded {{ $i == ($userBook->current_page ?: 1) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600 hover:bg-gray-300' }}">
                            {{ $i }}
                        </button>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para marcadores -->
<div id="bookmark-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold mb-4">Agregar Marcador</h3>
        <input type="text" id="bookmark-title" placeholder="Título del marcador" 
               class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-4">
        <div class="flex space-x-3">
            <button onclick="saveBookmark()" 
                    class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">
                Guardar
            </button>
            <button onclick="closeBookmarkModal()" 
                    class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400">
                Cancelar
            </button>
        </div>
    </div>
</div>

<script>
// Datos del libro
const bookData = @json($bookContent);
const bookId = {{ $book->id }};
let currentPage = {{ $userBook->current_page ?: 1 }};
const totalPages = {{ count($bookContent) }};

// Inicializar lector
document.addEventListener('DOMContentLoaded', function() {
    loadPage(currentPage);
    updateNavigationButtons();
});

// Cargar página
function loadPage(pageNumber) {
    if (pageNumber < 1 || pageNumber > totalPages) return;
    
    const content = bookData[pageNumber - 1];
    document.getElementById('page-content').innerHTML = `
        <h2 class="text-2xl font-bold mb-6 text-gray-900">${content.title}</h2>
        <div class="prose prose-lg max-w-none text-gray-700">
            ${content.content.split('\n').map(p => `<p class="mb-4">${p}</p>`).join('')}
        </div>
    `;
    
    currentPage = pageNumber;
    document.getElementById('current-page').textContent = currentPage;
    
    // Actualizar progreso
    updateProgress();
    updateNavigationButtons();
    updatePageNavigation();
}

// Navegación
function nextPage() {
    if (currentPage < totalPages) {
        loadPage(currentPage + 1);
    }
}

function previousPage() {
    if (currentPage > 1) {
        loadPage(currentPage - 1);
    }
}

function goToPage(pageNumber) {
    loadPage(pageNumber);
}

// Actualizar botones de navegación
function updateNavigationButtons() {
    document.getElementById('prev-btn').disabled = currentPage === 1;
    document.getElementById('next-btn').disabled = currentPage === totalPages;
}

// Actualizar navegación de páginas
function updatePageNavigation() {
    document.querySelectorAll('.page-nav-btn').forEach((btn, index) => {
        const pageNum = index + 1;
        if (pageNum === currentPage) {
            btn.className = 'page-nav-btn w-8 h-8 text-sm rounded bg-blue-600 text-white';
        } else {
            btn.className = 'page-nav-btn w-8 h-8 text-sm rounded bg-gray-200 text-gray-600 hover:bg-gray-300';
        }
    });
}

// Actualizar progreso
function updateProgress() {
    fetch(`/reader/${bookId}/progress`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            current_page: currentPage,
            total_pages: totalPages
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const percentage = Math.round(data.progress_percentage);
            document.getElementById('progress-bar').style.width = percentage + '%';
            document.getElementById('progress-text').textContent = percentage + '%';
            
            // Mostrar notificación si se completó el libro
            if (data.status === 'read' && percentage >= 95) {
                showCompletionNotification();
            }
        }
    });
}

// Configuración de fuente
function increaseFontSize() {
    const content = document.getElementById('book-content');
    const currentSize = parseInt(content.style.fontSize) || 16;
    if (currentSize < 24) {
        content.style.fontSize = (currentSize + 2) + 'px';
    }
}

function decreaseFontSize() {
    const content = document.getElementById('book-content');
    const currentSize = parseInt(content.style.fontSize) || 16;
    if (currentSize > 12) {
        content.style.fontSize = (currentSize - 2) + 'px';
    }
}

// Marcadores
function addBookmark() {
    document.getElementById('bookmark-modal').classList.remove('hidden');
    document.getElementById('bookmark-modal').classList.add('flex');
    document.getElementById('bookmark-title').value = `Página ${currentPage}`;
}

function closeBookmarkModal() {
    document.getElementById('bookmark-modal').classList.add('hidden');
    document.getElementById('bookmark-modal').classList.remove('flex');
}

function saveBookmark() {
    const title = document.getElementById('bookmark-title').value;
    
    fetch(`/reader/${bookId}/bookmark`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            page: currentPage,
            title: title
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeBookmarkModal();
            alert('Marcador guardado exitosamente');
        }
    });
}

// Notificación de libro completado
function showCompletionNotification() {
    // Crear notificación
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white p-4 rounded-lg shadow-lg z-50';
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>¡Felicidades! Has completado el libro</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Remover después de 5 segundos
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// Navegación con teclado
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowLeft') {
        previousPage();
    } else if (e.key === 'ArrowRight') {
        nextPage();
    }
});
</script>
@endsection