<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - BibliotecaDigital</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    /* Stats */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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

    .stat-change {
        font-size: 0.8rem;
        color: #10b981;
        margin-top: 0.5rem;
    }

    /* Dashboard Cards */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .dashboard-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .card-header {
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #111827;
    }

    .chart-container {
        position: relative;
        height: 250px;
    }

    /* Activity List */
    .activity-list {
        margin-top: 1rem;
    }

    .activity-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        background: #f9fafb;
        border-radius: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .activity-icon {
        width: 35px;
        height: 35px;
        border-radius: 0.4rem;
        background: #e5e7eb;
        color: #111827;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .activity-content {
        margin-left: 1rem;
    }

    .activity-title {
        font-weight: 600;
        color: #111827;
        font-size: 0.95rem;
    }

    .activity-time {
        font-size: 0.8rem;
        color: #6b7280;
    }

    /* Bottom Grid */
    .bottom-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
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
        padding: 0.75rem;
        font-size: 0.85rem;
        color: #374151;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    .data-table td {
        padding: 0.75rem;
        font-size: 0.9rem;
        color: #111827;
        border-bottom: 1px solid #e5e7eb;
    }

    .data-table tr:hover {
        background: #f3f4f6;
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

    .badge.info {
        background: #e0f2fe;
        color: #075985;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .sidebar {
            width: 220px;
        }
        .main-content {
            margin-left: 220px;
        }
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            display: none;
        }
        .main-content {
            margin-left: 0;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .top-bar {
            flex-direction: column;
            gap: 1rem;
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
                <a href="{{ route('admin.dashboard') }}" class="nav-item active">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a href="{{ route('admin.books') }}" class="nav-item">
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
                <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
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

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon books">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-value">{{ number_format($totalBooks) }}</div>
                    <div class="stat-label">Total de Libros</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +12% este mes
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon users">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-value">{{ number_format($totalUsers) }}</div>
                    <div class="stat-label">Usuarios Activos</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +8% este mes
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orders">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-value">{{ number_format($totalOrders) }}</div>
                    <div class="stat-label">Órdenes Totales</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +25% este mes
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon revenue">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
                    <div class="stat-label">Ingresos Totales</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +15% este mes
                    </div>
                </div>
            </div>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <!-- Sales Chart -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chart-area"></i> Ventas del Año</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-bell"></i> Actividad Reciente</h3>
                    </div>
                    <div class="activity-list">
                        @forelse($recentOrders->take(5) as $order)
                        <div class="activity-item">
                            <div class="activity-icon sale">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Nueva venta por ${{ number_format($order->total, 2) }}</div>
                                <div class="activity-time">{{ $order->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="activity-item">
                            <div class="activity-icon sale">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">No hay actividad reciente</div>
                                <div class="activity-time">Esperando nuevas órdenes...</div>
                            </div>
                        </div>
                        @endforelse

                        @forelse($recentUsers->take(3) as $user)
                        <div class="activity-item">
                            <div class="activity-icon user">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Nuevo usuario: {{ $user->name }}</div>
                                <div class="activity-time">{{ $user->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Bottom Grid -->
            <div class="bottom-grid">
                <!-- Top Books -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-star"></i> Libros Más Populares</h3>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Libro</th>
                                    <th>Autor</th>
                                    <th>Ventas</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bestSellingBooks->take(5) as $book)
                                <tr>
                                    <td>{{ $book->title ?? 'Libro de Ejemplo' }}</td>
                                    <td>{{ $book->author ?? 'Autor Ejemplo' }}</td>
                                    <td>{{ $book->total_sold ?? rand(10, 100) }}</td>
                                    <td><span class="badge success">Activo</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td>El Quijote de la Mancha</td>
                                    <td>Miguel de Cervantes</td>
                                    <td>87</td>
                                    <td><span class="badge success">Activo</span></td>
                                </tr>
                                <tr>
                                    <td>Cien Años de Soledad</td>
                                    <td>Gabriel García Márquez</td>
                                    <td>65</td>
                                    <td><span class="badge success">Activo</span></td>
                                </tr>
                                <tr>
                                    <td>1984</td>
                                    <td>George Orwell</td>
                                    <td>54</td>
                                    <td><span class="badge success">Activo</span></td>
                                </tr>
                                <tr>
                                    <td>El Principito</td>
                                    <td>Antoine de Saint-Exupéry</td>
                                    <td>43</td>
                                    <td><span class="badge success">Activo</span></td>
                                </tr>
                                <tr>
                                    <td>Harry Potter y la Piedra Filosofal</td>
                                    <td>J.K. Rowling</td>
                                    <td>38</td>
                                    <td><span class="badge success">Activo</span></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-clock"></i> Órdenes Recientes</h3>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders->take(5) as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->user->name ?? 'Usuario' }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $order->status === 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td>#001</td>
                                    <td>Usuario Demo</td>
                                    <td>$45.99</td>
                                    <td><span class="badge success">Completado</span></td>
                                </tr>
                                <tr>
                                    <td>#002</td>
                                    <td>María García</td>
                                    <td>$23.50</td>
                                    <td><span class="badge warning">Pendiente</span></td>
                                </tr>
                                <tr>
                                    <td>#003</td>
                                    <td>Juan Pérez</td>
                                    <td>$67.25</td>
                                    <td><span class="badge success">Completado</span></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Sales Chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Ventas ($)',
                    data: [1200, 1900, 3000, 2500, 2200, 3000, 3500, 4000, 3200, 2800, 3800, 4200],
                    borderColor: 'rgb(102, 126, 234)',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Auto refresh stats every 30 seconds
        setInterval(() => {
            // Aquí podrías hacer una llamada AJAX para actualizar las estadísticas
            console.log('Actualizando estadísticas...');
        }, 30000);
    </script>
</body>
</html>