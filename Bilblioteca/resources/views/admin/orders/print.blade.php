<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden #{{ $order->id }} - BibliotecaDigital</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
            border-bottom: 2px solid #333;
            padding-bottom: 1rem;
        }

        .header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: #666;
            font-size: 1.1rem;
        }

        .order-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-section h3 {
            color: #333;
            margin-bottom: 1rem;
            font-size: 1.2rem;
            border-bottom: 1px solid #ddd;
            padding-bottom: 0.5rem;
        }

        .info-item {
            margin-bottom: 0.5rem;
        }

        .info-label {
            font-weight: 600;
            display: inline-block;
            width: 100px;
        }

        .status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status.completed {
            background: #dcfce7;
            color: #166534;
        }

        .status.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status.processing {
            background: #e0f2fe;
            color: #075985;
        }

        .status.cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        .items-table th,
        .items-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .items-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .book-title {
            font-weight: 600;
        }

        .book-author {
            color: #666;
            font-size: 0.9rem;
        }

        .total-section {
            text-align: right;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 2px solid #333;
        }

        .total-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
        }

        .footer {
            margin-top: 3rem;
            text-align: center;
            color: #666;
            font-size: 0.9rem;
            border-top: 1px solid #ddd;
            padding-top: 1rem;
        }

        @media print {
            body {
                max-width: none;
                margin: 0;
                padding: 1rem;
            }
            
            .header {
                page-break-after: avoid;
            }
            
            .items-table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BibliotecaDigital</h1>
        <p>Comprobante de Orden</p>
    </div>

    <div class="order-info">
        <div class="info-section">
            <h3>Información de la Orden</h3>
            <div class="info-item">
                <span class="info-label">Orden #:</span>
                <strong>{{ $order->id }}</strong>
            </div>
            <div class="info-item">
                <span class="info-label">Fecha:</span>
                {{ $order->created_at->format('d/m/Y H:i') }}
            </div>
            <div class="info-item">
                <span class="info-label">Estado:</span>
                <span class="status {{ $order->status }}">{{ ucfirst($order->status) }}</span>
            </div>
        </div>

        <div class="info-section">
            <h3>Información del Cliente</h3>
            <div class="info-item">
                <span class="info-label">Nombre:</span>
                {{ $order->user->name ?? 'Usuario eliminado' }}
            </div>
            <div class="info-item">
                <span class="info-label">Email:</span>
                {{ $order->user->email ?? 'N/A' }}
            </div>
            <div class="info-item">
                <span class="info-label">Cliente desde:</span>
                {{ $order->user ? $order->user->created_at->format('d/m/Y') : 'N/A' }}
            </div>
        </div>
    </div>

    <h3>Libros Ordenados</h3>
    <table class="items-table">
        <thead>
            <tr>
                <th>Libro</th>
                <th>Precio Unit.</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>
                    <div class="book-title">{{ $item->book->title ?? 'Libro eliminado' }}</div>
                    <div class="book-author">{{ $item->book->author ?? 'Autor desconocido' }}</div>
                </td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td><strong>${{ number_format($item->price * $item->quantity, 2) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div style="margin-bottom: 0.5rem;">
            <strong>Items totales: {{ $order->orderItems->sum('quantity') }}</strong>
        </div>
        <div class="total-amount">
            Total: ${{ number_format($order->total, 2) }}
        </div>
    </div>

    <div class="footer">
        <p>Gracias por tu compra en BibliotecaDigital</p>
        <p>Este es un comprobante generado automáticamente el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <script>
        // Auto-print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>