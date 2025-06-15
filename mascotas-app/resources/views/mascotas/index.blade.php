@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <h2 class="text-center mb-4">Listado de Mascotas</h2>

    <form method="GET" action="{{ route('mascotas.index') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="tipo" class="form-label">Filtrar por Tipo</label>
            <input type="text" class="form-control" name="tipo" id="tipo" placeholder="Perro, Gato..." value="{{ request('tipo') }}">
        </div>
        <div class="col-md-4">
            <label for="raza" class="form-label">Filtrar por Raza</label>
            <input type="text" class="form-control" name="raza" id="raza" placeholder="Pitbull, Siamés..." value="{{ request('raza') }}">
        </div>
        <div class="col-md-2">
            <label for="orden" class="form-label">Orden por Edad</label>
            <select name="orden" class="form-select">
                <option value="asc" {{ request('orden') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                <option value="desc" {{ request('orden') == 'desc' ? 'selected' : '' }}>Descendente</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="limite" class="form-label">Cantidad</label>
            <input type="number" class="form-control" name="limite" min="1" value="{{ request('limite') }}">
        </div>
        <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Edad</th>
                    <th>Raza</th>
                    <th>Peso (kg)</th>
                    <th>Fecha de Adopción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mascotas as $mascota)
                    <tr>
                        <td>{{ $mascota->id }}</td>
                        <td>{{ $mascota->nombre }}</td>
                        <td>{{ $mascota->tipo }}</td>
                        <td>{{ $mascota->edad }}</td>
                        <td>{{ $mascota->raza }}</td>
                        <td>{{ $mascota->peso }}</td>
                        <td>{{ $mascota->fecha_adopcion }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No se encontraron resultados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
