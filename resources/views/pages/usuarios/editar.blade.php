@extends('layouts.main')

@section('page', 'usuarios.editar')
@section('nav', 'usuarios')
@section('title', 'Editar usuario · Lavandia — Sistema de Ventas')

@section('content')

  <x-page-header
    :crumb="[['label' => 'Inicio', 'url' => route('dashboard')], ['label' => 'Usuarios', 'url' => route('usuarios.index')], ['label' => 'Editar']]"
    title="Editar usuario"
    subtitle="Actualiza la información y el rol del usuario">
    <x-slot:buttons>
      <a href="{{ route('usuarios.index') }}" class="btn btn-light-outline"><i class="bi bi-arrow-left me-2"></i>Volver al listado</a>
    </x-slot:buttons>
  </x-page-header>

  <div class="row g-4">
    <div class="col-12 col-lg-7">
      <div class="card">
        <div class="card-header-clean"><h5 class="card-title mb-0"><i class="bi bi-person-gear me-2 text-primary"></i>Datos del usuario</h5></div>
        <form id="userForm" onsubmit="event.preventDefault(); notify('success','bi-check-circle','Cambios guardados correctamente');">
          <div class="card-body-clean">
            <div class="d-flex align-items-center gap-3 mb-4">
              <span class="avatar-sm av-a" id="userAvatar" style="width:54px;height:54px;font-size:18px;border-radius:14px">VR</span>
              <div><strong class="d-block" id="userAvatarName">Valentina Ríos</strong><span class="small text-muted-soft">Usuario #01</span></div>
            </div>
            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label class="form-label-clean">Nombre completo</label>
                <input type="text" class="form-control-clean w-100" id="u-name" value="Valentina Ríos">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label-clean">Email</label>
                <input type="email" class="form-control-clean w-100" id="u-email" value="valentina@lavandia.shop">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label-clean">Rol</label>
                <select class="form-select-clean w-100" id="u-role">
                  <option>Administradora</option>
                  <option>Vendedor</option>
                  <option>Inventario</option>
                  <option>Contabilidad</option>
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label-clean">Estado</label>
                <select class="form-select-clean w-100" id="u-status">
                  <option>Activo</option>
                  <option>Inactivo</option>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label-clean">Nueva contraseña</label>
                <input type="password" class="form-control-clean w-100" placeholder="Dejar en blanco para no cambiar">
              </div>
            </div>
          </div>
          <div class="card-footer bg-transparent d-flex gap-2" style="border-top:1px solid var(--line)">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-2"></i>Guardar cambios</button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-light-outline">Cancelar</a>
          </div>
        </form>
      </div>
    </div>

    <div class="col-12 col-lg-5">
      <div class="card">
        <div class="card-header-clean"><h5 class="card-title mb-0"><i class="bi bi-shield-lock me-2 text-primary"></i>Permisos del rol</h5></div>
        <div class="card-body-clean py-2">
          @foreach([
            'Ver dashboard y reportes',
            'Gestionar productos e inventario',
            'Crear y ver ventas',
            'Administrar clientes',
            'Configurar la tienda'
          ] as $p)
            <div class="setting-row">
              <div><p class="s-title">{{ $p }}</p></div>
              <i class="bi bi-check-circle-fill text-success"></i>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const raw = '{{ $usuarioId ?? '' }}';
    const id = raw ? parseInt(raw) : null;
    const u = id ? window.APP_DATA.users.find(x => x.id === id) : null;
    if (!u) return;
    document.getElementById('u-name').value = u.name;
    document.getElementById('u-email').value = u.email;
    document.getElementById('u-role').value = u.role;
    document.getElementById('u-status').value = u.status;
    document.getElementById('userAvatar').textContent = initials(u.name);
    document.getElementById('userAvatar').className = 'avatar-sm ' + u.avatar + ' d-inline-grid';
    document.getElementById('userAvatarName').textContent = u.name;
  });
</script>
@endpush