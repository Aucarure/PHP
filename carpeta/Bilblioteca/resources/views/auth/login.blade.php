<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión - Book Verse</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .auth-container {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #6366f1;
            margin-bottom: 0.5rem;
        }
        
        .logo-subtitle {
            color: #6b7280;
            font-size: 0.875rem;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            background-color: white;
            color: #111827;
        }
        
        input[type="email"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .checkbox-group input[type="checkbox"] {
            margin-right: 0.5rem;
            color: #6366f1;
        }
        
        .checkbox-group label {
            margin-bottom: 0;
            font-size: 0.875rem;
            color: #6b7280;
        }
        
        .auth-links {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        
        .auth-links a {
            color: #6366f1;
            text-decoration: none;
            font-size: 0.875rem;
        }
        
        .auth-links a:hover {
            text-decoration: underline;
        }
        
        .btn-primary {
            width: 100%;
            background-color: #6366f1;
            color: white;
            padding: 0.875rem;
            border-radius: 0.5rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background-color 0.2s;
        }
        
        .btn-primary:hover {
            background-color: #4f46e5;
        }
        
        .error-message {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }
        
        .register-link p {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        
        .register-link a {
            color: #6366f1;
            font-weight: 600;
            text-decoration: none;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Logo -->
        <div class="logo-section">
            <h1 class="logo-title">Book Verse</h1>
            <p class="logo-subtitle">Iniciar sesión en tu cuenta</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div style="background-color: #dcfce7; color: #166534; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       placeholder="correo@ejemplo.com">
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       placeholder="Tu contraseña">
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="checkbox-group">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">Recordarme</label>
            </div>

            <div class="auth-links">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn-primary">
                Iniciar sesión
            </button>
        </form>

        <!-- Register Link -->
        @if (Route::has('register'))
            <div class="register-link">
                <p>¿No tienes una cuenta?</p>
                <a href="{{ route('register') }}">Regístrate aquí</a>
            </div>
        @endif
    </div>
</body>
</html>