<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <title>Empresa - @yield('titulo')</title>
</head>

<body class="bg-gray-100">
    <header class="p-5 border-b bg-white shadow">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-3xl font-black">
                Empresa
            </a>
            @auth
            <nav class="flex gap-2 items-center">
                <a
                    class="font-bold text-gray-600 text-sm hidden md:block"
                    href="#">
                    Hola:
                    <span class="font-normal">
                        {{ auth()->user()->name }}
                    </span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="font-bold uppercase text-gray-600 text-sm cursor-pointer">
                        Cerrar Sesión
                    </button>
                </form>
            </nav>
            @endauth

            @guest
            <nav class="flex gap-2 items-center">
                <a class="font-bold uppercase text-gray-600 text-sm" href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}" class="font-bold uppercase text-gray-600 text-sm">
                    Crear Cuenta
                </a>
            </nav>
            @endguest



        </div>
    </header>

    <main class="container mx-auto mt-10">
        <h2 class="font-black text-center  text-3xl mb-10">
            @yield('titulo')
        </h2>
        @yield('contenido')
    </main>

    <footer class="mt-10 text-center p-5 text-gray-500 font-bold uppercase">
        Empresa - Todos los derechos reservados
        {{ now()->year }}
    </footer>

</body>

</html>