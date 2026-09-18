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
  <style>
    .auth-shell{
      min-height:100vh;display:grid;place-items:center;padding:24px;
      background:
        radial-gradient(1200px 500px at 110% -10%, rgba(124,92,240,.18), transparent 60%),
        radial-gradient(900px 420px at -10% 110%, rgba(139,92,246,.16), transparent 60%),
        var(--bg);
    }
    .auth-card{width:100%;max-width:420px;border:none;border-radius:20px;box-shadow:var(--shadow-lg)}
  </style>
  @stack('styles')
</head>
<body>
  <div class="auth-shell">
    <div class="w-100 d-flex justify-content-center">
      <div class="auth-card card">
        <div class="card-body-clean p-4 p-md-5">
          @yield('content')
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>