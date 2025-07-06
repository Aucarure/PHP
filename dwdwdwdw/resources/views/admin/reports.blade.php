<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reportes - Admin</title>
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

        /* Filters Bar */
        .filters-bar {
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

        .period-selector {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .period-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.2s;
            text-decoration: none;
            color: #374151;
        }

        .period-btn.active {
            background: #111827;
            color: white;
            border-color: #111827;
        }

        .period-btn:hover {
            background: #f3f4f6;
        }

        .period-btn.active:hover {
            background: #1f2937;
        }

        .export-btn {
            padding: 0.75rem 1.5rem;
            background: #111827;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .export-btn:hover {
            background: #1f2937;
        }

        /* Stats Grid */
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

        .stat-change {
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }

        .stat-change.positive {
            color: #10b981;
        }

        .stat-change.negative {
            color: #ef4444;
        }

        /* Charts Grid */
        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: white;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .chart-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .chart-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .chart-container {
            padding: 2rem;
            height: 350px;
            position: relative;
        }

        .chart-container canvas {
            max-height: 100%;
        }

        /* Bottom Grid */
        .bottom-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
        }

        /* Table */
        .table-container {
            overflow-x: auto;
            max-height: 400px;
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
            position: sticky;
            top: 0;
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

        .category-bar {
            width: 100%;
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .category-fill {
            height: 100%;
            background: #111827;
            transition: width 0.3s ease;
        }

        /* Progress bars */
        .progress-bar {
            width: 100%;
            height: 6px;
            background: #e5e7eb;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 0.25rem;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #10b981, #059669);
            transition: width 0.3s ease;
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

        .badge.info {
            background: #e0f2fe;
            color: #075985;
        }

        .rank-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 0.5rem;
        }

        .rank-1 { background: #ffd700; color: #92400e; }
        .rank-2 { background: #c0c0c0; color: #374151; }
        .rank-3 { background: #cd7f32; color: white; }
        .rank-other { background: #f3f4f6; color: #6b7280; }

        /* Summary Cards */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background: white;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-label {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .summary-value {
            font-weight: 600;
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
            .charts-grid {
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
            .filters-bar {
                flex-direction: column;
                align-items: stretch;
            }
            .period-selector {
                justify-content: center;
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
                <a href="{{ route('admin.orders') }}" class="nav-item">
                    <i class="fas fa-shopping-cart"></i> Órdenes
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-item active">
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
                <h1><i class="fas fa-chart-bar"></i> Reportes y Analytics</h1>
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

            <!-- Filters Bar -->
            <div class="filters-bar">
                <div class="period-selector">
                    <span style="font-weight: 600; color: #374151;">Período:</span>
                    <a href="{{ route('admin.reports', ['period' => 7]) }}" class="period-btn {{ $period == 7 ? 'active' : '' }}">7 días</a>
                    <a href="{{ route('admin.reports', ['period' => 30]) }}" class="period-btn {{ $period == 30 ? 'active' : '' }}">30 días</a>
                    <a href="{{ route('admin.reports', ['period' => 90]) }}" class="period-btn {{ $period == 90 ? 'active' : '' }}">90 días</a>
                    <a href="{{ route('admin.reports', ['period' => 365]) }}" class="period-btn {{ $period == 365 ? 'active' : '' }}">1 año</a>
                </div>
                <a href="{{ route('admin.reports.export', ['period' => $period]) }}" class="export-btn">
                    <i class="fas fa-download"></i> Exportar Reporte
                </a>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-value">${{ number_format($stats['period_revenue'], 2) }}</div>
                    <div class="stat-label">Ingresos del Período</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +15% vs período anterior
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-value">{{ number_format($stats['period_orders']) }}</div>
                    <div class="stat-label">Órdenes del Período</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +8% vs período anterior
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="stat-value">{{ number_format($stats['new_users']) }}</div>
                    <div class="stat-label">Nuevos Usuarios</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +12% vs período anterior
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-value">${{ number_format($stats['period_revenue'] / max($stats['period_orders'], 1), 2) }}</div>
                    <div class="stat-label">Valor Promedio por Orden</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +5% vs período anterior
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-value">{{ number_format($stats['active_users']) }}</div>
                    <div class="stat-label">Usuarios Activos</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +3% vs período anterior
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="charts-grid">
                <!-- Monthly Sales Chart -->
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">
                            <i class="fas fa-chart-line"></i> Ventas Mensuales {{ now()->year }}
                        </h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="monthlySalesChart"></canvas>
                    </div>
                </div>

                <!-- Sales by Category -->
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">
                            <i class="fas fa-pie-chart"></i> Ventas por Categoría
                        </h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Summary Grid -->
            <div class="summary-grid">
                <!-- Quick Stats -->
                <div class="summary-card">
                    <div class="chart-header">
                        <h3 class="chart-title">
                            <i class="fas fa-tachometer-alt"></i> Resumen Ejecutivo
                        </h3>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Total de Libros</span>
                        <span class="summary-value">{{ number_format($stats['total_books']) }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Usuarios Registrados</span>
                        <span class="summary-value">{{ number_format($stats['active_users']) }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Tasa de Conversión</span>
                        <span class="summary-value">{{ number_format(($stats['period_orders'] / max($stats['new_users'], 1)) * 100, 1) }}%</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Categorías Activas</span>
                        <span class="summary-value">{{ $salesByCategory->count() }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Ingresos Totales</span>
                        <span class="summary-value">${{ number_format($stats['period_revenue'], 2) }}</span>
                    </div>
                </div>

                <!-- Top Categories Performance -->
                <div class="summary-card">
                    <div class="chart-header">
                        <h3 class="chart-title">
                            <i class="fas fa-trophy"></i> Top Categorías
                        </h3>
                    </div>
                    @forelse($salesByCategory->take(5) as $index => $category)
                    <div class="summary-item">
                        <div style="display: flex; align-items: center;">
                            <span class="rank-badge rank-{{ $index + 1 <= 3 ? $index + 1 : 'other' }}">{{ $index + 1 }}</span>
                            <span class="summary-label">{{ $category->category }}</span>
                        </div>
                        <span class="summary-value">${{ number_format($category->revenue, 2) }}</span>
                    </div>
                    @empty
                    <div class="summary-item">
                        <span class="summary-label">Sin datos</span>
                        <span class="summary-value">-</span>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Bottom Grid -->
            <div class="bottom-grid">
                <!-- Top Selling Books -->
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">
                            <i class="fas fa-star"></i> Libros Más Vendidos
                        </h3>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Ranking</th>
                                    <th>Libro</th>
                                    <th>Autor</th>
                                    <th>Vendidos</th>
                                    <th>Ingresos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topBooks as $index => $book)
                                <tr>
                                    <td>
                                        <span class="rank-badge rank-{{ $index + 1 <= 3 ? $index + 1 : 'other' }}">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600;">{{ $book->title }}</div>
                                        <div style="font-size: 0.75rem; color: #6b7280;">{{ $book->category }}</div>
                                    </td>
                                    <td>{{ $book->author }}</td>
                                    <td>
                                        <strong>{{ $book->total_sold }}</strong>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ ($book->total_sold / $topBooks->max('total_sold')) * 100 }}%"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>${{ number_format($book->total_revenue, 2) }}</strong>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #6b7280; padding: 2rem;">
                                        No hay datos suficientes para mostrar
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Sales by Category Table -->
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">
                            <i class="fas fa-tags"></i> Rendimiento por Categoría
                        </h3>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Categoría</th>
                                    <th>Órdenes</th>
                                    <th>Libros</th>
                                    <th>Ingresos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($salesByCategory as $category)
                                <tr>
                                    <td>
                                        <div>
                                            <div style="font-weight: 600;">{{ $category->category }}</div>
                                            <div class="category-bar">
                                                <div class="category-fill" style="width: {{ ($category->revenue / $salesByCategory->max('revenue')) * 100 }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><strong>{{ $category->total_orders }}</strong></td>
                                    <td><strong>{{ $category->total_books }}</strong></td>
                                    <td><strong>${{ number_format($category->revenue, 2) }}</strong></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; color: #6b7280; padding: 2rem;">
                                        No hay datos de categorías
                                    </td>
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
        // Monthly Sales Chart
        const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
        const monthlySalesData = @json($monthlySales);
        
        const monthlyLabels = [];
        const monthlyRevenue = [];
        const monthlyOrders = [];
        
        for (let i = 1; i <= 12; i++) {
            const monthData = monthlySalesData.find(item => item.month === i);
            monthlyLabels.push(new Date(2024, i-1).toLocaleDateString('es', { month: 'short' }));
            monthlyRevenue.push(monthData ? monthData.revenue : 0);
            monthlyOrders.push(monthData ? monthData.orders : 0);
        }
        
        new Chart(monthlySalesCtx, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Ingresos ($)',
                    data: monthlyRevenue,
                    borderColor: '#111827',
                    backgroundColor: 'rgba(17, 24, 39, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y'
                }, {
                    label: 'Órdenes',
                    data: monthlyOrders,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: false,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: {
                        display: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)' }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: { color: 'rgba(0, 0, 0, 0.05)' },
                        beginAtZero: true
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false,
                        },
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.dataset.label === 'Ingresos ($)') {
                                    label += ' + context.parsed.y.toFixed(2);
                                } else {
                                    label += context.parsed.y;
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryData = @json($salesByCategory);
        
        // Generate colors for categories
        const categoryColors = [
            '#111827', '#374151', '#6b7280', '#9ca3af',
            '#d1d5db', '#10b981', '#3b82f6', '#f59e0b',
            '#ef4444', '#8b5cf6', '#ec4899', '#14b8a6'
        ];
        
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: categoryData.map(item => item.category),
                datasets: [{
                    data: categoryData.map(item => item.revenue),
                    backgroundColor: categoryColors.slice(0, categoryData.length),
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { 
                            padding: 20, 
                            usePointStyle: true,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = ' + context.parsed.toFixed(2);
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Auto-refresh every 60 seconds
        setInterval(() => {
            // Update stats values
            fetch(window.location.href)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newStats = doc.querySelectorAll('.stat-value');
                    const currentStats = document.querySelectorAll('.stat-value');
                    
                    newStats.forEach((stat, index) => {
                        if (currentStats[index]) {
                            // Add animation for value changes
                            if (currentStats[index].textContent !== stat.textContent) {
                                currentStats[index].style.transform = 'scale(1.1)';
                                currentStats[index].style.color = '#10b981';
                                setTimeout(() => {
                                    currentStats[index].textContent = stat.textContent;
                                    currentStats[index].style.transform = 'scale(1)';
                                    currentStats[index].style.color = '#111827';
                                }, 200);
                            }
                        }
                    });
                })
                .catch(error => console.log('Auto-refresh failed:', error));
        }, 60000);

        // Print functionality
        function printReport() {
            window.print();
        }

        // Export functionality
        document.querySelector('.export-btn').addEventListener('click', function(e) {
            // Show loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exportando...';
            this.disabled = true;
            
            // Reset after 3 seconds
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            }, 3000);
        });

        // Add smooth scrolling for better UX
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Animate progress bars on load
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('.progress-fill, .category-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + P for print
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                printReport();
            }
            
            // Ctrl/Cmd + E for export
            if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
                e.preventDefault();
                document.querySelector('.export-btn').click();
            }
        });

        // Add tooltips for better understanding
        function addTooltips() {
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 1px 2px rgba(0,0,0,0.05)';
                });
            });
        }

        // Initialize tooltips
        addTooltips();

        // Responsive chart resize
        window.addEventListener('resize', function() {
            Chart.getChart('monthlySalesChart')?.resize();
            Chart.getChart('categoryChart')?.resize();
        });
    </script>
</body>
</html>