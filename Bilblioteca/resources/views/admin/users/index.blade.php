<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Usuarios - Admin</title>
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

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            background: #f3f4f6;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1rem;
            color: #374151;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #111827;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6b7280;
            margin-top: 0.3rem;
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

        .btn-info {
            background: #3b82f6;
            color: white;
        }

        .btn-info:hover {
            background: #2563eb;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
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

        .user-info-table {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar-table {
            width: 45px;
            height: 45px;
            background: #111827;
            color: white;
            font-weight: 600;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .user-avatar-table.admin {
            background: #dc2626;
        }

        .user-details h4 {
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .user-details p {
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

        .badge.admin {
            background: #fecaca;
            color: #991b1b;
        }

        /* Actions */
        .actions {
            display: flex;
            gap: 0.5rem;
        }

        /* Role Toggle */
        .role-toggle {
            padding: 0.25rem 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            background: white;
            cursor: pointer;
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

        /* User Details Modal */
        .user-details-modal {
            max-width: 600px;
        }

        .detail-item {
            padding: 1rem 0;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .detail-label {
            font-weight: 600;
            color: #374151;
        }

        .detail-value {
            color: #111827;
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
                <a href="{{ route('admin.books') }}" class="nav-item">
                    <i class="fas fa-book"></i> Gestión de Libros
                </a>
                <a href="{{ route('admin.users') }}" class="nav-item active">
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
                <h1><i class="fas fa-users"></i> Gestión de Usuarios</h1>
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

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-value">{{ number_format($users->total()) }}</div>
                    <div class="stat-label">Total Usuarios</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div class="stat-value">{{ number_format($users->where('role', 'admin')->count()) }}</div>
                    <div class="stat-label">Administradores</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-value">{{ number_format($users->where('email_verified_at', '!=', null)->count()) }}</div>
                    <div class="stat-label">Usuarios Verificados</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div class="stat-value">{{ number_format($users->where('created_at', '>=', now()->subDays(30))->count()) }}</div>
                    <div class="stat-label">Nuevos (30 días)</div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="search-input" placeholder="Buscar usuarios por nombre o email...">
                </div>
                <div style="display: flex; gap: 1rem;">
                    <select class="search-input" style="width: auto; padding-left: 1rem;" id="roleFilter">
                        <option value="">Todos los roles</option>
                        <option value="admin">Administradores</option>
                        <option value="user">Usuarios</option>
                    </select>
                    <select class="search-input" style="width: auto; padding-left: 1rem;" id="statusFilter">
                        <option value="">Todos los estados</option>
                        <option value="verified">Verificados</option>
                        <option value="unverified">Sin verificar</option>
                    </select>
                    <button class="btn btn-primary" onclick="openModal('addUserModal')">
                        <i class="fas fa-plus"></i> Nuevo Usuario
                    </button>
                </div>
            </div>

            <!-- Main Card -->
            <div class="main-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Lista de Usuarios ({{ $users->total() }} total)
                    </h3>
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Órdenes</th>
                                <th>Libros</th>
                                <th>Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>
                                    <div class="user-info-table">
                                        <div class="user-avatar-table {{ $user->role === 'admin' ? 'admin' : '' }}">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="user-details">
                                            <h4>{{ $user->name }}</h4>
                                            <p>{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <select class="role-toggle" onchange="changeUserRole({{ $user->id }}, this.value)" 
                                            {{ $user->id === Auth::id() ? 'disabled' : '' }}>
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Usuario</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge success">Verificado</span>
                                    @else
                                        <span class="badge warning">Sin verificar</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="text-align: center;">
                                        <strong>{{ $user->orders_count ?? 0 }}</strong>
                                        <div style="font-size: 0.75rem; color: #6b7280;">órdenes</div>
                                    </div>
                                </td>
                                <td>
                                    <div style="text-align: center;">
                                        <strong>{{ $user->user_books_count ?? 0 }}</strong>
                                        <div style="font-size: 0.75rem; color: #6b7280;">libros</div>
                                    </div>
                                </td>
                                <td>
                                    <div style="color: #6b7280; font-size: 0.875rem;">
                                        {{ $user->created_at->format('d/m/Y') }}
                                        <div style="font-size: 0.75rem;">
                                            {{ $user->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="actions">
                                        <button class="btn btn-info btn-sm" onclick="viewUser({{ $user->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm" onclick="editUser({{ $user->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if($user->id !== Auth::id())
                                        <button class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align: center; color: #6b7280; padding: 3rem;">
                                    <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                                    <div>No hay usuarios registrados</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                <div style="padding: 1.5rem 2rem; background: #f9fafb; display: flex; justify-content: space-between; align-items: center;">
                    <div style="color: #6b7280; font-size: 0.875rem;">
                        Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }} resultados
                    </div>
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <button class="modal-close" onclick="closeModal('addUserModal')">&times;</button>
                <h3 class="modal-title">Crear Nuevo Usuario</h3>
            </div>
            
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nombre completo *</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Contraseña *</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Confirmar contraseña *</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Rol</label>
                    <select name="role" class="form-control">
                        <option value="user">Usuario</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addUserModal')">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Crear Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <button class="modal-close" onclick="closeModal('editUserModal')">&times;</button>
                <h3 class="modal-title">Editar Usuario</h3>
            </div>
            
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Nombre completo *</label>
                    <input type="text" name="name" id="edit_name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" id="edit_email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nueva contraseña (dejar vacío para mantener)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Rol</label>
                    <select name="role" id="edit_role" class="form-control">
                        <option value="user">Usuario</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editUserModal')">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- View User Modal -->
    <div id="viewUserModal" class="modal">
        <div class="modal-content user-details-modal">
            <div class="modal-header">
                <button class="modal-close" onclick="closeModal('viewUserModal')">&times;</button>
                <h3 class="modal-title">Detalles del Usuario</h3>
            </div>
            
            <div id="userDetailsContent">
                <!-- Content loaded by JavaScript -->
            </div>
            
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('viewUserModal')">
                    Cerrar
                </button>
            </div>
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

        // Change user role
        function changeUserRole(userId, newRole) {
            if (confirm(`¿Estás seguro de cambiar el rol de este usuario a ${newRole === 'admin' ? 'Administrador' : 'Usuario'}?`)) {
                fetch(`/admin/users/${userId}/role`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ role: newRole })
                })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Error al cambiar el rol del usuario');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cambiar el rol del usuario');
                });
            } else {
                // Revert the select to original value
                location.reload();
            }
        }

        // View user details
        function viewUser(userId) {
            fetch(`/admin/users/${userId}`)
                .then(response => response.json())
                .then(data => {
                    const user = data.user;
                    const stats = data.stats;
                    
                    document.getElementById('userDetailsContent').innerHTML = `
                        <div class="detail-item">
                            <span class="detail-label">Nombre:</span>
                            <span class="detail-value">${user.name}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Email:</span>
                            <span class="detail-value">${user.email}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Rol:</span>
                            <span class="detail-value">
                                <span class="badge ${user.role === 'admin' ? 'admin' : 'info'}">${user.role === 'admin' ? 'Administrador' : 'Usuario'}</span>
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Estado:</span>
                            <span class="detail-value">
                                <span class="badge ${user.email_verified_at ? 'success' : 'warning'}">${user.email_verified_at ? 'Verificado' : 'Sin verificar'}</span>
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Fecha de registro:</span>
                            <span class="detail-value">${new Date(user.created_at).toLocaleDateString('es-ES')}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Última actualización:</span>
                            <span class="detail-value">${new Date(user.updated_at).toLocaleDateString('es-ES')}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Total de órdenes:</span>
                            <span class="detail-value">${stats.total_orders}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Total gastado:</span>
                            <span class="detail-value">${stats.total_spent.toFixed(2)}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Libros en biblioteca:</span>
                            <span class="detail-value">${stats.books_owned}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Última orden:</span>
                            <span class="detail-value">${stats.last_order ? new Date(stats.last_order.created_at).toLocaleDateString('es-ES') : 'Nunca'}</span>
                        </div>
                    `;
                    
                    openModal('viewUserModal');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cargar los detalles del usuario');
                });
        }

        // Edit user
        function editUser(userId) {
            fetch(`/admin/users/${userId}/edit`)
                .then(response => response.json())
                .then(data => {
                    const user = data.user;
                    
                    document.getElementById('edit_name').value = user.name;
                    document.getElementById('edit_email').value = user.email;
                    document.getElementById('edit_role').value = user.role;
                    document.getElementById('editUserForm').action = `/admin/users/${userId}`;
                    
                    openModal('editUserModal');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cargar los datos del usuario');
                });
        }

        // Delete user
        function deleteUser(userId) {
            if (confirm('¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.')) {
                fetch(`/admin/users/${userId}`, {
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
                        alert('Error al eliminar el usuario');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar el usuario');
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

        // Role filter
        document.getElementById('roleFilter').addEventListener('change', function(e) {
            const filterRole = e.target.value;
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                if (!filterRole) {
                    row.style.display = '';
                } else {
                    const roleSelect = row.querySelector('.role-toggle');
                    if (roleSelect && roleSelect.value === filterRole) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });

        // Status filter
        document.getElementById('statusFilter').addEventListener('change', function(e) {
            const filterStatus = e.target.value;
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                if (!filterStatus) {
                    row.style.display = '';
                } else {
                    const badge = row.querySelector('.badge.success, .badge.warning');
                    if (badge) {
                        const isVerified = badge.classList.contains('success');
                        if ((filterStatus === 'verified' && isVerified) || 
                            (filterStatus === 'unverified' && !isVerified)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                }
            });
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('show');
            }
        });

        // Password confirmation validation
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                const passwordField = form.querySelector('input[name="password"]');
                const confirmField = form.querySelector('input[name="password_confirmation"]');
                
                if (passwordField && confirmField) {
                    confirmField.addEventListener('input', function() {
                        if (passwordField.value !== confirmField.value) {
                            confirmField.setCustomValidity('Las contraseñas no coinciden');
                        } else {
                            confirmField.setCustomValidity('');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>