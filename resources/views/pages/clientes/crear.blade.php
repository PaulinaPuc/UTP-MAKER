@extends('layouts.main')

@section('page', 'clientes')
@section('nav', 'clientes')
@section('title', 'Nuevo cliente · Lavandia — Sistema de Ventas')

@section('content')

  <x-page-header
    :crumb="[['label' => 'Inicio', 'url' => route('dashboard')], ['label' => 'Clientes', 'url' => route('clientes.index')], ['label' => 'Crear']]"
    title="Agregar nuevo cliente"
    subtitle="Registra un cliente en tu base de datos">
    <x-slot:buttons>
      <a href="{{ route('clientes.index') }}" class="btn btn-light-outline"><i class="bi bi-arrow-left me-2"></i>Volver al directorio</a>
    </x-slot:buttons>
  </x-page-header>

  <div class="row g-4">
    <div class="col-12 col-lg-7">
      <div class="card">
        <div class="card-header-clean"><h5 class="card-title mb-0"><i class="bi bi-person-plus me-2 text-primary"></i>Datos del cliente</h5></div>
        <form id="customerFormPage" onsubmit="event.preventDefault(); this.reset(); notify('success','bi-check-circle','Cliente registrado correctamente');">
          <div class="card-body-clean">
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label-clean">Nombre completo *</label>
                <input type="text" class="form-control-clean w-100" required placeholder="Nombre y apellidos">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label-clean">Email *</label>
                <input type="email" class="form-control-clean w-100" required placeholder="cliente@correo.com">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label-clean">Teléfono</label>
                <input type="tel" class="form-control-clean w-100" placeholder="+52 55 ...">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label-clean">Ciudad</label>
                <input type="text" class="form-control-clean w-100" placeholder="Ciudad de residencia">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label-clean">Dirección</label>
                <input type="text" class="form-control-clean w-100" placeholder="Calle, colonia">
              </div>
            </div>
          </div>
          <div class="card-footer bg-transparent d-flex gap-2" style="border-top:1px solid var(--line)">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-2"></i>Guardar cliente</button>
            <a href="{{ route('clientes.index') }}" class="btn btn-light-outline">Cancelar</a>
          </div>
        </form>
      </div>
    </div>

    <div class="col-12 col-lg-5">
      <div class="card">
        <div class="card-header-clean"><h5 class="card-title mb-0"><i class="bi bi-people me-2 text-primary"></i>Estadísticas rápidas</h5></div>
        <div class="card-body-clean">
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1 small"><span class="text-muted-soft">Clientes totales</span><strong>1,284</strong></div>
            <div class="progress" style="height:7px;border-radius:10px;background:var(--lavanda-100)"><div class="progress-bar" style="width:78%;border-radius:10px;background:var(--primary)"></div></div>
          </div>
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1 small"><span class="text-muted-soft">Clientes activos</span><strong>94%</strong></div>
            <div class="progress" style="height:7px;border-radius:10px;background:var(--lavanda-100)"><div class="progress-bar" style="width:94%;border-radius:10px;background:var(--success)"></div></div>
          </div>
          <p class="small text-muted-soft mb-0 mt-3"><i class="bi bi-info-circle me-1"></i>Los clientes nuevos reciben un correo de bienvenida automático.</p>
        </div>
      </div>
    </div>
  </div>

@endsection