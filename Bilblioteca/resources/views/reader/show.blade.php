@extends('layouts.app')

@section('title', 'Leyendo: ' . $book->title)

@section('content')
<div style="background-color: #1f2937; min-height: 100vh; overflow: hidden;">
    <!-- Header del Reader -->
    <div style="background-color: #374151; border-bottom: 1px solid #4b5563; padding: 1rem 0;">
        <div class="page-container" style="display: flex; justify-content: space-between; align-items: center;">
            <!-- Información del libro -->
            <div style="display: flex; align-items: center; gap: 1rem;">
                <a href="{{ route('library.index') }}" 
                   style="color: #9ca3af; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Volver a Mi Biblioteca
                </a>
                <div style="height: 1.5rem; width: 1px; background-color: #4b5563;"></div>
                <div>
                    <h1 style="color: white; font-size: 1.25rem; font-weight: 600; margin: 0;">{{ $book->title }}</h1>
                    <p style="color: #9ca3af; font-size: 0.875rem; margin: 0;">{{ $book->author }}</p>
                </div>
            </div>

            <!-- Controles -->
            <div style="display: flex; align-items: center; gap: 1rem;">
                <!-- Progreso -->
                <div style="color: #9ca3af; font-size: 0.875rem;">
                    <span id="current-page">{{ $userBook->current_page ?? 1 }}</span> / <span id="total-pages">0</span>
                </div>
                
                <!-- Barra de progreso -->
                <div style="width: 200px; height: 6px; background-color: #4b5563; border-radius: 3px; overflow: hidden;">
                    <div id="progress-bar" style="height: 100%; background-color: #6366f1; width: {{ $userBook->progress_percentage }}%; transition: width 0.3s;"></div>
                </div>

                <!-- Botón de favoritos -->
                <button id="favorite-btn" onclick="toggleFavorite()" 
                        style="background: none; border: none; cursor: pointer; color: {{ $userBook->is_favorite ? '#dc2626' : '#6b7280' }};">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Contenedor del PDF -->
    <div id="pdf-container" style="height: calc(100vh - 80px); display: flex;">
        <!-- Sidebar de navegación -->
        <div id="sidebar" style="width: 300px; background-color: #374151; border-right: 1px solid #4b5563; padding: 1rem; overflow-y: auto;">
            <h3 style="color: white; font-size: 1rem; font-weight: 600; margin-bottom: 1rem;">Navegación</h3>
            
            <!-- Controles de página -->
            <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                <button onclick="prevPage()" style="flex: 1; background-color: #4b5563; color: white; border: none; padding: 0.5rem; border-radius: 0.375rem; cursor: pointer;">
                    ← Anterior
                </button>
                <button onclick="nextPage()" style="flex: 1; background-color: #4b5563; color: white; border: none; padding: 0.5rem; border-radius: 0.375rem; cursor: pointer;">
                    Siguiente →
                </button>
            </div>

            <!-- Input de ir a página -->
            <div style="margin-bottom: 1rem;">
                <label style="color: #9ca3af; font-size: 0.875rem; margin-bottom: 0.5rem; display: block;">Ir a página:</label>
                <div style="display: flex; gap: 0.5rem;">
                    <input type="number" id="page-input" min="1" 
                           style="flex: 1; background-color: #4b5563; color: white; border: 1px solid #6b7280; padding: 0.5rem; border-radius: 0.375rem; outline: none;">
                    <button onclick="goToPage()" style="background-color: #6366f1; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.375rem; cursor: pointer;">
                        Ir
                    </button>
                </div>
            </div>

            <!-- Zoom controls -->
            <div style="margin-bottom: 1rem;">
                <label style="color: #9ca3af; font-size: 0.875rem; margin-bottom: 0.5rem; display: block;">Zoom:</label>
                <div style="display: flex; gap: 0.5rem;">
                    <button onclick="zoomOut()" style="background-color: #4b5563; color: white; border: none; padding: 0.5rem; border-radius: 0.375rem; cursor: pointer;">-</button>
                    <span id="zoom-level" style="color: white; padding: 0.5rem; min-width: 60px; text-align: center;">100%</span>
                    <button onclick="zoomIn()" style="background-color: #4b5563; color: white; border: none; padding: 0.5rem; border-radius: 0.375rem; cursor: pointer;">+</button>
                </div>
            </div>

            <!-- Marcadores -->
            <div style="margin-bottom: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <label style="color: #9ca3af; font-size: 0.875rem;">Marcadores:</label>
                    <button onclick="addBookmark()" style="background-color: #6366f1; color: white; border: none; padding: 0.25rem 0.5rem; border-radius: 0.25rem; cursor: pointer; font-size: 0.75rem;">
                        + Agregar
                    </button>
                </div>
                <div id="bookmarks-list" style="max-height: 200px; overflow-y: auto;">
                    @if($userBook->bookmarks)
                        @foreach($userBook->bookmarks as $bookmark)
                            <div style="background-color: #4b5563; padding: 0.5rem; margin-bottom: 0.5rem; border-radius: 0.375rem; cursor: pointer;" 
                                 onclick="goToPage({{ $bookmark['page'] }})">
                                <div style="color: white; font-size: 0.875rem; font-weight: 500;">{{ $bookmark['title'] }}</div>
                                <div style="color: #9ca3af; font-size: 0.75rem;">Página {{ $bookmark['page'] }}</div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Miniatura de páginas -->
            <div id="page-thumbnails" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.5rem;">
                <!-- Se llenarán dinámicamente -->
            </div>
        </div>

        <!-- Visor principal -->
        <div id="viewer" style="flex: 1; background-color: #1f2937; overflow: auto; padding: 1rem;">
            <div id="pdf-viewer" style="display: flex; justify-content: center;">
                <canvas id="pdf-canvas" style="box-shadow: 0 0 20px rgba(0,0,0,0.5); border-radius: 8px; background: white; display: none;"></canvas>
                <!-- Iframe fallback -->
                <iframe id="pdf-iframe" 
                        src="{{ $book->getPdfUrl() }}" 
                        style="width: 100%; height: 80vh; border: none; border-radius: 8px; box-shadow: 0 0 20px rgba(0,0,0,0.5); background: white; display: none;"
                        title="PDF Viewer">
                </iframe>
            </div>
        </div>
    </div>

    <!-- Indicador de carga -->
    <div id="loading" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; text-align: center; display: none;">
        <div style="border: 4px solid #374151; border-top: 4px solid #6366f1; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto 1rem;"></div>
        <p>Cargando PDF...</p>
    </div>

    <!-- Modal para marcadores -->
    <div id="bookmark-modal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: none; justify-content: center; align-items: center; z-index: 1000;">
        <div style="background-color: white; border-radius: 0.75rem; padding: 1.5rem; width: 400px; max-width: 90vw;">
            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem; color: #111827;">Agregar Marcador</h3>
            <input type="text" id="bookmark-title" placeholder="Título del marcador" 
                   style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; margin-bottom: 1rem; outline: none;">
            <div style="display: flex; gap: 0.5rem;">
                <button onclick="saveBookmark()" 
                        style="flex: 1; background-color: #6366f1; color: white; padding: 0.75rem; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 500;">
                    Guardar
                </button>
                <button onclick="closeBookmarkModal()" 
                        style="flex: 1; background-color: #6b7280; color: white; padding: 0.75rem; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 500;">
                    Cancelar
                </button>
            </div>
        </div>
    </div>

    <!-- Notificación de libro completado -->
    <div id="completion-notification" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #059669; color: white; padding: 2rem; border-radius: 0.75rem; text-align: center; display: none; z-index: 1000;">
        <svg width="48" height="48" fill="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 1rem;">
            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
        </svg>
        <h3 style="margin: 0 0 0.5rem 0; font-size: 1.25rem; font-weight: 600;">¡Libro completado!</h3>
        <p style="margin: 0; opacity: 0.9;">Has terminado de leer "{{ $book->title }}"</p>
        <button onclick="closeNotification()" style="margin-top: 1rem; background-color: rgba(255,255,255,0.2); color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.375rem; cursor: pointer;">
            Continuar
        </button>
    </div>
