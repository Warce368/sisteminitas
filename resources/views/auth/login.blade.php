@extends('layouts.log')
@section('contenido')
<form method="POST" action="{{ route('login') }}">
    @csrf
    <section class="min-vh-100 bg-dark">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white border-light"
                        style="border-radius: 10px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);">
                        <div class="card-body p-5">
                            <!-- Logo/Header -->
                            <div class="text-center mb-5">
                                <h2 class="fw-bold mb-3">Iniciar Sesión</h2>
                                <p class="text-muted">Ingrese sus credenciales para acceder</p>
                            </div>

                            <!-- Email Input - Ahora visible -->
                            <div class="mb-4">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-secondary text-white">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" name="email" id="email"
                                        class="form-control bg-dark text-white border-secondary"
                                        placeholder="ejemplo@dominio.com" required autofocus>
                                </div>
                            </div>

                            <!-- Password Input - Ahora visible -->
                            <div class="mb-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-secondary text-white">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" name="password" id="password"
                                        class="form-control bg-dark text-white border-secondary" placeholder="••••••••"
                                        required>
                                </div>
                            </div>



                            <!-- Submit Button -->
                            <button class="btn btn-primary btn-lg w-100 py-2 mb-3" type="submit">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Acceder
                            </button>

                            <!-- Error Messages -->
                            @if($errors->any())
                            <div class="alert alert-danger mt-3 py-2 small">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first() }}
                            </div>
                            @endif

                            <!-- Footer Links -->
                            <div class="text-center mt-4 pt-3 border-top border-secondary">
                                <p class="small text-muted">¿Necesita una cuenta? <a href="#"
                                        class="text-primary text-decoration-none">Contáctenos</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

<style>
    body {
        background-color: #121212 !important;
    }

    .bg-dark {
        background-color: #1e1e1e !important;
    }

    .border-light {
        border-color: #2d2d2d !important;
    }

    .border-secondary {
        border-color: #3d3d3d !important;
    }

    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
    }

    .form-control {
        background-color: #2d2d2d !important;
        color: white !important;
        border: 1px solid #3d3d3d !important;
    }

    .form-control:focus {
        background-color: #2d2d2d;
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        color: rgb(176, 176, 176);
    }

    .input-group-text {
        background-color: #2d2d2d !important;
        border-color: #3d3d3d !important;
        color: #ffffff !important;
    }

    .text-primary {
        color: #0d6efd !important;
    }

    .alert-danger {
        background-color: rgba(220, 53, 69, 0.2) !important;
        border-color: rgba(220, 53, 69, 0.3) !important;
        color: #ff6b6b !important;
    }
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

@endsection