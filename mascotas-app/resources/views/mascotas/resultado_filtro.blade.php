@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Filtrado por tipo: <strong>{{ $tipo }}</strong>, raza: <strong>{{ $raza }}</strong>, mostrando: {{ $cantidad }}</h3>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Peso</th>
                <th>Fecha de Adopción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mascotas as $mascota)
            <tr>
                <td>{{ $mascota->nombre }}</td>
                <td>{{ $mascota->edad }}</td>
                <td>{{ $mascota->peso }}</td>
                <td>{{ $mascota->fecha_adopcion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
