@extends('layouts.blank')

@section('title', '404 · Lavandia — Sistema de Ventas')

@section('content')
  <div style="min-height:100vh;display:grid;place-items:center;background:var(--bg);padding:24px">
    <div class="text-center">
      <div class="sidebar-brand justify-content-center mb-4" style="padding:0">
        <span class="brand-ic"><i class="bi bi-bag-heart"></i></span>
        <span>Lavandia</span>
      </div>
      <div style="font-family:'Poppins',sans-serif;font-size:96px;font-weight:700;line-height:1;background:linear-gradient(135deg,var(--primary),var(--violet));-webkit-background-clip:text;background-clip:text;color:transparent">404</div>
      <h3 class="fw-bold mt-3 mb-2">Página no encontrada</h3>
      <p class="text-muted-soft mb-4" style="max-width:380px;margin:0 auto">
        La página que buscas no existe o fue movida. Vuelve al inicio para continuar trabajando.
      </p>
      <div class="d-flex gap-2 justify-content-center mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="bi bi-grid me-2"></i>Ir al Dashboard</a>
        <button class="btn btn-light-outline" onclick="history.back()"><i class="bi bi-arrow-left me-2"></i>Volver atrás</button>
      </div>
    </div>
  </div>
@endsection