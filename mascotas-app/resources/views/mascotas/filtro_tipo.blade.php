@extends('mascotas.layout')

@section('contenido')
    <h2 class="mb-4">Buscar Mascota por Tipo</h2>

    <form method="POST" action="/mascotas/tipo" class="mb-4">
        @csrf
        <div class="form-group">
            <label for="tipo">Tipo de mascota:</label>
            <input type="text" name="tipo" class="form-control" required placeholder="Ejemplo: Perro, Gato...">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Buscar</button>
    </form>

    @isset($mascotas)
        <h4>Resultados para: "{{ $tipo }}"</h4>
        @if(count($mascotas) > 0)
            <table class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>Nombre</th><th>Edad</th><th>Raza</th><th>Peso</th><th>Fecha Adopción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mascotas as $m)
                        <tr>
                            <td>{{ $m->nombre }}</td>
                            <td>{{ $m->edad }} años</td>
                            <td>{{ $m->raza }}</td>
                            <td>{{ $m->peso }} kg</td>
                            <td>{{ $m->fecha_adopcion }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No se encontraron mascotas de tipo "{{ $tipo }}".</p>
        @endif
    @endisset

    {{-- Estadísticas globales (no dependen del resultado) --}}
    @if(isset($conteoPorTipo) && count($conteoPorTipo) > 0)
        <hr>
        <h4 class="mt-4">Estadísticas Generales por Tipo de Mascota</h4>
        <canvas id="grafico" width="400" height="150" class="my-3"></canvas>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('grafico').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($conteoPorTipo)) !!},
                    datasets: [{
                        label: 'Cantidad por tipo',
                        data: {!! json_encode(array_values($conteoPorTipo)) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endif
@endsection