</div>

<script src="{{ asset('js/pdf.min.js') }}"></script>
<script>
// Variables globales
let pdfDoc = null;
let pageNum = {{ $userBook->current_page ?? 1 }};
let pageRendering = false;
let pageNumPending = null;
let scale = 1.0;
let canvas = document.getElementById('pdf-canvas');
let ctx = canvas.getContext('2d');
let bookId = {{ $book->id }};
let lastSavedPage = pageNum;
let isBookCompleted = {{ $userBook->status === 'read' ? 'true' : 'false' }};

// Configurar PDF.js para usar archivos locales
pdfjsLib.GlobalWorkerOptions.workerSrc = '{{ asset("js/pdf.worker.min.js") }}';

// Cargar el PDF
function loadPDF() {
    document.getElementById('loading').style.display = 'block';
    
    const pdfUrl = '{{ $book->getPdfUrl() }}';
    console.log('Intentando cargar PDF desde:', pdfUrl);
    
    // Verificar que PDF.js esté cargado
    if (typeof pdfjsLib === 'undefined') {
        console.error('PDF.js no está cargado');
        document.getElementById('loading').style.display = 'none';
        alert('Error: PDF.js no está disponible. Por favor, recarga la página.');
        return;
    }
    
    // Configurar opciones del PDF
    const loadingTask = pdfjsLib.getDocument({
        url: pdfUrl,
        cMapUrl: 'https://unpkg.com/pdfjs-dist@3.11.174/cmaps/',
        cMapPacked: true,
        enableXfa: true,
        isEvalSupported: false,
        disableAutoFetch: false,
        disableStream: false,
        disableRange: false
    });
    
    loadingTask.promise.then(function(pdf) {
        console.log('PDF cargado exitosamente, páginas:', pdf.numPages);
        pdfDoc = pdf;
        document.getElementById('total-pages').textContent = pdf.numPages;
        document.getElementById('page-input').max = pdf.numPages;
        
        // Renderizar la primera página
        renderPage(pageNum);
        
        // Generar miniaturas
        generateThumbnails();
        
        // Actualizar progreso
        updateProgress();
        
        document.getElementById('loading').style.display = 'none';
    }).catch(function(error) {
        console.error('Error completo cargando PDF:', error);
        document.getElementById('loading').style.display = 'none';
        
        // Mostrar error más detallado
        let errorMessage = 'Error al cargar el PDF:\n\n';
        
        if (error.name === 'MissingPDFException') {
            errorMessage += 'El archivo PDF no se encuentra en la ruta especificada.\n';
            errorMessage += 'Ruta: ' + pdfUrl;
        } else if (error.name === 'InvalidPDFException') {
            errorMessage += 'El archivo PDF está corrupto o no es válido.';
        } else if (error.name === 'UnexpectedResponseException') {
            errorMessage += 'No se pudo acceder al archivo PDF.\n';
            errorMessage += 'Código de estado: ' + error.status;
        } else {
            errorMessage += error.message;
        }
        
        errorMessage += '\n\nRuta del PDF: ' + pdfUrl;
        errorMessage += '\n\n¿Quieres intentar recargar la página?';
        
        if (confirm(errorMessage)) {
            location.reload();
        }
    });
}

