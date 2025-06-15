@extends('mascotas.layout')

@section('contenido')
    <h2>Ordenar Mascotas por Edad</h2>
    <form method="POST" action="/mascotas/ordenar">
        @csrf
        <div class="form-group">
            <label for="orden">Orden:</label>
            <select name="orden" class="form-control" required>
                <option value="asc">Ascendente</option>
                <option value="desc">Descendente</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Buscar</button>
    </form>
@endsection
