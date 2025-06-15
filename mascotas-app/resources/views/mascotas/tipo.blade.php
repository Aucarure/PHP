<!DOCTYPE html>
<html>
<head>
    <title>Filtrar por Tipo</title>
</head>
<body>
    <h1>Filtrar Mascotas por Tipo</h1>
    <form method="GET" action="{{ route('mascotas.tipo') }}">
        <label for="tipo">Tipo de Mascota:</label>
        <input type="text" name="tipo" id="tipo" value="{{ old('tipo', $tipo ?? '') }}">
        <button type="submit">Buscar</button>
    </form>

    <h2>Resultados:</h2>
    <ul>
        @foreach ($mascotas as $mascota)
            <li>{{ $mascota->nombre }} - {{ $mascota->tipo }} - {{ $mascota->raza }}</li>
        @endforeach
    </ul>
</body>
</html>
