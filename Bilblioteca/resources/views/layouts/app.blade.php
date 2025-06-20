<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Book Verse') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fafafa;
        }
        
        .navbar {
            background-color: white;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .book-verse-logo {
            color: #6366f1;
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .nav-link {
            color: #6b7280;
            font-weight: 500;
            font-size: 0.875rem;
            text-decoration: none;
            padding: 0.5rem 1rem;
            transition: color 0.2s;
        }
        
        .nav-link:hover {
            color: #374151;
        }
        
        .search-input {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            width: 100%;
            max-width: 300px;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #6366f1;
            background-color: white;
        }
        
        .hero-section {
            background-color: #f3f4f6;
            padding: 4rem 0;
            text-align: center;
        }
        
        .hero-title {
            font-size: 2.25rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 1rem;
            letter-spacing: -0.025em;
        }
        
        .hero-subtitle {
            color: #6b7280;
            font-size: 1.125rem;
            margin-bottom: 2rem;
        }
        
        .explore-btn {
            background-color: #6366f1;
            color: white;
            padding: 0.875rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s;
        }
        
        .explore-btn:hover {
            background-color: #5147e8;
        }
        
        .section-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #374151;
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .book-card {
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            transition: all 0.2s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .book-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .book-image {
            height: 200px;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
        }
        
        .book-content {
            padding: 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .book-title {
            font-size: 1rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.5rem;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .book-author {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
        
        .book-price {
            color: #6366f1;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .ver-mas-btn {
            background-color: #111827;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.2s;
            margin-top: auto;
        }
        
        .ver-mas-btn:hover {
            background-color: #374151;
        }
        
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .page-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 4rem;
        }
        
        .nav-left {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        
        .nav-center {
            flex: 1;
            max-width: 400px;
            margin: 0 2rem;
        }
        
        .nav-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .cart-icon {
            position: relative;
            padding: 0.5rem;
            color: #6b7280;
        }
        
        .cart-count {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #dc2626;
            color: white;
            border-radius: 50%;
            width: 1rem;
            height: 1rem;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .user-icon {
            padding: 0.5rem;
            color: #6b7280;
        }
        
        @media (max-width: 768px) {
            .nav-center {
                display: none;
            }
            
            .nav-left {
                gap: 1rem;
            }
            
            .hero-title {
                font-size: 1.875rem;
            }
            
            .books-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="navbar fixed w-full top-0 z-50">
            <div class="navbar-container">
                <!-- Logo y Links de Navegación -->
                <div class="nav-left">
                    <a href="{{ route('home') }}" class="book-verse-logo">
                        Book Verse
                    </a>
                    <div class="hidden md:flex items-center gap-6">
                        <a href="{{ route('home') }}" class="nav-link">Inicio</a>
                        <a href="{{ route('books.index') }}" class="nav-link">Catálogo</a>
                        <a href="{{ route('categories.index') }}" class="nav-link">Categorías</a>
                        @auth
                            <a href="{{ route('library.index') }}" class="nav-link">Mi biblioteca</a>
                        @endauth
                    </div>
                </div>

                <!-- Barra de Búsqueda -->
                <div class="nav-center">
                    <form action="{{ route('books.index') }}" method="GET">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Buscar Libros..." 
                               class="search-input">
                    </form>
                </div>

                <!-- Iconos de Usuario y Carrito -->
                <div class="nav-right">
                    @auth
                        @if(Auth::user()->isUser())
                            <!-- Cart Icon (solo para usuarios) -->
                            <a href="{{ route('cart.index') }}" style="position: relative; padding: 0.5rem; color: #6b7280; text-decoration: none;">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L6 19h12M9 21v-8h6v8"></path>
                                </svg>
                                @if(Auth::user()->cartItems->count() > 0)
                                    <span style="position: absolute; top: 0; right: 0; background-color: #dc2626; color: white; border-radius: 50%; width: 1rem; height: 1rem; font-size: 0.75rem; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                                        {{ Auth::user()->cartItems->count() }}
                                    </span>
                                @endif
                            </a>
                        @endif
                        
                        <!-- User Icon -->
                        <div style="position: relative;">
                            <button onclick="toggleUserMenu()" style="padding: 0.5rem; color: #6b7280; background: none; border: none; cursor: pointer; display: flex; align-items: center; border-radius: 0.375rem;" 
                                    onmouseover="this.style.backgroundColor='#f3f4f6'" 
                                    onmouseout="this.style.backgroundColor='transparent'">
                                @if(Auth::user()->isAdmin())
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                @else
                                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @endif
                                <!-- Flecha hacia abajo -->
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 0.25rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- User Dropdown Menu -->
                            <div id="userMenu" style="display: none; position: absolute; right: 0; top: 100%; background: white; border: 1px solid #e5e7eb; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); z-index: 50; min-width: 220px; margin-top: 0.25rem;">
                                <!-- User Info Header -->
                                <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb; background-color: #f9fafb;">
                                    <p style="font-weight: 600; color: #111827; margin: 0; font-size: 0.875rem;">{{ Auth::user()->name }}</p>
                                    <p style="font-size: 0.75rem; color: #6b7280; margin: 0.25rem 0 0 0;">{{ Auth::user()->email }}</p>
                                    <span style="background-color: {{ Auth::user()->isAdmin() ? '#dc2626' : '#6366f1' }}; color: white; font-size: 0.7rem; padding: 0.125rem 0.5rem; border-radius: 9999px; font-weight: 500; display: inline-block; margin-top: 0.5rem;">
                                        {{ Auth::user()->isAdmin() ? '⚙️ Administrador' : '👤 Usuario' }}
                                    </span>
                                </div>
                                
                                <!-- Menu Options -->
                                <div style="padding: 0.5rem 0;">
                                    @if(Auth::user()->isUser())
                                        <a href="{{ route('library.index') }}" style="display: flex; align-items: center; padding: 0.75rem 1rem; color: #374151; text-decoration: none; font-size: 0.875rem; transition: background-color 0.2s;" 
                                           onmouseover="this.style.backgroundColor='#f3f4f6'" 
                                           onmouseout="this.style.backgroundColor='transparent'">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.75rem;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                            Mi biblioteca
                                        </a>
                                        
                                        <a href="{{ route('cart.index') }}" style="display: flex; align-items: center; padding: 0.75rem 1rem; color: #374151; text-decoration: none; font-size: 0.875rem; transition: background-color 0.2s;" 
                                           onmouseover="this.style.backgroundColor='#f3f4f6'" 
                                           onmouseout="this.style.backgroundColor='transparent'">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.75rem;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L6 19h12"></path>
                                            </svg>
                                            Mi carrito
                                            @if(Auth::user()->cartItems->count() > 0)
                                                <span style="background-color: #dc2626; color: white; border-radius: 50%; width: 1rem; height: 1rem; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; font-weight: 600; margin-left: auto;">
                                                    {{ Auth::user()->cartItems->count() }}
                                                </span>
                                            @endif
                                        </a>
                                    @endif
                                    
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; padding: 0.75rem 1rem; color: #374151; text-decoration: none; font-size: 0.875rem; transition: background-color 0.2s;" 
                                           onmouseover="this.style.backgroundColor='#f3f4f6'" 
                                           onmouseout="this.style.backgroundColor='transparent'">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.75rem;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                            Panel de administración
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('profile.edit') }}" style="display: flex; align-items: center; padding: 0.75rem 1rem; color: #374151; text-decoration: none; font-size: 0.875rem; transition: background-color 0.2s;" 
                                       onmouseover="this.style.backgroundColor='#f3f4f6'" 
                                       onmouseout="this.style.backgroundColor='transparent'">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.75rem;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Editar perfil
                                    </a>
                                    
                                    <!-- Divider -->
                                    <div style="height: 1px; background-color: #e5e7eb; margin: 0.5rem 0;"></div>
                                    
                                    <!-- Logout -->
                                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" style="width: 100%; text-align: left; display: flex; align-items: center; padding: 0.75rem 1rem; background: none; border: none; color: #dc2626; font-size: 0.875rem; cursor: pointer; transition: background-color 0.2s;" 
                                                onmouseover="this.style.backgroundColor='#fef2f2'" 
                                                onmouseout="this.style.backgroundColor='transparent'">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.75rem;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            Cerrar sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" style="color: #6b7280; text-decoration: none; padding: 0.5rem; font-size: 0.875rem; font-weight: 500;">Iniciar Sesión</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="pt-16">
            @if (session('success'))
                <div class="page-container pt-4">
                    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="page-container pt-4">
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            const isVisible = menu.style.display === 'block';
            
            // Cerrar todos los menús abiertos
            document.querySelectorAll('[id$="Menu"]').forEach(m => m.style.display = 'none');
            
            // Mostrar/ocultar el menú actual
            menu.style.display = isVisible ? 'none' : 'block';
        }

        // Cerrar menú cuando se hace clic fuera
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const userButton = event.target.closest('button[onclick="toggleUserMenu()"]');
            
            // Si el clic no fue en el botón del menú, cerrar el menú
            if (!userButton && userMenu) {
                userMenu.style.display = 'none';
            }
        });

        // Cerrar menú con tecla Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.getElementById('userMenu').style.display = 'none';
            }
        });

        // Confirmar logout
        function confirmLogout() {
            return confirm('¿Estás seguro de que quieres cerrar sesión?');
        }
    </script>
</body>
</html>