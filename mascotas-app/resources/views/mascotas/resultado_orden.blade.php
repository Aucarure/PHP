@extends('mascotas.layout')

@section('contenido')
    <h2>Resultado: Mascotas ordenadas por edad ({{ strtoupper($orden) }})</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th><th>Tipo</th><th>Edad</th><th>Raza</th><th>Peso</th><th>Fecha Adopción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mascotas as $m)
                <tr>
                    <td>{{ $m->nombre }}</td>
                    <td>{{ $m->tipo }}</td>
                    <td>{{ $m->edad }}</td>
                    <td>{{ $m->raza }}</td>
                    <td>{{ $m->peso }} kg</td>
                    <td>{{ $m->fecha_adopcion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
