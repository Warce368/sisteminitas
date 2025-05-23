<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sisteminitas')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background-color: #121212;
            color: #e0e0e0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .wrapper {
            display: flex;
            flex-direction: row;
            min-height: 100vh;
            background-color: #121212;
        }

        .sidebar {
            width: 250px;
            background-color: #212529;
            padding-top: 20px;
            transition: transform 0.3s ease-in-out;
            border-right: 1px solid #343a40;
            flex-shrink: 0;
            position: relative;
            z-index: 1100;
        }

        .sidebar a {
            color: #e0e0e0;
            padding: 15px;
            display: block;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar a:hover {
            background-color: #343a40;
            color: #fff;
        }

        .content {
            flex: 1;
            padding: 30px 40px;
            background-color: #121212;
            color: #e0e0e0;
            overflow-x: auto;
        }

        /* Inputs y botones modo oscuro */
        input,
        select,
        textarea,
        button {
            background-color: #2c2f33;
            color: #e0e0e0;
            border: 1px solid #444;
            border-radius: 4px;
            padding: 8px 10px;
        }

        input::placeholder,
        textarea::placeholder {
            color: #bbb;
        }

        input:focus,
        select:focus,
        textarea:focus {
            background-color: #3b3f45;
            border-color: #5865f2;
            color: #fff;
            outline: none;
            box-shadow: 0 0 0 0.25rem rgba(88, 101, 242, .25);
        }

        button.btn {
            border: none;
            cursor: pointer;
        }

        /* Sidebar oculto en móviles */
        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: 250px;
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
                border-right: none;
                box-shadow: 2px 0 8px rgba(0, 0, 0, 0.7);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .content {
                padding: 20px 15px;
                margin-top: 56px;
                /* espacio para navbar movil */
            }

            /* Overlay para sidebar */
            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.7);
                z-index: 1050;
            }

            .overlay.active {
                display: block;
            }
        }
    </style>
</head>

<body>

    <!-- Botón hamburguesa (visible solo en móviles) -->
    <nav class="navbar navbar-dark bg-dark d-md-none fixed-top">
        <div class="container-fluid">
            <button class="btn btn-outline-light" id="toggleSidebar" aria-label="Toggle menu">
                ☰ Menú
            </button>
            <span class="navbar-brand mb-0 h1">SisteMinitas</span>
        </div>
    </nav>

    <!-- Capa oscura detrás del sidebar en móviles -->
    <div class="overlay" id="overlay"></div>

    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar" aria-label="Sidebar navigation">
            <h4 class="text-white text-center mb-4">SisteMinitas</h4>
            <a href="{{ url('/') }}">Inicio</a>

            @php
            $user = Auth::user();
            @endphp

            @if ($user->role != 'OPERADOR')
            <a href="{{ url('users') }}">Administrar usuarios</a>
            @endif


            <a href="{{ url('clientes') }}">Clientes</a>
            <a href="{{ url('pagos') }}">Cobranzas</a>

            <a data-bs-toggle="collapse" href="#submenuhistorial" role="button" aria-expanded="false"
                aria-controls="submenuconfig">
                Historial ▾
            </a>
            <div class="collapse ps-3" id="submenuhistorial">
                <a href="{{ url('historial') }}">Historial General</a>
                <a href="{{ url('historial/cliente') }}">Historial Cliente</a>

            </div>



            <a data-bs-toggle="collapse" href="#submenuconfig" role="button" aria-expanded="false"
                aria-controls="submenuconfig">
                Configuracion ▾
            </a>
            <div class="collapse ps-3" id="submenuconfig">
                <a href="{{ url('zonas') }}">Zona</a>
                <a href="{{ url('direcciones') }}">Direcciones</a>
                <a href="{{ url('servicios') }}">Planes</a>
                <a href="{{ url('/antenas') }}">Antenas</a>
                <a href="{{ url('/mapa-antenas') }}">Antenas Mapa</a>
            </div>
            @if ($user->role != 'OPERADOR')
            <a href="{{ url('/auditoria') }}">Log</a>
            @endif


            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Cerrar Sesión
            </a>


            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

        <!-- Contenido principal -->
        <main class="content" tabindex="-1">
            @yield('content')

        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    </script>
</body>

</html>