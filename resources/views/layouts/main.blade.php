<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Lavandia — Sistema de Ventas')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
  @stack('styles')
</head>
<body data-page="@yield('page', 'dashboard')">
  <div class="sidebar-backdrop"></div>
  <div class="app-shell">
    <x-sidebar active="@yield('nav', 'dashboard')" />
    <div class="main">
      <x-topbar active="@yield('nav', 'dashboard')" />
      <main class="main-content">
        @yield('content')
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/js/data.js') }}"></script>
  <script src="{{ asset('assets/js/app.js') }}"></script>
  @stack('scripts')
</body>
</html>