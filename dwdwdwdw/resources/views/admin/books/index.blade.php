<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Libros - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #111827;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
        }

        .sidebar-header h2 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #111827;
        }

        .sidebar-header p {
            font-size: 0.9rem;
            color: #6b7280;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: #374151;
            text-decoration: none;
            transition: background 0.2s, transform 0.2s;
            font-weight: 500;
        }

        .nav-item i {
            margin-right: 1rem;
            width: 20px;
            text-align: center;
        }

        .nav-item:hover {
            background: #f3f4f6;
            transform: translateX(4px);
        }

        .nav-item.active {
            background: #e5e7eb;
            color: #111827;
            font-weight: 700;
        }

        .back-to-site {
            display: block;
            margin: 1rem;
            padding: 0.75rem 1rem;
            background: #111827;
            color: white;
            text-align: center;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
        }

        .back-to-site:hover {
            opacity: 0.9;
        }

        /* Main content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
        }

        /* Top bar */
        .top-bar {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 0.75rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e5e7eb;
        }

        .top-bar h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #111827;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: #111827;
            color: white;
            font-weight: 600;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        /* Action Bar */
        .action-bar {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 0.75rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e5e7eb;
            gap: 1rem;
        }

        .search-box {
            flex: 1;
            max-width: 400px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-left: 2.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            background: #f9fafb;
        }

        .search-box i {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #111827;
            color: white;
        }

        .btn-primary:hover {
            background: #1f2937;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        /* Main Card */
        .main-card {
            background: white;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .card-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Table */
        .table-container {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: #f9fafb;
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
            color: #374151;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 600;
        }

        .data-table td {
            padding: 1rem 1.5rem;
            font-size: 0.9rem;
            color: #111827;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        .data-table tr:hover {
            background: #f9fafb;
        }

        .book-cover {
            width: 50px;
            height: 70px;
            object-fit: cover;
            border-radius: 0.25rem;
            border: 1px solid #e5e7eb;
        }

        .book-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .book-details h4 {
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .book-details p {
            color: #6b7280;
            font-size: 0.875rem;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge.success {
            background: #dcfce7;
            color: #166534;
        }

        .badge.warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge.danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge.info {
            background: #e0f2fe;
            color: #075985;
        }

        /* Actions */
        .actions {
            display: flex;
            gap: 0.5rem;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 0.75rem;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
        }

        .modal-close {
            float: right;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control:focus {
            outline: none;
            border-color: #111827;
            box-shadow: 0 0 0 3px rgba(17, 24, 39, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        /* Alert messages */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-color: #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-color: #fecaca;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 220px;
            }
            .main-content {
                margin-left: 220px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .main-content {
                margin-left: 0;
            }
            .action-bar {
                flex-direction: column;
                align-items: stretch;
            }
            .search-box {
                max-width: none;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-crown"></i> Admin Panel</h2>
                <p>BibliotecaDigital</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-item">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a href="{{ route('admin.books') }}" class="nav-item active">
                    <i class="fas fa-book"></i> Gestión de Libros
                </a>
                <a href="{{ route('admin.users') }}" class="nav-item">
                    <i class="fas fa-users"></i> Usuarios
                </a>
                <a href="{{ route('admin.orders') }}" class="nav-item">
                    <i class="fas fa-shopping-cart"></i> Órdenes
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-item">
                    <i class="fas fa-chart-bar"></i> Reportes
                </a>
            </nav>
            
            <a href="{{ route('home') }}" class="back-to-site">
                <i class="fas fa-arrow-left"></i> Volver al Sitio
            </a>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <h1><i class="fas fa-book"></i> Gestión de Libros</h1>
                <div class="user-info">
                    <div>
                        <div style="font-weight: 600;">{{ Auth::user()->name }}</div>
                        <div style="font-size: 0.875rem;">Administrador</div>
                    </div>
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>

            <!-- Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="search-input" placeholder="Buscar libros por título, autor o categoría...">
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button class="btn btn-secondary">
                        <i class="fas fa-filter"></i> Filtros
                    </button>
                    <button class="btn btn-primary" onclick="openModal('addBookModal')">
                        <i class="fas fa-plus"></i> Nuevo Libro
                    </button>
                </div>
            </div>

            <!-- Main Card -->
            <div class="main-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Lista de Libros ({{ $books->total() }} total)
                    </h3>
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Libro</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $book)
                            <tr>
                                <td>
                                    <div class="book-info">
                                        <img src="{{ $book->cover_image ?? 'https://via.placeholder.com/50x70?text=Sin+Imagen' }}" 
                                             alt="{{ $book->title }}" class="book-cover">
                                        <div class="book-details">
                                            <h4>{{ $book->title }}</h4>
                                            <p>Por {{ $book->author }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge info">{{ $book->category }}</span>
                                </td>
                                <td>
                                    <strong>${{ number_format($book->price, 2) }}</strong>
                                </td>
                                <td>
                                    <span class="badge success">Activo</span>
                                </td>
                                <td>
                                    <div style="color: #6b7280; font-size: 0.875rem;">
                                        {{ $book->created_at->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('books.show', $book) }}" target="_blank" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-warning btn-sm" onclick="editBook({{ $book->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteBook({{ $book->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #6b7280; padding: 3rem;">
                                    <i class="fas fa-book" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                                    <div>No hay libros registrados</div>
                                    <button class="btn btn-primary" style="margin-top: 1rem;" onclick="openModal('addBookModal')">
                                        <i class="fas fa-plus"></i> Agregar primer libro
                                    </button>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($books->hasPages())
                <div style="padding: 1.5rem 2rem; background: #f9fafb; display: flex; justify-content: space-between; align-items: center;">
                    <div style="color: #6b7280; font-size: 0.875rem;">
                        Mostrando {{ $books->firstItem() }} a {{ $books->lastItem() }} de {{ $books->total() }} resultados
                    </div>
                    <div>
                        {{ $books->links() }}
                    </div>
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Add Book Modal -->
    <div id="addBookModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <button class="modal-close" onclick="closeModal('addBookModal')">&times;</button>
                <h3 class="modal-title">Agregar Nuevo Libro</h3>
            </div>
            
            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Título *</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Autor *</label>
                    <input type="text" name="author" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Categoría *</label>
                    <select name="category" class="form-control" required>
                        <option value="">Seleccionar categoría</option>
                        <option value="Ficción">Ficción</option>
                        <option value="No Ficción">No Ficción</option>
                        <option value="Ciencia">Ciencia</option>
                        <option value="Historia">Historia</option>
                        <option value="Biografía">Biografía</option>
                        <option value="Autoayuda">Autoayuda</option>
                        <option value="Tecnología">Tecnología</option>
                        <option value="Romance">Romance</option>
                        <option value="Misterio">Misterio</option>
                        <option value="Fantasía">Fantasía</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Precio *</label>
                    <input type="number" name="price" class="form-control" step="0.01" min="0" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Imagen de portada</label>
                    <input type="file" name="cover_image" class="form-control" accept="image/*">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Archivo PDF del libro</label>
                    <input type="file" name="file_path" class="form-control" accept=".pdf">
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addBookModal')">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Libro
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Modal functions
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('show');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
        }

        // Book actions
        function editBook(bookId) {
            alert('Función de edición en desarrollo para el libro ID: ' + bookId);
        }

        function deleteBook(bookId) {
            if (confirm('¿Estás seguro de que deseas eliminar este libro?')) {
                fetch(`/admin/books/${bookId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Error al eliminar el libro');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar el libro');
                });
            }
        }

        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('show');
            }
        });
    </script>
</body>
</html>