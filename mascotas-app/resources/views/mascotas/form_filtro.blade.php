@extends('mascotas.layout')

@section('contenido')
<div class="container">
    <h1 class="mb-4">Filtrar mascotas</h1>

    {{-- Formulario con estilos Bootstrap --}}
    <form action="{{ route('mascotas.filtrar') }}" method="POST" class="mb-4">
        @csrf
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="tipo" class="col-form-label">Tipo:</label>
            </div>
            <div class="col-auto">
                <select name="tipo" id="tipo" class="form-select">
                    <option value="">-- Todos --</option>
                    @foreach ($tiposDisponibles as $tipoDisponible)
                        <option value="{{ $tipoDisponible }}" {{ (isset($tipo) && $tipoDisponible == $tipo) ? 'selected' : '' }}>
                            {{ ucfirst($tipoDisponible) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    {{-- Resultados --}}
    @if(isset($mascotas) && count($mascotas) > 0)
        <div class="row">
            @foreach($mascotas as $mascota)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $mascota->nombre }}</h5>
                            <p class="card-text">Tipo: {{ $mascota->tipo }}</p>
                            <p class="card-text">Raza: {{ $mascota->raza }}</p>
                            <p class="card-text">Edad: {{ $mascota->edad }} años</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @elseif(isset($mascotas))
        <div class="alert alert-warning">
            No se encontraron mascotas con ese filtro.
        </div>
    @endif
</div>
@endsection
