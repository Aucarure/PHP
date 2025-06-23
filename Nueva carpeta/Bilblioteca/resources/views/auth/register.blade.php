<x-guest-layout>
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #f9fafb; padding: 2rem 0;">
        <div style="width: 100%; max-width: 400px; background: white; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
            <!-- Logo -->
            <div style="text-align: center; margin-bottom: 2rem;">
                <h1 style="font-size: 1.875rem; font-weight: 700; color: #6366f1; margin-bottom: 0.5rem;">Book Verse</h1>
                <p style="color: #6b7280; font-size: 0.875rem;">Crear nueva cuenta</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div style="margin-bottom: 1rem;">
                    <label for="name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                        Nombre completo
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; background-color: white; color: #111827;"
                           placeholder="Ingresa tu nombre completo">
                    @error('name')
                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div style="margin-bottom: 1rem;">
                    <label for="email" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                        Correo electrónico
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; background-color: white; color: #111827;"
                           placeholder="correo@ejemplo.com">
                    @error('email')
                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div style="margin-bottom: 1rem;">
                    <label for="password" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                        Contraseña
                    </label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; background-color: white; color: #111827;"
                           placeholder="Mínimo 8 caracteres">
                    @error('password')
                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div style="margin-bottom: 1rem;">
                    <label for="password_confirmation" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                        Confirmar contraseña
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; background-color: white; color: #111827;"
                           placeholder="Confirma tu contraseña">
                    @error('password_confirmation')
                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                

                <div style="display: flex; align-items: center; justify-content: between; margin-bottom: 1.5rem;">
                    <a href="{{ route('login') }}" style="text-decoration: underline; font-size: 0.875rem; color: #6b7280;">
                        ¿Ya tienes cuenta?
                    </a>
                </div>

                <button type="submit" 
                        style="width: 100%; background-color: #6366f1; color: white; padding: 0.875rem; border-radius: 0.5rem; font-weight: 600; border: none; cursor: pointer; font-size: 0.875rem;"
                        onmouseover="this.style.backgroundColor='#4f46e5'" 
                        onmouseout="this.style.backgroundColor='#6366f1'">
                    Crear cuenta
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>