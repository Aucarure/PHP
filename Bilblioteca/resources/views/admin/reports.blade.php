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

        .export-btn {
            padding: 0.75rem 1.5rem;
            background: #10b981;
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

        /* Stats Grid */
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
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #059669);
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            background: #f0f9ff;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1rem;
            color: #0ea5e9;
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
            display: flex;
            align-items: center;
            gap: 0.25rem;
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
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        /* Additional Charts */
        .additional-charts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        /* Summary Grid */
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
                <a href="/admin/dashboard" class="nav-item">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a href="/admin/books" class="nav-item">
                    <i class="fas fa-book"></i> Gestión de Libros
                </a>
                <a href="/admin/users" class="nav-item">
                    <i class="fas fa-users"></i> Usuarios
                </a>
                <a href="/admin/orders" class="nav-item">
                    <i class="fas fa-shopping-cart"></i> Órdenes
                </a>
                <a href="/admin/reports" class="nav-item active">
                    <i class="fas fa-chart-bar"></i> Reportes
                </a>
            </nav>
            
            <a href="/" class="back-to-site">
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
                        <div style="font-weight: 600;">María Fernanda</div>
                        <div style="font-size: 0.875rem;">Administrador</div>
                    </div>
                    <div style="width: 45px; height: 45px; background: #111827; color: white; font-weight: 600; border-radius: 9999px; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                        M
                    </div>
                </div>
            </div>

            <!-- Filters Bar -->
            <div class="filters-bar">
                <div class="period-selector">
                    <span style="font-weight: 600; color: #374151;">Período:</span>
                    <a href="?period=7" class="period-btn">7 días</a>
                    <a href="?period=30" class="period-btn active">30 días</a>
                    <a href="?period=90" class="period-btn">90 días</a>
                    <a href="?period=365" class="period-btn">1 año</a>
                </div>
                <a href="/admin/reports/export?period=30" class="export-btn">
                    <i class="fas fa-download"></i> Exportar Reporte
                </a>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-value">$143.45</div>
                    <div class="stat-label">Ingresos del Período</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +15% vs período anterior
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-value">5</div>
                    <div class="stat-label">Órdenes del Período</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +8% vs período anterior
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="stat-value">3</div>
                    <div class="stat-label">Nuevos Usuarios</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +12% vs período anterior
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-value">$28.69</div>
                    <div class="stat-label">Valor Promedio por Orden</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +5% vs período anterior
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-value">0</div>
                    <div class="stat-label">Usuarios Activos</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +3% vs período anterior
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <div class="stat-value">166.7%</div>
                    <div class="stat-label">Tasa de Conversión</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> +25% vs período anterior
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="charts-grid">
                <!-- Monthly Sales Chart -->
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">
                            <i class="fas fa-chart-line"></i> Ventas Mensuales 2025
                        </h3>
                        <div style="font-size: 0.875rem; color: #6b7280;">
                            Comparativo de ingresos y órdenes
                        </div>
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

            <!-- Additional Charts -->
            <div class="additional-charts">
                <!-- Daily Sales Trend -->
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">
                            <i class="fas fa-chart-area"></i> Tendencia de Ventas Diarias
                        </h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="dailySalesChart"></canvas>
                    </div>
                </div>

                <!-- Hourly Activity -->
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">
                            <i class="fas fa-clock"></i> Actividad por Hora
                        </h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="hourlyActivityChart"></canvas>
                    </div>
                </div>

                <!-- Order Status Distribution -->
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">
                            <i class="fas fa-tasks"></i> Estado de Órdenes
                        </h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="orderStatusChart"></canvas>
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
                        <span class="summary-value">9</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Usuarios Registrados</span>
                        <span class="summary-value">0</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Tasa de Conversión</span>
                        <span class="summary-value">166.7%</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Categorías Activas</span>
                        <span class="summary-value">3</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Ingresos Totales</span>
                        <span class="summary-value">$143.45</span>
                    </div>
                </div>

                <!-- Top Categories Performance -->
                <div class="summary-card">
                    <div class="chart-header">
                        <h3 class="chart-title">
                            <i class="fas fa-trophy"></i> Top Categorías
                        </h3>
                    </div>
                    <div class="summary-item">
                        <div style="display: flex; align-items: center;">
                            <span class="rank-badge rank-1">1</span>
                            <span class="summary-label">Base de Datos</span>
                        </div>
                        <span class="summary-value">$59.97</span>
                    </div>
                    <div class="summary-item">
                        <div style="display: flex; align-items: center;">
                            <span class="rank-badge rank-2">2</span>
                            <span class="summary-label">Clásicos</span>
                        </div>
                        <span class="summary-value">$30.50</span>
                    </div>
                    <div class="summary-item">
                        <div style="display: flex; align-items: center;">
                            <span class="rank-badge rank-3">3</span>
                            <span class="summary-label">Algoritmos</span>
                        </div>
                        <span class="summary-value">$22.99</span>
                    </div>
                </div>

                <!-- Growth Analysis -->
                <div class="summary-card">
                    <div class="chart-header">
                        <h3 class="chart-title">
                            <i class="fas fa-trending-up"></i> Análisis de Crecimiento
                        </h3>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Crecimiento de Ingresos</span>
                        <span class="summary-value" style="color: #10b981;">+15.2%</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Nuevos Clientes</span>
                        <span class="summary-value" style="color: #10b981;">+12.5%</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Retención de Usuarios</span>
                        <span class="summary-value" style="color: #f59e0b;">-2.1%</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Ticket Promedio</span>
                        <span class="summary-value" style="color: #10b981;">+8.7%</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
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
                                <tr>
                                    <td>
                                        <span class="rank-badge rank-1">1</span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600;">Base de datos Relacionales</div>
                                        <div style="font-size: 0.75rem; color: #6b7280;">Base de Datos</div>
                                    </td>
                                    <td>Carlos Mendoza</td>
                                    <td>
                                        <strong>3</strong>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: 100%"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>$59.97</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="rank-badge rank-2">2</span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600;">Don Quijote de la Mancha</div>
                                        <div style="font-size: 0.75rem; color: #6b7280;">Clásicos</div>
                                    </td>
                                    <td>Miguel de Cervantes</td>
                                    <td>
                                        <strong>1</strong>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: 33%"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>$30.50</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="rank-badge rank-3">3</span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600;">Algoritmos y Estructuras</div>
                                        <div style="font-size: 0.75rem; color: #6b7280;">Algoritmos</div>
                                    </td>
                                    <td>Roberto Silva</td>
                                    <td>
                                        <strong>1</strong>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: 33%"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>$22.99</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Activity Feed -->
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">
                            <i class="fas fa-rss"></i> Actividad Reciente
                        </h3>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div style="space-y: 1rem;">
                            <div style="display: flex; align-items: start; gap: 1rem; padding: 1rem; background: #f9fafb; border-radius: 0.5rem; margin-bottom: 1rem;">
                                <div style="width: 35px; height: 35px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.875rem;">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #111827;">Nueva venta completada</div>
                                    <div style="font-size: 0.875rem; color: #6b7280;">Orden #005 por $30.50</div>
                                    <div style="font-size: 0.75rem; color: #9ca3af;">Hace 2 horas</div>
                                </div>
                            </div>

                            <div style="display: flex; align-items: start; gap: 1rem; padding: 1rem; background: #f9fafb; border-radius: 0.5rem; margin-bottom: 1rem;">
                                <div style="width: 35px; height: 35px; background: #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.875rem;">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #111827;">Nuevo usuario registrado</div>
                                    <div style="font-size: 0.875rem; color: #6b7280;">juan.perez@email.com</div>
                                    <div style="font-size: 0.75rem; color: #9ca3af;">Hace 4 horas</div>
                                </div>
                            </div>

                            <div style="display: flex; align-items: start; gap: 1rem; padding: 1rem; background: #f9fafb; border-radius: 0.5rem; margin-bottom: 1rem;">
                                <div style="width: 35px; height: 35px; background: #f59e0b; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.875rem;">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #111827;">Libro más vendido</div>
                                    <div style="font-size: 0.875rem; color: #6b7280;">"Base de datos Relacionales" alcanzó 3 ventas</div>
                                    <div style="font-size: 0.75rem; color: #9ca3af;">Hace 6 horas</div>
                                </div>
                            </div>

                            <div style="display: flex; align-items: start; gap: 1rem; padding: 1rem; background: #f9fafb; border-radius: 0.5rem;">
                                <div style="width: 35px; height: 35px; background: #8b5cf6; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.875rem;">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #111827;">Meta alcanzada</div>
                                    <div style="font-size: 0.875rem; color: #6b7280;">Ingresos mensuales superaron $100</div>
                                    <div style="font-size: 0.75rem; color: #9ca3af;">Hace 1 día</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Metrics -->
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">
                            <i class="fas fa-bullseye"></i> Métricas de Rendimiento
                        </h3>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div style="margin-bottom: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <span style="font-size: 0.875rem; color: #6b7280;">Tasa de Conversión</span>
                                <span style="font-weight: 600;">166.7%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 85%"></div>
                            </div>
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <span style="font-size: 0.875rem; color: #6b7280;">Retención de Clientes</span>
                                <span style="font-weight: 600;">87.2%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 87%"></div>
                            </div>
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <span style="font-size: 0.875rem; color: #6b7280;">Satisfacción del Cliente</span>
                                <span style="font-weight: 600;">94.5%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 94%"></div>
                            </div>
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <span style="font-size: 0.875rem; color: #6b7280;">Crecimiento Mensual</span>
                                <span style="font-weight: 600;">15.3%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 76%"></div>
                            </div>
                        </div>

                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <span style="font-size: 0.875rem; color: #6b7280;">Eficiencia Operativa</span>
                                <span style="font-weight: 600;">92.1%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 92%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Real-time Updates -->
            <div class="chart-card" style="margin-bottom: 2rem;">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-broadcast-tower"></i> Actualizaciones en Tiempo Real
                    </h3>
                    <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #10b981;">
                        <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; animation: pulse 2s infinite;"></div>
                        En vivo
                    </div>
                </div>
                <div style="padding: 1.5rem;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                        <div style="text-align: center; padding: 1rem; background: #f0f9ff; border-radius: 0.5rem;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: #0ea5e9;">2</div>
                            <div style="font-size: 0.875rem; color: #6b7280;">Usuarios Online</div>
                        </div>
                        <div style="text-align: center; padding: 1rem; background: #f0fdf4; border-radius: 0.5rem;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: #10b981;">$28.69</div>
                            <div style="font-size: 0.875rem; color: #6b7280;">Ventas Hoy</div>
                        </div>
                        <div style="text-align: center; padding: 1rem; background: #fefce8; border-radius: 0.5rem;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: #f59e0b;">12</div>
                            <div style="font-size: 0.875rem; color: #6b7280;">Páginas Vistas</div>
                        </div>
                        <div style="text-align: center; padding: 1rem; background: #fdf2f8; border-radius: 0.5rem;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: #ec4899;">0</div>
                            <div style="font-size: 0.875rem; color: #6b7280;">Carritos Abandonados</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Sample data for charts
        const monthlyData = {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            revenue: [1200, 1900, 3000, 2500, 2200, 3000, 3500, 4000, 3200, 2800, 3800, 4200],
            orders: [12, 19, 25, 22, 18, 28, 32, 35, 28, 24, 33, 38]
        };

        const categoryData = {
            labels: ['Base de Datos', 'Clásicos', 'Algoritmos', 'Programación', 'Literatura'],
            data: [59.97, 30.50, 22.99, 24.99, 15.99],
            colors: ['#0ea5e9', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899']
        };

        // Monthly Sales Chart
        const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
        new Chart(monthlySalesCtx, {
            type: 'line',
            data: {
                labels: monthlyData.labels,
                datasets: [{
                    label: 'Ingresos ($)',
                    data: monthlyData.revenue,
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgba(14, 165, 233, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y'
                }, {
                    label: 'Órdenes',
                    data: monthlyData.orders,
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
                        grid: { drawOnChartArea: false }
                    },
                    x: {
                        grid: { color: 'rgba(0, 0, 0, 0.05)' }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: categoryData.labels,
                datasets: [{
                    data: categoryData.data,
                    backgroundColor: categoryData.colors,
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
                        labels: { padding: 20, usePointStyle: true }
                    }
                }
            }
        });

        // Daily Sales Chart
        const dailySalesCtx = document.getElementById('dailySalesChart').getContext('2d');
        new Chart(dailySalesCtx, {
            type: 'bar',
            data: {
                labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
                datasets: [{
                    label: 'Ventas Diarias',
                    data: [12, 19, 3, 5, 2, 3, 9, 15, 8, 11],
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderColor: '#10b981',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Hourly Activity Chart
        const hourlyCtx = document.getElementById('hourlyActivityChart').getContext('2d');
        new Chart(hourlyCtx, {
            type: 'line',
            data: {
                labels: ['00', '04', '08', '12', '16', '20'],
                datasets: [{
                    label: 'Actividad por Hora',
                    data: [2, 1, 5, 12, 8, 4],
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Order Status Chart
        const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
        new Chart(orderStatusCtx, {
            type: 'pie',
            data: {
                labels: ['Completadas', 'Pendientes', 'Procesando'],
                datasets: [{
                    data: [5, 0, 0],
                    backgroundColor: ['#10b981', '#f59e0b', '#3b82f6']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Add pulse animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.5; }
            }
        `;
        document.head.appendChild(style);

        // Auto-refresh functionality
        setInterval(() => {
            // Simulate real-time updates
            const onlineUsers = document.querySelector('.chart-card:last-child .grid > div:first-child .text-xl');
            if (onlineUsers) {
                const current = parseInt(onlineUsers.textContent);
                onlineUsers.textContent = Math.max(0, current + Math.floor(Math.random() * 3) - 1);
            }
        }, 5000);
    </script>
</body>
</html>