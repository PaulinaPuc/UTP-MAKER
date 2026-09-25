@extends('layouts.main')

@section('page', 'usuarios')
@section('nav', 'usuarios')
@section('title', 'Usuarios · Lavandia — Sistema de Ventas')

@section('content')

  <x-page-header
    :crumb="[['label' => 'Inicio', 'url' => route('dashboard')], ['label' => 'Sistema'], ['label' => 'Usuarios']]"
    title="Usuarios del sistema"
    subtitle="Controla los accesos y roles del personal">
    <x-slot:buttons>
      <a href="{{ route('usuarios.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Agregar usuario</a>
    </x-slot:buttons>
  </x-page-header>

  <div class="row g-3 g-md-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
      <x-stat-card icon="bi-person-badge" color="1" title="Total de usuarios" value="5" />
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <x-stat-card icon="bi-shield-check" color="2" title="Administradores" value="1" />
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <x-stat-card icon="bi-person-check" color="3" title="Activos" value="4" />
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
      <x-stat-card icon="bi-person-slash" color="5" title="Inactivos" value="1" />
    </div>
  </div>

  <x-data-table title="Equipo del sistema"
    :headers="[['label' => 'Usuario'], ['label' => 'Email'], ['label' => 'Rol'], ['label' => 'Estado'], ['label' => 'Último acceso'], ['label' => 'Acciones', 'class' => 'text-end']]">
    <x-slot:headerActions>
      <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-person-plus me-1"></i>Nuevo</a>
    </x-slot:headerActions>
    <tbody id="usersTable"></tbody>
  </x-data-table>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const box = document.getElementById('usersTable');
    box.innerHTML = window.APP_DATA.users.map(u =>
      '<tr>' +
      '<td><div class="usr-cell"><span class="avatar-sm ' + u.avatar + '">' + initials(u.name) + '</span>' +
      '<div class="usr-meta"><strong>' + u.name + '</strong><span>ID #' + String(u.id).padStart(2, '0') + '</span></div></div></td>' +
      '<td>' + u.email + '</td>' +
      '<td><span class="badge-soft badge-o">' + u.role + '</span></td>' +
      '<td><span class="badge-soft ' + (u.status === 'Activo' ? 'badge-g' : 'badge-d') + '">' + u.status + '</span></td>' +
      '<td>' + u.last + '</td>' +
      '<td class="text-end"><a class="btn btn-soft btn-sm" href="/usuarios/' + u.id + '/editar"><i class="bi bi-pencil me-1"></i>Editar</a>' +
      '<button class="btn btn-danger-soft btn-sm ms-1" onclick="notify(\'danger\',\'bi-trash\',\'Usuario eliminado\')"><i class="bi bi-trash"></i></button></td></tr>'
    ).join('');
  });
</script>
@endpush