<x-guest-layout>
    <h1 class="text-lg font-semibold text-gray-900 mb-6">Iniciar sesión</h1>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" value="Correo electrónico"/>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required autofocus autocomplete="username"/>
            <x-input-error class="mt-2" :messages="$errors->get('email')"/>
        </div>

        <div>
            <x-input-label for="password" value="Contraseña"/>
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="current-password"/>
            <x-input-error class="mt-2" :messages="$errors->get('password')"/>
        </div>

        <label for="remember" class="inline-flex items-center">
            <input id="remember" name="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <span class="ms-2 text-sm text-gray-600">Recordarme</span>
        </label>

        <x-primary-button class="mt-4">
            Entrar
        </x-primary-button>
    </form>
</x-guest-layout>
