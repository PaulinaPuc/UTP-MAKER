@extends('layouts.auth')

@section('title', 'Iniciar sesión · Lavandia — Sistema de Ventas')

@section('content')
  <div class="text-center mb-4">
    <div class="sidebar-brand justify-content-center mb-2" style="padding:0">
      <span class="brand-ic"><i class="bi bi-bag-heart"></i></span>
      <span>Lavandia</span>
    </div>
    <h4 class="fw-bold mb-1">Sistema de Ventas</h4>
    <p class="text-muted-soft small mb-0">Inicia sesión para continuar</p>
  </div>

  <form onsubmit="event.preventDefault(); notify('success','bi-box-arrow-in-right','Bienvenida de vuelta, Valentina'); setTimeout(function(){ window.location.href='/' }, 900);">
    <div class="mb-3">
      <label class="form-label-clean">Correo electrónico</label>
      <input type="email" class="form-control-clean w-100" required value="valentina@lavandia.shop" placeholder="correo@lavandia.shop">
    </div>
    <div class="mb-3">
      <div class="d-flex justify-content-between align-items-center">
        <label class="form-label-clean">Contraseña</label>
        <a href="#" class="small" style="font-size:12px" onclick="event.preventDefault(); notify('primary','bi-envelope','Te enviamos un enlace para recuperar tu contraseña')">¿Olvidaste tu contraseña?</a>
      </div>
      <input type="password" class="form-control-clean w-100" required value="password1234" placeholder="••••••••">
    </div>
    <div class="mb-4">
      <label class="form-switch-custom d-inline-flex align-items-center gap-2" style="width:auto;height:auto;cursor:pointer">
        <input type="checkbox" checked>
        <span class="track"></span>
        <span class="small text-muted-soft" style="margin-left:36px;font-size:13px;color:var(--ink-soft)">Mantener sesión iniciada</span>
      </label>
    </div>
    <button type="submit" class="btn btn-primary w-100 btn-lg"><i class="bi bi-box-arrow-in-right me-2"></i>Iniciar sesión</button>
  </form>

  <p class="text-center text-muted-soft small mt-4 mb-0">
    ¿No tienes cuenta? <a href="#" onclick="event.preventDefault(); notify('primary','bi-person-plus','El registro está habilitado en el backend')">Crear cuenta</a>
  </p>

  <div class="d-flex justify-content-center gap-3 mt-3">
    <span class="badge-soft badge-g"><i class="bi bi-check2 me-1"></i>Demo</span>
    <span class="badge-soft badge-p"><i class="bi bi-shield-check me-1"></i>Seguro</span>
  </div>
@endsection

@push('scripts')
<script>
  if (!window.notify) {
    window.notify = function (type, icon, message, ms) {
      console.log(type, message);
    };
  }
</script>
@endpush