// Renderizar página
function renderPage(num) {
    if (pageRendering) {
        pageNumPending = num;
        return;
    }
    
    pageRendering = true;
    
    // Asegurar que el número de página sea válido
    if (num < 1) num = 1;
    if (num > pdfDoc.numPages) num = pdfDoc.numPages;
    
    console.log('Renderizando página:', num, 'de', pdfDoc.numPages);
    
    pdfDoc.getPage(num).then(function(page) {
        console.log('Página obtenida:', num);
        
        const viewport = page.getViewport({ scale: scale });
        
        // Configurar el canvas
        canvas.height = viewport.height;
        canvas.width = viewport.width;
        
        const renderContext = {
            canvasContext: ctx,
            viewport: viewport
        };
        
        const renderTask = page.render(renderContext);
        
        renderTask.promise.then(function() {
            console.log('Página renderizada exitosamente:', num);
            pageRendering = false;
            
            if (pageNumPending !== null) {
                renderPage(pageNumPending);
                pageNumPending = null;
            }
            
            // Actualizar UI
            document.getElementById('current-page').textContent = num;
            document.getElementById('page-input').value = num;
            pageNum = num;
            
            // Actualizar progreso
            updateProgress();
            
            // Guardar progreso (con throttling)
            saveProgress();
            
            // Verificar si el libro está completado
            checkBookCompletion();
            
            // Mostrar el canvas
            canvas.style.display = 'block';
            
        }).catch(function(error) {
            console.error('Error renderizando página:', num, error);
            pageRendering = false;
            
            // Intentar renderizar la página 1 si hay error
            if (num !== 1) {
                console.log('Intentando renderizar página 1 como fallback');
                renderPage(1);
            }
        });
        
    }).catch(function(error) {
        console.error('Error obteniendo página:', num, error);
        pageRendering = false;
        
        // Intentar con página 1 si hay error
        if (num !== 1) {
            console.log('Intentando página 1 como fallback');
            renderPage(1);
        }
    });
}

