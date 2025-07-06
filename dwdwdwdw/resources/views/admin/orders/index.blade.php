<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Órdenes - Admin</title>
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

        .filters {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .filter-select {
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            background: white;
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

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
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

        .order-id {
            font-weight: 600;
            color: #111827;
        }

        .order-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .order-user-avatar {
            width: 35px;
            height: 35px;
            background: #111827;
            color: white;
            font-weight: 600;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        .order-details h4 {
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .order-details p {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .order-items {
            font-size: 0.875rem;
            color: #6b7280;
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

        /* Status Dropdown */
        .status-select {
            padding: 0.25rem 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            background: white;
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
            max-width: 600px;
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

        .order-detail-item {
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

        .order-books {
            margin-top: 1rem;
        }

        .book-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            background: #f9fafb;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .book-title {
            font-weight: 600;
        }

        .book-price {
            color: #6b7280;
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
            .filters {
                justify-content: stretch;
            }
            .filter-select {
                flex: 1;
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
                <a href="{{ route('admin.users') }}" class="nav-item">
                    <i class="fas fa-users"></i> Usuarios
                </a>
                <a href="{{ route('admin.orders') }}" class="nav-item active">
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
                <h1><i class="fas fa-shopping-cart"></i> Gestión de Órdenes</h1>
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
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-value">{{ number_format($stats['total_orders']) }}</div>
                    <div class="stat-label">Total Órdenes</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value">{{ number_format($stats['completed_orders']) }}</div>
                    <div class="stat-label">Completadas</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-value">{{ number_format($stats['pending_orders']) }}</div>
                    <div class="stat-label">Pendientes</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-value">${{ number_format($stats['total_revenue'], 2) }}</div>
                    <div class="stat-label">Ingresos Totales</div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="search-input" placeholder="Buscar por ID, usuario o email...">
                </div>
                <div class="filters">
                    <select class="filter-select" id="statusFilter">
                        <option value="">Todos los estados</option>
                        <option value="pending">Pendiente</option>
                        <option value="processing">Procesando</option>
                        <option value="completed">Completado</option>
                        <option value="cancelled">Cancelado</option>
                    </select>
                    <input type="date" class="filter-select" id="dateFrom" placeholder="Desde">
                    <input type="date" class="filter-select" id="dateTo" placeholder="Hasta">
                    <a href="{{ route('admin.orders.export') }}" class="btn btn-secondary">
                        <i class="fas fa-download"></i> Exportar
                    </a>
                </div>
            </div>

            <!-- Main Card -->
            <div class="main-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Lista de Órdenes ({{ $orders->total() }} total)
                    </h3>
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>
                                    <span class="order-id">#{{ $order->id }}</span>
                                </td>
                                <td>
                                    <div class="order-user">
                                        <div class="order-user-avatar">
                                            {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div class="order-details">
                                            <h4>{{ $order->user->name ?? 'Usuario eliminado' }}</h4>
                                            <p>{{ $order->user->email ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="order-items">
                                        <strong>{{ $order->orderItems->count() }}</strong> items
                                        <div style="font-size: 0.75rem;">
                                            {{ $order->orderItems->sum('quantity') }} libros
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong>${{ number_format($order->total, 2) }}</strong>
                                </td>
                                <td>
                                    <select class="status-select" onchange="updateOrderStatus({{ $order->id }}, this.value)">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Procesando</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completado</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                </td>
                                <td>
                                    <div style="color: #6b7280; font-size: 0.875rem;">
                                        {{ $order->created_at->format('d/m/Y') }}
                                        <div style="font-size: 0.75rem;">
                                            {{ $order->created_at->format('H:i') }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="actions">
                                        <button class="btn btn-info btn-sm" onclick="viewOrder({{ $order->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('admin.orders.print', $order) }}" target="_blank" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align: center; color: #6b7280; padding: 3rem;">
                                    <i class="fas fa-shopping-cart" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                                    <div>No hay órdenes registradas</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                <div style="padding: 1.5rem 2rem; background: #f9fafb; display: flex; justify-content: space-between; align-items: center;">
                    <div style="color: #6b7280; font-size: 0.875rem;">
                        Mostrando {{ $orders->firstItem() }} a {{ $orders->lastItem() }} de {{ $orders->total() }} resultados
                    </div>
                    <div>
                        {{ $orders->links() }}
                    </div>
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- View Order Modal -->
    <div id="viewOrderModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <button class="modal-close" onclick="closeModal('viewOrderModal')">&times;</button>
                <h3 class="modal-title">Detalles de la Orden</h3>
            </div>
            
            <div id="orderDetailsContent">
                <!-- Content loaded by JavaScript -->
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                <button type="button" class="btn btn-secondary" onclick="closeModal('viewOrderModal')">
                    Cerrar
                </button>
                <button type="button" class="btn btn-info" onclick="printOrderDetails()">
                    <i class="fas fa-print"></i> Imprimir
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

        // Update order status
        function updateOrderStatus(orderId, newStatus) {
            if (confirm(`¿Estás seguro de cambiar el estado de la orden a "${newStatus}"?`)) {
                fetch(`/admin/orders/${orderId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Error al actualizar el estado');
                        location.reload(); // Revert the select
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al actualizar el estado');
                    location.reload(); // Revert the select
                });
            } else {
                location.reload(); // Revert the select
            }
        }

        // View order details - FUNCIÓN CORREGIDA
        function viewOrder(orderId) {
            fetch(`/admin/orders/${orderId}/details`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    const order = data.order;
                    
                    let booksHtml = '';
                    if (order.order_items && order.order_items.length > 0) {
                        order.order_items.forEach(item => {
                            booksHtml += `
                                <div class="book-item">
                                    <div>
                                        <div class="book-title">${item.book ? item.book.title : 'Libro eliminado'}</div>
                                        <div class="book-price">Cantidad: ${item.quantity} × $${parseFloat(item.price).toFixed(2)}</div>
                                    </div>
                                    <div>
                                        <strong>$${(item.quantity * item.price).toFixed(2)}</strong>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        booksHtml = '<div class="book-item"><div>No hay libros en esta orden</div></div>';
                    }
                    
                    document.getElementById('orderDetailsContent').innerHTML = `
                        <div class="order-detail-item">
                            <span class="detail-label">ID de Orden:</span>
                            <span class="detail-value">#${order.id}</span>
                        </div>
                        <div class="order-detail-item">
                            <span class="detail-label">Usuario:</span>
                            <span class="detail-value">${order.user ? order.user.name : 'Usuario eliminado'}</span>
                        </div>
                        <div class="order-detail-item">
                            <span class="detail-label">Email:</span>
                            <span class="detail-value">${order.user ? order.user.email : 'N/A'}</span>
                        </div>
                        <div class="order-detail-item">
                            <span class="detail-label">Estado:</span>
                            <span class="detail-value">
                                <span class="badge ${getStatusBadgeClass(order.status)}">${getStatusText(order.status)}</span>
                            </span>
                        </div>
                        <div class="order-detail-item">
                            <span class="detail-label">Fecha de orden:</span>
                            <span class="detail-value">${new Date(order.created_at).toLocaleDateString('es-ES')} ${new Date(order.created_at).toLocaleTimeString('es-ES')}</span>
                        </div>
                        <div class="order-detail-item">
                            <span class="detail-label">Total:</span>
                            <span class="detail-value"><strong>${parseFloat(order.total).toFixed(2)}</strong></span>
                        </div>
                        <div class="order-books">
                            <h4 style="margin-bottom: 1rem; color: #374151;">Libros ordenados:</h4>
                            ${booksHtml}
                        </div>
                    `;
                    
                    openModal('viewOrderModal');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cargar los detalles de la orden: ' + error.message);
                });
        }

        // Print order details
        function printOrderDetails() {
            window.print();
        }

        // Helper functions
        function getStatusBadgeClass(status) {
            switch(status) {
                case 'completed': return 'success';
                case 'processing': return 'info';
                case 'pending': return 'warning';
                case 'cancelled': return 'danger';
                default: return 'info';
            }
        }

        function getStatusText(status) {
            switch(status) {
                case 'completed': return 'Completado';
                case 'processing': return 'Procesando';
                case 'pending': return 'Pendiente';
                case 'cancelled': return 'Cancelado';
                default: return status;
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

        // Status filter
        document.getElementById('statusFilter').addEventListener('change', function(e) {
            const filterStatus = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                if (!filterStatus) {
                    row.style.display = '';
                } else {
                    const statusSelect = row.querySelector('.status-select');
                    if (statusSelect && statusSelect.value === filterStatus) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });

        // Date filters
        document.getElementById('dateFrom').addEventListener('change', filterByDate);
        document.getElementById('dateTo').addEventListener('change', filterByDate);

        function filterByDate() {
            const dateFrom = document.getElementById('dateFrom').value;
            const dateTo = document.getElementById('dateTo').value;
            
            if (!dateFrom && !dateTo) return;
            
            const rows = document.querySelectorAll('.data-table tbody tr');
            
            rows.forEach(row => {
                const dateCell = row.querySelector('td:nth-child(6)');
                if (!dateCell) return;
                
                const dateText = dateCell.textContent.trim();
                const orderDate = parseDate(dateText);
                
                let show = true;
                
                if (dateFrom && orderDate < new Date(dateFrom)) {
                    show = false;
                }
                
                if (dateTo && orderDate > new Date(dateTo)) {
                    show = false;
                }
                
                row.style.display = show ? '' : 'none';
            });
        }

        function parseDate(dateText) {
            // Parse "DD/MM/YYYY" format
            const parts = dateText.split('/');
            if (parts.length === 3) {
                return new Date(parts[2], parts[1] - 1, parts[0]);
            }
            return new Date();
        }

        // Auto-refresh every 30 seconds
        setInterval(() => {
            // Only refresh if no modals are open
            if (!document.querySelector('.modal.show')) {
                const currentUrl = new URL(window.location);
                const hasFilters = currentUrl.searchParams.toString();
                
                if (!hasFilters) {
                    // Only auto-refresh if no filters are applied
                    fetch(window.location.href)
                        .then(response => response.text())
                        .then(html => {
                            // Update only the stats without full page reload
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newStats = doc.querySelectorAll('.stat-value');
                            const currentStats = document.querySelectorAll('.stat-value');
                            
                            newStats.forEach((stat, index) => {
                                if (currentStats[index]) {
                                    currentStats[index].textContent = stat.textContent;
                                }
                            });
                        })
                        .catch(error => console.log('Auto-refresh failed:', error));
                }
            }
        }, 30000);

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('show');
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // ESC to close modals
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal.show').forEach(modal => {
                    modal.classList.remove('show');
                });
            }
        });
    </script>
</body>
</html>