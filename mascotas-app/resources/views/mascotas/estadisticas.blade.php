@extends('mascotas.layout')

@section('contenido')
    <h2>Estadísticas de Mascotas Registradas</h2>

    <canvas id="grafico" width="400" height="200"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('grafico').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($conteoPorTipo)) !!},
                datasets: [{
                    label: 'Cantidad por Tipo',
                    data: {!! json_encode(array_values($conteoPorTipo)) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            }
        });
    </script>
@endsection
