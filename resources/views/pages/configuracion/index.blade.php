@extends('layouts.main')

@section('page', 'configuracion')
@section('nav', 'configuracion')
@section('title', 'Configuración · Lavandia — Sistema de Ventas')

@section('content')

  <x-page-header
    :crumb="[['label' => 'Inicio', 'url' => route('dashboard')], ['label' => 'Configuración']]"
    title="Configuración"
    subtitle="Personaliza la tienda, tus datos y preferencias del sistema">
  </x-page-header>

  <div class="row g-3 g-md-4">
    <div class="col-12 col-lg-4">
      <div class="card mb-4">
        <div class="card-header-clean"><h5 class="card-title mb-0">Perfil de usuario</h5></div>
        <div class="card-body-clean text-center">
          <div class="avatar-sm mx-auto mb-3 av-a" style="width:76px;height:76px;border-radius:22px;font-size:26px">
            <span data-userinitials>VR</span>
          </div>
          <h5 class="fw-bold mb-0" data-username>Valentina Ríos</h5>
          <p class="text-muted-soft small mb-3" data-userrole>Administradora</p>
          <button class="btn btn-light-outline w-100" onclick="notify('primary','bi-camera','Selector de foto de perfil (integrado al backend)',3500)">
            <i class="bi bi-camera me-2"></i>Cambiar foto
          </button>
        </div>
      </div>
      <div class="card mb-4">
        <div class="card-header-clean"><h5 class="card-title mb-0">Apariencia</h5></div>
        <div class="card-body-clean py-2">
          <div class="setting-row">
            <div><p class="s-title">Tema lavanda</p><p class="s-desc">Identidad visual de la plantilla</p></div>
            <span class="badge-soft badge-g">Activo</span>
          </div>
          <div class="setting-row">
            <div><p class="s-title">Modo compacto</p><p class="s-desc">Reduce el espacio entre tarjetas</p></div>
            <label class="form-switch-custom"><input type="checkbox" id="compactMode"><span class="track"></span></label>
          </div>
          <div class="setting-row">
            <div><p class="s-title">Redondear bordes</p><p class="s-desc">Componentes con bordes suaves</p></div>
            <label class="form-switch-custom"><input type="checkbox" checked><span class="track"></span></label>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-8">
      <div class="card mb-4">
        <div class="card-header-clean"><h5 class="card-title mb-0"><i class="bi bi-shop me-2 text-primary"></i>Información de la tienda</h5></div>
        <div class="card-body-clean">
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <label class="form-label-clean">Nombre de la tienda</label>
              <input type="text" class="form-control-clean w-100" data-brand>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label-clean">Eslogan / lema</label>
              <input type="text" class="form-control-clean w-100" value="Tienda Premium" data-brandtag>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label-clean">Email de contacto</label>
              <input type="email" class="form-control-clean w-100" value="hola@lavandia.shop">
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label-clean">Teléfono</label>
              <input type="tel" class="form-control-clean w-100" value="+52 55 0000 0000">
            </div>
            <div class="col-12">
              <label class="form-label-clean">Moneda</label>
              <select class="form-select-clean">
                <option>MXN — Peso mexicano</option>
                <option>USD — Dólar</option>
                <option>EUR — Euro</option>
                <option>COP — Peso colombiano</option>
              </select>
            </div>
          </div>
          <button class="btn btn-primary mt-4" onclick="notify('success','bi-check-circle','Cambios de tienda guardados')">
            <i class="bi bi-check-lg me-2"></i>Guardar cambios
          </button>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header-clean"><h5 class="card-title mb-0"><i class="bi bi-credit-card me-2 text-primary"></i>Métodos de pago</h5></div>
        <div class="card-body-clean py-2">
          @foreach([
            ['Tarjeta de crédito / débito', 'Visa, Mastercard y Amex', true],
            ['Transferencia bancaria', 'SPEI y cuentas CLABE', true],
            ['PayPal', 'Pagos internacionales', false],
            ['Pago contra entrega', 'Efectivo al recibir', true],
          ] as [$title, $desc, $checked])
            <div class="setting-row">
              <div><p class="s-title">{{ $title }}</p><p class="s-desc">{{ $desc }}</p></div>
              <label class="form-switch-custom"><input type="checkbox" @if($checked) checked @endif><span class="track"></span></label>
            </div>
          @endforeach
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header-clean"><h5 class="card-title mb-0"><i class="bi bi-bell me-2 text-primary"></i>Notificaciones</h5></div>
        <div class="card-body-clean py-2">
          @foreach([
            ['Nuevos pedidos', 'Alerta cuando un cliente realiza una compra', true],
            ['Stock bajo', 'Aviso al bajar del punto de reorden', true],
            ['Resumen semanal', 'Reporte por correo cada lunes', false],
          ] as [$title, $desc, $checked])
            <div class="setting-row">
              <div><p class="s-title">{{ $title }}</p><p class="s-desc">{{ $desc }}</p></div>
              <label class="form-switch-custom"><input type="checkbox" @if($checked) checked @endif><span class="track"></span></label>
            </div>
          @endforeach
        </div>
      </div>

      <div class="card">
        <div class="card-header-clean"><h5 class="card-title mb-0"><i class="bi bi-shield-lock me-2 text-primary"></i>Seguridad</h5></div>
        <div class="card-body-clean">
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <label class="form-label-clean">Correo actual</label>
              <input type="email" class="form-control-clean w-100" data-useremail>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label-clean">Nueva contraseña</label>
              <input type="password" class="form-control-clean w-100" placeholder="••••••••">
            </div>
            <div class="col-12">
              <label class="form-label-clean">Confirmar contraseña</label>
              <input type="password" class="form-control-clean w-100" placeholder="••••••••">
            </div>
          </div>
          <button class="btn btn-danger-soft mt-4" onclick="notify('success','bi-shield-check','Contraseña actualizada correctamente')">
            <i class="bi bi-shield-check me-2"></i>Actualizar contraseña
          </button>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('compactMode').addEventListener('change', e => {
      notify('primary', 'bi-aspect-ratio', e.target.checked ? 'Modo compacto activado' : 'Modo compacto desactivado');
    });
    document.querySelectorAll('input[data-brand]').forEach(el => { el.value = window.APP_DATA.store.name; });
    const t = document.querySelector('[data-brandtag]');
    if (t) t.value = window.APP_DATA.store.tagline;
  });
</script>
@endpush