// Funciones de navegación
function prevPage() {
    if (pageNum <= 1) return;
    pageNum--;
    queueRenderPage(pageNum);
}

function nextPage() {
    if (pageNum >= pdfDoc.numPages) return;
    pageNum++;
    queueRenderPage(pageNum);
}

function goToPage(page = null) {
    const targetPage = page || parseInt(document.getElementById('page-input').value);
    if (targetPage >= 1 && targetPage <= pdfDoc.numPages) {
        pageNum = targetPage;
        queueRenderPage(pageNum);
    }
}

function queueRenderPage(num) {
    if (pageRendering) {
        pageNumPending = num;
    } else {
        renderPage(num);
    }
}

// Funciones de zoom
function zoomIn() {
    scale *= 1.2;
    document.getElementById('zoom-level').textContent = Math.round(scale * 100) + '%';
    queueRenderPage(pageNum);
}

function zoomOut() {
    scale /= 1.2;
    document.getElementById('zoom-level').textContent = Math.round(scale * 100) + '%';
    queueRenderPage(pageNum);
}

// Actualizar progreso visual
function updateProgress() {
    if (pdfDoc) {
        const progress = (pageNum / pdfDoc.numPages) * 100;
        document.getElementById('progress-bar').style.width = progress + '%';
    }
}

// Guardar progreso (con throttling para evitar muchas peticiones)
let saveTimeout = null;
function saveProgress() {
    if (saveTimeout) {
        clearTimeout(saveTimeout);
    }
    
    saveTimeout = setTimeout(() => {
        if (pageNum !== lastSavedPage) {
            fetch(`/reader/${bookId}/progress`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    current_page: pageNum,
                    total_pages: pdfDoc.numPages
                })
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    lastSavedPage = pageNum;
                    
                    // Mostrar notificación si se completó el libro
                    if (data.status === 'read' && !isBookCompleted) {
                        isBookCompleted = true;
                        showCompletionNotification();
                    }
                }
            }).catch(error => {
                console.error('Error saving progress:', error);
            });
        }
    }, 2000); // Guardar cada 2 segundos
}

// Verificar si el libro está completado
function checkBookCompletion() {
    if (!isBookCompleted && pdfDoc && pageNum >= pdfDoc.numPages) {
        // Marcar como completado
        fetch(`/reader/${bookId}/completed`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                isBookCompleted = true;
                showCompletionNotification();
            }
        }).catch(error => {
            console.error('Error marking as completed:', error);
        });
    }
}

// Mostrar notificación de completado
function showCompletionNotification() {
    document.getElementById('completion-notification').style.display = 'block';
}

function closeNotification() {
    document.getElementById('completion-notification').style.display = 'none';
}

// Toggle favorito
function toggleFavorite() {
    const userBookId = {{ $userBook->id }};
    
    fetch(`/library/${userBookId}/toggle-favorite`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        }
    }).then(response => response.json())
    .then(data => {
        if (data.success) {
            const btn = document.getElementById('favorite-btn');
            btn.style.color = data.is_favorite ? '#dc2626' : '#6b7280';
        }
    }).catch(error => {
        console.error('Error toggling favorite:', error);
    });
}

// Funciones de marcadores
function addBookmark() {
    document.getElementById('bookmark-modal').style.display = 'flex';
    document.getElementById('bookmark-title').value = `Página ${pageNum}`;
    document.getElementById('bookmark-title').focus();
}

function closeBookmarkModal() {
    document.getElementById('bookmark-modal').style.display = 'none';
}

function saveBookmark() {
    const title = document.getElementById('bookmark-title').value.trim();
    
    if (!title) {
        alert('Por favor ingresa un título para el marcador');
        return;
    }
    
    fetch(`/reader/${bookId}/bookmark`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            page: pageNum,
            title: title
        })
    }).then(response => response.json())
    .then(data => {
        if (data.success) {
            closeBookmarkModal();
            addBookmarkToList(pageNum, title);
            alert('Marcador guardado exitosamente');
        }
    }).catch(error => {
        console.error('Error saving bookmark:', error);
        alert('Error al guardar el marcador');
    });
}

function addBookmarkToList(page, title) {
    const bookmarksList = document.getElementById('bookmarks-list');
    const bookmarkDiv = document.createElement('div');
    bookmarkDiv.style.cssText = 'background-color: #4b5563; padding: 0.5rem; margin-bottom: 0.5rem; border-radius: 0.375rem; cursor: pointer;';
    bookmarkDiv.onclick = () => goToPage(page);
    
    bookmarkDiv.innerHTML = `
        <div style="color: white; font-size: 0.875rem; font-weight: 500;">${title}</div>
        <div style="color: #9ca3af; font-size: 0.75rem;">Página ${page}</div>
    `;
    
    bookmarksList.appendChild(bookmarkDiv);
}

// Generar miniaturas
function generateThumbnails() {
    const container = document.getElementById('page-thumbnails');
    container.innerHTML = '';
    
    for (let i = 1; i <= Math.min(pdfDoc.numPages, 10); i++) {
        const thumbnailDiv = document.createElement('div');
        thumbnailDiv.style.cssText = `
            background-color: #4b5563; 
            border-radius: 0.375rem; 
            padding: 0.5rem; 
            cursor: pointer; 
            text-align: center;
            border: 2px solid ${i === pageNum ? '#6366f1' : 'transparent'};
        `;
        
        thumbnailDiv.innerHTML = `
            <div style="background-color: #6b7280; height: 60px; border-radius: 0.25rem; margin-bottom: 0.5rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem;">
                ${i}
            </div>
            <span style="color: #9ca3af; font-size: 0.75rem;">Página ${i}</span>
        `;
        
        thumbnailDiv.onclick = () => {
            pageNum = i;
            queueRenderPage(pageNum);
            updateThumbnailSelection();
        };
        
        container.appendChild(thumbnailDiv);
    }
}

function updateThumbnailSelection() {
    const thumbnails = document.querySelectorAll('#page-thumbnails > div');
    thumbnails.forEach((thumb, index) => {
        thumb.style.border = (index + 1) === pageNum ? '2px solid #6366f1' : '2px solid transparent';
    });
}

// Controles de teclado
document.addEventListener('keydown', function(e) {
    // Evitar que se ejecuten los shortcuts si hay un modal abierto
    if (document.getElementById('bookmark-modal').style.display === 'flex') {
        if (e.key === 'Escape') {
            closeBookmarkModal();
        }
        return;
    }
    
    switch(e.key) {
        case 'ArrowLeft':
            e.preventDefault();
            prevPage();
            break;
        case 'ArrowRight':
            e.preventDefault();
            nextPage();
            break;
        case 'Escape':
            window.location.href = '{{ route("library.index") }}';
            break;
        case '+':
        case '=':
            e.preventDefault();
            zoomIn();
            break;
        case '-':
            e.preventDefault();
            zoomOut();
            break;
        case 'b':
        case 'B':
            e.preventDefault();
            addBookmark();
            break;
    }
});

// Animación de carga
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);

// Inicializar cuando la página cargue
document.addEventListener('DOMContentLoaded', function() {
    // Intentar cargar con PDF.js primero
    loadPDF();
    
    // Fallback a iframe si PDF.js falla después de 5 segundos
    setTimeout(function() {
        if (!pdfDoc) {
            console.log('PDF.js falló, usando iframe como fallback');
            document.getElementById('pdf-canvas').style.display = 'none';
            document.getElementById('pdf-iframe').style.display = 'block';
            document.getElementById('loading').style.display = 'none';
            
            // Simular que tenemos un PDF para las funciones básicas
            pdfDoc = { numPages: 1 };
            document.getElementById('total-pages').textContent = '1';
            document.getElementById('page-input').max = 1;
            updateProgress();
        }
    }, 5000);
});

// Guardar progreso antes de cerrar la página
window.addEventListener('beforeunload', function() {
    if (pageNum !== lastSavedPage && pdfDoc) {
        navigator.sendBeacon(`/reader/${bookId}/progress`, JSON.stringify({
            current_page: pageNum,
            total_pages: pdfDoc.numPages
        }));
    }
});

// Manejar errores de red
window.addEventListener('online', function() {
    console.log('Conexión restaurada');
});

window.addEventListener('offline', function() {
    console.log('Conexión perdida - el progreso se guardará cuando se restaure');
});
</script>
@endsection